<?php
//QQ63779278
class Dispatch_EweiShopV2Model
{
	/**
     * 计算运费
     * @param type $param 重量或者是数量
     * @param type $d
     * @param type $calculatetype -1默认读取$d中的calculatetype值 1按数量计算运费 0按重量计算运费
     */
	public function getDispatchPrice($param, $d, $calculatetype = -1)
	{
		if (empty($d)) {
			return 0;
		}

		$price = 0;

		if ($calculatetype == -1) {
			$calculatetype = $d['calculatetype'];
		}

		if ($calculatetype == 1) {
			if ($param <= $d['firstnum']) {
				$price = floatval($d['firstnumprice']);
			}
			else {
				$price = floatval($d['firstnumprice']);
				$secondweight = $param - floatval($d['firstnum']);
				$dsecondweight = floatval($d['secondnum']) <= 0 ? 1 : floatval($d['secondnum']);
				$secondprice = 0;

				if ($secondweight % $dsecondweight == 0) {
					$secondprice = $secondweight / $dsecondweight * floatval($d['secondnumprice']);
				}
				else {
					$secondprice = ((int) ($secondweight / $dsecondweight) + 1) * floatval($d['secondnumprice']);
				}

				$price += $secondprice;
			}
		}
		else if ($param <= $d['firstweight']) {
			if (0 <= $param) {
				$price = floatval($d['firstprice']);
			}
			else {
				$price = 0;
			}
		}
		else {
			$price = floatval($d['firstprice']);
			$secondweight = $param - floatval($d['firstweight']);
			$dsecondweight = floatval($d['secondweight']) <= 0 ? 1 : floatval($d['secondweight']);
			$secondprice = 0;

			if ($secondweight % $dsecondweight == 0) {
				$secondprice = $secondweight / $dsecondweight * floatval($d['secondprice']);
			}
			else {
				$secondprice = ((int) ($secondweight / $dsecondweight) + 1) * floatval($d['secondprice']);
			}

			$price += $secondprice;
		}

		return $price;
	}

	public function getCityDispatchPrice($areas, $address, $param, $d)
	{
		$city = $address['city'];
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);

		if (empty($new_area)) {
			if (is_array($areas) && 0 < count($areas)) {
				foreach ($areas as $area) {
					$citys = explode(';', $area['citys']);
					$citys = array_filter($citys);
					if (!empty($citys) && in_array($city, $citys)) {
						return $this->getDispatchPrice($param, $area, $d['calculatetype']);
					}
				}
			}
		}
		else {
			$address_datavalue = trim($address['datavalue']);
			if (is_array($areas) && 0 < count($areas)) {
				foreach ($areas as $area) {
					$citys_code = explode(';', $area['citys_code']);
					if (in_array($address_datavalue, $citys_code) && !empty($citys_code)) {
						return $this->getDispatchPrice($param, $area, $d['calculatetype']);
					}
				}
			}
		}

