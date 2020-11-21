<?php
defined('IN_IA') or exit('Access Denied');

function wl_syssetting_save($data, $key) {
	global $_W;
	if (empty($key)) {
		return FALSE;
	}
	
	$record = array();
	$record['value'] = iserializer($data);
	$exists = pdo_select_count('weliam_shiftcar_setting', array('key'=>$key,'uniacid' => -1));
	if ($exists) {
		$return = pdo_update('weliam_shiftcar_setting', $record, array('key' => $key,'uniacid' => -1));
	} else {
		$record['key'] = $key;
		$record['uniacid'] = -1;
		$return = pdo_insert('weliam_shiftcar_setting', $record);
	}
	cache_write('weliam_shiftcar_syssetting', '');
	
	return $return;
}

function wl_syssetting_read($key){
	global $_W;
	$settings = cache_load('weliam_shiftcar_syssetting');
	if (empty($_W['wlsetting'])) {
		$settings = pdo_fetch_one('weliam_shiftcar_setting', array('key'=>$key,'uniacid' => -1), array('value'));
		if (is_array($settings)) {
			$settings = iunserializer($settings['value']);
		} else {
			$settings = '';
		}
		cache_write('weliam_shiftcar_syssetting', $settings);
	}
	return $settings;
}