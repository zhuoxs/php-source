<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
define('IN_GW', true);

if(checksubmit() || $_W['isajax']) {
	_login($_GPC['referer']);
}

$setting = $_W['setting'];
template('user/login');
function _login($forward = '')
{
	global $_GPC, $_W;
	$member = array();
	$member['username'] = trim($_GPC['username']);
	if (empty($member['username'])) {
		message('请输入要登录的用户名');
	}
	$member['password'] = $_GPC['password'];
	if (empty($member['password'])) {
		message('请输入密码');
	}
	$member['password'] = md5($member['password']);

	$user = pdo_fetch("SELECT * FROM ".tablename('sqtg_sun_admin')." WHERE code = '{$member['username']}' and state=1 and password = '{$member['password']}'");

	if ($user) {
		unset($user['password']);
		$_SESSION['admin'] = $user;
		$url = url('site/entry');
		header('location:' . $url."&op=index&do=index&m=sqtg_sun");
	} else {
		message('登录失败，请检查您输入的用户名和密码！');
	}
}