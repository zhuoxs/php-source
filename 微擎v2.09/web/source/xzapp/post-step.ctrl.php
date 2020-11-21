<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

$uniacid = intval($_GPC['uniacid']);
$step = intval($_GPC['step']) ? intval($_GPC['step']) : 1;

$user_create_account_info = permission_user_account_num();

if ($step == 1) {
	if ($user_create_account_info['xzapp_limit'] <= 0 && !$_W['isfounder']) {
		$authurl = "javascript:alert('创建熊掌号已达上限');";
	}

	if (empty($authurl) && !empty($_W['setting']['platform']['authstate'])) {
		$authurl = "javascript:alert('暂不支持授权接入');";
	}
}

if ($step == 2) {
	}
if ($step == 3) {
	}

if ($step == 4) {
	$uniacid = intval($_GPC['uniacid']);
	$acid = intval($_GPC['acid']);
	$uni_account = pdo_get('uni_account', array('uniacid' => $uniacid));

	if (empty($uni_account)) {
		itoast('非法访问', '', '');
	}
	$owner_info = account_owner($uniacid);
	if (!(user_is_founder($_W['uid'], true) || $_W['uid'] == $owner_info['uid'])) {
		itoast('非法访问');
	}
	$account = account_fetch($uni_account['default_acid']);
}

template('xzapp/post-step');



















