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
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$orderid = intval($_GPC['id']);
		$order = pdo_fetch('select id,status,price,refundid,goodsprice,dispatchprice,deductprice,deductcredit2,finishtime,isverify,`virtual`,refundstate,merchid from ' . tablename('ewei_shop_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));

		if (empty($order)) {
			return app_error(AppError::$OrderNotFound);
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
			return app_error(AppError::$OrderCanNotRefund, $_err);
		}

		$order['cannotrefund'] = false;

		if ($order['status'] == 2) {
			$goods = pdo_fetchall('select og.goodsid, og.price, og.total, og.optionname, g.cannotrefund, g.thumb, g.title from' . tablename('ewei_shop_order_goods') . ' og left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid where og.orderid=' . $order['id']);

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
			return app_error(AppError::$OrderCanNotRefund, '此订单不可退换货');
		}

		$order['refundprice'] = $order['price'] + $order['deductcredit2'];

		if (2 <= $order['status']) {
			$order['refundprice'] -= $order['dispatchprice'];
		}

		$order['refundprice'] = round($order['refundprice'], 2);
		return array('uniacid' => $uniacid, 'openid' => $_W['openid'], 'orderid' => $orderid, 'order' => $order, 'refundid' => $order['refundid']);
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		extract($this->globalData());

		if ($order['status'] == '-1') {
			return app_error(AppError::$OrderCanNotResubmit);
		}

		$refund = array();
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
			$refund['createtime'] = date('Y-m-d H:i:s', $refund['createtime']);
			$reasonArr = array('不想要了', '卖家缺货', '拍错了/订单信息错误', '其它');
			$reasonIndex = array_search($refund['reason'], $reasonArr);

			if ($refund['status'] == 3) {
				$refund['statusstr'] = '需填写快递单号';
			}
			else if ($refund['status'] == 4) {
				$refund['statusstr'] = '等待商家确认';
			}
			else {
				if ($refund['status'] == 5) {
					$refund['statusstr'] = '商家已经发货';
				}
			}
		}

		$express_list = m('express')->getExpressList();
		return app_json(array('title' => ($order['status'] == 1 ? '退款' : '售后') . '申请', 'refundtype' => $refund['rtype'], 'refundreason' => ($refund['rtype'] == '2' ? '换货' : '退款') . '原因', 'refundexplain' => ($refund['rtype'] == '2' ? '换货' : '退款') . '说明', 'price' => $show_price, 'content' => isset($refund['content']) ? $refund['content'] : '', 'order' => $order, 'refund' => $refund, 'images' => is_array($refund['imgs']) ? $refund['imgs'] : array(), 'imgs' => !empty($images) ? $images : array(), 'express_list' => $express_list, 'rtypeIndex' => !empty($refund) ? $refund['rtype'] : 0, 'reasonIndex' => !empty($reasonIndex) ? $reasonIndex : 0));
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		extract($this->globalData());

		if ($order['status'] == '-1') {
			return app_error(AppError::$OrderCanNotRefund, '订单已经处理完毕');
		}

		$price = trim($_GPC['price']);
		$rtype = intval($_GPC['rtype']);

		if ($rtype != 2) {
			if (empty($price) && $order['deductprice'] == 0) {
				return app_error(AppError::$OrderCanNotRefund, '退款金额不能为0元');
			}

			if ($order['refundprice'] < $price) {
				return app_error(AppError::$OrderCanNotRefund, '退款金额不能超过' . $order['refundprice'] . '元');
			}
		}

		$images = $_GPC['images'];

		if (is_string($images)) {
			$images = htmlspecialchars_decode(str_replace('\\', '', $images));
			$images = @json_decode($images, true);
		}

		$refund = array('uniacid' => $uniacid, 'merchid' => $order['merchid'], 'applyprice' => $price, 'rtype' => $rtype, 'reason' => trim($_GPC['reason']), 'content' => trim($_GPC['content']), 'imgs' => iserializer($images));

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
		return app_json();
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
		return app_json();
	}

	public function express()
	{
		global $_W;
		global $_GPC;
		extract($this->globalData());

		if (empty($refundid)) {
			return app_error(AppError::$ParamsError, '参数错误');
		}

		if (empty($_GPC['expresssn'])) {
			return app_error(AppError::$ParamsError, '请填写快递单号');
		}

		$refund = array('status' => 4, 'express' => trim($_GPC['express']), 'expresscom' => trim($_GPC['expresscom']), 'expresssn' => trim($_GPC['expresssn']), 'sendtime' => time());
		pdo_update('ewei_shop_order_refund', $refund, array('id' => $refundid, 'uniacid' => $uniacid));
		return app_json();
	}

	public function receive()
	{
		global $_W;
		global $_GPC;
		extract($this->globalData());
		$refundid = intval($_GPC['refundid']);
		$refund = pdo_fetch('select * from ' . tablename('ewei_shop_order_refund') . ' where id=:id and uniacid=:uniacid and orderid=:orderid limit 1', array(':id' => $refundid, ':uniacid' => $uniacid, ':orderid' => $orderid));

		if (empty($refund)) {
			return app_error(AppError::$OrderNotFound, '换货申请未找到');
		}

		$time = time();
		$refund_data = array();
		$refund_data['status'] = 1;
		$refund_data['refundtime'] = $time;
		pdo_update('ewei_shop_order_refund', $refund_data, array('id' => $refundid, 'uniacid' => $uniacid));
		$order_data = array();
		$order_data['refundstate'] = 0;
		$order_data['status'] = -1;
		$order_data['refundtime'] = $time;
		pdo_update('ewei_shop_order', $order_data, array('id' => $orderid, 'uniacid' => $uniacid));
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
		return app_json(array('list' => $expresslist));
	}
}

?>
