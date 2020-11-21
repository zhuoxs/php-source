<?php
defined('IN_IA') or exit('Access Denied');

function tg_syssetting_save($data, $key) {
	global $_W;
	if (empty($key)) {
		return FALSE;
	}
	
	$record = array();
	$record['value'] = iserializer($data);
	$exists = pdo_select_count('tg_setting', array('key'=>$key,'uniacid' => -1));
	if ($exists) {
		$return = pdo_update('tg_setting', $record, array('key' => $key,'uniacid' => -1));
	} else {
		$record['key'] = $key;
		$record['uniacid'] = -1;
		$return = pdo_insert('tg_setting', $record);
	}
	cache_write('tgsetting', '');
	
	return $return;
}

function tg_syssetting_read($key){
	global $_W;
	$settings = pdo_fetch_one('tg_setting', array('key'=>$key,'uniacid' => -1), array('value'));
	if (is_array($settings)) {
		$settings = iunserializer($settings['value']);
	} else {
		$settings = '';
	}
	return $settings;
}