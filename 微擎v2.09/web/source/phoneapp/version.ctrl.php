<?php
defined('IN_IA') or exit('Access Denied');

load()->model('phoneapp');
load()->model('welcome');

$do = safe_gpc_belong($do, array('home'), 'home');

$version_id = intval($_GPC['version_id']);
$phoneapp_info = phoneapp_fetch($_W['uniacid']);

if (!empty($version_id)) {
	$version_info = phoneapp_version($version_id);
}
cache_build_account_modules($_W['uniacid']);
if ($do == 'home') {
	$notices = welcome_notices_get();
	template('phoneapp/version-home');
}