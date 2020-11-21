<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Detail_EweiShopV2Page extends PluginMobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$advs = array();
		$advs[] = array('thumb' => 'http://demo.foxteam.cc/attachment/images/11/2016/07/nDWWvjzIPJHfdX1p1AbBccF1Z2VIPd.png', 'link' => 'http://www.baidu.com');
		mobileUrl();
		include $this->template();
		exit();
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$shop = m('common')->getSysset('shop');
		$member = m('member')->getMember($openid);
		$goods = $this->model->getGoods($id, $member);
		$set = m('common')->getPluginset('creditshop');
		$goods['subdetail'] = m('ui')->lazy($goods['subdetail']);
		$goods['noticedetail'] = m('ui')->lazy($goods['noticedetail']);
		$goods['usedetail'] = m('ui')->lazy($goods['usedetail']);
		$goods['goodsdetail'] = m('ui')->lazy($goods['goodsdetail']);
		$credit = $member['credit1'];
		$money = $member['credit2'];

		if (!empty($goods)) {
			pdo_update('ewei_shop_creditshop_goods', array('views' => $goods['views'] + 1), array('id' => $id));
			$goods['followed'] = m('user')->followed($openid);
		}
		else {
			$this->message('商品已下架或被删除!', mobileUrl('creditshop'), 'error');
		}

		if ($goods['type'] == 0) {
			$stores = array();

			if (!empty($goods['isverify'])) {
				$storeids = array();

				if (!empty($goods['storeids'])) {
					$storeids = array_merge(explode(',', $goods['storeids']), $storeids);
				}

				if (empty($storeids)) {
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  uniacid=:uniacid and status=1', array(':uniacid' => $_W['uniacid']));
				}
				else {
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and status=1', array(':uniacid' => $_W['uniacid']));
				}
			}
		}

		$_W['shopshare'] = array('title' => !empty($goods['share_title']) ? $goods['share_title'] : $goods['title'], 'imgUrl' => !empty($goods['share_icon']) ? tomedia($goods['share_icon']) : tomedia($goods['thumb']), 'link' => mobileUrl('creditshop/detail', array('id' => $id), true), 'desc' => !empty($goods['share_desc']) ? $goods['share_desc'] : $goods['title']);
		$com = p('commission');

		if ($com) {
			$cset = $com->getSet();

			if (!empty($cset)) {
				if ($member['isagent'] == 1 && $member['status'] == 1) {
					$_W['shopshare']['link'] = mobileUrl('creditshop/detail', array('id' => $id, 'mid' => $member['id']), true);
					if (empty($cset['become_reg']) && (empty($member['realname']) || empty($member['mobile']))) {
						$trigger = true;
					}
				}
				else {
					if (!empty($_GPC['mid'])) {
						$_W['shopshare']['link'] = mobileUrl('creditshop/detail', array('id' => $id, 'mid' => $_GPC['mid']), true);
					}
				}
			}
		}

		include $this->template();
	}

	public function pay($a = array(), $b = array())
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$shop = m('common')->getSysset('shop');
		$member = m('member')->getMember($openid);
		$goods = $this->model->getGoods($id, $member);
		$credit = $member['credit1'];
		$money = $member['credit2'];

		if (empty($goods['canbuy'])) {
			show_json(0, $goods['buymsg']);
		}

		$needpay = false;

		if (0 < $goods['money']) {
			pdo_delete('ewei_shop_creditshop_log', array('goodsid' => $id, 'openid' => $openid, 'status' => 0, 'paystatus' => 0));
			$needpay = true;
			$lastlog = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where goodsid=:goodsid and openid=:openid  and status=0 and paystatus=1 and uniacid=:uniacid limit 1', array(':goodsid' => $id, ':openid' => $openid, ':uniacid' => $uniacid));

			if (!empty($lastlog)) {
				show_json(1, array('logid' => $lastlog['id']));
			}
		}
		else {
			pdo_delete('ewei_shop_creditshop_log', array('goodsid' => $id, 'openid' => $openid, 'status' => 0));
		}

		$dispatchstatus = 0;
		if ($goods['isverify'] == 1 || $goods['goodstype'] == 1) {
			$dispatchstatus = -1;
		}

		$logno = m('common')->createNO('creditshop_log', 'logno', empty($goods['type']) ? 'EE' : 'EL');
		$log = array('uniacid' => $uniacid, 'openid' => $openid, 'logno' => $logno, 'goodsid' => $id, 'status' => 0, 'paystatus' => 0 < $goods['money'] ? 0 : -1, 'dispatchstatus' => $dispatchstatus, 'createtime' => time(), 'storeid' => intval($_GPC['storeid']), 'realname' => trim($_GPC['realname']), 'mobile' => trim($_GPC['mobile']));

		if (empty($goods['type'])) {
			$log['eno'] = $this->model->createENO();
		}

		pdo_insert('ewei_shop_creditshop_log', $log);
		$logid = pdo_insertid();
		if (!empty($log['realname']) && !empty($log['mobile'])) {
			$up = array('realname' => $log['realname'], 'mobile' => $log['mobile']);
			pdo_update('ewei_shop_member', $up, array('id' => $member['id'], 'uniacid' => $_W['uniacid']));

			if (!empty($member['uid'])) {
				load()->model('mc');
				mc_update($member['uid'], $up);
			}
		}

		if ($needpay) {
			$useweixin = true;

			if (!empty($goods['usecredit2'])) {
				if ($goods['money'] < $money) {
					$useweixin = false;
				}
			}

			if (is_h5app() && $useweixin) {
				$useweixin = false;
			}

			pdo_update('ewei_shop_creditshop_log', array('paytype' => $useweixin ? 1 : 0), array('id' => $logid));

			if ($useweixin) {
				$set = m('common')->getSysset();
				$set['pay']['weixin'] = !empty($set['pay']['weixin_sub']) ? 1 : $set['pay']['weixin'];
				$set['pay']['weixin_jie'] = !empty($set['pay']['weixin_jie_sub']) ? 1 : $set['pay']['weixin_jie'];

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
				$params['user'] = $openid;
				$params['fee'] = $goods['money'];
				$params['title'] = $set['shop']['name'] . (empty($goods['type']) ? ' ' . $_W['shopset']['trade']['credittext'] . '兑换' : '' . $_W['shopset']['trade']['credittext'] . '抽奖') . ' 单号:' . $log['logno'];
				if (isset($set['pay']) && $set['pay']['weixin'] == 1 && $jie !== 1) {
					load()->model('payment');
					$setting = uni_setting($_W['uniacid'], array('payment'));
					$options = array();

					if (is_array($setting['payment'])) {
						$options = $setting['payment']['wechat'];
						$options['appid'] = $_W['account']['key'];
						$options['secret'] = $_W['account']['secret'];
					}

					$wechat = m('common')->wechat_build($params, $options, 2);
					$wechat['success'] = false;

					if (!is_error($wechat)) {
						$wechat['weixin'] = true;
						$wechat['success'] = true;
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

					$wechat = m('common')->wechat_native_build($params, $options, 2);

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

				show_json(1, array('logid' => $logid, 'wechat' => $wechat));
			}
		}

		show_json(1, array('logid' => $logid));
	}

	public function lottery()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$member = m('member')->getMember($openid);
		$goods = $this->model->getGoods($id, $member);
		$credit = $member['credit1'];
		$money = $member['credit2'];
		$logid = intval($_GPC['logid']);
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $logid, ':uniacid' => $uniacid));

		if (empty($log)) {
			show_json(-1, '服务器错误!');
		}

		if (1 <= $log['status']) {
			show_json(-1, '此记录已作废!');
		}

		if (empty($goods['canbuy'])) {
			show_json(-1, $goods['buymsg']);
		}

		pdo_update('ewei_shop_creditshop_goods', array('joins' => $goods['joins'] + 1), array('id' => $id));
		$update = array('couponid' => $goods['couponid']);

		if (empty($log['paystatus'])) {
			if (0 < $goods['credit'] && $credit < $goods['credit']) {
				show_json(-1, '' . $_W['shopset']['trade']['credittext'] . '不足!');
			}

			if (0 < $goods['money'] && $money < $goods['money'] && $log['paytype'] == 0) {
				show_json(-1, '余额不足!');
			}
		}

		if (0 < $goods['money'] && empty($log['paystatus'])) {
			if ($log['paytype'] == 0) {
				m('member')->setCredit($openid, 'credit2', 0 - $goods['money'], '' . $_W['shopset']['trade']['credittext'] . ('商城抽奖扣除余额度 ' . $goods['money']));
				$update['paystatus'] = 1;
			}

			if ($log['paytype'] == 1) {
				if (empty($log['paystatus'])) {
					show_json(-1, '未支付成功!');
				}
			}
		}

		if (0 < $goods['credit'] && empty($log['creditpay'])) {
			m('member')->setCredit($openid, 'credit1', 0 - $goods['credit'], '' . $_W['shopset']['trade']['credittext'] . '商城抽奖扣除' . $_W['shopset']['trade']['credittext'] . (' ' . $goods['credit']));
			$update['creditpay'] = 1;
		}

		$status = 1;

		if (!empty($goods['type'])) {
			if (0 < $goods['rate1'] && 0 < $goods['rate2']) {
				if ($goods['rate1'] == $goods['rate2']) {
					$status = 2;
				}
				else {
					$rand = rand(0, intval($goods['rate2']));

					if ($rand <= intval($goods['rate1'])) {
						$status = 2;
					}
				}
			}

			if ($status == 2) {
				$update['eno'] = $this->model->createENO();
			}
		}
		else {
			$status = 2;
		}

		$update['status'] = $status;
		pdo_update('ewei_shop_creditshop_log', $update, array('id' => $logid));

		if ($status == 2) {
			$this->model->sendMessage($logid);

			if ($goods['goodstype'] == 1) {
				if (com('coupon')) {
					com('coupon')->creditshop($logid);
					$status = 3;
				}
			}
		}

		show_json($status);
	}
}

?>
