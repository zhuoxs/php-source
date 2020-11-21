<?php
//QQ63779278
class Store_EweiShopV2Model
{
	public function getStoreInfo($id)
	{
		global $_W;
		return pdo_fetch('select * from ' . tablename('ewei_shop_store') . ' where id=:id and uniacid=:uniacid Limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
	}

	public function getGoodsInfo($id)
	{
		global $_W;
		$sql = 'select * from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid Limit 1';
		return pdo_fetch($sql, array(':id' => $id, ':uniacid' => $_W['uniacid']));
	}

	public function getStoreGoodsInfo($goodsid, $storeid, $flag = 0)
	{
		global $_W;

		if (empty($flag)) {
			$con = ' and gstatus=1';
		}
		else {
			$con = '';
		}

		$sql = 'select * from ' . tablename('ewei_shop_newstore_goods') . ' where goodsid=:goodsid and storeid=:storeid and uniacid=:uniacid ' . $con . ' Limit 1';
		return pdo_fetch($sql, array(':goodsid' => $goodsid, ':storeid' => $storeid, ':uniacid' => $_W['uniacid']));
	}

	public function getStoreGoodsOption($goodsid, $storeid)
	{
		global $_W;
		$sql = 'select * from ' . tablename('ewei_shop_newstore_goods_option') . ' where goodsid=:goodsid and storeid=:storeid and uniacid=:uniacid';
		return pdo_fetchall($sql, array(':goodsid' => $goodsid, ':storeid' => $storeid, ':uniacid' => $_W['uniacid']));
	}

	public function getOneStoreGoodsOption($optionid, $goodsid, $storeid)
	{
		global $_W;
		$sql = 'select * from ' . tablename('ewei_shop_newstore_goods_option') . ' where goodsid=:goodsid and storeid=:storeid and optionid=:optionid and uniacid=:uniacid Limit 1';
		return pdo_fetch($sql, array(':goodsid' => $goodsid, ':storeid' => $storeid, ':optionid' => $optionid, ':uniacid' => $_W['uniacid']));
	}

	public function getAllStore()
	{
		global $_W;
		$uniacid = $_W['uniacid'];
		$sql = 'select * from ' . tablename('ewei_shop_store') . ' where uniacid=:uniacid';
		return pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']));
	}

	public function checkStoreid()
	{
		global $_W;
		global $_GPC;
		$newstoreid = intval($_SESSION['newstoreid']);

		if (empty($newstoreid)) {
			$newstoreid = intval($_GPC['storeid']);

			if (!empty($newstoreid)) {
				$_SESSION['newstoreid'] = $newstoreid;
			}
		}

		return $newstoreid;
	}

	public function getStoreName($list, $return = 'all')
	{
		global $_W;

		if (!is_array($list)) {
			return $this->getListUserOne($list);
		}

		$store = array();

		foreach ($list as $value) {
			$storeid = $value['storeid'];

			if (empty($storeid)) {
				$storeid = 0;
			}

			if (empty($store[$storeid])) {
				$store[$storeid] = array();
			}

			array_push($store[$storeid], $value);
		}

		if (!empty($store)) {
			$store_ids = array_keys($store);
			$store_list = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where uniacid=:uniacid and id in(' . implode(',', $store_ids) . ')', array(':uniacid' => $_W['uniacid']), 'id');
			$all = array('store' => $store, 'store_list' => $store_list);
			return $return == 'all' ? $all : $all[$return];
		}

		return array();
	}

	public function getListStoreOne($storeid)
	{
		global $_W;
		$storeid = intval($storeid);

		if ($storeid) {
			$store = pdo_fetch('select * from ' . tablename('ewei_shop_store') . (' where uniacid=:uniacid and id=' . $storeid), array(':uniacid' => $_W['uniacid']));
			return $store;
		}

		return false;
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
