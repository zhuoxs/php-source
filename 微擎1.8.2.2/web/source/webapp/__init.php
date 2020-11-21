<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

if ($action == 'manage' && $do == 'create_display') {
	define('FRAME', 'system');
}

$account_api = WeAccount::createByUniacid($_W['uniacid']);

if ($action != 'manage' && $do != 'switch') {
	if (is_error($account_api)) {
		message($account_api['message'], url('account/display'));
	}
	$check_manange = $account_api->checkIntoManage();
	if (is_error($check_manange)) {
		$account_display_url = $account_api->accountDisplayUrl();
		itoast('', $account_display_url);
	}
}

if ($action == 'manage' && $do == 'list') {
	define('FRAME', '');
} else {
	$account_type = $account_api->menuFrame;
	define('FRAME', $account_type);
}
