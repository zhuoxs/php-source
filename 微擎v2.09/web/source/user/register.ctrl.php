<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('user');
load()->model('setting');
load()->model('utility');
load()->classs('oauth2/oauth2client');

$dos = array('display', 'valid_mobile', 'register', 'check_username', 'get_extendfields', 'check_code', 'check_mobile_code', 'check_password_safe', 'check_failed_code');
$do = in_array($do, $dos) ? $do : 'display';

if (empty($_W['setting']['register']['open']) && empty($_W['setting']['copyright']['mobile_status'])) {
	itoast('本站暂未开启注册功能，请联系管理员！', '', '');
}
if (empty($_GPC['register_type'])) {
	$_GPC['register_type'] = !empty($_W['setting']['register']['open']) ? 'system' : 'mobile';
}
$register_type = safe_gpc_belong(safe_gpc_string($_GPC['register_type']), array('system', 'mobile'), 'system');
$owner_uid = intval($_GPC['owner_uid']);
$setting = $_W['setting']['register'];
$user_type = empty($_GPC['type']) || $_GPC['type'] == USER_TYPE_COMMON ? USER_TYPE_COMMON : USER_TYPE_CLERK;

if ($register_type == 'system') {
	$extendfields = OAuth2Client::create($register_type)->systemFields();
} else {
	$setting_sms_sign = setting_load('site_sms_sign');
	$register_sign = !empty($setting_sms_sign['site_sms_sign']['register']) ? $setting_sms_sign['site_sms_sign']['register'] : '';
}

if ($do == 'valid_mobile' || $do == 'register' && $register_type == 'mobile') {
	$validate_mobile = OAuth2Client::create('mobile')->validateMobile();
	if (is_error($validate_mobile)) {
		iajax(-1, $validate_mobile['message']);
	}
}

if ($do == 'register') {
	if(checksubmit() || $_W['ispost'] && $_W['isajax']) {
		$register_user = OAuth2Client::create($register_type)->setUserType($user_type)->register();
		$redirect = url('user/login');
		if ($user_type == USER_TYPE_CLERK && !empty($_GPC['m'])) {
			if (empty($_GPC['redirect'])) {
				$redirect = url('module/permission/display', array('m' => $_GPC['m']));
			} else {
				$redirect = url('module/permission/post', array('m' => $_GPC['m']));
			}
		}
		if ($register_type == 'system') {
			if (is_error($register_user)) {
				itoast($register_user['message']);
			} else {
				itoast($register_user['message'], $redirect);
			}
		}

		if ($register_type == 'mobile') {
			if (is_error($register_user)) {
				iajax(-1, $register_user['message']);
			} else {
				iajax(0, $register_user['message'], $redirect);
			}
		}
	}
}

if ($do == 'check_username') {
	$member['username'] = safe_gpc_string($_GPC['username']);
	if (user_check(array('username' => $member['username']))) {
		iajax(-1, '非常抱歉，此用户名已经被注册，你需要更换注册名称！');
	} else {
		iajax(0, '用户名未被注册');
	}
}

if ($do == 'check_code') {
	if (!checkcaptcha(intval($_GPC['code']))) {
		iajax(-1, '你输入的验证码不正确, 请重新输入.');
	} else {
		iajax(0, '验证码正确');
	}
}

template('user/register');