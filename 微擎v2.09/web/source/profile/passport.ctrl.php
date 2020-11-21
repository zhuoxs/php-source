<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

$dos = array('oauth', 'save_oauth', 'uc_setting', 'upload_file');
$do = in_array($do, $dos) ? $do : 'oauth';

if ($do == 'save_oauth') {
	$type = $_GPC['type'];
	$account = intval($_GPC['account']);
	if ($type == 'oauth') {
		$host = safe_gpc_url(rtrim($_GPC['host'],'/'), false);

		if (!empty($_GPC['host']) && empty($host)) {
			iajax(-1, '域名不合法');
		}
		if (empty($host) && empty($account)) {
			uni_setting_save('oauth', '');
		} else {
			$data = array(
				'host' => $host,
				'account' => $account,
			);
			uni_setting_save('oauth', iserializer($data));
		}
		cache_delete(cache_system_key('unisetting', array('uniacid' => $_W['uniacid'])));
	}
	if ($type == 'jsoauth') {
		uni_setting_save('jsauth_acid', $account);
		cache_delete(cache_system_key('unisetting', array('uniacid' => $_W['uniacid'])));
	}
	iajax(0, '');
}

if ($do == 'oauth') {
	$oauthInfo = uni_setting_load();
	$oauth = $oauthInfo['oauth'];

	$jsoauth = $oauthInfo['jsauth_acid'];

	$user_have_accounts = user_borrow_oauth_account_list();
	$oauth_accounts = $user_have_accounts['oauth_accounts'];
	$jsoauth_accounts = $user_have_accounts['jsoauth_accounts'];
}

template('profile/passport');
