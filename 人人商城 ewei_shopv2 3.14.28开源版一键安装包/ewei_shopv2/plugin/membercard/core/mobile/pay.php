<?php
//QQ63779278
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
		$member = m('member')->getMember($openid, true);
		$uniacid = $_W['uniacid'];
		$orderid = intval($_GPC['id']);
		$order = pdo_fetch('select o.*,c.name,c.status as gstatus,c.isdelete as gdeleted,c.stock from ' . tablename('ewei_shop_member_card_order') . ' as o
				left join ' . tablename('ewei_shop_member_card') . ' as c on c.id = o.member_card_id
				where o.id = :id and o.uniacid = :uniacid order by o.createtime desc', array(':id' => $orderid, ':uniacid' => $uniacid));

		if (empty($order)) {
			$this->message('订单未找到！', mobileUrl('membercard/index'), 'error');
		}

		if (empty($order['gstatus']) || !empty($order['gdeleted'])) {
			$this->message($order['name'] . '<br/> 已下架!', mobileUrl('membercard/index'), 'error');
		}

		if ($order['stock'] <= 0) {
			$this->message($order['name'] . '<br/>库存不足!', mobileUrl('membercard/index'), 'error');
		}

		if ($order['status'] == -1) {
			header('location: ' . mobileUrl('membercard/detail', array('id' => $order['member_card_id'])));
			exit();
		}
		else {
			if (1 <= $order['status']) {
				header('location: ' . mobileUrl('membercard/detail', array('id' => $order['member_card_id'])));
				exit();
			}
		}

		$log = pdo_fetch('SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid limit 1', array(':uniacid' => $uniacid, ':module' => 'membercard', ':tid' => $order['orderno']));

		if (!empty($ispeerpay)) {
		}
		else {
			if (!empty($log) && $log['status'] != '0') {
				header('location: ' . mobileUrl('membercard/detail', array('id' => $order['id'])));
				exit();
			}
		}

		if (empty($log)) {
			$log = array('uniacid' => $uniacid, 'openid' => trim($member['uid']), 'module' => 'membercard', 'tid' => trim($order['orderno']), 'fee' => $order['total'], 'status' => 0);
			pdo_insert('core_paylog', $log);
			$plid = pdo_insertid();
		}

		$set = m('common')->getSysset(array('shop', 'pay'));
		$set['pay']['weixin'] = !empty($set['pay']['weixin_sub']) ? 1 : $set['pay']['weixin'];
		$set['pay']['weixin_jie'] = !empty($set['pay']['weixin_jie_sub']) ? 1 : $set['pay']['weixin_jie'];
		$param_title = $set['shop']['name'] . '订单';
		$sec = m('common')->getSec();
		$sec = iunserializer($sec['sec']);
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

				$wechat = m('common')->wechat_build($params, $options, 21);

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

		$alipay = array('success' => false);
		if (isset($set['pay']) && $set['pay']['alipay'] == 1) {
			if (is_array($setting['payment']['alipay']) && ($setting['payment']['alipay']['switch'] || $setting['payment']['alipay']['pay_switch'])) {
				$params = array();
				$params['tid'] = trim($log['tid']);
				$params['user'] = trim($_W['openid']);
				$params['fee'] = $order['price'];
				$params['title'] = trim($param_title);
				load()->func('communication');
				load()->model('payment');
				$setting = uni_setting($_W['uniacid'], array('payment'));

				if (is_array($setting['payment'])) {
					$options = $setting['payment']['alipay'];
					$alipay = m('common')->alipay_build($params, $options, 22, $_W['openid']);

					if (!empty($alipay['url'])) {
						$alipay['url'] = urlencode($alipay['url']);
						$alipay['success'] = true;
					}
				}
			}
		}

		list(, $payment) = m('common')->public_build();

		if ($payment['type'] == '4') {
			$params = array('service' => 'pay.alipay.native', 'body' => trim($param_title), 'out_trade_no' => trim($log['tid']), 'total_fee' => $order['price']);

			if (!empty($order['ordersn2'])) {
				$params['out_trade_no'] = $log['tid'] . '_B';
			}
			else {
				$params['out_trade_no'] = $log['tid'] . '_borrow';
			}

			$AliPay = m('pay')->build($params, $payment, 0);
			if (!empty($AliPay) && !is_error($AliPay)) {
				$alipay['url'] = urlencode($AliPay['code_url']);
				$alipay['success'] = true;
			}
		}

		$payinfo = array('orderid' => $orderid, 'card_id' => $order['member_card_id'], 'credit' => $credit, 'wechat' => $wechat, 'money' => $order['total']);

		if (is_h5app()) {
			$payinfo = array('wechat' => !empty($sec['app_wechat']['merchname']) && !empty($set['pay']['app_wechat']) && !empty($sec['app_wechat']['appid']) && !empty($sec['app_wechat']['appsecret']) && !empty($sec['app_wechat']['merchid']) && !empty($sec['app_wechat']['apikey']) && 0 < $order['total'] ? true : false, 'alipay' => false, 'mcname' => $sec['app_wechat']['merchname'], 'card_id' => $order['member_card_id'], 'orderno' => $order['orderno'], 'money' => $order['total'], 'attach' => $_W['uniacid'] . ':21', 'type' => 21, 'orderid' => $orderid, 'credit' => $credit);
		}

		include $this->template();
	}

	public function complete()
	{
		global $_W;
		global $_GPC;
		$orderid = intval($_GPC['orderid']);
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		if (is_h5app() && empty($orderid)) {
			$orderno = $_GPC['orderno'];
			$orderid = pdo_fetchcolumn('select id from ' . tablename('ewei_shop_member_card_order') . ' where orderno=:orderno and uniacid=:uniacid and openid=:openid limit 1', array(':orderno' => $orderno, ':uniacid' => $uniacid, ':openid' => $openid));
		}

		if (empty($orderid)) {
			if ($_W['ispost']) {
				show_json(0, '参数错误!');
			}
			else {
				$this->message('参数错误!', mobileUrl('membercard/detail'));
			}
		}

		$order = pdo_fetch('select * from ' . tablename('ewei_shop_member_card_order') . ' where id = :orderid and uniacid=:uniacid and openid=:openid', array(':orderid' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));

		if (empty($order)) {
			if ($_W['ispost']) {
				show_json(0, '订单不存在!');
			}
			else {
				$this->message('参数错误!', mobileUrl('membercard/detail'));
			}
		}

		$set = m('common')->getSysset(array('shop', 'pay'));
		$set['pay']['weixin'] = !empty($set['pay']['weixin_sub']) ? 1 : $set['pay']['weixin'];
		$set['pay']['weixin_jie'] = !empty($set['pay']['weixin_jie_sub']) ? 1 : $set['pay']['weixin_jie'];
		$order_goods = pdo_fetch('select * from  ' . tablename('ewei_shop_member_card') . '
					where id = :id and uniacid=:uniacid and isdelete=0', array(':uniacid' => $_W['uniacid'], ':id' => $order['member_card_id']));

		if (empty($order_goods)) {
			if ($_W['ispost']) {
				show_json(0, '会员卡不存在!');
			}
			else {
				$this->message('会员卡不存在!', mobileUrl('membercard/detail'));
			}
		}

		$type = $_GPC['type'];

		if (!in_array($type, array('wechat', 'alipay', 'credit', 'cash'))) {
			if ($_W['ispost']) {
				show_json(0, '未找到支付方式!');
			}
			else {
				$this->message('未找到支付方式!', mobileUrl('membercard/detail'));
			}
		}

		$log = pdo_fetch('SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid limit 1', array(':uniacid' => $uniacid, ':module' => 'membercard', ':tid' => $order['orderno']));
		if (empty($log) && empty($ispeerpay)) {
			if ($_W['ispost']) {
				show_json(0, '支付出错,请重试!');
			}
			else {
				$this->message('支付出错,请重试!', mobileUrl('membercard/detail'));
			}
		}

		if ($type == 'credit') {
			if (empty($set['pay']['credit']) && 0 < $log['fee']) {
				if ($_W['ispost']) {
					show_json(0, '未开启余额支付!');
				}
				else {
					$this->message('未开启余额支付', mobileUrl('membercard/detail'));
				}
			}

			if ($log['fee'] < 0) {
				if ($_W['ispost']) {
					show_json(0, '金额错误');
				}
				else {
					$this->message('金额错误', mobileUrl('membercard/detail'));
				}
			}

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
					$this->message($result['message'], mobileUrl('membercard/detail'));
				}
			}

			$this->model->payResult($log['tid'], $type);
			pdo_update('ewei_shop_member_card_order', array('paytype' => 'credit', 'status' => 1, 'paytime' => time(), 'finishtime' => time()), array('id' => $orderid));

			if ($_W['ispost']) {
				show_json(1);
			}
			else {
				header('location: ' . mobileUrl('membercard/detail', array('id' => $order['member_card_id'])));
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
					pdo_update('ewei_shop_member_card_order', array('paytype' => 'wechat', 'status' => 1, 'paytime' => time(), 'finishtime' => time(), 'apppay' => is_h5app() ? 1 : 0), array('id' => $orderid));

					if ($_W['ispost']) {
						show_json(1);
					}
					else {
						show_json(1);
						header('location: ' . mobileUrl('membercard/detail', array('id' => $order['member_card_id'])));
						exit();
					}
				}
				else if ($_W['ispost']) {
					show_json(0, '支付出错,请重试(1)!');
				}
				else {
					$this->message('支付出错,请重试!', mobileUrl('membercard/orders'));
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
		$order = pdo_fetch('select status from ' . tablename('ewei_shop_member_card_order') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $orderid, ':uniacid' => $uniacid));
		show_json(1, $order);
	}

	public function checkorder()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$orderid = intval($_GPC['orderid']);
		$order = pdo_fetch('select o.*,c.name,c.status as gstatus,c.isdelete as gdeleted,c.stock from ' . tablename('ewei_shop_member_card_order') . ' as o
				left join ' . tablename('ewei_shop_member_card') . ' as c on c.id = o.member_card_id
				where o.id = :id and o.uniacid = :uniacid order by o.createtime desc', array(':id' => $orderid, ':uniacid' => $uniacid));

		if (empty($order)) {
			show_json(0, '订单未找到！');
		}

		if (empty($order['gstatus']) || !empty($order['gdeleted'])) {
			show_json(0, $order['name'] . '<br/> 已下架!');
		}

		if ($order['stock'] <= 0) {
			show_json(0, $order['name'] . '<br/>库存不足!');
		}

		if ($order['status'] == 1) {
			show_json(0, '改订单已经支付请不要重复支付');
		}

		show_json(1, '可以支付');
	}
}

?>
