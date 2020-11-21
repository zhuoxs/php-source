<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		$set = m('common')->getSysset('template');

		if (!empty($set['style_v3'])) {
			if (cv('order.list.status1')) {
				header('location: ' . webUrl('order.list.status1'));
			}
			else if (cv('order.list.status2')) {
				header('location: ' . webUrl('order.list.status2'));
			}
			else if (cv('order.list.status3')) {
				header('location: ' . webUrl('order.list.status3'));
			}
			else if (cv('order.list.status0')) {
				header('location: ' . webUrl('order.list.status0'));
			}
			else if (cv('order.list.status_1')) {
				header('location: ' . webUrl('order.list.status_1'));
			}
			else if (cv('order.list.status4')) {
				header('location: ' . webUrl('order.list.status4'));
			}
			else if (cv('order.list.status5')) {
				header('location: ' . webUrl('order.list.status5'));
			}
			else if (cv('order.export')) {
				header('location: ' . webUrl('order.export'));
			}
			else if (cv('order.batchsend')) {
				header('location: ' . webUrl('order.batchsend'));
			}
			else {
				header('location: ' . webUrl());
			}
		}
		else {
			include $this->template();
		}
	}

	/**
     * 查询订单金额
     * @param int $day 查询天数
     * @return bool
     */
	protected function selectOrderPrice($day = 0)
	{
		global $_W;
		$day = (int) $day;

		if ($day != 0) {
			if ($day == 30) {
				$d = date('t');
				$year = date('Y');
				$month = date('m');
				$createtime1 = strtotime($year . '-' . $month . '-1 00:00:00');
				$createtime2 = strtotime($year . '-' . $month . '-' . $d . ' 23:59:59');
			}
			else if ($day == 7) {
				$yest = date('Y-m-d', strtotime('-1 day'));
				$createtime1 = strtotime(date('Y-m-d', strtotime('-7 day')));
				$createtime2 = strtotime($yest . ' 23:59:59');
			}
			else {
				$yesterday = strtotime('-1 day');
				$yy = date('Y', $yesterday);
				$ym = date('m', $yesterday);
				$yd = date('d', $yesterday);
				$createtime1 = strtotime($yy . '-' . $ym . '-' . $yd . ' 00:00:00');
				$createtime2 = strtotime($yy . '-' . $ym . '-' . $yd . ' 23:59:59');
			}
		}
		else {
			$createtime1 = strtotime(date('Y-m-d', time()));
			$createtime2 = strtotime(date('Y-m-d', time())) + 3600 * 24 - 1;
		}

		$sql = 'select id,price,paytime from ' . tablename('ewei_shop_order') . ' where uniacid = :uniacid and ismr=0 and isparent=0 and (status > 0 or ( status=0 and paytype=3)) and deleted=0 and paytime between :createtime1 and :createtime2';
		$param = array(':uniacid' => $_W['uniacid'], ':createtime1' => $createtime1, ':createtime2' => $createtime2);
		$pdo_res = pdo_fetchall($sql, $param);
		$price = 0;

		foreach ($pdo_res as $arr) {
			$price += $arr['price'];
		}

		$result = array('price' => round($price, 2), 'count' => count($pdo_res), 'fetchall' => $pdo_res);
		return $result;
	}

	/**
     * 查询近七天交易记录
     * @param array $pdo_fetchall 查询订单的记录
     * @param int $days 查询天数默认7
     * @return $transaction["price"] 七日 每日交易金额
     * @return $transaction["count"] 七日 每日交易订单数
     */
	protected function selectTransaction(array $pdo_fetchall, $days = 7)
	{
		$transaction = array();
		$days = (int) $days;

		if (!empty($pdo_fetchall)) {
			$i = $days;

			while (1 <= $i) {
				$transaction['price'][date('Y-m-d', time() - $i * 3600 * 24)] = 0;
				$transaction['count'][date('Y-m-d', time() - $i * 3600 * 24)] = 0;
				--$i;
			}

			foreach ($pdo_fetchall as $key => $value) {
				if (array_key_exists(date('Y-m-d', $value['paytime']), $transaction['price'])) {
					$transaction['price'][date('Y-m-d', $value['paytime'])] += $value['price'];
					$transaction['count'][date('Y-m-d', $value['paytime'])] += 1;
				}
			}

			return $transaction;
		}

		return array();
	}

	/**
     * ajax return 交易订单
     */
	protected function order($day)
	{
		global $_GPC;
		$day = (int) $day;
		$orderPrice = $this->selectOrderPrice($day);
		$orderPrice['avg'] = empty($orderPrice['count']) ? 0 : round($orderPrice['price'] / $orderPrice['count'], 2);
		unset($orderPrice['fetchall']);
		return $orderPrice;
	}

	public function ajaxorder()
	{
		$order0 = $this->order(0);
		$order1 = $this->order(1);
		$order7 = $this->order(7);
		$order30 = $this->order(30);
		$order7['price'] = $order7['price'];
		$order7['count'] = $order7['count'];
		$order7['avg'] = empty($order7['count']) ? 0 : round($order7['price'] / $order7['count'], 2);
		$order30['price'] = $order30['price'];
		$order30['count'] = $order30['count'];
		$order30['avg'] = empty($order30['count']) ? 0 : round($order30['price'] / $order30['count'], 2);
		show_json(1, array('order0' => $order0, 'order1' => $order1, 'order7' => $order7, 'order30' => $order30));
	}

	/**
     * ajax return 七日交易记录.近7日交易时间,交易金额,交易数量
     */
	public function ajaxtransaction()
	{
		$orderPrice = $this->selectOrderPrice(7);
		$transaction = $this->selectTransaction($orderPrice['fetchall'], 7);

		if (empty($transaction)) {
			$i = 7;

			while (1 <= $i) {
				$transaction['price'][date('Y-m-d', time() - $i * 3600 * 24)] = 0;
				$transaction['count'][date('Y-m-d', time() - $i * 3600 * 24)] = 0;
				--$i;
			}
		}

		echo json_encode(array('price_key' => array_keys($transaction['price']), 'price_value' => array_values($transaction['price']), 'count_value' => array_values($transaction['count'])));
	}
}

?>
