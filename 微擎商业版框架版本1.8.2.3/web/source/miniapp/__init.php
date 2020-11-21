<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

if (in_array($action, array('post', 'manage'))) {
	$account_api = WeAccount::createByUniacid(intval($_GPC['uniacid']));
	define('FRAME', 'system');
}

if (!in_array($action, array('display', 'post', 'manage', 'auth'))) {
	$account_api = WeAccount::createByUniacid($_W['uniacid']);
	if (is_error($account_api)) {
		itoast('', url('account/display'));
	}
	$check_manange = $account_api->checkIntoManage();
	if (is_error($check_manange)) {
		$account_display_url = $account_api->accountDisplayUrl();
		itoast('', $account_display_url);
	}
	$account_type = $account_api->menuFrame;
	define('FRAME', $account_type);
}
define('ACCOUNT_TYPE', $account_api->type);
define('TYPE_SIGN', $account_api->typeSign);
define('ACCOUNT_TYPE_NAME', $account_api->typeName);