		return $this->getDispatchPrice($param, $d);
	}

	/**
     * 获取默认快递信息
     */
	public function getDefaultDispatch($merchid = 0)
	{
		global $_W;
		$sql = 'select * from ' . tablename('ewei_shop_dispatch') . ' where isdefault=1 and uniacid=:uniacid and merchid=:merchid and enabled=1 Limit 1';
		$params = array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid);
		$data = pdo_fetch($sql, $params);
		return $data;
	}

	/**
     * 获取最新的一条快递信息
     */
	public function getNewDispatch($merchid = 0)
	{
		global $_W;
		$sql = 'select * from ' . tablename('ewei_shop_dispatch') . ' where uniacid=:uniacid and merchid=:merchid and enabled=1 order by id desc Limit 1';
		$params = array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid);
		$data = pdo_fetch($sql, $params);
		return $data;
	}

	/**
     * 获取一条快递信息
     */
	public function getOneDispatch($id)
	{
		global $_W;
		$params = array(':uniacid' => $_W['uniacid']);

		if ($id == 0) {
			$sql = 'select * from ' . tablename('ewei_shop_dispatch') . ' where isdefault=1 and uniacid=:uniacid and enabled=1 Limit 1';
		}
		else {
			$sql = 'select * from ' . tablename('ewei_shop_dispatch') . ' where id=:id and uniacid=:uniacid and enabled=1 Limit 1';
			$params[':id'] = $id;
		}

		$data = pdo_fetch($sql, $params);
		return $data;
	}

	public function getAllNoDispatchAreas($areas = array(), $type = 0)
	{
		global $_W;
		$tradeset = m('common')->getSysset('trade');

		if (empty($type)) {
			$dispatchareas = iunserializer($tradeset['nodispatchareas']);
		}
		else {
			$dispatchareas = iunserializer($tradeset['nodispatchareas_code']);
		}

		$set_citys = array();
		$dispatch_citys = array();

		if (!empty($dispatchareas)) {
			$set_citys = explode(';', trim($dispatchareas, ';'));
		}

		if (!empty($areas)) {
			$areas = iunserializer($areas);

			if (!empty($areas)) {
				$dispatch_citys = explode(';', trim($areas, ';'));
			}
		}

		$citys = array();

		if (!empty($set_citys)) {
			$citys = $set_citys;
		}

		if (!empty($dispatch_citys)) {
			$citys = array_merge($citys, $dispatch_citys);
			$citys = array_unique($citys);
		}

		return $citys;
	}

	public function checkOnlyDispatchAreas($user_city_code, $dispatch_data)
	{
		global $_W;
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);

		if (empty($new_area)) {
			$areas = $dispatch_data['nodispatchareas'];
		}
		else {
			$areas = $dispatch_data['nodispatchareas_code'];
		}

		$isnoarea = 1;
		if (!empty($user_city_code) && !empty($areas)) {
			$areas = iunserializer($areas);
			$citys = explode(';', trim($areas, ';'));

			if (in_array($user_city_code, $citys)) {
				$isnoarea = 0;
			}
		}

		return $isnoarea;
	}

	public function getNoDispatchAreas($goods)
	{
		global $_W;
		if ($goods['type'] == 2 || $goods['type'] == 3) {
			return '';
		}

		if ($goods['dispatchtype'] == 1) {
			$dispatchareas = $this->getAllNoDispatchAreas();
		}
		else {
			if (empty($goods['dispatchid'])) {
				$dispatch = m('dispatch')->getDefaultDispatch($goods['merchid']);
			}
			else {
				$dispatch = m('dispatch')->getOneDispatch($goods['dispatchid']);
			}

			if (empty($dispatch)) {
				$dispatch = m('dispatch')->getNewDispatch($goods['merchid']);
			}

			if (empty($dispatch['isdispatcharea'])) {
				$onlysent = 0;
				$citys = $this->getAllNoDispatchAreas($dispatch['nodispatchareas']);
			}
			else {
				$onlysent = 1;
				$dispatchareas = unserialize($dispatch['nodispatchareas']);
				$citys = explode(';', trim($dispatchareas, ';'));
			}
		}

		return array('onlysent' => $onlysent, 'citys' => $citys, 'enabled' => $dispatch['enabled']);
	}

	public function getCityfreepricePrice($areas, $address)
	{
		$city = $address['city'];
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);

		if (empty($new_area)) {
			if (is_array($areas) && 0 < count($areas)) {
				foreach ($areas as $area) {
					$citys = explode(';', $area['citys']);
					$citys = array_filter($citys);
					if (!empty($citys) && in_array($city, $citys)) {
						return $area['freeprice'];
					}
				}
			}
		}
		else {
			$address_datavalue = trim($address['datavalue']);
			if (is_array($areas) && 0 < count($areas)) {
				foreach ($areas as $area) {
					$citys_code = explode(';', $area['citys_code']);
					if (in_array($address_datavalue, $citys_code) && !empty($citys_code)) {
						return $area['freeprice'];
					}
				}
			}
		}
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
