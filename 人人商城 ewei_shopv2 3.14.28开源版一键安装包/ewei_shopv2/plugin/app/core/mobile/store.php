<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Store_EweiShopV2Page extends AppMobilePage
{
	/**
     * 门店选择
     */
	public function selector()
	{
		global $_W;
		global $_GPC;
		$ids = trim($_GPC['ids']);
		$type = intval($_GPC['type']);
		$merchid = intval($_GPC['merchid']);
		$lng = $_GPC['lng'];
		$lat = $_GPC['lat'];
		$condition = '';

		if (!empty($ids)) {
			$condition = ' and id in(' . $ids . ')';
		}

		if ($type == 1) {
			$condition .= ' and type in(1,3) ';
		}
		else {
			if ($type == 2) {
				$condition .= ' and type in(2,3) ';
			}
		}

		if (0 < $merchid) {
			$list = pdo_fetchall('select * from ' . tablename('ewei_shop_merch_store') . ' where  uniacid=:uniacid and merchid=:merchid and status=1 ' . $condition . ' order by displayorder desc,id desc', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
		}
		else {
			$list = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  uniacid=:uniacid and status=1 ' . $condition . ' order by displayorder desc,id desc', array(':uniacid' => $_W['uniacid']));
		}

		foreach ($list as $key => $value) {
			$list[$key]['dast'] = m('util')->GetDistance($value['lat'], $value['lng'], $lat, $lng, 2) . 'km';
		}

		$score = array();

		foreach ($list as $key => $value) {
			$score[$key] = $value['dast'];
		}

		array_multisort($score, SORT_ASC, SORT_NUMERIC, $list);
		$list = set_medias($list, 'logo');
		return app_json(array('list' => $list));
	}

	/**
     * 门店地图
     */
	public function map()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$merchid = intval($_GPC['merchid']);

		if (0 < $merchid) {
			$store = pdo_fetch('select * from ' . tablename('ewei_shop_merch_store') . ' where id=:id and uniacid=:uniacid and merchid=:merchid', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
		}
		else {
			$store = pdo_fetch('select * from ' . tablename('ewei_shop_store') . ' where id=:id and uniacid=:uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		}

		$store['logo'] = empty($store['logo']) ? $_W['shopset']['shop']['logo'] : $store['logo'];
		$store['logo'] = tomedia($store['logo']);
		$gcj02 = $this->Convert_BD09_To_GCJ02($store['lat'], $store['lng']);
		$store['lat'] = $gcj02['lat'];
		$store['lng'] = $gcj02['lng'];
		return app_json(array('store' => $store));
	}

	public function Convert_BD09_To_GCJ02($lat, $lng)
	{
		$x_pi = 3.1415926535897931 * 3000 / 180;
		$x = $lng - 0.0064999999999999997;
		$y = $lat - 0.0060000000000000001;
		$z = sqrt($x * $x + $y * $y) - 2.0000000000000002E-5 * sin($y * $x_pi);
		$theta = atan2($y, $x) - 3.0000000000000001E-6 * cos($x * $x_pi);
		$lng = $z * cos($theta);
		$lat = $z * sin($theta);
		return array('lat' => $lat, 'lng' => $lng);
	}
}

?>
