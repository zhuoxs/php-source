<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Recharge_EweiShopV2Page extends AppMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$set = $_W['shopset'];

		if (!empty($set['trade']['closerecharge'])) {
			return app_error(AppError::$SystemError, '系统未开启充值!');
		}

		if (empty($set['trade']['minimumcharge'])) {
			$minimumcharge = 0;
		}
		else {
			$minimumcharge = $set['trade']['minimumcharge'];
		}

		$member = $this->member;
		$credit = $member['credit2'];
		$wechat = array('success' => false);
		$alipay = array('success' => false);

		if ($this->iswxapp) {
			if (!empty($set['pay']['wxapp'])) {
				$wechat['success'] = true;
			}
		}
		else {
			if (!empty($set['pay']['nativeapp_wechat'])) {
				$wechat['success'] = true;
			}

			if (!empty($set['pay']['nativeapp_alipay'])) {
				$alipay['success'] = true;
			}
		}

		$acts = com_run('sale::getRechargeActivity');
		return app_json(array('credit' => $credit, 'wechat' => $wechat, 'alipay' => $alipay, 'acts' => $acts, 'coupons' => $this->getrecouponlist(), 'minimumcharge' => $minimumcharge));
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		$set = $_W['shopset'];

		if (empty($set['trade']['minimumcharge'])) {
			$minimumcharge = 0;
		}
		else {
			$minimumcharge = $set['trade']['minimumcharge'];
		}

		$money = round($_GPC['money'], 2);

		if ($money <= 0) {
			return app_error(AppError::$MemberRechargeError, '充值金额必须大于0!');
		}

		if ($money < $minimumcharge && 0 < $minimumcharge) {
			return app_error(AppError::$MemberRechargeError, '最低充值金额为' . $minimumcharge . '元!');
		}

		if (empty($money)) {
			return app_error(AppError::$MemberRechargeError, '请填写充值金额!');
		}

		pdo_delete('ewei_shop_member_log', array('openid' => $_W['openid'], 'status' => 0, 'type' => 0, 'uniacid' => $_W['uniacid']));
		$logno = m('common')->createNO('member_log', 'logno', 'RC');
		$log = array('uniacid' => $_W['uniacid'], 'logno' => $logno, 'title' => $set['shop']['name'] . '会员充值', 'openid' => $_W['openid'], 'money' => $money, 'type' => 0, 'createtime' => time(), 'status' => 0, 'couponid' => intval($_GPC['couponid']));
		pdo_insert('ewei_shop_member_log', $log);
		$logid = pdo_insertid();
		$type = $_GPC['type'];
		$set = m('common')->getSysset(array('shop', 'pay'));

		if ($type == 'wechat') {
			$params = array();
			$params['tid'] = $log['logno'];
			$params['fee'] = $money;
			$params['title'] = $log['title'];
			$wechat = array('success' => false);
			if (!empty($set['pay']['wxapp']) && $this->iswxapp) {
				$payinfo = array('openid' => $_W['openid_wa'], 'title' => $log['title'], 'tid' => $params['tid'], 'fee' => $money);
				$res = $this->model->wxpay($payinfo, 15);

				if (!is_error($res)) {
					$wechat = array('success' => true, 'payinfo' => $res);
				}
				else {
					$wechat['payinfo'] = $res;
				}
			}
			else {
				return app_error(AppError::$MemberRechargeError, '未开启微信支付!');
			}

			if (!$wechat['success']) {
				return app_error(AppError::$MemberRechargeError, '微信支付参数错误!');
			}

			return app_json(array('wechat' => $wechat, 'logid' => $logid));
		}

		if ($type == 'alipay') {
			$sec = m('common')->getSec();
			$sec = iunserializer($sec['sec']);
			$alipay_config = $sec['nativeapp']['alipay'];
			$alipay = array('success' => false);
			if (!empty($set['pay']['nativeapp_alipay']) && !$this->iswxapp) {
				$params = array('out_trade_no' => $log['logno'], 'total_amount' => $money, 'subject' => $log['title'], 'body' => $_W['uniacid'] . ':1:NATIVEAPP');

				if (!empty($alipay_config)) {
					$alipay = $this->model->alipay_build($params, $alipay_config);
				}
			}
			else {
				return app_error(AppError::$MemberRechargeError, '未开启支付宝支付!');
			}

			return app_json(array('alipay' => $alipay, 'logid' => $logid));
		}

		return app_error(AppError::$MemberRechargeError, '未找到支付方式');
	}

	public function wechat_complete()
	{
		global $_W;
		global $_GPC;
		$logid = intval($_GPC['logid']);
		$log = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_log') . ' WHERE `id`=:id and `uniacid`=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $logid));

		if (empty($log)) {
			$logno = intval($_GPC['logno']);
			$log = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_log') . ' WHERE `logno`=:logno and `uniacid`=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':logno' => $logno));
		}

		if (!empty($log)) {
			$payquery = $this->model->isWeixinPay($log['logno'], $log['money']);

			if (!is_error($payquery)) {
				if (empty($log['status'])) {
					$ret = pdo_update('ewei_shop_member_log', array('status' => 1, 'rechargetype' => 'wechat', 'apppay' => is_h5app() ? 1 : 0), array('id' => $logid));

					if ($ret) {
						m('member')->setCredit($log['openid'], 'credit2', $log['money'], array(0, $_W['shopset']['shop']['name'] . '会员充值:wechatcomplete:credit2:' . $log['money']));
						m('member')->setRechargeCredit($log['openid'], $log['money']);
						com_run('sale::setRechargeActivity', $log);
						com_run('coupon::useRechargeCoupon', $log);
						m('notice')->sendMemberLogMessage($logid);
					}
				}

				return app_json();
			}
		}

		return app_error(AppError::$MemberRechargeError, '找不到充值订单!');
	}

	public function alipay_complete()
	{
		global $_W;
		global $_GPC;
		$alidata = $_GPC['alidata'];

		if (empty($alidata)) {
			return app_error(AppError::$ParamsError, '支付宝返回数据错误');
		}

		$logid = intval($_GPC['logid']);
		$log = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_log') . ' WHERE `id`=:id and `uniacid`=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $logid));

		if (empty($log)) {
			$logno = intval($_GPC['logno']);
			$log = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_log') . ' WHERE `logno`=:logno and `uniacid`=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':logno' => $logno));
		}

		if (!empty($log)) {
			$sec = m('common')->getSec();
			$sec = iunserializer($sec['sec']);
			$public_key = $sec['nativeapp']['alipay']['public_key'];

			if (empty($public_key)) {
				return app_error(AppError::$MemberRechargeError, '支付宝公钥为空');
			}

			$alidata = htmlspecialchars_decode($alidata);
			$alidata = json_decode($alidata, true);
			$newalidata = $alidata['alipay_trade_app_pay_response'];
			$newalidata['sign_type'] = $alidata['sign_type'];
			$newalidata['sign'] = $alidata['sign'];
			$alisign = m('finance')->RSAVerify($newalidata, $public_key, false, true);

			if ($alisign) {
				if (empty($log['status'])) {
					pdo_update('ewei_shop_member_log', array('status' => 1, 'rechargetype' => 'alipay', 'apppay' => 2), array('id' => $logid));
					m('member')->setCredit($log['openid'], 'credit2', $log['money'], array(0, $_W['shopset']['shop']['name'] . '会员充值:wechatcomplete:credit2:' . $log['money']));
					m('member')->setRechargeCredit($log['openid'], $log['money']);
					com_run('sale::setRechargeActivity', $log);
					com_run('coupon::useRechargeCoupon', $log);
					m('notice')->sendMemberLogMessage($logid);
				}

				return app_json();
			}
		}

		return app_error(AppError::$MemberRechargeError, '找不到充值订单!');
	}

	public function getstatus()
	{
		global $_W;
		global $_GPC;
		$logno = $_GPC['logno'];
		$log = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_log') . ' WHERE `logno`=:logno and `uniacid`=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':logno' => $logno));
		if (!empty($log) && !empty($log['status'])) {
			show_json(1);
		}
		else {
			show_json(0);
		}
	}

	public function getrecouponlist()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$time = time();
		$sql = 'select d.id,d.couponid,d.gettime,c.timelimit,c.coupontype,c.timedays,c.timestart,c.timeend,c.thumb,c.couponname,c.enough,c.backtype,c.deduct,c.discount,c.backmoney,c.backcredit,c.backredpack,c.bgcolor,c.thumb,c.merchid,c.tagtitle,c.settitlecolor,c.titlecolor from ' . tablename('ewei_shop_coupon_data') . ' d';
		$sql .= ' left join ' . tablename('ewei_shop_coupon') . ' c on d.couponid = c.id';
		$sql .= ' where d.openid=:openid and d.uniacid=:uniacid and coupontype=1';
		$sql .= ' and (   (c.timelimit = 0 and ( c.timedays=0 or c.timedays*86400 + d.gettime >=' . $time . ' ) )  or  (c.timelimit =1 and c.timeend>=' . $time . ')) and  d.used =0 ';
		$sql .= ' order by d.gettime desc  ';
		$coupons = set_medias(pdo_fetchall($sql, array(':openid' => $openid, ':uniacid' => $_W['uniacid'])), 'thumb');

		if (empty($coupons)) {
			$coupons = array();
		}

		foreach ($coupons as $i => &$row) {
			$row = com('coupon')->setMyCoupon($row, $time);

			if (0 < $row['enough']) {
				$title2 = '充值满' . (double) $row['enough'] . '元';
			}
			else {
				$title2 = '充值';
			}

			if ($row['backtype'] == 2) {
				if ($row['coupontype'] == '1') {
					$tagtitle = '充值返现券';
				}

				if (!empty($row['backmoney']) && 0 < $row['backmoney']) {
					$title2 = $title2 . '送' . $row['backmoney'] . '元余额';
				}

				if (!empty($row['backcredit']) && 0 < $row['backcredit']) {
					$title2 = $title2 . '送' . $row['backcredit'] . '积分';
				}

				if (!empty($row['backredpack']) && 0 < $row['backredpack']) {
					$title2 = $title2 . '送' . $row['backredpack'] . '元红包';
				}
			}

			if ($row['tagtitle'] == '') {
				$row['tagtitle'] = $tagtitle;
			}

			$row['title2'] = $title2;
			$row['color'] = 'org';
			unset($row['css']);
			unset($row['backtype']);
			unset($row['deduct']);
			unset($row['discount']);
			unset($row['bgcolor']);
			unset($row['merchid']);
			unset($row['settitlecolor']);
			unset($row['titlecolor']);
			unset($row['merchname']);
			unset($row['backstr']);
			unset($row['backpre']);
			unset($row['_backmoney']);
		}

		unset($row);
		return $coupons;
	}
}

?>
