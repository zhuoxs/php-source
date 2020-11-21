<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Deferred_EweiShopV2Page extends PluginMobilePage
{
	public function do_deferred()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$time = strtotime($_GPC['time']);
		$day = 86400;
		$orderid = $_GPC['orderid'];
		$isall = intval($_GPC['isall']);

		if (empty($orderid)) {
			show_json(0, '缺少订单ID');
		}

		if (empty($_GPC['time'])) {
			show_json(0, '缺少顺延时间');
		}

		$order = pdo_get('ewei_shop_order', array('id' => $orderid));

		if (empty($order)) {
			show_json(0, '没有查到该订单');
		}

		if (!empty($order['cycelbuy_periodic'])) {
			$arr = explode(',', $order['cycelbuy_periodic']);
		}
		else {
			show_json(0, '无法获取周期');
		}

		if ($arr[1] == 0) {
			$interval = $arr[0] * $day;
		}
		else if ($arr[1] == 1) {
			$interval = $arr[0] * ($day * 7);
		}
		else {
			$interval = $arr[0] * ($day * 30);
		}

		$condition = 'orderid = :orderid and uniacid = :uniacid and status = 0 order by receipttime asc';

		if (empty($isall)) {
			$condition .= ' limit 1';
		}

		$param = array('orderid' => $orderid, 'uniacid' => $_W['uniacid']);
		$data = pdo_fetchall('select * from ' . tablename('ewei_shop_cycelbuy_periods') . ' where ' . $condition, $param);
		$data['receipttime'] = $time;

		foreach ($data as $k => $v) {
			$receipttime = $time + $interval * $k;
			pdo_update('ewei_shop_cycelbuy_periods', array('receipttime' => $receipttime), array('id' => $v['id']));
		}

		$this->model->sendMessage(NULL, $data, 'TM_CYCELBUY_SELLER_DATE');
		$this->model->sendMessage($openid, $data, 'TM_CYCELBUY_BUYER_DATE');
		show_json(1, '顺延成功');
	}
}

?>
