<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Op_EweiShopV2Page extends WebPage
{
	public function delete()
	{
		global $_W;
		global $_GPC;
		$status = intval($_GPC['status']);
		$orderid = intval($_GPC['id']);
		pdo_update('ewei_shop_order', array('deleted' => 1), array('id' => $orderid, 'uniacid' => $_W['uniacid']));
		plog('order.op.delete', '订单删除 ID: ' . $orderid);
		show_json(1, webUrl('order', array('status' => $status)));
	}

	protected function opData()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_order') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));

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
		$is_peerpay = false;
		$is_peerpay = m('order')->checkpeerpay($item['id']);

		if (!empty($is_peerpay)) {
			show_json(0, '代付订单不能改价');
		}

		if (100 <= $item['ordersn2']) {
			$item['ordersn2'] = 0;
		}

		if ($_W['ispost']) {
			$changegoodsprice = $_GPC['changegoodsprice'];

			if (!is_array($changegoodsprice)) {
				show_json(0, '未找到改价内容!');
			}

			if (0 < $item['parentid']) {
				$parent_order = array();
				$parent_order['id'] = $item['parentid'];
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
				$og = pdo_fetch('select price,realprice from ' . tablename('ewei_shop_order_goods') . ' where id=:ogid and uniacid=:uniacid limit 1', array(':ogid' => $ogid, ':uniacid' => $_W['uniacid']));

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
				$orderupdate['changedispatchprice'] += $changedispatchprice;

				if (0 < $item['parentid']) {
					$parent_order['dispatch_change'] = $changedispatchprice;
				}
			}

			if (!empty($orderupdate)) {
				pdo_update('ewei_shop_order', $orderupdate, array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			}

			if (0 < $item['parentid']) {
				if (!empty($parent_order)) {
					m('order')->changeParentOrderPrice($parent_order);
				}
			}

			foreach ($changegoodsprice as $ogid => $change) {
				$og = pdo_fetch('select price,realprice,changeprice from ' . tablename('ewei_shop_order_goods') . ' where id=:ogid and uniacid=:uniacid limit 1', array(':ogid' => $ogid, ':uniacid' => $_W['uniacid']));

				if (!empty($og)) {
					$realprice = $og['realprice'] + $change;
					$changeprice = $og['changeprice'] + $change;
					pdo_update('ewei_shop_order_goods', array('realprice' => $realprice, 'changeprice' => $changeprice), array('id' => $ogid));
				}
			}

			$pluginc = p('commission');

			if ($pluginc) {
				$pluginc->calculate($item['id'], true);
			}

			plog('order.op.changeprice', '订单号： ' . $item['ordersn'] . ' <br/> 价格： ' . $item['price'] . ' -> ' . $orderprice);
			m('notice')->sendOrderChangeMessage($item['openid'], array('title' => '订单金额', 'orderid' => $item['id'], 'ordersn' => $item['ordersn'], 'olddata' => $item['price'], 'data' => round($orderprice, 2), 'type' => 1), 'orderstatus');
			show_json(1);
		}

		$order_goods = pdo_fetchall('select og.id,g.title,g.thumb,g.goodssn,og.goodssn as option_goodssn, g.productsn,og.productsn as option_productsn, og.total,og.price,og.optionname as optiontitle, og.realprice,og.oldprice from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $item['id']));

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

		if (1 < $item['status']) {
			show_json(0, '订单已付款，不需重复付款！');
		}

		if (!empty($item['virtual']) && com('virtual')) {
			com('virtual')->pay($item);
		}
		else {
			$time = time();
			$updateorder = array('status' => 1, 'paytype' => 11, 'paytime' => $time);
			$isonlyverifygoods = m('order')->checkisonlyverifygoods($item['id']);

			if ($isonlyverifygoods) {
				$updateorder['status'] = 2;
				$updateorder['sendtime'] = $time;
			}

			pdo_update('ewei_shop_order', $updateorder, array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			m('order')->setStocksAndCredits($item['id'], 1);
			m('notice')->sendOrderMessage($item['id']);
			com_run('printer::sendOrderMessage', $item['id']);

			if (com('coupon')) {
				com('coupon')->sendcouponsbytask($item['id']);
			}

			if (com('coupon') && !empty($item['couponid'])) {
				com('coupon')->backConsumeCoupon($item['id']);
			}

			if (p('commission')) {
				p('commission')->checkOrderPay($item['id']);
			}

			$plugincoupon = com('coupon');

			if ($plugincoupon) {
				$oid = $item['id'];
				$plugincoupon->useConsumeCoupon($oid);
			}
		}

		m('verifygoods')->createverifygoods($item['id']);
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
			if (!empty($item['transid'])) {
			}

			$time = time();
			if (0 < $item['refundstate'] && !empty($item['refundid'])) {
				$change_refund = array();
				$change_refund['status'] = -1;
				$change_refund['refundtime'] = $time;
				pdo_update('ewei_shop_order_refund', $change_refund, array('id' => $item['refundid'], 'uniacid' => $_W['uniacid']));
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
			if (!empty($item['virtual']) && $item['virtual'] != 0) {
				$goodsid = pdo_fetch('SELECT goodsid FROM ' . tablename('ewei_shop_order_goods') . ' WHERE uniacid = ' . $_W['uniacid'] . ' AND orderid = ' . $item['id']);
				$typeid = $item['virtual'];
				$vkdata = ltrim($item['virtual_info'], '[');
				$vkdata = rtrim($vkdata, ']');
				$arr = explode('}', $vkdata);

				foreach ($arr as $k => $v) {
					if (!$v) {
						unset($arr[$k]);
					}
				}

				$vkeynum = count($arr);
				pdo_query('update ' . tablename('ewei_shop_virtual_data') . ' set openid="",usetime=0,orderid=0,ordersn="",price=0,merchid=' . $item['merchid'] . ' where typeid=' . intval($typeid) . ' and orderid = ' . $item['id']);
				pdo_query('update ' . tablename('ewei_shop_virtual_type') . ' set usedata=usedata-' . $vkeynum . ' where id=' . intval($typeid));
			}

			$goodscircle = p('goodscircle');

			if ($goodscircle) {
				$goodscircle->updateOrder($item['openid'], $item['id']);
			}

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
			pdo_update('ewei_shop_order', array('status' => 0, 'cancelpaytime' => time()), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
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

		pdo_update('ewei_shop_order', array('status' => 3, 'finishtime' => time()), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
		m('order')->fullback($item['id']);
		if (p('ccard') && !empty($item['ccardid'])) {
			p('ccard')->setBegin($item['id'], $item['ccardid']);
		}

		m('member')->upgradeLevel($item['openid'], $item['id']);
		m('order')->setStocksAndCredits($item['id'], 3);
		m('order')->setGiveBalance($item['id'], 1);
		m('notice')->sendOrderMessage($item['id']);
		com_run('printer::sendOrderMessage', $item['id']);

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

		if (p('lottery')) {
			$res = p('lottery')->getLottery($item['openid'], 1, array('money' => $item['price'], 'paytype' => 2));

			if ($res) {
				p('lottery')->getLotteryList($item['openid'], array('lottery_id' => $res));
			}
		}

		if (p('task')) {
			p('task')->checkTaskProgress($item['price'], 'order_full', '', $item['openid']);
		}

		$goodscircle = p('goodscircle');

		if ($goodscircle) {
			$goodscircle->updateOrder($item['openid'], $item['id']);
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

		pdo_update('ewei_shop_order', array('status' => 1, 'finishtime' => 0), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
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

		$sendtype = intval($_GPC['sendtype']);
		if ($item['status'] != 2 && $item['sendtype'] == 0) {
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

			$data = array('sendtime' => 0, 'remarksend' => $remark);

			if (0 < $item['sendtype']) {
				if (empty($sendtype)) {
					if (empty($_GPC['bundle'])) {
						show_json(0, '请选择您要修改的包裹！');
					}

					$sendtype = intval($_GPC['bundle']);
				}

				$data['sendtype'] = 0;
				pdo_update('ewei_shop_order_goods', $data, array('orderid' => $item['id'], 'sendtype' => $sendtype, 'uniacid' => $_W['uniacid']));
				$order = pdo_fetch('select sendtype from ' . tablename('ewei_shop_order') . ' where id = ' . $item['id'] . ' and uniacid = ' . $_W['uniacid'] . ' ');
				pdo_update('ewei_shop_order', array('sendtype' => $order['sendtype'] - 1, 'status' => 1), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			}
			else {
				$data['status'] = 1;
				pdo_update('ewei_shop_order', $data, array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			}

			if ($item['paytype'] == 3) {
				m('order')->setStocksAndCredits($item['id'], 2);
			}

			plog('order.op.sendcancel', '订单取消发货 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn'] . ' 原因: ' . $remark);
			show_json(1);
		}

		$sendgoods = array();
		$bundles = array();

		if (0 < $sendtype) {
			$sendgoods = pdo_fetchall('select g.id,g.title,g.thumb,og.sendtype,g.ispresell from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid and og.sendtype=' . $sendtype . ' ', array(':uniacid' => $_W['uniacid'], ':orderid' => $item['id']));
		}
		else {
			if (0 < $item['sendtype']) {
				$i = 1;

				while ($i <= intval($item['sendtype'])) {
					$bundles[$i]['goods'] = pdo_fetchall('select g.id,g.title,g.thumb,og.sendtype,g.ispresell from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid and og.sendtype=' . $i . ' ', array(':uniacid' => $_W['uniacid'], ':orderid' => $item['id']));
					$bundles[$i]['sendtype'] = $i;

					if (empty($bundles[$i]['goods'])) {
						unset($bundles[$i]);
					}

					++$i;
				}
			}
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
			show_json(0, '订单未付款，无法确认取货！');
		}

		$time = time();
		$d = array('status' => 3, 'sendtime' => $time, 'finishtime' => $time);

		if ($item['isverify'] == 1) {
			$d['verified'] = 1;
			$d['verifytime'] = $time;
			$d['verifyopenid'] = '';
		}

		pdo_update('ewei_shop_order', $d, array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
		m('order')->fullback($item['id']);

		if (com('coupon')) {
			com('coupon')->sendcouponsbytask($item['id']);
		}

		if (!empty($item['couponid'])) {
			com('coupon')->backConsumeCoupon($item['id']);
		}

		if (!empty($item['refundid'])) {
			$refund = pdo_fetch('select * from ' . tablename('ewei_shop_order_refund') . ' where id=:id limit 1', array(':id' => $item['refundid']));

			if (!empty($refund)) {
				pdo_update('ewei_shop_order_refund', array('status' => -1), array('id' => $item['refundid']));
				pdo_update('ewei_shop_order', array('refundstate' => 0), array('id' => $item['id']));
			}
		}

		$log = '订单确认取货';
		if (p('ccard') && !empty($item['ccardid'])) {
			p('ccard')->setBegin($item['id'], $item['ccardid']);
			$log = '订单确认充值';
		}

		$log .= ' ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn'];
		m('order')->setGiveBalance($item['id'], 1);
		m('order')->setStocksAndCredits($item['id'], 3);
		m('member')->upgradeLevel($item['openid'], $item['id']);
		m('notice')->sendOrderMessage($item['id']);

		if (p('commission')) {
			p('commission')->checkOrderFinish($item['id']);
		}

		$goodscircle = p('goodscircle');

		if ($goodscircle) {
			$goodscircle->updateOrder($item['openid'], $item['id']);
		}

		plog('order.op.fetch', $log);
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
			if ($item['city_express_state'] == 0) {
				if (!empty($_GPC['isexpress']) && empty($_GPC['expresssn'])) {
					show_json(0, '请输入快递单号！');
				}

				if (!empty($item['transid'])) {
				}

				$time = time();
				$data = array('sendtype' => 0 < $item['sendtype'] ? $item['sendtype'] : intval($_GPC['sendtype']), 'express' => trim($_GPC['express']), 'expresscom' => trim($_GPC['expresscom']), 'expresssn' => trim($_GPC['expresssn']), 'sendtime' => $time);
				if (intval($_GPC['sendtype']) == 1 || 0 < $item['sendtype']) {
					if (empty($_GPC['ordergoodsid'])) {
						show_json(0, '请选择发货商品！');
					}

					$ogoods = array();
					$ogoods = pdo_fetchall('select sendtype from ' . tablename('ewei_shop_order_goods') . '
                        where orderid = ' . $item['id'] . ' and uniacid = ' . $_W['uniacid'] . ' order by sendtype desc ');
					$senddata = array('sendtype' => $ogoods[0]['sendtype'] + 1, 'sendtime' => $data['sendtime']);
					$data['sendtype'] = $ogoods[0]['sendtype'] + 1;
					$goodsid = $_GPC['ordergoodsid'];

					foreach ($goodsid as $key => $value) {
						pdo_update('ewei_shop_order_goods', $data, array('id' => $value, 'uniacid' => $_W['uniacid']));
					}

					$send_goods = pdo_fetch('select * from ' . tablename('ewei_shop_order_goods') . '
                        where orderid = ' . $item['id'] . ' and sendtype = 0 and uniacid = ' . $_W['uniacid'] . ' limit 1 ');

					if (empty($send_goods)) {
						$senddata['status'] = 2;
					}

					$senddata['refundid'] = 0;
					pdo_update('ewei_shop_order', $senddata, array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				}
				else {
					$data['status'] = 2;
					$data['refundid'] = 0;
					pdo_update('ewei_shop_order', $data, array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				}
			}
			else {
				$cityexpress = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_city_express') . ' WHERE uniacid=:uniacid AND merchid=:merchid', array(':uniacid' => $_W['uniacid'], ':merchid' => 0));

				if ($cityexpress['express_type'] == 1) {
					$dada = m('order')->dada_send($item);

					if ($dada['state'] == 0) {
						show_json(0, $dada['result']);
					}
					else {
						$data['status'] = 2;
						$data['refundid'] = 0;
						$data['sendtime'] = time();
						pdo_update('ewei_shop_order', $data, array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
					}
				}
				else {
					$data['status'] = 2;
					$data['refundid'] = 0;
					$data['sendtime'] = time();
					pdo_update('ewei_shop_order', $data, array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				}
			}

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

			$goodscircle = p('goodscircle');

			if ($goodscircle) {
				$goodscircle->updateOrder($item['openid'], $item['id']);
			}

			m('notice')->sendOrderMessage($item['id']);
			plog('order.op.send', '订单发货 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn'] . ' <br/>快递公司: ' . $_GPC['expresscom'] . ' 快递单号: ' . $_GPC['expresssn']);
			show_json(1);
		}

		$noshipped = array();
		$shipped = array();

		if (0 < $item['sendtype']) {
			$noshipped = pdo_fetchall('select og.id,g.title,g.thumb,og.sendtype,g.ispresell from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.sendtype = 0 and og.orderid=:orderid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $item['id']));
			$i = 1;

			while ($i <= $item['sendtype']) {
				$shipped[$i]['sendtype'] = $i;
				$shipped[$i]['goods'] = pdo_fetchall('select g.id,g.title,g.thumb,og.sendtype,g.ispresell from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.sendtype = ' . $i . ' and og.orderid=:orderid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $item['id']));
				++$i;
			}
		}

		$order_goods = pdo_fetchall('select og.id,g.title,g.thumb,og.sendtype,g.ispresell from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.orderid=:orderid and og.uniacid=:uniacid and og.single_refundtime=0', array(':uniacid' => $_W['uniacid'], ':orderid' => $item['id']));
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
			pdo_update('ewei_shop_order', array('remarksaler' => $_GPC['remark']), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
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
		$changeexpress = 1;
		$sendtype = intval($_GPC['sendtype']);
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

				if (0 < $item['sendtype']) {
					if (empty($sendtype)) {
						if (empty($_GPC['bundle'])) {
							show_json(0, '请选择您要修改的包裹！');
						}

						$sendtype = intval($_GPC['bundle']);
					}

					pdo_update('ewei_shop_order_goods', $change_data, array('orderid' => $id, 'sendtype' => $sendtype, 'uniacid' => $_W['uniacid']));
				}
				else {
					pdo_update('ewei_shop_order', $change_data, array('id' => $id, 'uniacid' => $_W['uniacid']));
				}

				plog('order.op.changeexpress', '修改快递状态 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn'] . ' 快递公司: ' . $expresscom . ' 快递单号: ' . $expresssn);
				show_json(1);
			}
			else {
				show_json(0, '请填写快递单号！');
			}
		}

		$sendgoods = array();
		$bundles = array();

		if (0 < $sendtype) {
			$sendgoods = pdo_fetchall('select g.id,g.title,g.thumb,og.sendtype,g.ispresell from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid and og.sendtype=' . $sendtype . ' ', array(':uniacid' => $_W['uniacid'], ':orderid' => $item['id']));
		}
		else {
			if (0 < $item['sendtype']) {
				$i = 1;

				while ($i <= intval($item['sendtype'])) {
					$bundles[$i]['goods'] = pdo_fetchall('select g.id,g.title,g.thumb,og.sendtype,g.ispresell from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid and og.sendtype=' . $i . ' ', array(':uniacid' => $_W['uniacid'], ':orderid' => $item['id']));
					$bundles[$i]['sendtype'] = $i;

					if (empty($bundles[$i]['goods'])) {
						unset($bundles[$i]);
					}

					++$i;
				}
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

				$item = pdo_fetch('SELECT id, ordersn, address,openid FROM ' . tablename('ewei_shop_order') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));
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
				pdo_update('ewei_shop_order', array('address' => $address_array), array('id' => $id, 'uniacid' => $_W['uniacid']));
				plog('order.op.changeaddress', '修改收货地址 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn'] . ' <br>原地址: 收件人: ' . $oldaddress['realname'] . ' 手机号: ' . $oldaddress['mobile'] . ' 收件地址: ' . $oldaddress['address'] . '<br>新地址: 收件人: ' . $realname . ' 手机号: ' . $mobile . ' 收件地址: ' . $province . ' ' . $city . ' ' . $area . ' ' . $address);
				m('notice')->sendOrderChangeMessage($item['openid'], array('title' => '订单收货地址', 'orderid' => $item['id'], 'ordersn' => $item['ordersn'], 'olddata' => $oldaddress['address'], 'data' => $province . $city . $area . $address, 'type' => 0), 'orderstatus');
				show_json(1);
			}
		}

		include $this->template();
	}

	public function upload_invoice()
	{
		global $_W;
		global $_GPC;
		$order_id = $_GPC['order_id'];

		if (!$_W['ispost']) {
			$invoice = pdo_fetch('select invoicename,invoice_img from ' . tablename('ewei_shop_order') . ' where id = :order_id and uniacid = :uniacid limit 1', array(':order_id' => $order_id, ':uniacid' => $_W['uniacid']));
			$invoice_info = m('sale')->parseInvoiceInfo($invoice['invoicename']);

			if ($invoice_info['title']) {
				if ($invoice_info['entity']) {
					show_json(0, '本单不支持电子发票');
				}

				include $this->template();
				return NULL;
			}

			show_json(0, '本单不支持电子发票');
		}

		$invoice_img = $_GPC['invoice_img'];

		if (empty($invoice_img)) {
			show_json(0, '请选择图片');
		}

		$invoice_img = save_media($invoice_img);
		$update_ret = pdo_update('ewei_shop_order', array('invoice_img' => $invoice_img), array('id' => $order_id));
		$update_ret ? show_json(1) : show_json(0, '电子发票上传失败，请重试');
	}

	public function peerpay()
	{
		global $_W;
		global $_GPC;
		$order_id = $_GPC['id'];

		if (empty($order_id)) {
			show_json(0, '参数错误');
		}

		$peerpay = m('order')->checkpeerpay($order_id);

		if (!$peerpay) {
			show_json(0, '非代付订单');
		}

		$sql = 'SELECT * FROM ' . tablename('ewei_shop_order_peerpay_payinfo') . ' where pid=:pid';
		$list = pdo_fetchall($sql, array(':pid' => $peerpay['id']));
		include $this->template();
	}
}

?>
