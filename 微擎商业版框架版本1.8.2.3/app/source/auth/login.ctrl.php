<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
$openid = $_W['openid'];
$dos = array('basic', 'uc', 'mobile_exist');
$do = in_array($do, $dos) ? $do : 'basic';

$setting = uni_setting($_W['uniacid'], array('uc', 'passport'));
$uc_setting = $setting['uc'] ? $setting['uc'] : array();
$ltype = empty($setting['passport']['type']) ? 'hybird' : $setting['passport']['type'];
$audit = @intval($setting['passport']['audit']);
$item = !empty($setting['passport']['item']) ? $setting['passport']['item'] : 'random';
$type = trim($_GPC['type']) ? trim($_GPC['type']) : 'email';
$forward = url('mc');
if(!empty($_GPC['forward'])) {
	$forward = './index.php?' . base64_decode($_GPC['forward']) . '#wechat_redirect';
}

if($do == 'mobile_exist') {
	if($_W['ispost'] && $_W['isajax']) {
		$type = safe_gpc_string($_GPC['find_mode']);
		$info = safe_gpc_string($_GPC['mobile']);
		$member_table = table('member');
		switch ($type) {
			case 'mobile':
				$member_table->searchWithMobile($info);
				break;
			case 'email':
				$member_table->searchWithMemberEmail($info);
				break;
			default:
				$member_table->searchWithRandom($info);
				break;
		}
		$is_exist = $member_table->searchWithMember();
		if (!empty($is_exist)) {
			message(error(1, ''), '', 'ajax');
		} else {
			message(error(2, ''), '', 'ajax');
		}
	}
}
if(!empty($_W['member']) && (!empty($_W['member']['mobile']) || !empty($_W['member']['email']))) {
	header('location: ' . $forward);
	exit;
}
if($do == 'basic') {
	if($_W['ispost'] && $_W['isajax']) {
		$username = trim($_GPC['username']);
		$password = trim($_GPC['password']);
		$mode = trim($_GPC['mode']);
		if (empty($username)) {
			message('用户名不能为空', '', 'error');
		}
		if (empty($password)) {
			if ($mode == 'code') {
				message('验证码不能为空', '', 'error');
			} else {
				message('密码不能为空', '', 'error');
			}
		}
		if ($mode == 'code') {
			load()->model('utility');
			if (!code_verify($_W['uniacid'], $username, $password)) {
				message('验证码错误', '', 'error');
			} else {
				pdo_delete('uni_verifycode', array('receiver' => $username));
			}
		}
		$sql = 'SELECT `uid`,`salt`,`password` FROM ' . tablename('mc_members') . ' WHERE `uniacid`=:uniacid';
		$pars = array();
		$pars[':uniacid'] = $_W['uniacid'];
		if ($item == 'mobile') {
			if (preg_match(REGULAR_MOBILE, $username)) {
				$sql .= ' AND `mobile`=:mobile';
				$pars[':mobile'] = $username;
			} else {
				message('请输入正确的手机', '', 'error');
			}
		} elseif ($item == 'email') {
			if (preg_match(REGULAR_EMAIL, $username)) {
				$sql .= ' AND `email`=:email';
				$pars[':email'] = $username;
			} else {
				message('请输入正确的邮箱', '', 'error');
			}
		} else {
			if (preg_match(REGULAR_MOBILE, $username)) {
				$sql .= ' AND `mobile`=:mobile';
				$pars[':mobile'] = $username;
			} else {
				$sql .= ' AND `email`=:email';
				$pars[':email'] = $username;
			}
		}
		$user = pdo_fetch($sql, $pars);
		if ($mode == 'basic') {
			$hash = md5($password . $user['salt'] . $_W['config']['setting']['authkey']);
			if ($user['password'] != $hash) {
				message('密码错误', '', 'error');
			}
		}
		if (empty($user)) {
			message('该帐号尚未注册', '', 'error');
		}
		if (_mc_login($user)) {
			message('登录成功！', referer(), 'success');
		}
		message('未知错误导致登录失败', '', 'error');
	}
	template('auth/login');
	exit;
} elseif ($do == 'uc') {
	if ($_W['ispost'] && $_W['isajax']) {
		if(empty($uc_setting) || $uc_setting['status'] <> 1) {
			exit('系统尚未开启UC');
		}
		
		$post = $_GPC['__input'];
		$username = trim($post['username']);
		$password = trim($post['password']);
		empty($username) && exit('请填写' . $uc_setting['title'] . '用户名');
		empty($password) && exit('请填写' . $uc_setting['title'] . '密码！');
		
		mc_init_uc();
		$data = uc_user_login($username, $password);
		if ($data[0] < 0) {
			if($data[0] == -1) exit('用户不存在，或者被删除！');
			elseif ($data[0] == -2) exit('密码错误！');
			elseif ($data[0] == -3) exit('安全提问错误！');
		}
		
		$exist = pdo_fetch('SELECT * FROM ' . tablename('mc_mapping_ucenter') . ' WHERE `uniacid`=:uniacid AND `centeruid`=:centeruid', array(':uniacid' => $_W['uniacid'], 'centeruid' => $data[0]));
		if (!empty($exist)) {
			$user['uid'] = $exist['uid'];
			if(_mc_login($user)) {
				exit('success');
			} else {
				exit('未知错误导致登录失败');
			}
		} else {
			if (!empty($_SESSION['openid'])) {
				$default_groupid = pdo_fetchcolumn('SELECT groupid FROM ' .tablename('mc_groups') . ' WHERE uniacid = :uniacid AND isdefault = 1', array(':uniacid' => $_W['uniacid']));
				$user = array(
					'uniacid' => $_W['uniacid'],
					'email' => $data[3],
					'salt' => random(8),
					'groupid' => $default_groupid,
					'createtime' => TIMESTAMP,
				);
				$user['password'] = md5($data[2] . $user['salt'] . $_W['config']['setting']['authkey']);
				pdo_insert('mc_members', $user);
				$uid = pdo_insertid();
				pdo_insert('mc_mapping_ucenter', array('uniacid' => $_W['uniacid'], 'uid' => $uid, 'centeruid' => $data[0]));
				pdo_update('mc_mapping_fans', array('uid' => $uid), array('uniacid' => $_W['uniacid'], 'acid' => $_W['acid'], 'openid' => $_SESSION['openid']));
				$user['uid'] = $uid;
				if (_mc_login($user)) {
					exit('success');
				} else {
					exit('未知错误导致登录失败');
				}
			}
			exit('该' . $uc_setting['title'] . '账号尚未绑定系统账号');
		}
	}
	template('auth/uc-login');
	exit;
}
