<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Pay_EweiShopV2Page extends AppMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$member = m('member')->getMember($openid, true);
		$uniacid = $_W['uniacid'];
		$orderid = intval($_GPC['orderid']);
		$teamid = intval($_GPC['teamid']);
		$order = pdo_fetch('select o.*,g.title,g.status as gstatus,g.deleted as gdeleted,g.stock,l.id as l_id,l.ladder_num as l_ladder_num,l.ladder_price as l_ladder_price,
                og.id as og_id,og.title as og_title,og.price as og_price,og.single_price as og_single_price, og.stock as og_stock 
                from ' . tablename('ewei_shop_groups_order') . ' as o
				left join ' . tablename('ewei_shop_groups_goods') . ' as g on g.id = o.goodid
				left join' . tablename('ewei_shop_groups_ladder') . ' as l on l.id = o.ladder_id
				left join ' . tablename('ewei_shop_groups_order_goods') . ' as or_g on or_g.groups_order_id = o.id 
				left join' . tablename('ewei_shop_groups_goods_option') . ' as og on og.id = or_g.groups_goods_option_id
				where o.id = :id and o.uniacid = :uniacid order by o.createtime desc', array(':id' => $orderid, ':uniacid' => $uniacid));

		if (empty($order)) {
			return app_error(1, '订单未找到');
		}

		if (!empty($isteam) && $order['success'] == -1) {
			return app_error(1, '该活动已失效，请浏览其他商品或联系商家！(1)');
		}

		if (empty($order['gstatus']) || !empty($order['gdeleted'])) {
			return app_error(1, $order['title'] . '已下架!');
		}

		if (!empty($order['more_spec'])) {
			if ($order['og_stock'] <= 0) {
				return app_error(1, $order['og_title'] . '库存不足(2)!');
			}
		}
		else {
			if ($order['stock'] <= 0) {
				return app_error(1, $order['title'] . '库存不足(1)!');
			}
		}

		if (!empty($teamid)) {
			$team_orders = pdo_fetchall('select * from ' . tablename('ewei_shop_groups_order') . '
					where teamid = :teamid and uniacid = :uniacid ', array(':teamid' => $teamid, ':uniacid' => $uniacid));

			foreach ($team_orders as $key => $value) {
				if ($team_orders && $value['success'] == -1) {
					return app_error(1, '该活动已过期，请浏览其他商品或联系商家！(2)');
				}

				if ($team_orders && $value['success'] == 1) {
					return app_error(1, '该活动已结束，请浏览其他商品或联系商家！(3)');
				}
			}

			$num = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . ' as o where teamid = :teamid and status > :status and uniacid = :uniacid ', array(':teamid' => $teamid, ':status' => 0, ':uniacid' => $uniacid));

			if ($order['groupnum'] <= $num) {
				return app_error(1, '该活动已成功组团，请浏览其他商品或联系商家！');
			}
		}

		if (empty($order)) {
			return app_error(1, '暂无订单');
		}

		if ($order['status'] == -1) {
			return app_error(1, '该活动已过期，请浏览其他商品或联系商家！(4)');
		}

		if (1 <= $order['status']) {
			return app_error(1, '订单已付款');
		}

		$log = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_groups_paylog') . '
		 WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid limit 1', array(':uniacid' => $uniacid, ':module' => 'groups', ':tid' => $order['orderno']));
		if (!empty($log) && $log['status'] != '0') {
			return app_error(1, '订单已付款');
		}

		if (empty($log)) {
			$log = array('uniacid' => $uniacid, 'openid' => $_W['openid'], 'module' => 'groups', 'tid' => $order['orderno'], 'credit' => $order['credit'], 'creditmoney' => $order['creditmoney'], 'fee' => $order['price'] - $order['creditmoney'] + $order['freight'], 'status' => 0);
			pdo_insert('ewei_shop_groups_paylog', $log);
			$plid = pdo_insertid();
		}

		$set = m('common')->getSysset(array('shop', 'pay'));
		$credit = array('success' => false);
		if (isset($set['pay']) && $set['pay']['credit'] == 1) {
			if ($order['deductcredit2'] <= 0) {
				$credit = array('success' => true, 'current' => $member['credit2']);
			}
		}

		$param_title = $set['shop']['name'] . '订单';
		$wechat = array('success' => false);
		if (!empty($set['pay']['wxapp']) && 0 < $order['price'] + $order['freight'] && $this->iswxapp) {
			$payinfo = array('openid' => $_W['openid_wa'], 'title' => $set['shop']['name'] . '订单', 'tid' => $order['orderno'], 'fee' => $order['price'] - $order['creditmoney'] + $order['freight']);
			$res = $this->model->wxpay($payinfo, 19);

			if (!is_error($res)) {
				$wechat = array('success' => true, 'payinfo' => $res);
				if (!empty($res['package']) && strexists($res['package'], 'prepay_id=')) {
					$prepay_id = str_replace('prepay_id=', '', $res['package']);
					pdo_update('ewei_shop_groups_order', array('wxapp_prepay_id' => $prepay_id), array('id' => $orderid, 'uniacid' => $_W['uniacid']));
				}
			}
			else {
				$wechat['payinfo'] = $res;
			}
		}

		$payinfo = array('orderid' => $orderid, 'orderno' => $order['orderno'], 'teamid' => $teamid, 'credit' => $credit, 'wechat' => $wechat, 'money' => $log['fee']);
		return app_json(array('data' => $payinfo));
	}

	public function complete()
	{
		global $_W;
		global $_GPC;
		$orderid = intval($_GPC['id']);
		$teamid = intval($_GPC['teamid']);
		$isteam = intval($_GPC['isteam']);
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$member = m('member')->getMember($openid);

		if (empty($orderid)) {
			return app_error(1, '参数错误(1)');
		}

		$order = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order') . ' where id = :orderid and uniacid=:uniacid and openid=:openid', array(':orderid' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));

		if (empty($order)) {
			return app_error(1, '参数错误(2)');
		}

		$order_goods = pdo_fetch('select * from  ' . tablename('ewei_shop_groups_goods') . '
					where id = :id and uniacid=:uniacid ', array(':uniacid' => $_W['uniacid'], ':id' => $order['goodid']));

		if (empty($order_goods)) {
			return app_error(1, '商品不存在');
		}

		$type = $_GPC['type'];

		if (!in_array($type, array('wechat', 'credit'))) {
			return app_error(1, '未找到支付方式！');
		}

		$log = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_groups_paylog') . '
		 WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid limit 1', array(':uniacid' => $uniacid, ':module' => 'groups', ':tid' => $order['orderno']));

		if (empty($log)) {
			return app_error(1, '支付出错,请重试');
		}

		if ($type == 'credit') {
			$orderno = $order['orderno'];
			$credits = m('member')->getCredit($openid, 'credit2');
			if ($credits < $log['fee'] || $credits < 0) {
				return app_error(1, '余额不足，请充值！');
			}

			$fee = floatval($log['fee']);
			$result = m('member')->setCredit($openid, 'credit2', 0 - $fee, array($member['uid'], $_W['shopset']['shop']['name'] . '消费' . $fee));

			if (is_error($result)) {
				return app_error($result['message']);
			}

			p('groups')->payResult($log['tid'], $type);
			pdo_update('ewei_shop_groups_order', array('pay_type' => 'credit', 'status' => 1, 'paytime' => time(), 'starttime' => time()), array('id' => $orderid));
			return app_json(array('orderno' => $log, 'fee' => $fee, 'type' => '余额支付', 'msg' => '支付成功'));
		}

		if ($type == 'wechat') {
			$orderno = $order['orderno'];
			$payquery = $this->model->isWeixinPay($orderno, $order['price']);

			if (!is_error($payquery)) {
				p('groups')->payResult($log['tid'], $type);
				pdo_update('ewei_shop_groups_order', array('pay_type' => 'wechat', 'status' => 1, 'paytime' => time(), 'starttime' => time(), 'apppay' => is_h5app() ? 1 : 0), array('id' => $orderid));
				return app_json(array('orderno' => $log, 'fee' => $log['fee'], 'type' => '微信支付', 'msg' => '支付成功'));
			}

			return app_error(1, '支付出错，请重试（1）');
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
