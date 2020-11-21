<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
$dos = array('subscribe', 'check', 'ban');
$do = in_array($do, $dos) ? $do : 'subscribe';
load()->model('extension');
load()->model('cache');

if ($do == 'subscribe') {

	$_W['page']['title'] = '系统 - 订阅管理';

		$modules = pdo_fetchall("SELECT title, name, subscribes FROM ".tablename('modules')." WHERE subscribes <> ''", array(), 'name');
	if (!empty($modules)) {
		foreach ($modules as $module) {
			$module['subscribes'] = unserialize($module['subscribes']);
			if (!empty($module['subscribes'])) {
				foreach ($module['subscribes'] as $event) {
					if ($event == 'text' || $event == 'enter') {
						continue;
					}
					$module_subscribes[$module['name']]= $module['subscribes'];
				}
			}
		}
	}
	$mtypes = ext_module_msg_types();
	$module_ban = $_W['setting']['module_receive_ban'];
	if (!is_array($module_ban)) {
		$module_ban = array();
	}
	template('extension/subscribe');
}

if ($do == 'check') {
	$_W['uniacid'] = 1;
	load()->classs('account');
	$modulename = $_GPC['modulename'];
	$obj = WeUtility::createModuleReceiver($modulename);
	if (empty($obj)) {
		exit('error');
	}
	$obj->uniacid = $_W['uniacid'];
	$obj->acid = $_W['acid'];
	if(method_exists($obj, 'receive')) {
		@$obj->receive();
		exit('success');
	}
}

if ($do == 'ban') {
	$modulename = $_GPC['modulename'];
	$ban = $_GPC['ban'];
	if (empty($modulename)) {
		message('请设置模块名', referer(), 'error');
	}
	if (!is_array($_W['setting']['module_receive_ban'])) {
		$_W['setting']['module_receive_ban'] = array();
	}
		if (empty($ban)) {
		$_W['setting']['module_receive_ban'][$modulename] = $modulename;
	} else {
		unset($_W['setting']['module_receive_ban'][$modulename]);
	}
	setting_save($_W['setting']['module_receive_ban'], 'module_receive_ban');
	cache_build_module_subscribe_type();
	message($module_ban, '', 'ajax');
}
