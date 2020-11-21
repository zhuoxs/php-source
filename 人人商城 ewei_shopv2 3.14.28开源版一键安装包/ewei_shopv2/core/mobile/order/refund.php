<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Refund_EweiShopV2Page extends MobileLoginPage
{
	protected function globalData()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$orderid = intval($_GPC['id']);
		$order = pdo_fetch('select id,status,price,refundid,goodsprice,dispatchprice,deductprice,deductcredit2,finishtime,isverify,`virtual`,refundstate,merchid,random_code,iscycelbuy,paytype from ' . tablename('ewei_shop_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));
		$orderprice = $order['price'];

		if ($order['iscycelbuy'] == 1) {
			$order_goods = pdo_fetch('select * from ' . tablename('ewei_shop_cycelbuy_periods') . ('where orderid = ' . $order['id'] . ' and status != 0'));

			if (!empty($order_goods)) {
				show_json(0, '订单已经开始，无法进行退款');
			}
		}

		if (empty($order)) {
			if (!$_W['isajax']) {
				header('location: ' . mobileUrl('order'));
				exit();
			}
			else {
				show_json(0, '订单未找到');
			}
		}

		$_err = '';

		if ($order['status'] == 0) {
			$_err = '订单未付款，不能申请退款!';
		}
		else {
			if ($order['status'] == 3) {
				if (!empty($order['virtual']) || $order['isverify'] == 1) {
					$_err = '此订单不允许退款!';
				}
				else {
					if ($order['refundstate'] == 0) {
						$tradeset = m('common')->getSysset('trade');
						$refunddays = intval($tradeset['refunddays']);

						if (0 < $refunddays) {
							$days = intval((time() - $order['finishtime']) / 3600 / 24);

							if ($refunddays < $days) {
								$_err = '订单完成已超过 ' . $refunddays . ' 天, 无法发起退款申请!';
							}
						}
						else {
							$_err = '订单完成, 无法申请退款!';
						}
					}
				}
			}
		}

		if (!empty($_err)) {
			if ($_W['isajax']) {
				show_json(0, $_err);
			}
			else {
				$this->message($_err, '', 'error');
			}
		}

		$order['cannotrefund'] = false;

		if ($order['status'] == 2) {
			$goods = pdo_fetchall('select og.goodsid, og.price, og.total, og.optionname, g.cannotrefund, g.thumb, g.title,g.isfullback from' . tablename('ewei_shop_order_goods') . ' og left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid where og.orderid=' . $order['id']);

			if (!empty($goods)) {
				foreach ($goods as $g) {
					if ($g['cannotrefund'] == 1) {
						$order['cannotrefund'] = true;
						break;
					}
				}
			}
		}

		if ($order['cannotrefund']) {
			$this->message('此订单不可退换货');
		}

		$fullback_log = pdo_fetchall('select * from ' . tablename('ewei_shop_fullback_log') . ' where orderid = ' . $orderid . ' and uniacid = ' . $uniacid . ' ');
		$fullbackkprice = 0;
		if ($fullback_log && is_array($fullback_log)) {
			foreach ($fullback_log as $key => $value) {
				$fullbackgoods = pdo_fetch('select refund from ' . tablename('ewei_shop_fullback_goods') . ' where goodsid = ' . $value['goodsid'] . ' and uniacid = ' . $uniacid . ' ');

				if ($fullbackgoods['refund'] == 0) {
					$this->message('此订单包含全返产品不允许退款');
				}
			}

			foreach ($fullback_log as $k => $val) {
				if (0 < $val['fullbackday']) {
					if ($val['fullbackday'] < $val['day']) {
						$fullbackkprice += $val['priceevery'] * $val['fullbackday'];
					}
					else {
						$fullbackkprice += $val['price'];
					}
				}
			}
		}

		$order['price'] = $order['price'] - $fullbackkprice;
		$order['refundprice'] = $order['price'] + $order['deductcredit2'];

		if (2 <= $order['status']) {
			$order['refundprice'] -= $order['dispatchprice'];
		}

		$order['refundprice'] = round($order['refundprice'], 2);
		return array('uniacid' => $uniacid, 'openid' => $_W['openid'], 'orderid' => $orderid, 'order' => $order, 'refundid' => $order['refundid'], 'fullback_log' => $fullback_log, 'fullbackgoods' => $fullbackgoods, 'orderprice' => $orderprice);
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		extract($this->globalData());
		if ($order['status'] == 2 && $order['price'] == $order['dispatchprice']) {
			$canreturns = 1;
		}

		if ($order['status'] == '-1') {
			$this->message('请不要重复提交!', '', 'error');
		}

		$refund = false;
		$imgnum = 0;

		if (0 < $order['refundstate']) {
			if (!empty($refundid)) {
				$refund = pdo_fetch('select * from ' . tablename('ewei_shop_order_refund') . ' where id=:id and uniacid=:uniacid and orderid=:orderid limit 1', array(':id' => $refundid, ':uniacid' => $uniacid, ':orderid' => $orderid));

				if (!empty($refund['refundaddress'])) {
					$refund['refundaddress'] = iunserializer($refund['refundaddress']);
				}
			}

			if (!empty($refund['imgs'])) {
				$refund['imgs'] = iunserializer($refund['imgs']);
			}
		}

		if (empty($refund)) {
			$show_price = round($order['refundprice'], 2);
		}
		else {
			$show_price = round($refund['applyprice'], 2);
		}

		$express_list = m('express')->getExpressList();
		$trade = m('common')->getSysset('trade', $_W['uniacid']);
		include $this->template();
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		extract($this->globalData());

		if ($order['status'] == '-1') {
			show_json(0, '订单已经处理完毕!');
		}

		if ($order['paytype'] == 11) {
			show_json(0, '后台付款订单不允许售后');
		}

		$price = trim($_GPC['price']);
		$rtype = intval($_GPC['rtype']);

		if ($rtype != 2) {
			if (empty($price) && $order['deductprice'] == 0) {
				show_json(0, '退款金额不能为0元');
			}

			if ($order['refundprice'] < $price) {
				show_json(0, '退款金额不能超过' . $order['refundprice'] . '元');
			}
		}

		if (($rtype == 0 || $rtype == 1) && 3 <= $order['status']) {
			if ($fullback_log) {
				m('order')->fullbackstop($orderid);
			}
		}

		$refund = array('uniacid' => $uniacid, 'merchid' => $order['merchid'], 'applyprice' => $price, 'rtype' => $rtype, 'reason' => trim($_GPC['reason']), 'content' => trim($_GPC['content']), 'imgs' => iserializer($_GPC['images']));

		if ($refund['rtype'] == 2) {
			$refundstate = 2;
		}
		else {
			$refundstate = 1;
		}

		if ($order['refundstate'] == 0) {
			$refund['createtime'] = time();
			$refund['orderid'] = $orderid;
			$refund['orderprice'] = $order['refundprice'];
			$refund['refundno'] = m('common')->createNO('order_refund', 'refundno', 'SR');
			pdo_insert('ewei_shop_order_refund', $refund);
			$refundid = pdo_insertid();
			pdo_update('ewei_shop_order', array('refundid' => $refundid, 'refundstate' => $refundstate), array('id' => $orderid, 'uniacid' => $uniacid));
		}
		else {
			pdo_update('ewei_shop_order', array('refundstate' => $refundstate), array('id' => $orderid, 'uniacid' => $uniacid));
			pdo_update('ewei_shop_order_refund', $refund, array('id' => $refundid, 'uniacid' => $uniacid));
		}

		m('notice')->sendOrderMessage($orderid, true);
		show_json(1);
	}

	public function cancel()
	{
		global $_W;
		global $_GPC;
		extract($this->globalData());
		$change_refund = array();
		$change_refund['status'] = -2;
		$change_refund['refundtime'] = time();
		pdo_update('ewei_shop_order_refund', $change_refund, array('id' => $refundid, 'uniacid' => $uniacid));
		pdo_update('ewei_shop_order', array('refundstate' => 0), array('id' => $orderid, 'uniacid' => $uniacid));
		show_json(1);
	}

	public function express()
	{
		global $_W;
		global $_GPC;
		extract($this->globalData());

		if (empty($refundid)) {
			show_json(0, '参数错误!');
		}

		if (empty($_GPC['expresssn'])) {
			show_json(0, '请填写快递单号');
		}

		$refund = array('status' => 4, 'express' => trim($_GPC['express']), 'expresscom' => trim($_GPC['expresscom']), 'expresssn' => trim($_GPC['expresssn']), 'sendtime' => time());
		pdo_update('ewei_shop_order_refund', $refund, array('id' => $refundid, 'uniacid' => $uniacid));
		show_json(1);
	}

	public function receive()
	{
		global $_W;
		global $_GPC;
		extract($this->globalData());
		$refundid = intval($_GPC['refundid']);
		$refund = pdo_fetch('select * from ' . tablename('ewei_shop_order_refund') . ' where id=:id and uniacid=:uniacid and orderid=:orderid limit 1', array(':id' => $refundid, ':uniacid' => $uniacid, ':orderid' => $orderid));

		if (empty($refund)) {
			show_json(0, '换货申请未找到!');
		}

		$time = time();
		$refund_data = array();
		$refund_data['status'] = 1;
		$refund_data['refundtime'] = $time;
		pdo_update('ewei_shop_order_refund', $refund_data, array('id' => $refundid, 'uniacid' => $uniacid));
		$order_data = array();
		$order_data['refundstate'] = 0;
		$order_data['status'] = 3;
		$order_data['refundtime'] = $time;
		$order_data['finishtime'] = $time;
		pdo_update('ewei_shop_order', $order_data, array('id' => $orderid, 'uniacid' => $uniacid));
		show_json(1);
	}

	public function refundexpress()
	{
		global $_W;
		global $_GPC;
		extract($this->globalData());
		$express = trim($_GPC['express']);
		$expresssn = trim($_GPC['expresssn']);
		$expresscom = trim($_GPC['expresscom']);
		$expresslist = m('util')->getExpressList($express, $expresssn);
		include $this->template('order/refundexpress');
	}
}

?>
