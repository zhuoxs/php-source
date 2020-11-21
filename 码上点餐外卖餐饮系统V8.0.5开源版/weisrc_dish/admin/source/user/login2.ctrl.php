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

function _login($forward = '') {
	global $_GPC, $_W;
	load()->model('user');
	$member = array();
	$username = trim($_GPC['username']);
	$password = trim($_GPC['password']);

	$verify = trim($_GPC['verify']);
	if(empty($verify)) {
		message('请输入验证码');
	}
	$result = checkcaptcha($verify);
	if (empty($result)) {
		message('输入验证码错误');
	}
	if(empty($username)) {
		message('请输入要登录的用户名');
	}
	$member['username'] = $username;
	$member['password'] = $_GPC['password'];
	if(empty($member['password'])) {
		message('请输入密码');
	}

	$record = __user_single($username, $password);
	if(!empty($record)) {
		if($record['status'] == 1) {
			message('您的账号正在审核或是已经被系统禁止，请联系网站管理员解决！');
		}
		$storeid = $record['storeid'];
		$_W['uniacid'] = $record['weid'];
		$_W['user_id'] = $record['id'];

		if (!empty($_W['siteclose']) && empty($_W['isfounder'])) {
			message('站点已关闭，关闭原因：' . $_W['setting']['copyright']['reason']);
		}
//		$cookie = array();
//		$cookie['user_id'] = $record['id'];
//		$cookie['lastvisit'] = $record['lastvisit'];
//		$cookie['lastip'] = $record['lastip'];
//		$cookie['hash'] = md5($record['password'] . $record['salt']);
//		$session = base64_encode(json_encode($cookie));
//		isetcookie('__session', $session, !empty($_GPC['rember']) ? 7 * 86400 : 0, true);
//		isetcookie('__uniacid', $_W['uniacid'], 7 * 86400);
//		isetcookie('__user_id', $record['id'], 7 * 86400);

		$password = user_hash($password, $record['salt']);
		$cookie = array();
		$cookie['user_id'] = $record['id'];
		$cookie['hash'] = $password;
		$session = base64_encode(json_encode($cookie));
		isetcookie('__weisrc_dish_session', $session, 7 * 86400);

		$data = array(
			'lastvisit' => TIMESTAMP,
			'lastip' => CLIENT_IP,
		);
		pdo_update("weisrc_dish_account", $data, array('id' => $record['id']));
		message("欢迎回来，{$record['username']}！", url('site/entry/stores', array('m' => 'weisrc_dish', 'storeid' => $storeid, 'do' => 'start')), 'success');
	} else {
		message('登录失败，请检查您输入的用户名和密码！');
	}
}

function __user_single($username, $password) {
	global $_W;
	$sql = "SELECT * FROM ".tablename("weisrc_dish_account")." WHERE accountname=:accountname LIMIT 1";
	$params = array(
		':accountname' => $username
	);
	$record = pdo_fetch($sql, $params);
	if (empty($record)) {
		return false;
	}
	$password = user_hash($password, $record['salt']);
	if ($password != $record['password']) {
		return false;
	}
	return $record;
}
