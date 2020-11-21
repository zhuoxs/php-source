<?php
defined('IN_IA') or exit('Access Denied');
define('IN_GW', true);
global $_GPC;
if(checksubmit()) {
	_login($_GPC['referer']);
}
include wl_template('admin/login');

function _login($forward = '') {
	global $_GPC, $_W;
	$username = trim($_GPC['username']);
	$password = trim($_GPC['password']);
    $verify = trim($_GPC['verify']);
	$m = pdo_fetch("select name from".tablename('modules')."where name='feng_merchants'");
    if(empty($username)) {
        message('请输入账户名！', '', 'error');
    }
    if(empty($password)) {
        message('请输入密码！', '', 'error');
    }
    if(empty($verify)) {
        message('请输入验证码！', '', 'error');
    }
    $result = checkcaptcha($verify);
    if (empty($result)) {
        message('验证码错误，请重新输入！', '', 'error');
    }
	if (empty($m)) {
        message('您还未购买多商家后台！', '', 'error');
    }
    $record = __user_single($username, $password);
	if (!empty($record)) {
		$cookie = array();
		$cookie['uid'] = $record['uid'];
		$cookie['tg_mall']['merch_id'] = $record['id'];
		$cookie['tg_mall']['uniacid'] = $record['uniacid'];
		$session = base64_encode(json_encode($cookie));
		isetcookie('___shop_session___', $session, !empty($_GPC['rember']) ? 7 * 86400 : 0, true);
        isetcookie('__uniacid', $record['uniacid'], 7 * 86400);
        isetcookie('merchantid', $record['id'], 7 * 86400);
		
		session_start();
		$_SESSION['role'] = 'merchant';
		$_SESSION['role_id'] = $record['id'];
		$_SESSION['role_name'] = $record['name'];
		$_SESSION['role_logo'] = $record['thumb'];
		message("欢迎回来，{$record['uname']}！", web_url('store/setting',array('role'=>'merchant')), 'success');
	} else {
		message('登录失败，请检查您的账号和密码！', '', 'error');
	}
}

function __user_single($username, $password) {
    global $_W;
    $sql = "SELECT * FROM ".tablename('tg_merchant')." WHERE uname=:uname";
    $params = array(
        ':uname' => $username,
    );
    $record = pdo_fetch($sql, $params);
    if (empty($record)) {
        return false;
    }
//  $password = user_hash($password, $record['salt']);
    if ($password != $record['password']) {
        return false;
    }
    return $record;
}
