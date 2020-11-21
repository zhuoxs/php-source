<?php
/**
 * [weliam] Copyright (c) 2016/3/26
 * 设置mod
 */
defined('IN_IA') or exit('Access Denied');

function setting_get_list(){
	global $_W;
	$settings=pdo_fetchall("select * from".tablename('tg_setting')."where uniacid={$_W['uniacid']}");
	foreach($settings as$key=>&$value){
		$value['value'] = unserialize($value['value']);
	}
	return $settings;
}

function setting_get_by_name($name=''){
	global $_W;
	$setting = pdo_fetch("select * from".tablename('tg_setting')." where `key`  = '{$name}' and uniacid={$_W['uniacid']}");
	if($setting){
		$set = unserialize($setting['value']);
		return $set;
	}else{
		return FALSE;
	}
}

function setting_insert($data=array('')) {
	global $_W;
	$f=pdo_insert('tg_setting',$data);
	if($f){
		cache_write('tgsetting'.$_W['uniacid'], '');
		$insertid = pdo_insertid();
		return $insertid;
	}else{
		return FALSE;
	}
}

function setting_update_by_params($data,$params) {
	global $_W;
	$flag = pdo_update('tg_setting',$data,$params);
	cache_write('tgsetting'.$_W['uniacid'], '');
	return $flag;
}

function tgsetting_load($key = '') {
	global $_W;
	$_W['tgsetting'] = cache_load('tgsetting'.$_W['uniacid']);
	if (empty($_W['tgsetting'])) {
		$settings = pdo_fetch_many('tg_setting', array('uniacid' => $_W['uniacid']), array('key', 'value'), 'key');
		if (is_array($settings)) {
			foreach ($settings as $k => &$v) {
				$settings[$k] = iunserializer($v['value']);
			}
		} else {
			$settings = array();
		}
		$_W['tgsetting'] = $settings;
		cache_write('tgsetting'.$_W['uniacid'], $settings);
	}
	return $_W['tgsetting'];
}

function tgsetting_save($data, $key) {
	global $_W;
	if (empty($key)) {
		return FALSE;
	}
	
	$record = array();
	$record['value'] = iserializer($data);
	$exists = pdo_select_count('tg_setting', array('key'=>$key,'uniacid' => $_W['uniacid']));
	if ($exists) {
		$return = pdo_update('tg_setting', $record, array('key' => $key,'uniacid' => $_W['uniacid']));
	} else {
		$record['key'] = $key;
		$record['uniacid'] = $_W['uniacid'];
		$return = pdo_insert('tg_setting', $record);
	}
	cache_write('tgsetting'.$_W['uniacid'], '');
	
	return $return;
}

function tgsetting_read($key){
	global $_W;
	$settings = pdo_fetch_one('tg_setting', array('key'=>$key,'uniacid' => $_W['uniacid']), array('value'));
	if (is_array($settings)) {
		$settings = iunserializer($settings['value']);
	} else {
		$settings = '';
	}
	return $settings;
}