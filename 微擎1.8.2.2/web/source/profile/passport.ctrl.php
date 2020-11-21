<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

$dos = array('oauth', 'save_oauth', 'uc_setting', 'upload_file');
$do = in_array($do, $dos) ? $do : 'oauth';
$_W['page']['title'] = '公众平台oAuth选项 - 会员中心';

load()->model('user');

if ($do == 'save_oauth') {
	$type = $_GPC['type'];
	$account = trim($_GPC['account']);
	if ($type == 'oauth') {
		$host = safe_gpc_url(rtrim($_GPC['host'],'/'), false);

		if (!empty($_GPC['host']) && empty($host)) {
			iajax(-1, '域名不合法');
		}
		$data = array(
			'host' => $host,
			'account' => $account,
		);
		pdo_update('uni_settings', array('oauth' => iserializer($data)), array('uniacid' => $_W['uniacid']));
		cache_delete(cache_system_key('unisetting', array('uniacid' => $_W['uniacid'])));
	}
	if ($type == 'jsoauth') {
		pdo_update('uni_settings', array('jsauth_acid' => $account), array('uniacid' => $_W['uniacid']));
		cache_delete(cache_system_key('unisetting', array('uniacid' => $_W['uniacid'])));
	}
	iajax(0, '');
}

if ($do == 'oauth') {
	$oauthInfo = table('unisetting')->getOauthByUniacid($_W['uniacid']);
	$oauth = iunserializer($oauthInfo['oauth']) ? iunserializer($oauthInfo['oauth']) : array();
	$jsoauth = $oauthInfo['jsauth_acid'];

	$user_have_accounts = user_borrow_oauth_account_list();
	$oauth_accounts = $user_have_accounts['oauth_accounts'];
	$jsoauth_accounts = $user_have_accounts['jsoauth_accounts'];
}

template('profile/passport');
