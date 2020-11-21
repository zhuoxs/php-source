<?php
defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'base';

if ($op == 'task') {
	$settings['url'] = app_url('home/auto_task');
	$settings['name'] = '计划任务入口';
	
	$lock = cache_read(MODULE_NAME.':task:status');
	if(empty($lock) || ($lock['value'] == 1 && $lock['expire'] < (time() - 600 ))){
		$status = 1;
	}else{
		$status = 2;
	}
	
	include wl_template('system/task');
}

if ($op == 'base') {
	wl_load() -> model('syssetting');
	$settings = tg_syssetting_read('base');
	if (checksubmit('submit')) {
		$base = array(
			'name'=>$_GPC['name'],
			'logo'=>$_GPC['logo'],
			'copyright'=>$_GPC['copyright']
		);
		tg_syssetting_save($base, 'base');
		message('更新设置成功！', web_url('system/setting/base'), 'success');
	}
	include wl_template('system/base');
}
