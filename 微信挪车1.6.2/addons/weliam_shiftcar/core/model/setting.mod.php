<?php
defined('IN_IA') or exit('Access Denied');

function setting_get_list(){
	global $_W;
	$settings=pdo_fetchall("select * from".tablename('weliam_shiftcar_setting')."where uniacid = {$_W['uniacid']}");
	foreach($settings as$key=>&$value){
		$value['value'] = unserialize($value['value']);
	}
	return $settings;
}

function wlsetting_load() {
	global $_W;
	$_W['wlsetting'] = cache_load('weliam_shiftcar_setting'.$_W['uniacid']);
	if (empty($_W['wlsetting'])) {
		$settings = pdo_fetch_many('weliam_shiftcar_setting', array('uniacid' => $_W['uniacid']), array('key', 'value'), 'key');
		if (is_array($settings)) {
			foreach ($settings as $k => &$v) {
				$settings[$k] = iunserializer($v['value']);
			}
		} else {
			$settings = array();
		}
		$_W['wlsetting'] = $settings;
		cache_write('weliam_shiftcar_setting'.$_W['uniacid'], $settings);
	}
	return $_W['wlsetting'];
}

function wlsetting_save($data, $key) {
	global $_W;
	if (empty($key)) {
		return FALSE;
	}
	
	$record = array();
	$record['value'] = iserializer($data);
	$exists = pdo_select_count('weliam_shiftcar_setting', array('key'=>$key,'uniacid' => $_W['uniacid']));
	if ($exists) {
		$return = pdo_update('weliam_shiftcar_setting', $record, array('key' => $key,'uniacid' => $_W['uniacid']));
	} else {
		$record['key'] = $key;
		$record['uniacid'] = $_W['uniacid'];
		$return = pdo_insert('weliam_shiftcar_setting', $record);
	}
	cache_write('weliam_shiftcar_setting'.$_W['uniacid'], '');
	
	return $return;
}

function wlsetting_read($key){
	global $_W;
	$settings = pdo_fetch_one('weliam_shiftcar_setting', array('key'=>$key,'uniacid' => $_W['uniacid']), array('value'));
	if (is_array($settings)) {
		$settings = iunserializer($settings['value']);
	} else {
		$settings = array();
	}
	return $settings;
}