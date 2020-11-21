<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Refund_EweiShopV2Page extends AppMobilePage
{
	protected function globalData()
	{
		global $_W;
		global $_GPC;
		$_err = '';
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$orderid = intval($_GPC['orderid']);
		$order = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order') . '
            where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));

		if (empty($order)) {
			if ($_W['isajax']) {
				return app_error('订单未找到');
			}
		}

		if ($order['heads'] == 1 && $order['success'] == 0) {
		}

		$goodRefund = false;
		$groupsSet = pdo_fetch('select goodsid,refundday from ' . tablename('ewei_shop_groups_set') . 'where uniacid = :uniacid ', array(':uniacid' => $uniacid));

		if (in_array($order['goodid'], explode(',', $groupsSet['goodsid']))) {
			$goodRefund = true;
		}

		$verifytotal = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_verify') . ' where orderid = :orderid and openid = :openid and uniacid = :uniacid and verifycode = :verifycode ', array(':orderid' => $order['id'], ':openid' => $order['openid'], ':uniacid' => $order['uniacid'], ':verifycode' => $order['verifycode']));

		if ($order['status'] == 0) {
			$_err = '订单未付款，不能申请退款!';
		}
		else if ($order['status'] == 2) {
			if ($goodRefund) {
				$_err = '该商品发货之后不允许退款!';
			}

			if (0 < $verifytotal) {
				$_err = '该商品已经核销不允许退款!';
			}
		}
		else {
			if ($order['status'] == 3) {
				if ($goodRefund) {
					$_err = '该商品发货之后不允许退款!';
				}
				else {
					if ($order['refundstate'] == 0) {
						$refunddays = intval($groupsSet['refundday']);

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
			return app_error($_err);
		}

		$order['refundprice'] = $order['price'] - $order['creditmoney'] + $order['freight'];

		if (2 <= $order['status']) {
			$order['refundprice'] -= $order['freight'];
		}

		$order['refundprice'] = round($order['refundprice'], 2);
		return array('uniacid' => $uniacid, 'openid' => $_W['openid'], 'orderid' => $orderid, 'order' => $order, 'refundid' => $order['refundid'], 'goodRefund' => $goodRefund);
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		extract($this->globalData());

		if ($order['status'] == '-1') {
			throw new Exception('请不要重复提交！');
		}

		$refund = false;
		$imgnum = 0;

		if (0 < $order['refundstate']) {
			if (!empty($refundid)) {
				$refund = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order_refund') . ' where id=:id and uniacid=:uniacid and orderid=:orderid limit 1', array(':id' => $refundid, ':uniacid' => $uniacid, ':orderid' => $orderid));

				if (!empty($refund['refundaddress'])) {
					$refund['refundaddress'] = iunserializer($refund['refundaddress']);
				}
				else if ($refund['refundaddressid']) {
					$refund['refundaddress'] = pdo_fetch('select * from ' . tablename('ewei_shop_member_address') . ' where id = :id and uniacid=:uniacid', array(':id' => $refund['refundaddressid'], ':uniacid' => $_W['uniacid']));
				}
				else {
					$refund['refundaddress'] = pdo_fetch('select * from ' . tablename('ewei_shop_refund_address') . ' where uniacid=:uniacid order by id desc limit 1', array(':uniacid' => $uniacid));
				}
			}

			if (!empty($refund['images'])) {
				$refund['images'] = iunserializer($refund['images']);
			}
		}

		if (empty($refund)) {
			$show_price = round($order['refundprice'], 2);
		}
		else {
			$show_price = round($refund['applyprice'], 2);
		}

		$express_list = m('express')->getExpressList();
		$refund['applytime'] = date('Y-m-d H:i:s', $refund['applytime']);
		return app_json(array('express_list' => $express_list, 'show_price' => $show_price, 'refund' => $refund, 'order' => $order, 'rtypeIndex' => $refund['rtype'] ?: 0));
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		extract($this->globalData());

		if ($order['status'] == '-1') {
			return app_error('订单已经处理完毕!');
		}

		$price = trim($_GPC['price']);
		$rtype = intval($_GPC['rtype']);

		if ($rtype != 2) {
			if (empty($price)) {
				return app_error('退款金额不能为0元');
			}

			if ($order['refundprice'] < $price) {
				return app_error('退款金额不能超过' . $order['refundprice'] . '元');
			}
		}

		$refund = array('uniacid' => $uniacid, 'applyprice' => $_GPC['price'], 'refundaddressid' => $order['addressid'], 'refundaddress' => $order['address'], 'rtype' => $rtype, 'reason' => trim($_GPC['reason']), 'content' => trim($_GPC['content']), 'images' => iserializer($_GPC['images']));

		if ($refund['rtype'] == 2) {
			$refundstate = 2;
		}
		else {
			$refundstate = 1;
		}

		if ($order['refundstate'] == 0) {
			$refundno = m('common')->createNO('groups_order_refund', 'refundno', 'PR');
			$refund['applytime'] = time();
			$refund['openid'] = $openid;
			$refund['orderid'] = $orderid;
			$refund['applycredit'] = $order['credit'];
			$refund['applyprice'] = $_GPC['price'];
			$refund['refundno'] = $refundno;
			pdo_insert('ewei_shop_groups_order_refund', $refund);
			$refundid = pdo_insertid();
			pdo_update('ewei_shop_groups_order', array('refundid' => $refundid, 'refundstate' => $refundstate), array('id' => $orderid, 'uniacid' => $uniacid));
		}
		else {
			pdo_update('ewei_shop_groups_order', array('refundstate' => $refundstate), array('id' => $orderid, 'uniacid' => $uniacid));
			pdo_update('ewei_shop_groups_order_refund', $refund, array('id' => $refundid, 'uniacid' => $uniacid));
		}

		p('groups')->sendTeamMessage($orderid, true);
		return app_json();
	}

	public function cancel()
	{
		global $_W;
		global $_GPC;
		extract($this->globalData());
		$change_refund = array();
		$change_refund['refundstatus'] = -2;
		$change_refund['refundtime'] = time();
		pdo_update('ewei_shop_groups_order_refund', $change_refund, array('id' => $refundid, 'uniacid' => $uniacid));
		pdo_update('ewei_shop_groups_order', array('refundstate' => 0), array('id' => $orderid, 'uniacid' => $uniacid));
		return app_json();
	}

	public function express()
	{
		global $_W;
		global $_GPC;
		extract($this->globalData());

		if (empty($refundid)) {
			return app_error('参数错误！');
		}

		if (empty($_GPC['expresssn'])) {
			return app_error('请填写快递单号');
		}

		$refund = array('refundstatus' => 4, 'express' => trim($_GPC['express']), 'expresscom' => trim($_GPC['expresscom']), 'expresssn' => trim($_GPC['expresssn']), 'sendtime' => time());
		pdo_update('ewei_shop_groups_order_refund', $refund, array('id' => $refundid, 'uniacid' => $uniacid));
		return app_json();
	}

	public function receive()
	{
		global $_W;
		global $_GPC;
		extract($this->globalData());
		$refundid = intval($_GPC['refundid']);
		$refund = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order_refund') . ' where id=:id and uniacid=:uniacid and orderid=:orderid limit 1', array(':id' => $refundid, ':uniacid' => $uniacid, ':orderid' => $orderid));

		if (empty($refund)) {
			return app_error('换货申请未找到');
		}

		$time = time();
		$refund_data = array();
		$refund_data['refundstatus'] = 1;
		$refund_data['refundtime'] = $time;
		pdo_update('ewei_shop_groups_order_refund', $refund_data, array('id' => $refundid, 'uniacid' => $uniacid));
		$order_data = array();
		$order_data['refundstate'] = -1;
		$order_data['refundtime'] = $time;
		$order_data['status'] = 3;
		$order_data['finishtime'] = $time;
		pdo_update('ewei_shop_groups_order', $order_data, array('id' => $orderid, 'uniacid' => $uniacid));
		return app_json();
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
		return app_json(array('data' => $expresslist));
	}
}

?>
