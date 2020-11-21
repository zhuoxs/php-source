<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Op_EweiShopV2Page extends WebPage
{
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

		return array('id' => $id, 'item' => $item);
	}

	public function send()
	{
		global $_W;
		global $_GPC;
		$periodsid = $_GPC['periodsid'];
		$opdata = $this->opData();
		extract($opdata);

		if (empty($item['addressid'])) {
			show_json(0, '无收货地址，无法发货！');
		}

		if (empty($item['status'])) {
			show_json(0, '订单未付款，无法发货！');
		}

		if ($_W['ispost']) {
			if ($item['city_express_state'] == 0) {
				if (!empty($_GPC['isexpress']) && empty($_GPC['expresssn'])) {
					show_json(0, '请输入快递单号！');
				}

				if (!empty($item['transid'])) {
				}

				$time = time();
				$data = array('express' => trim($_GPC['express']), 'expresscom' => trim($_GPC['expresscom']), 'expresssn' => trim($_GPC['expresssn']), 'sendtime' => $time);
				$data['status'] = 1;
				pdo_update('ewei_shop_cycelbuy_periods', $data, array('id' => $periodsid, 'uniacid' => $_W['uniacid']));
			}
			else {
				$cityexpress = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_city_express') . ' WHERE uniacid=:uniacid AND merchid=:merchid', array(':uniacid' => $_W['uniacid'], ':merchid' => 0));

				if ($cityexpress['express_type'] == 1) {
					$periods = pdo_get('ewei_shop_cycelbuy_periods', array('id' => $periodsid));
					$periods['remark'] = $item['info'];
					list(, , $periodsNum) = explode(',', $item['cycelbuy_periodic']);
					$periods['price'] = round($item['goodsprice'] / $periodsNum, 2);
					$dada = m('order')->dada_send($periods);

					if ($dada['state'] == 0) {
						show_json(0, $dada['result']);
					}
					else {
						$data['status'] = 1;
						$data['sendtime'] = time();
						pdo_update('ewei_shop_cycelbuy_periods', $data, array('id' => $periodsid, 'uniacid' => $_W['uniacid']));
					}
				}
				else {
					$data['status'] = 1;
					$data['sendtime'] = time();
					pdo_update('ewei_shop_cycelbuy_periods', $data, array('id' => $periodsid, 'uniacid' => $_W['uniacid']));
				}
			}

			if (!empty($item['refundid'])) {
				$refund = pdo_fetch('select * from ' . tablename('ewei_shop_order_refund') . ' where id=:id limit 1', array(':id' => $item['refundid']));

				if (!empty($refund)) {
					pdo_update('ewei_shop_order_refund', array('status' => -1, 'endtime' => $time), array('id' => $item['refundid']));
					pdo_update('ewei_shop_order', array('refundstate' => 0), array('id' => $item['id']));
				}
			}

			$up_data = array('status' => 2, 'sendtime' => time());

			if (!empty($_GPC['expresssn'])) {
				$up_data['expresscom'] = trim($_GPC['expresscom']);
				$up_data['expresssn'] = trim($_GPC['expresssn']);
			}

			pdo_update('ewei_shop_order', $up_data, array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			m('order')->setStocksAndCredits($item['id'], 1);
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

		$recently = pdo_fetch('select * from ' . tablename('ewei_shop_cycelbuy_periods') . ' where id=:id and orderid=:orderid and status = 0', array('id' => $periodsid, ':orderid' => $item['id']));
		unset($address);
		$address = array_merge($recently, iunserializer($recently['address']));
		unset($recently['address']);
		$express_list = m('express')->getExpressList();
		include $this->template();
	}

	/**
     * 分期订单确认收货
     * @author 青椒
     * @date 2018/2/4
     * @parme id 分期订单id
     */
	public function fetch()
	{
		global $_W;
		global $_GPC;
		$p = p('commission');
		$pcoupon = com('coupon');
		$id = $_GPC['id'];
		$orderid = $_GPC['orderid'];

		if (empty($id)) {
			show_json(0, '缺少分期ID');
		}

		if (empty($orderid)) {
			show_json(0, '缺少订单ID');
		}

		$order = pdo_fetch('select * from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and id=:id  limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $orderid));
		$last_periods = pdo_fetch('select * from ' . tablename('ewei_shop_cycelbuy_periods') . ' where uniacid=:uniacid and orderid=:orderid order by id desc  limit 1', array(':uniacid' => $_W['uniacid'], ':orderid' => $orderid));

		if (!empty($last_periods)) {
			if ($last_periods['id'] == $id) {
				pdo_update('ewei_shop_order', array('status' => 3, 'finishtime' => time()), array('id' => $orderid, 'status' => 2));
				$result = pdo_update('ewei_shop_cycelbuy_periods', array('status' => 2, 'finishtime' => time()), array('orderid' => $orderid, 'uniacid' => $_W['uniacid']));
				m('member')->upgradeLevel($order['openid'], $orderid);
				m('order')->setGiveBalance($orderid, 1);
				m('notice')->sendOrderMessage($orderid);
				m('order')->fullback($orderid);
				m('order')->setStocksAndCredits($orderid, 3);

				if ($pcoupon) {
					com('coupon')->sendcouponsbytask($orderid);

					if (!empty($order['couponid'])) {
						$pcoupon->backConsumeCoupon($orderid);
					}
				}

				if ($p) {
					$p->checkOrderFinish($orderid);
				}
			}
			else {
				$result = pdo_update('ewei_shop_cycelbuy_periods', array('status' => 2, 'finishtime' => time()), array('id' => $id, 'uniacid' => $_W['uniacid']));
			}

			if ($result != false) {
				show_json(1, '确认收货成功');
			}
			else {
				show_json(0, '确认收货失败');
			}
		}
	}

	public function close()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		include $this->template();
	}
}

?>
