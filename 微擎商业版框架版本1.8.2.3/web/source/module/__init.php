<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

if (in_array($action, array('permission', 'default-entry', 'manage-account'))) {
	$referer = (url_params(referer()));
	if (empty($_GPC['version_id']) && intval($referer['version_id']) > 0) {
		itoast('', $_W['siteurl'] . '&version_id=' . $referer['version_id']);
	}
	$account_api = WeAccount::createByUniacid($_W['uniacid']);
	if (is_error($account_api)) {
		itoast('', url('module/display'));
	}
	$check_manange = $account_api->checkIntoManage();
		define('FRAME', 'account');
	if (is_error($check_manange)) {
		$account_display_url = $account_api->accountDisplayUrl();
		itoast('', $account_display_url);
	}
}
if (in_array($action, array('group', 'manage-system'))) {
	define('FRAME', 'system');
}

if (in_array($action, array('display'))) {
	define('FRAME', '');
}

$module_all_support = module_support_type();
$module_support = !empty($module_all_support[$_GPC['support']]) ? $module_all_support[$_GPC['support']]['type'] : ACCOUNT_TYPE_SIGN;
$module_support_name = $_GPC['support'];
