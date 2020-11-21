<?php
defined('IN_IA') or exit('Access Denied');

function address_tree_in_use($terarea){
	$provinces = pdo_fetch_many('weliam_shiftcar_address', array('visible' => 2, 'level' => 1), array(), 'id');
	$cities = pdo_fetch_many('weliam_shiftcar_address', array('visible' => 2, 'level' => 2), array(), 'id');
	$districts= pdo_fetch_many('weliam_shiftcar_address', array('visible' => 2, 'level' => 3), array(), 'id');
	
	$address_tree = array();
	foreach ($provinces as $province_id => $province) {
		$address_tree[$province_id] = array(
			'title' => $province['name'],
			'cities' => array()
		);
		foreach ($cities as $city_id => $city) {
			if(in_array($city['id'], $terarea)){
				unset($cities[$city_id]);
			}else{
				if ($city['pid'] == $province_id) {
					$address_tree[$province_id]['cities'][$city_id] = array(
						'title' => $city['name'],
						'districts' => array(),
					);
					foreach ($districts as $district_id => $district) {
						if ($district['pid'] == $city_id) {
							$address_tree[$province_id]['cities'][$city_id]['districts'][$district_id] = $district['name'];
						}
					}
				}
			}
		}
	}
	return $address_tree;
}