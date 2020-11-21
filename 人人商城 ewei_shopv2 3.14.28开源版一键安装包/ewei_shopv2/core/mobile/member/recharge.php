<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Recharge_EweiShopV2Page extends MobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$set = $_W['shopset'];
		$set['pay']['weixin'] = !empty($set['pay']['weixin_sub']) ? 1 : $set['pay']['weixin'];
		$set['pay']['weixin_jie'] = !empty($set['pay']['weixin_jie_sub']) ? 1 : $set['pay']['weixin_jie'];
		$sec = m('common')->getSec();
		$sec = iunserializer($sec['sec']);
		$status = 1;

		if (!empty($set['trade']['closerecharge'])) {
			$this->message('系统未开启充值!', '', 'error');
		}

		if (empty($set['trade']['minimumcharge'])) {
			$minimumcharge = 0;
		}
		else {
			$minimumcharge = $set['trade']['minimumcharge'];
		}

		$credit = m('member')->getCredit($_W['openid'], 'credit2');
		$wechat = array('success' => false);

		if (is_weixin()) {
			$data = m('common')->getSysset('pay');
			if (isset($set['pay']) && $set['pay']['weixin'] == 1 && !empty($data['weixin_id'])) {
				list(, $payment) = m('common')->public_build();

				if ($payment['is_new']) {
					if ($payment['type'] == 2 || $payment['type'] == 3) {
						if (!empty($payment['sub_appsecret'])) {
							m('member')->wxuser($payment['sub_appid'], $payment['sub_appsecret']);
						}
					}
				}

				if (is_array($payment) && !is_error($payment)) {
					$wechat['success'] = true;
				}
				else {
					if ($set['pay']['weixin']) {
						$wechat['success'] = true;
					}
				}
			}

			if (isset($set['pay']) && $set['pay']['weixin_jie'] == 1 && !$wechat['success']) {
				if (!empty($set['pay']['weixin_jie_sub']) && !empty($sec['sub_secret_jie_sub'])) {
					m('member')->wxuser($sec['sub_appid_jie_sub'], $sec['sub_secret_jie_sub']);
				}
				else {
					if (!empty($sec['secret'])) {
						m('member')->wxuser($sec['appid'], $sec['secret']);
					}
				}

				$wechat['success'] = true;
			}
		}

		$alipay = array('success' => false);
		if (isset($set['pay']['alipay']) && $set['pay']['alipay'] == 1) {
			load()->model('payment');
			$setting = uni_setting($_W['uniacid'], array('payment'));
			if (is_array($setting['payment']['alipay']) && ($setting['payment']['alipay']['switch'] || $setting['payment']['alipay']['recharge_switch'])) {
				$alipay['success'] = true;
			}
		}

		$acts = com_run('sale::getRechargeActivity');

		if (is_h5app()) {
			$payinfo = array('wechat' => !empty($sec['app_wechat']['merchname']) && !empty($set['pay']['app_wechat']) && !empty($sec['app_wechat']['appid']) && !empty($sec['app_wechat']['appsecret']) && !empty($sec['app_wechat']['merchid']) && !empty($sec['app_wechat']['apikey']) ? true : false, 'alipay' => false, 'mcname' => $sec['app_wechat']['merchname'], 'aliname' => empty($_W['shopset']['shop']['name']) ? $sec['app_wechat']['merchname'] : $_W['shopset']['shop']['name'], 'logno' => NULL, 'money' => NULL, 'attach' => $_W['uniacid'] . ':1', 'type' => 1);
			if (!empty($set['pay']['app_alipay']) && (!empty($sec['app_alipay']['public_key']) || !empty($sec['app_alipay']['public_key_rsa2']))) {
				$payinfo['alipay'] = true;
			}
		}

		include $this->template();
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		$set = $_W['shopset'];
		if (empty($set['trade']['minimumcharge']) || $set['trade']['minimumcharge'] <= 0) {
			$minimumcharge = 1;
		}
		else {
			$minimumcharge = $set['trade']['minimumcharge'];
		}

		$money = floatval($_GPC['money']);

		if ($money <= 0) {
			show_json(0, '充值金额必须大于0!');
		}

		if ($money < $minimumcharge && 0 < $minimumcharge) {
			show_json(0, '最低充值金额为' . $minimumcharge . '元!');
		}

		if (empty($money)) {
			show_json(0, '请填写充值金额!');
		}

		pdo_delete('ewei_shop_member_log', array('openid' => $_W['openid'], 'status' => 0, 'type' => 0, 'uniacid' => $_W['uniacid']));
		$logno = m('common')->createNO('member_log', 'logno', 'RC');
		$log = array('uniacid' => $_W['uniacid'], 'logno' => $logno, 'title' => $set['shop']['name'] . '会员充值', 'openid' => $_W['openid'], 'money' => $money, 'type' => 0, 'createtime' => time(), 'status' => 0, 'couponid' => intval($_GPC['couponid']));
		pdo_insert('ewei_shop_member_log', $log);
		$logid = pdo_insertid();
		$type = $_GPC['type'];
		if (empty($logid) || (int) $logid < 1) {
			show_json(0, '充值订单创建失败请重试!');
		}

		if (is_h5app()) {
			show_json(1, array('logno' => $logno, 'money' => $money));
		}

		$set = m('common')->getSysset(array('shop', 'pay'));
		$set['pay']['weixin'] = !empty($set['pay']['weixin_sub']) ? 1 : $set['pay']['weixin'];
		$set['pay']['weixin_jie'] = !empty($set['pay']['weixin_jie_sub']) ? 1 : $set['pay']['weixin_jie'];

		if ($type == 'wechat') {
			if (!is_weixin()) {
				show_json(0, '非微信环境!');
			}

			if (empty($set['pay']['weixin']) && empty($set['pay']['weixin_jie'])) {
				show_json(0, '未开启微信支付!');
			}

			$wechat = array('success' => false);
			$jie = intval($_GPC['jie']);
			$params = array();
			$params['tid'] = $log['logno'];
			$params['user'] = $_W['openid'];
			$params['fee'] = $money;
			$params['title'] = $log['title'];
			if (isset($set['pay']) && $set['pay']['weixin'] == 1 && $jie !== 1) {
				load()->model('payment');
				$setting = uni_setting($_W['uniacid'], array('payment'));
				$options = array();

				if (is_array($setting['payment'])) {
					$options = $setting['payment']['wechat'];
					$options['appid'] = $_W['account']['key'];
					$options['secret'] = $_W['account']['secret'];
				}

				$wechat = m('common')->wechat_build($params, $options, 1);

				if (!is_error($wechat)) {
					$wechat['success'] = true;

					if (!empty($wechat['code_url'])) {
						$wechat['weixin_jie'] = true;
					}
					else {
						$wechat['weixin'] = true;
					}
				}
			}

			if (isset($set['pay']) && $set['pay']['weixin_jie'] == 1 && !$wechat['success'] || $jie === 1) {
				$params['tid'] = $params['tid'] . '_borrow';
				$sec = m('common')->getSec();
				$sec = iunserializer($sec['sec']);
				$options = array();
				$options['appid'] = $sec['appid'];
				$options['mchid'] = $sec['mchid'];
				$options['apikey'] = $sec['apikey'];
				if (!empty($set['pay']['weixin_jie_sub']) && !empty($sec['sub_secret_jie_sub'])) {
					$wxuser = m('member')->wxuser($sec['sub_appid_jie_sub'], $sec['sub_secret_jie_sub']);
					$params['openid'] = $wxuser['openid'];
				}
				else {
					if (!empty($sec['secret'])) {
						$wxuser = m('member')->wxuser($sec['appid'], $sec['secret']);
						$params['openid'] = $wxuser['openid'];
					}
				}

				$wechat = m('common')->wechat_native_build($params, $options, 1);

				if (!is_error($wechat)) {
					$wechat['success'] = true;

					if (!empty($params['openid'])) {
						$wechat['weixin'] = true;
					}
					else {
						$wechat['weixin_jie'] = true;
					}
				}
			}

			$wechat['jie'] = $jie;

			if (!$wechat['success']) {
				show_json(0, '微信支付参数错误!');
			}

			show_json(1, array('wechat' => $wechat, 'logid' => $logid));
		}
		else {
			if ($type == 'alipay') {
				$alipay = array('success' => false);
				$params = array();
				$params['tid'] = $log['logno'];
				$params['user'] = $_W['openid'];
				$params['fee'] = $money;
				$params['title'] = $log['title'];
				load()->func('communication');
				load()->model('payment');
				$setting = uni_setting($_W['uniacid'], array('payment'));

				if (is_array($setting['payment'])) {
					$options = $setting['payment']['alipay'];
					$alipay = m('common')->alipay_build($params, $options, 1, $_W['openid']);

					if (!empty($alipay['url'])) {
						$alipay['url'] = urlencode($alipay['url']);
						$alipay['success'] = true;
					}
				}

				list(, $payment) = m('common')->public_build();

				if ($payment['type'] == '4') {
					$params = array('service' => 'pay.alipay.native', 'body' => $params['title'], 'out_trade_no' => $params['tid'], 'total_fee' => $money);

					if (!empty($order['ordersn2'])) {
						$params['out_trade_no'] = $log['logno'] . '_B';
					}
					else {
						$params['out_trade_no'] = $log['logno'] . '_borrow';
					}

					$AliPay = m('pay')->build($params, $payment, 1);
					if (!empty($AliPay) && !is_error($AliPay)) {
						$alipay['url'] = urlencode($AliPay['code_url']);
						$alipay['success'] = true;
					}
				}

				show_json(1, array('alipay' => $alipay, 'logid' => $logid, 'logno' => $logno));
			}
		}

		show_json(0, '未找到支付方式');
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
			if (empty($log['status'])) {
				show_json(0);
			}
			else if ($_W['ispost']) {
				show_json(1);
			}
			else {
				header('location: ' . mobileUrl('member'));
			}
		}

		if ($_W['ispost']) {
			show_json(0);
		}
		else {
			header('location: ' . mobileUrl('member'));
		}
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
}

?>
