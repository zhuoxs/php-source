<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('module');

$dos = array('entrance_link');
$do = in_array($do, $dos) ? $do : 'entrance_link';

permission_check_account_user('wxapp_entrance_link');

$wxapp_info = miniapp_fetch($_W['uniacid']);

if ($do == 'entrance_link') {
	$wxapp_modules = pdo_getcolumn('wxapp_versions', array('id' => $version_id), 'modules');
	$module_info = array();
	if (!empty($wxapp_modules)) {
		$module_info = iunserializer($wxapp_modules);
		$module_info = pdo_getall('modules_bindings', array('module' => array_keys($module_info), 'entry' => 'page'));
	}
	template('wxapp/version-entrance');
}