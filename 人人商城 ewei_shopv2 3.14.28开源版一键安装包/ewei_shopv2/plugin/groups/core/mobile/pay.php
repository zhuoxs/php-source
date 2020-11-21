<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Pay_EweiShopV2Page extends PluginMobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		load()->model('mc');
		$uid = mc_openid2uid($openid);

		if (empty($uid)) {
			mc_oauth_userinfo($openid);
		}

		$member = m('member')->getMember($openid, true);
		$uniacid = $_W['uniacid'];
		$orderid = intval($_GPC['orderid']);
		$teamid = intval($_GPC['teamid']);
		$order = pdo_fetch('select o.*,g.title,g.status as gstatus,g.deleted as gdeleted,g.stock from ' . tablename('ewei_shop_groups_order') . ' as o
				left join ' . tablename('ewei_shop_groups_goods') . ' as g on g.id = o.goodid
				where o.id = :id and o.uniacid = :uniacid order by o.createtime desc', array(':id' => $orderid, ':uniacid' => $uniacid));

		if (empty($order)) {
			$this->message('订单未找到！', mobileUrl('groups/index'), 'error');
		}

		if (!empty($isteam) && $order['success'] == -1) {
			$this->message('该活动已失效，请浏览其他商品或联系商家！', mobileUrl('groups/index'), 'error');
		}

		if (empty($order['gstatus']) || !empty($order['gdeleted'])) {
			$this->message($order['title'] . '<br/> 已下架!', mobileUrl('groups/index'), 'error');
		}

		if ($order['stock'] <= 0) {
			$this->message($order['title'] . '<br/>库存不足!', mobileUrl('groups/index'), 'error');
		}

		if (!empty($teamid)) {
			$team_orders = pdo_fetchall('select * from ' . tablename('ewei_shop_groups_order') . '
					where teamid = :teamid and uniacid = :uniacid ', array(':teamid' => $teamid, ':uniacid' => $uniacid));

			foreach ($team_orders as $key => $value) {
				if ($team_orders && $value['success'] == -1) {
					$this->message('该活动已过期，请浏览其他商品或联系商家！', mobileUrl('groups/index'), 'error');
				}

				if ($team_orders && $value['success'] == 1) {
					$this->message('该活动已结束，请浏览其他商品或联系商家！', mobileUrl('groups/index'), 'error');
				}
			}

			$num = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . ' as o where teamid = :teamid and status > :status and uniacid = :uniacid ', array(':teamid' => $teamid, ':status' => 0, ':uniacid' => $uniacid));

			if ($order['groupnum'] <= $num) {
				$this->message('该活动已成功组团，请浏览其他商品或联系商家！', mobileUrl('groups/index'), 'error');
			}
		}

		if (empty($order)) {
			header('location: ' . mobileUrl('groups'));
			exit();
		}

		if ($order['status'] == -1) {
			header('location: ' . mobileUrl('groups/goods', array('id' => $order['goodid'])));
			exit();
		}
		else {
			if (1 <= $order['status']) {
				header('location: ' . mobileUrl('groups/goods', array('id' => $order['goodid'])));
				exit();
			}
		}

		$log = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_groups_paylog') . '
		 WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid limit 1', array(':uniacid' => $uniacid, ':module' => 'groups', ':tid' => $order['orderno']));
		if (!empty($log) && $log['status'] != '0') {
			header('location: ' . mobileUrl('groups/goods', array('id' => $order['id'])));
			exit();
		}

		if (empty($log)) {
			$log = array('uniacid' => $uniacid, 'openid' => $_W['openid'], 'module' => 'groups', 'tid' => $order['orderno'], 'credit' => $order['credit'], 'creditmoney' => $order['creditmoney'], 'fee' => $order['price'] - $order['creditmoney'] + $order['freight'], 'status' => 0);
			pdo_insert('ewei_shop_groups_paylog', $log);
			$plid = pdo_insertid();
		}

		$set = m('common')->getSysset(array('shop', 'pay'));
		$set['pay']['weixin'] = !empty($set['pay']['weixin_sub']) ? 1 : $set['pay']['weixin'];
		$set['pay']['weixin_jie'] = !empty($set['pay']['weixin_jie_sub']) ? 1 : $set['pay']['weixin_jie'];
		$sec = m('common')->getSec();
		$sec = iunserializer($sec['sec']);
		$param_title = $set['shop']['name'] . '订单';
		$credit = array('success' => false);
		if (isset($set['pay']) && $set['pay']['credit'] == 1) {
			if ($order['deductcredit2'] <= 0) {
				$credit = array('success' => true, 'current' => $member['credit2']);
			}
		}

		$wechat = array('success' => false);

		if (is_weixin()) {
			$params = array();
			$params['tid'] = $log['tid'];
			$params['user'] = $openid;
			$params['fee'] = $log['fee'];
			$params['title'] = $param_title;
			if (isset($set['pay']) && $set['pay']['weixin'] == 1) {
				load()->model('payment');
				$setting = uni_setting($_W['uniacid'], array('payment'));
				$options = array();

				if (is_array($setting['payment'])) {
					$options = $setting['payment']['wechat'];
					$options['appid'] = $_W['account']['key'];
					$options['secret'] = $_W['account']['secret'];
				}

				$wechat = m('common')->wechat_build($params, $options, 5);

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

			if (isset($set['pay']) && $set['pay']['weixin_jie'] == 1 && !$wechat['success']) {
				$params['tid'] = $params['tid'] . '_borrow';
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

				$wechat = m('common')->wechat_native_build($params, $options, 5);

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
		}

		$payinfo = array('orderid' => $orderid, 'teamid' => $teamid, 'credit' => $credit, 'wechat' => $wechat, 'money' => $log['fee']);

		if (is_h5app()) {
			$payinfo = array('wechat' => !empty($sec['app_wechat']['merchname']) && !empty($set['pay']['app_wechat']) && !empty($sec['app_wechat']['appid']) && !empty($sec['app_wechat']['appsecret']) && !empty($sec['app_wechat']['merchid']) && !empty($sec['app_wechat']['apikey']) && 0 < $order['price'] ? true : false, 'alipay' => false, 'mcname' => $sec['app_wechat']['merchname'], 'ordersn' => $order['orderno'], 'money' => $log['fee'], 'attach' => $_W['uniacid'] . ':5', 'type' => 5, 'orderid' => $orderid, 'credit' => $credit, 'teamid' => $teamid);
		}

		include $this->template();
	}

	public function complete()
	{
		global $_W;
		global $_GPC;
		$orderid = intval($_GPC['orderid']);
		$teamid = intval($_GPC['teamid']);
		$isteam = intval($_GPC['isteam']);
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		if (is_h5app() && empty($orderid)) {
			$ordersn = $_GPC['ordersn'];
			$orderid = pdo_fetchcolumn('select id from ' . tablename('ewei_shop_groups_order') . ' where orderno=:orderno and uniacid=:uniacid and openid=:openid limit 1', array(':orderno' => $ordersn, ':uniacid' => $uniacid, ':openid' => $openid));
		}

		if (empty($orderid)) {
			if ($_W['ispost']) {
				show_json(0, '参数错误!');
			}
			else {
				$this->message('参数错误!', mobileUrl('groups/orders'));
			}
		}

		$order = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order') . ' where id = :orderid and uniacid=:uniacid and openid=:openid', array(':orderid' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));

		if (empty($order)) {
			if ($_W['ispost']) {
				show_json(0, '订单不存在!');
			}
			else {
				$this->message('参数错误!', mobileUrl('groups/orders'));
			}
		}

		$order_goods = pdo_fetch('select * from  ' . tablename('ewei_shop_groups_goods') . '
					where id = :id and uniacid=:uniacid ', array(':uniacid' => $_W['uniacid'], ':id' => $order['goodid']));

		if (empty($order_goods)) {
			if ($_W['ispost']) {
				show_json(0, '商品不存在!');
			}
			else {
				$this->message('商品不存在!', mobileUrl('groups/orders'));
			}
		}

		$type = $_GPC['type'];

		if (!in_array($type, array('wechat', 'alipay', 'credit', 'cash'))) {
			if ($_W['ispost']) {
				show_json(0, '未找到支付方式!');
			}
			else {
				$this->message('未找到支付方式!', mobileUrl('groups/orders'));
			}
		}

		$log = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_groups_paylog') . '
		 WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid limit 1', array(':uniacid' => $uniacid, ':module' => 'groups', ':tid' => $order['orderno']));

		if (empty($log)) {
			if ($_W['ispost']) {
				show_json(0, '支付出错,请重试(0)!');
			}
			else {
				$this->message('支付出错,请重试!', mobileUrl('groups/orders'));
			}
		}

		if ($type == 'credit') {
			$orderno = $order['orderno'];
			$credits = m('member')->getCredit($openid, 'credit2');
			if ($credits < $log['fee'] || $credits < 0) {
				show_json($credits, '余额不足,请充值');
			}

			$fee = floatval($log['fee']);
			$result = m('member')->setCredit($openid, 'credit2', 0 - $fee, array($_W['member']['uid'], $_W['shopset']['shop']['name'] . '消费' . $fee));

			if (is_error($result)) {
				if ($_W['ispost']) {
					show_json(0, $result['message']);
				}
				else {
					$this->message($result['message'], mobileUrl('groups/orders'));
				}
			}

			$this->model->payResult($log['tid'], $type);
			pdo_update('ewei_shop_groups_order', array('pay_type' => 'credit', 'status' => 1, 'paytime' => time(), 'starttime' => time()), array('id' => $orderid));

			if ($_W['ispost']) {
				show_json(1);
			}
			else {
				header('location: ' . mobileUrl('groups/team/detail', array('orderid' => $orderid, 'teamid' => $orderid)));
				exit();
			}
		}
		else {
			if ($type == 'wechat') {
				$orderno = $order['orderno'];

				if (!empty($order['ordersn2'])) {
					$orderno .= 'GJ' . sprintf('%02d', $order['ordersn2']);
				}

				$payquery = m('finance')->isWeixinPay($orderno, $log['fee'], is_h5app() ? true : false);
				$payqueryBorrow = m('finance')->isWeixinPayBorrow($orderno, $log['fee']);
				if (!is_error($payquery) || !is_error($payqueryBorrow)) {
					$this->model->payResult($log['tid'], $type, is_h5app() ? true : false);
					pdo_update('ewei_shop_groups_order', array('pay_type' => 'wechat', 'status' => 1, 'paytime' => time(), 'starttime' => time(), 'apppay' => is_h5app() ? 1 : 0), array('id' => $orderid));

					if ($_W['ispost']) {
						show_json(1);
					}
					else {
						header('location: ' . mobileUrl('groups/team/detail', array('orderid' => $orderid, 'teamid' => $orderid)));
						exit();
					}
				}
				else if ($_W['ispost']) {
					show_json(0, '支付出错,请重试(1)!');
				}
				else {
					$this->message('支付出错,请重试!', mobileUrl('groups/orders'));
				}
			}
		}
	}

	public function orderstatus()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$orderid = intval($_GPC['id']);
		$order = pdo_fetch('select status from ' . tablename('ewei_shop_groups_order') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $orderid, ':uniacid' => $uniacid));
		show_json(1, $order);
	}

	public function checkorder()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$orderid = intval($_GPC['orderid']);
		$teamid = intval($_GPC['teamid']);
		$isteam = intval($_GPC['isteam']);
		$order = pdo_fetch('select o.*,g.title,g.status as gstatus,g.deleted as gdeleted,g.stock from ' . tablename('ewei_shop_groups_order') . ' as o
				left join ' . tablename('ewei_shop_groups_goods') . ' as g on g.id = o.goodid
				where o.id = :id and o.uniacid = :uniacid order by o.createtime desc', array(':id' => $orderid, ':uniacid' => $uniacid));

		if (empty($order)) {
			show_json(0, '订单未找到！');
		}

		if (!empty($isteam) && $order['success'] == -1) {
			show_json(0, '该活动已失效，请浏览其他商品或联系商家！！');
		}

		if (empty($order['gstatus']) || !empty($order['gdeleted'])) {
			show_json(0, $order['title'] . '<br/> 已下架!');
		}

		if ($order['stock'] <= 0) {
			show_json(0, $order['title'] . '<br/>库存不足!');
		}

		if (!empty($teamid)) {
			$team_orders = pdo_fetchall('select * from ' . tablename('ewei_shop_groups_order') . '
					where teamid = :teamid and uniacid = :uniacid ', array(':teamid' => $teamid, ':uniacid' => $uniacid));

			foreach ($team_orders as $key => $value) {
				if ($team_orders && $value['success'] == -1) {
					show_json(0, '该活动已过期，请浏览其他商品或联系商家！');
				}

				if ($team_orders && $value['success'] == 1) {
					show_json(0, '该活动已结束，请浏览其他商品或联系商家！');
				}
			}

			$num = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . ' as o where teamid = :teamid and status > :status and uniacid = :uniacid ', array(':teamid' => $teamid, ':status' => 0, ':uniacid' => $uniacid));

			if ($order['groupnum'] <= $num) {
				show_json(0, '该活动已成功组团，请浏览其他商品或联系商家！');
			}
		}

		show_json(1, '可以支付');
	}
}

?>
