<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
$account_api = WeAccount::createByUniacid($_W['uniacid']);


if (!in_array($action, array('display', 'manage'))) {
	if (is_error($account_api)) {
		message($account_api['message'], url('account/display', array('type' => PHONEAPP_TYPE_SIGN)));
	}
	$check_manange = $account_api->checkIntoManage();
	if (is_error($check_manange)) {
		$account_display_url = $account_api->accountDisplayUrl();
		itoast('', $account_display_url);
	}
}

if ($action == 'manage') {
	define('FRAME', 'system');
}

if (($action == 'version' && $do == 'home') || in_array($action, array('description', 'front-download'))) {
	$account_type = $account_api->menuFrame;
	define('FRAME', $account_type);
}