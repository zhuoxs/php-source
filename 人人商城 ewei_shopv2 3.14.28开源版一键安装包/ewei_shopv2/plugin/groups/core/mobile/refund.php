<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Refund_EweiShopV2Page extends PluginMobileLoginPage
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
			if (!$_W['isajax']) {
				header('location: ' . mobileUrl('groups/orders'));
				exit();
			}
			else {
				$this->message('订单未找到', mobileUrl('groups/index'), 'error');
			}
		}

		if ($order['heads'] == 1 && $order['success'] == 0) {
			$_err = '拼团未成功，团长不允许退款！';
			$this->message($_err, mobileUrl('groups/index'), 'error');
		}

		$goodRefund = false;
		$groupsSet = pdo_fetch('select goodsid,refundday from ' . tablename('ewei_shop_groups_set') . 'where uniacid = :uniacid ', array(':uniacid' => $uniacid));

		if (in_array($order['goodid'], explode(',', $groupsSet['goodsid']))) {
			$goodRefund = true;
		}

		if ($groupsSet['refundday'] == 0) {
			$goodRefund = true;
		}

		$verifytotal = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_verify') . ' where orderid = :orderid and openid = :openid and uniacid = :uniacid and verifycode = :verifycode ', array(':orderid' => $order['id'], ':openid' => $order['openid'], ':uniacid' => $order['uniacid'], ':verifycode' => $order['verifycode']));

		if ($order['status'] == 0) {
			$_err = '订单未付款，不能申请退款!';
		}
		else if ($order['status'] == 2) {
			if ($goodRefund) {
				$_err = '该商品不允许退款!';
			}

			if (0 < $verifytotal) {
				$_err = '该商品已经核销不允许退款!';
			}
		}
		else {
			if ($order['status'] == 3) {
				if ($goodRefund) {
					$_err = '该商品不允许退款!';
				}
				else if (0 < $verifytotal) {
					$_err = '该商品已经核销不允许退款!';
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
			if ($_W['isajax']) {
				show_json(0, $_err);
			}
			else {
				$this->message($_err, mobileUrl('groups/index'), 'error');
			}
		}

		$order['refundprice'] = $order['price'] - $order['creditmoney'] + $order['freight'];

		if (2 <= $order['status']) {
			$order['refundprice'] -= $order['freight'];
		}

		$order['refundprice'] = round($order['refundprice'], 2);
		return array('uniacid' => $uniacid, 'openid' => $_W['openid'], 'orderid' => $orderid, 'order' => $order, 'refundid' => $order['refundid']);
	}

	public function main()
	{
		global $_W;
		global $_GPC;

		try {
			extract($this->globalData());
			if ($order['success'] == 0 && $order['heads'] == 1) {
				throw new Exception('拼团未完成,团长不能退款哦！');
			}

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

			$this->model->groupsShare();
			$express_list = m('express')->getExpressList();
			include $this->template();
		}
		catch (Exception $e) {
			$content = $e->getMessage();
			include $this->template('groups/error');
		}
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		extract($this->globalData());
		$error = '';

		if ($order['status'] == '-1') {
			$error = '订单已经处理完毕';
		}

		$price = trim($_GPC['price']);
		$rtype = intval($_GPC['rtype']);

		if ($rtype != 2) {
			if (empty($price)) {
				$error = '退款金额不能为0元';
			}

			if ($order['refundprice'] < $price) {
				$error = '退款金额不能超过' . $order['refundprice'] . '元';
			}
		}

		if (!empty($error)) {
			if ($_W['isajax']) {
				show_json(0, $error);
			}
			else {
				$this->message($error, mobileUrl('groups/index'), 'error');
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
		show_json(1);
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

		$refund = array('refundstatus' => 4, 'express' => trim($_GPC['express']), 'expresscom' => trim($_GPC['expresscom']), 'expresssn' => trim($_GPC['expresssn']), 'sendtime' => time());
		pdo_update('ewei_shop_groups_order_refund', $refund, array('id' => $refundid, 'uniacid' => $uniacid));
		show_json(1);
	}

	public function receive()
	{
		global $_W;
		global $_GPC;
		extract($this->globalData());
		$refundid = intval($_GPC['refundid']);
		$refund = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order_refund') . ' where id=:id and uniacid=:uniacid and orderid=:orderid limit 1', array(':id' => $refundid, ':uniacid' => $uniacid, ':orderid' => $orderid));

		if (empty($refund)) {
			show_json(0, '换货申请未找到!');
		}

		$time = time();
		$refund_data = array();
		$refund_data['refundstatus'] = 1;
		$refund_data['refundtime'] = $time;
		pdo_update('ewei_shop_groups_order_refund', $refund_data, array('id' => $refundid, 'uniacid' => $uniacid));
		$order_data = array();
		$order_data['refundstate'] = -1;
		$order_data['status'] = 3;
		$order_data['refundtime'] = $time;
		$order_data['finishtime'] = $time;
		pdo_update('ewei_shop_groups_order', $order_data, array('id' => $orderid, 'uniacid' => $uniacid));
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
		$this->model->groupsShare();
		include $this->template('groups/refund/express');
	}
}

?>
