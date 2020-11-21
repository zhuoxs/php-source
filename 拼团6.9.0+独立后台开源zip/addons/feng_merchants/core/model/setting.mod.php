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
	$f=pdo_insert('tg_setting',$data);
	if($f){
		$insertid = pdo_insertid();
		return $insertid;
	}else{
		return FALSE;
	}
}
function setting_update_by_params($data,$params) {
	global $_W;
	$flag = pdo_update('tg_setting',$data,$params);
	return $flag;
}

function tgsetting_load($key = '') {
	global $_W;
	cache_load('tgsetting');
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
		cache_write('tgsetting', $settings);
	}
	return $_W['tgsetting'];
}