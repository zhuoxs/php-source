<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'mmanage/core/inc/page_mmanage.php';
class Index_EweiShopV2Page extends MmanageMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$account = $_W['mmanage'];
		$shopset = $_W['shopset']['shop'];
		$notice = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_system_copyright_notice') . ' WHERE status=1 ORDER BY displayorder ASC,createtime DESC LIMIT 10');
		include $this->template();
	}

	public function get_today()
	{
		$order = $this->order(0);
		$member = $this->newmember(0);
		show_json(1, array('today_count' => $order['count'], 'today_price' => $order['price'], 'today_member' => $member['count']));
	}

	public function get_order()
	{
		$totals = m('order')->getTotals();
		show_json(1, $totals);
	}

	public function get_shop()
	{
		global $_W;
		$goods = m('goods')->getTotals();
		$goodscount = $goods['sale'] + $goods['out'] + $goods['stock'] + $goods['cycle'];
		$open_redis = function_exists('redis') && !is_error(redis());

		if ($open_redis) {
			$redis_key = 'ewei_' . $_W['uniacid'] . '_member_mmanage_index1';
			$member_count = m('member')->memberRadisCount($redis_key, false);

			if (!$member_count) {
				$member_count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
				m('member')->memberRadisCount($redis_key, $member_count);
			}
		}
		else {
			$member_count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
		}

		show_json(1, array('goods_count' => $goodscount, 'member_count' => $member_count));
	}

	/**
     * ajax return 交易订单
     */
	protected function order($day)
	{
		global $_GPC;
		$day = (int) $day;
		$orderPrice = $this->selectOrderPrice($day);
		$orderPrice['avg'] = empty($orderPrice['count']) ? 0 : round($orderPrice['price'] / $orderPrice['count'], 1);
		unset($orderPrice['fetchall']);
		return $orderPrice;
	}

	protected function selectOrderPrice($day = 0)
	{
		global $_W;
		$day = (int) $day;

		if ($day != 0) {
			$createtime1 = strtotime(date('Y-m-d', time() - $day * 3600 * 24));
			$createtime2 = strtotime(date('Y-m-d', time()));
		}
		else {
			$createtime1 = strtotime(date('Y-m-d', time()));
			$createtime2 = strtotime(date('Y-m-d', time() + 3600 * 24));
		}

		$sql = 'select id,price,createtime from ' . tablename('ewei_shop_order') . ' where uniacid = :uniacid and ismr=0 and isparent=0 and (status > 0 or ( status=0 and paytype=3)) and deleted=0 and createtime between :createtime1 and :createtime2';
		$param = array(':uniacid' => $_W['uniacid'], ':createtime1' => $createtime1, ':createtime2' => $createtime2);
		$pdo_res = pdo_fetchall($sql, $param);
		$price = 0;

		foreach ($pdo_res as $arr) {
			$price += $arr['price'];
		}

		$result = array('price' => round($price, 1), 'count' => count($pdo_res), 'fetchall' => $pdo_res);
		return $result;
	}

	protected function newmember($day = 0)
	{
		global $_GPC;
		global $_W;
		$day = (int) $day;

		if (isset($_GPC['day'])) {
			$day = (int) $_GPC['day'];
		}

		$param = array(':uniacid' => $_W['uniacid']);
		$open_redis = function_exists('redis') && !is_error(redis());

		if ($open_redis) {
			$redis_key = 'ewei_' . $_W['uniacid'] . '_member_mmanage_index2';
			$member_count = m('member')->memberRadisCount($redis_key, false);

			if (!$member_count) {
				$member_count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where uniacid=:uniacid', $param);
				m('member')->memberRadisCount($redis_key, $member_count);
			}
		}
		else {
			$member_count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where uniacid=:uniacid', $param);
		}

		$newmember = $this->selectMemberCreate($day);
		return array('count' => (int) $newmember, 'rate' => empty($member_count) ? 0 : (int) number_format(round($newmember / $member_count, 3) * 100));
	}

	protected function selectMemberCreate($day = 0)
	{
		global $_W;
		$day = (int) $day;

		if ($day != 0) {
			$createtime1 = strtotime(date('Y-m-d', time() - $day * 3600 * 24));
			$createtime2 = strtotime(date('Y-m-d', time()));
		}
		else {
			$createtime1 = strtotime(date('Y-m-d', time()));
			$createtime2 = strtotime(date('Y-m-d', time() + 3600 * 24));
		}

		$sql = 'select count(*) from ' . tablename('ewei_shop_member') . ' where uniacid = :uniacid and createtime between :createtime1 and :createtime2';
		$param = array(':uniacid' => $_W['uniacid'], ':createtime1' => $createtime1, ':createtime2' => $createtime2);
		$open_redis = function_exists('redis') && !is_error(redis());
		return pdo_fetchcolumn($sql, $param);
	}
}

?>
