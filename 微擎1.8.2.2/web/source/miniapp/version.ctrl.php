<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('miniapp');
load()->model('welcome');

$dos = array('home');
$do = in_array($do, $dos) ? $do : 'home';
$_W['page']['title'] = '小程序 - 管理';

$version_id = intval($_GPC['version_id']);
$wxapp_info = miniapp_fetch($_W['uniacid']);
if (!empty($version_id)) {
	$version_info = miniapp_version($version_id);
}

if ($do == 'home') {
	$notices = welcome_notices_get();
	template('miniapp/version-home');
}