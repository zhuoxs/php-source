<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Op_EweiShopV2Page extends MerchWebPage
{
	public function delete()
	{
		global $_W;
		global $_GPC;
		$status = intval($_GPC['status']);
		$orderid = intval($_GPC['id']);
		pdo_update('ewei_shop_order', array('deleted' => 1), array('id' => $orderid, 'uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid']));
		plog('order.op.delete', '订单删除 ID: ' . $orderid);
		show_json(1, webUrl('order', array('status' => $status)));
	}

	protected function opData()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_order') . ' WHERE id = :id and uniacid=:uniacid and merchid = :merchid', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));

		if (empty($item)) {
			if ($_W['isajax']) {
				show_json(0, '未找到订单!');
			}

			$this->message('未找到订单!', '', 'error');
		}

		$order_goods = pdo_fetchall('select single_refundstate from ' . tablename('ewei_shop_order_goods') . ' where orderid=:orderid and uniacid=:uniacid', array(':uniacid' => $_W['uniacid'], ':orderid' => $item['id']));
		$is_singlerefund = false;

		foreach ($order_goods as $og) {
			if (!$is_singlerefund && ($og['single_refundstate'] == 1 || $og['single_refundstate'] == 2)) {
				$is_singlerefund = true;
				break;
			}
		}

		return array('id' => $id, 'item' => $item, 'is_singlerefund' => $is_singlerefund);
	}

	public function changeprice()
	{
		global $_W;
		global $_GPC;
		$opdata = $this->opData();
		extract($opdata);
		$merch_user = $_W['merch_user'];

		if (100 <= $item['ordersn2']) {
			$item['ordersn2'] = 0;
		}

		if ($_W['ispost']) {
			if (empty($merch_user['changepricechecked'])) {
				show_json(0, '您没有改价的权限!');
			}

			if (0 < $item['parentid']) {
				$parent_order = array();
				$parent_order['id'] = $item['parentid'];
			}

			$changegoodsprice = $_GPC['changegoodsprice'];

			if (!is_array($changegoodsprice)) {
				show_json(0, '未找到改价内容!');
			}

			$changeprice = 0;

			foreach ($changegoodsprice as $ogid => $change) {
				$changeprice += floatval($change);
			}

			$dispatchprice = floatval($_GPC['changedispatchprice']);

			if ($dispatchprice < 0) {
				$dispatchprice = 0;
			}

			$orderprice = $item['price'] + $changeprice;
			$changedispatchprice = 0;

			if ($dispatchprice != $item['dispatchprice']) {
				$changedispatchprice = $dispatchprice - $item['dispatchprice'];
				$orderprice += $changedispatchprice;
			}

			if ($orderprice < 0) {
				show_json(0, '订单实际支付价格不能小于0元!');
			}

			foreach ($changegoodsprice as $ogid => $change) {
				$og = pdo_fetch('select price,realprice from ' . tablename('ewei_shop_order_goods') . ' where id=:ogid and uniacid=:uniacid and merchid = :merchid limit 1', array(':ogid' => $ogid, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));

				if (!empty($og)) {
					$realprice = $og['realprice'] + $change;

					if ($realprice < 0) {
						show_json(0, '单个商品不能优惠到负数');
					}
				}
			}

			$ordersn2 = $item['ordersn2'] + 1;

			if (99 < $ordersn2) {
				show_json(0, '超过改价次数限额');
			}

			$orderupdate = array();

			if ($orderprice != $item['price']) {
				$orderupdate['price'] = $orderprice;
				$orderupdate['ordersn2'] = $item['ordersn2'] + 1;

				if (0 < $item['parentid']) {
					$parent_order['price_change'] = $orderprice - $item['price'];
				}
			}

			$orderupdate['changeprice'] = $item['changeprice'] + $changeprice;

			if ($dispatchprice != $item['dispatchprice']) {
				$orderupdate['dispatchprice'] = $dispatchprice;
				$orderupdate['changedispatchprice'] = $item['changedispatchprice'] + $changedispatchprice;

				if (0 < $item['parentid']) {
					$parent_order['dispatch_change'] = $changedispatchprice;
				}
			}

			if (!empty($orderupdate)) {
				pdo_update('ewei_shop_order', $orderupdate, array('id' => $item['id'], 'uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid']));
			}

			if (0 < $item['parentid']) {
				if (!empty($parent_order)) {
					m('order')->changeParentOrderPrice($parent_order);
				}
			}

			foreach ($changegoodsprice as $ogid => $change) {
				$og = pdo_fetch('select price,realprice,changeprice from ' . tablename('ewei_shop_order_goods') . ' where id=:ogid and uniacid=:uniacid and merchid = :merchid limit 1', array(':ogid' => $ogid, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));

				if (!empty($og)) {
					$realprice = $og['realprice'] + $change;
					$changeprice = $og['changeprice'] + $change;
					pdo_update('ewei_shop_order_goods', array('realprice' => $realprice, 'changeprice' => $changeprice), array('id' => $ogid));
				}
			}

			if (0 < abs($changeprice)) {
				$pluginc = p('commission');

				if ($pluginc) {
					$pluginc->calculate($item['id'], true);
				}
			}

			plog('order.op.changeprice', '订单号： ' . $item['ordersn'] . ' <br/> 价格： ' . $item['price'] . ' -> ' . $orderprice);
			m('notice')->sendOrderChangeMessage($item['openid'], array('title' => '订单金额', 'orderid' => $item['id'], 'ordersn' => $item['ordersn'], 'olddata' => $item['price'], 'data' => round($orderprice, 2), 'type' => 1), 'orderstatus');
			show_json(1);
		}

		$order_goods = pdo_fetchall('select og.id,g.title,g.thumb,g.goodssn,og.goodssn as option_goodssn, g.productsn,og.productsn as option_productsn, og.total,og.price,og.optionname as optiontitle, og.realprice,og.oldprice from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.merchid = :merchid and og.orderid=:orderid ', array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid'], ':orderid' => $item['id']));

		if (empty($item['addressid'])) {
			$user = unserialize($item['carrier']);
			$item['addressdata'] = array('realname' => $user['carrier_realname'], 'mobile' => $user['carrier_mobile']);
		}
		else {
			$user = iunserializer($item['address']);

			if (!is_array($user)) {
				$user = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_address') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $item['addressid'], ':uniacid' => $_W['uniacid']));
			}

			$user['address'] = $user['province'] . ' ' . $user['city'] . ' ' . $user['area'] . ' ' . $user['address'];
			$item['addressdata'] = array('realname' => $user['realname'], 'mobile' => $user['mobile'], 'address' => $user['address']);
		}

		include $this->template();
	}

	public function pay($a = array(), $b = array())
	{
		global $_W;
		global $_GPC;
		$opdata = $this->opData();
		extract($opdata);
		show_json(1);

		if (1 < $item['status']) {
			show_json(0, '订单已付款，不需重复付款！');
		}

		if (!empty($item['virtual']) && com('virtual')) {
			com('virtual')->pay($item);
		}
		else {
			pdo_update('ewei_shop_order', array('status' => 1, 'paytype' => 11, 'paytime' => time()), array('id' => $item['id'], 'uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid']));
			m('order')->setStocksAndCredits($item['id'], 1);
			m('notice')->sendOrderMessage($item['id']);

			if (com('coupon')) {
				com('coupon')->sendcouponsbytask($item['id']);
			}

			if (com('coupon') && !empty($item['couponid'])) {
				com('coupon')->backConsumeCoupon($item['id']);
			}

			if (p('commission')) {
				p('commission')->checkOrderPay($item['id']);
			}
		}

		plog('order.op.pay', '订单确认付款 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn']);
		show_json(1);
	}

	public function close()
	{
		global $_W;
		global $_GPC;
		$opdata = $this->opData();
		extract($opdata);

		if ($is_singlerefund) {
			show_json(0, '订单商品存在维权，无法关闭订单！');
		}

		if ($item['status'] == -1) {
			show_json(0, '订单已关闭，无需重复关闭！');
		}
		else {
			if (1 <= $item['status']) {
				show_json(0, '订单已付款，不能关闭！');
			}
		}

		if ($_W['ispost']) {
			if (0 < $item['parentid']) {
				show_json(1);
			}

			if (!empty($item['transid'])) {
			}

			$time = time();
			if (0 < $item['refundstate'] && !empty($item['refundid'])) {
				$change_refund = array();
				$change_refund['status'] = -1;
				$change_refund['refundtime'] = $time;
				pdo_update('ewei_shop_order_refund', $change_refund, array('id' => $item['refundid'], 'uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid']));
			}

			if (0 < $item['deductcredit']) {
				m('member')->setCredit($item['openid'], 'credit1', $item['deductcredit'], array('0', $_W['shopset']['shop']['name'] . ('购物返还抵扣积分 积分: ' . $item['deductcredit'] . ' 抵扣金额: ' . $item['deductprice'] . ' 订单号: ' . $item['ordersn'])));
			}

			m('order')->setDeductCredit2($item);
			if (com('coupon') && !empty($item['couponid'])) {
				com('coupon')->returnConsumeCoupon($item['id']);
			}

			m('order')->setStocksAndCredits($item['id'], 2);
			pdo_update('ewei_shop_order', array('status' => -1, 'refundstate' => 0, 'canceltime' => $time, 'remarkclose' => $_GPC['remark']), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			plog('order.op.close', '订单关闭 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn']);
			show_json(1);
		}

		include $this->template();
	}

	public function paycancel()
	{
		global $_W;
		global $_GPC;
		$opdata = $this->opData();
		extract($opdata);

		if ($is_singlerefund) {
			show_json(0, '订单商品存在维权，无法取消付款！');
		}

		if ($item['status'] != 1) {
			show_json(0, '订单未付款，不需取消！');
		}

		if ($_W['ispost']) {
			m('order')->setStocksAndCredits($item['id'], 2);
			pdo_update('ewei_shop_order', array('status' => 0, 'cancelpaytime' => time()), array('id' => $item['id'], 'uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid']));
			plog('order.op.paycancel', '订单取消付款 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn']);
			show_json(1);
		}
	}

	public function finish()
	{
		global $_W;
		global $_GPC;
		$opdata = $this->opData();
		extract($opdata);

		if ($is_singlerefund) {
			show_json(0, '订单商品存在维权，无法确认收货！');
		}

		$merch_user = $_W['merch_user'];

		if (empty($merch_user['finishchecked'])) {
			show_json(0, '您没有确认收货的权限!');
		}

		pdo_update('ewei_shop_order', array('status' => 3, 'finishtime' => time()), array('id' => $item['id'], 'uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid']));
		m('member')->upgradeLevel($item['openid'], $item['id']);
		m('order')->setStocksAndCredits($item['id'], 3);
		m('order')->setGiveBalance($item['id'], 1);
		m('notice')->sendOrderMessage($item['id']);

		if (com('coupon')) {
			com('coupon')->sendcouponsbytask($item['id']);
		}

		if (!empty($item['couponid'])) {
			com('coupon')->backConsumeCoupon($item['id']);
		}

		if (p('lineup')) {
			p('lineup')->checkOrder($item);
		}

		if (p('commission')) {
			p('commission')->checkOrderFinish($item['id']);
		}

		plog('order.op.finish', '订单完成 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn']);
		show_json(1);
	}

	public function fetchcancel()
	{
		global $_W;
		global $_GPC;
		$opdata = $this->opData();
		extract($opdata);

		if ($is_singlerefund) {
			show_json(0, '订单商品存在维权，无法取消取货！');
		}

		if ($item['status'] != 3) {
			show_json(0, '订单未取货，不需取消！');
		}

		pdo_update('ewei_shop_order', array('status' => 1, 'finishtime' => 0), array('id' => $item['id'], 'uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid']));
		plog('order.op.fetchcancel', '订单取消取货 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn']);
		show_json(1);
	}

	public function sendcancel()
	{
		global $_W;
		global $_GPC;
		$opdata = $this->opData();
		extract($opdata);

		if ($is_singlerefund) {
			show_json(0, '订单商品存在维权，无法取消发货！');
		}

		if ($item['status'] != 2) {
			show_json(0, '订单未发货，不需取消发货！');
		}

		if ($_W['ispost']) {
			if (!empty($item['transid'])) {
			}

			$remark = trim($_GPC['remark']);

			if (!empty($item['remarksend'])) {
				$remark = $item['remarksend'] . '
' . $remark;
			}

			pdo_update('ewei_shop_order', array('status' => 1, 'sendtime' => 0, 'remarksend' => $remark), array('id' => $item['id'], 'uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid']));

			if ($item['paytype'] == 3) {
				m('order')->setStocksAndCredits($item['id'], 2);
			}

			plog('order.op.sendcancel', '订单取消发货 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn'] . ' 原因: ' . $remark);
			show_json(1);
		}

		include $this->template();
	}

	public function fetch()
	{
		global $_W;
		global $_GPC;
		$opdata = $this->opData();
		extract($opdata);

		if ($is_singlerefund) {
			show_json(0, '订单商品存在维权，无法确认取货！');
		}

		if ($item['status'] != 1) {
			message('订单未付款，无法确认取货！');
		}

		$time = time();
		$d = array('status' => 3, 'sendtime' => $time, 'finishtime' => $time);

		if ($item['isverify'] == 1) {
			$d['verified'] = 1;
			$d['verifytime'] = $time;
			$d['verifyopenid'] = '';
			$verifyinfo = iunserializer($item['verifyinfo']);

			if (empty($verifyinfo)) {
				$verifyinfo[] = array('verifyopenid' => $item['openid'], 'verifystoreid' => $item['storeid'], 'verifytime' => $time);
			}
			else {
				foreach ($verifyinfo as &$v) {
					$v['verified'] = 1;
					$v['verifytime'] = $time;
				}

				unset($v);
			}

			$d['verifyinfo'] = iserializer($verifyinfo);
		}

		pdo_update('ewei_shop_order', $d, array('id' => $item['id'], 'uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid']));

		if (!empty($item['refundid'])) {
			$refund = pdo_fetch('select * from ' . tablename('ewei_shop_order_refund') . ' where id=:id limit 1', array(':id' => $item['refundid']));

			if (!empty($refund)) {
				pdo_update('ewei_shop_order_refund', array('status' => -1), array('id' => $item['refundid']));
				pdo_update('ewei_shop_order', array('refundstate' => 0), array('id' => $item['id']));
			}
		}

		m('order')->setGiveBalance($item['id'], 1);
		m('member')->upgradeLevel($item['openid'], $item['id']);
		m('notice')->sendOrderMessage($item['id']);

		if (p('commission')) {
			p('commission')->checkOrderFinish($item['id']);
		}

		plog('order.op.fetch', '订单确认取货 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn']);
		show_json(1);
	}

	public function send()
	{
		global $_W;
		global $_GPC;
		$opdata = $this->opData();
		extract($opdata);

		if ($is_singlerefund) {
			show_json(0, '订单商品存在维权，无法发货！');
		}

		if (empty($item['addressid'])) {
			show_json(0, '无收货地址，无法发货！');
		}

		if ($item['paytype'] != 3) {
			if ($item['status'] != 1) {
				show_json(0, '订单未付款，无法发货！');
			}
		}

		if ($_W['ispost']) {
			if (!empty($_GPC['isexpress']) && empty($_GPC['expresssn'])) {
				show_json(0, '请输入快递单号！');
			}

			if (!empty($item['transid'])) {
			}

			$time = time();
			pdo_update('ewei_shop_order', array('status' => 2, 'express' => trim($_GPC['express']), 'expresscom' => trim($_GPC['expresscom']), 'expresssn' => trim($_GPC['expresssn']), 'sendtime' => $time), array('id' => $item['id'], 'uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid']));

			if (!empty($item['refundid'])) {
				$refund = pdo_fetch('select * from ' . tablename('ewei_shop_order_refund') . ' where id=:id limit 1', array(':id' => $item['refundid']));

				if (!empty($refund)) {
					pdo_update('ewei_shop_order_refund', array('status' => -1, 'endtime' => $time), array('id' => $item['refundid']));
					pdo_update('ewei_shop_order', array('refundstate' => 0), array('id' => $item['id']));
				}
			}

			if ($item['paytype'] == 3) {
				m('order')->setStocksAndCredits($item['id'], 1);
			}

			m('notice')->sendOrderMessage($item['id']);
			plog('order.op.send', '订单发货 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn'] . ' <br/>快递公司: ' . $_GPC['expresscom'] . ' 快递单号: ' . $_GPC['expresssn']);
			show_json(1);
		}

		$address = iunserializer($item['address']);

		if (!is_array($address)) {
			$address = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_address') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $item['addressid'], ':uniacid' => $_W['uniacid']));
		}

		$express_list = m('express')->getExpressList();
		include $this->template();
	}

	public function remarksaler()
	{
		global $_W;
		global $_GPC;
		$opdata = $this->opData();
		extract($opdata);

		if ($_W['ispost']) {
			pdo_update('ewei_shop_order', array('remarksaler' => $_GPC['remark']), array('id' => $item['id'], 'uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid']));
			plog('order.op.remarksaler', '订单备注 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn'] . ' 备注内容: ' . $_GPC['remark']);
			show_json(1);
		}

		include $this->template();
	}

	public function changeexpress()
	{
		global $_W;
		global $_GPC;
		$opdata = $this->opData();
		extract($opdata);
		$edit_flag = 1;

		if ($_W['ispost']) {
			$express = $_GPC['express'];
			$expresscom = $_GPC['expresscom'];
			$expresssn = trim($_GPC['expresssn']);

			if (empty($id)) {
				$ret = '参数错误！';
				show_json(0, $ret);
			}

			if (!empty($expresssn)) {
				$change_data = array();
				$change_data['express'] = $express;
				$change_data['expresscom'] = $expresscom;
				$change_data['expresssn'] = $expresssn;
				pdo_update('ewei_shop_order', $change_data, array('id' => $id, 'uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid']));
				plog('order.op.changeexpress', '修改快递状态 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn'] . ' 快递公司: ' . $expresscom . ' 快递单号: ' . $expresssn);
				show_json(1);
			}
			else {
				show_json(0, '请填写快递单号！');
			}
		}

		$address = iunserializer($item['address']);

		if (!is_array($address)) {
			$address = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_address') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $item['addressid'], ':uniacid' => $_W['uniacid']));
		}

		$express_list = m('express')->getExpressList();
		include $this->template('order/op/send');
	}

	public function changeaddress()
	{
		global $_W;
		global $_GPC;
		$opdata = $this->opData();
		extract($opdata);
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$address_street = intval($area_set['address_street']);

		if (empty($item['addressid'])) {
			$user = unserialize($item['carrier']);
		}
		else {
			$user = iunserializer($item['address']);

			if (!is_array($user)) {
				$user = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_address') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $item['addressid'], ':uniacid' => $_W['uniacid']));
			}

			$address_info = $user['address'];
			$user_address = $user['address'];
			$user['address'] = $user['province'] . ' ' . $user['city'] . ' ' . $user['area'] . ' ' . $user['street'] . ' ' . $user['address'];
			$item['addressdata'] = $oldaddress = array('realname' => $user['realname'], 'mobile' => $user['mobile'], 'address' => $user['address']);
		}

		if ($_W['ispost']) {
			$realname = $_GPC['realname'];
			$mobile = $_GPC['mobile'];
			$province = $_GPC['province'];
			$city = $_GPC['city'];
			$area = $_GPC['area'];
			$street = $_GPC['street'];
			$changead = intval($_GPC['changead']);
			$address = trim($_GPC['address']);

			if (!empty($id)) {
				if (empty($realname)) {
					$ret = '请填写收件人姓名！';
					show_json(0, $ret);
				}

				if (empty($mobile)) {
					$ret = '请填写收件人手机！';
					show_json(0, $ret);
				}

				if ($changead) {
					if ($province == '请选择省份') {
						$ret = '请选择省份！';
						show_json(0, $ret);
					}

					if (empty($address)) {
						$ret = '请填写详细地址！';
						show_json(0, $ret);
					}
				}

				$item = pdo_fetch('SELECT id, ordersn, address FROM ' . tablename('ewei_shop_order') . ' WHERE id = :id and uniacid=:uniacid and merchid = :merchid', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));
				$address_array = iunserializer($item['address']);
				$address_array['realname'] = $realname;
				$address_array['mobile'] = $mobile;

				if ($changead) {
					$address_array['province'] = $province;
					$address_array['city'] = $city;
					$address_array['area'] = $area;
					$address_array['street'] = $street;
					$address_array['address'] = $address;
				}
				else {
					$address_array['province'] = $user['province'];
					$address_array['city'] = $user['city'];
					$address_array['area'] = $user['area'];
					$address_array['street'] = $user['street'];
					$address_array['address'] = $user_address;
				}

				$address_array = iserializer($address_array);
				pdo_update('ewei_shop_order', array('address' => $address_array), array('id' => $id, 'uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid']));
				plog('order.op.changeaddress', '修改收货地址 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn'] . ' <br>原地址: 收件人: ' . $oldaddress['realname'] . ' 手机号: ' . $oldaddress['mobile'] . ' 收件地址: ' . $oldaddress['address'] . '<br>新地址: 收件人: ' . $realname . ' 手机号: ' . $mobile . ' 收件地址: ' . $province . ' ' . $city . ' ' . $area . ' ' . $address);
				show_json(1);
			}
		}

		include $this->template();
	}
}

?>
