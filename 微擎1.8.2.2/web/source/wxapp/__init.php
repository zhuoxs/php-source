<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('miniapp');
$version_id = intval($_GPC['version_id']);
if (!empty($version_id)) {
	$version_info = miniapp_version($version_id);
}

if ($action == 'post') {
	define('FRAME', 'system');
}

if (!in_array($action, array('display', 'post', 'manage', 'auth'))) {
	$account_api = WeAccount::createByUniacid($_W['uniacid']);
	if (is_error($account_api)) {
		itoast('', url('account/display', array('type' => WXAPP_TYPE_SIGN)));
	}
	$check_manange = $account_api->checkIntoManage();
	if (is_error($check_manange)) {
		$account_display_url = $account_api->accountDisplayUrl();
		itoast('', $account_display_url);
	}
	$account_type = $account_api->menuFrame;
	define('FRAME', $account_type);
}
