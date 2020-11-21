<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->func('communication');
load()->classs('weixin.platform');
load()->classs('wxapp.platform');
load()->model('miniapp');

$account_platform = new WxappPlatform();
$dos = array('forward', 'confirm');
$do = in_array($do, $dos) ? $do : 'forward';

$setting = setting_load('platform');
if ($do == 'forward') {

	if (empty($_GPC['auth_code'])) {
		itoast('授权登录失败，请重试', url('wxapp/manage'), 'error');
	}
	$auth_info = $account_platform->getAuthInfo($_GPC['auth_code']);
	if (is_error($auth_info)) {
		itoast('授权登录新建小程序失败：' . $auth_info['message'], url('wxapp/manage'), 'error');
	}
	$auth_refresh_token = $auth_info['authorization_info']['authorizer_refresh_token'];
	$auth_appid = $auth_info['authorization_info']['authorizer_appid'];

	$account_info = $account_platform->getAccountInfo($auth_appid);
	if (is_error($account_info)) {
		itoast('授权登录新建小程序失败：' . $account_info['message'], url('wxapp/manage'), 'error');
	}
	if (!empty($_GPC['test'])) {
		echo "此为测试平台接入返回结果：<br/> 公众号名称：{$account_info['authorizer_info']['nick_name']} <br/> 接入状态：成功";
		exit;
	}
	if ($account_info['authorizer_info']['service_type_info']['id'] == '0' || $account_info['authorizer_info']['service_type_info']['id'] == '1') {
		if ($account_info['authorizer_info']['verify_type_info']['id'] > '-1') {
			$level = '3';
		} else {
			$level = '1';
		}
	} elseif ($account_info['authorizer_info']['service_type_info']['id'] == '2') {
		if ($account_info['authorizer_info']['verify_type_info']['id'] > '-1') {
			$level = '4';
		} else {
			$level = '2';
		}
	}
	if (!empty($account_info['authorizer_info']['user_name'])) {
		$account_found = pdo_get('account_wxapp', array('original' => $account_info['authorizer_info']['user_name']));
		if (!empty($account_found)) {
			message('小程序已经在系统中接入，是否要更改为授权接入方式？ <div><a class="btn btn-primary" href="' . url('wxapp/auth/confirm', array('level' => $level, 'auth_refresh_token' => $auth_refresh_token, 'auth_appid' => $auth_appid, 'acid' => $account_found['acid'], 'uniacid' => $account_found['uniacid'])) . '">是</a> &nbsp;&nbsp;<a class="btn btn-default" href="index.php">否</a></div>', '', 'tips');
		}
	}
	$account_insert = array(
		'name' => $account_info['authorizer_info']['nick_name'],
		'description' => '',
		'groupid' => 0,
	);

	$account_wxapp_data = array(
		'name' => trim($account_info['authorizer_info']['nick_name']),
		'description' => trim($_GPC['description']),
		'original' => trim($account_info['authorizer_info']['user_name']),
		'level' => 1,
		'key' => trim($auth_appid),
		'secret' => trim($_GPC['appsecret']),
		'type' => ACCOUNT_TYPE_APP_AUTH,
		'encodingaeskey'=>$account_platform->encodingaeskey,
		'auth_refresh_token'=>$auth_refresh_token,
		'token' => $account_platform->token,
	);
	$uniacid = miniapp_account_create($account_wxapp_data, ACCOUNT_TYPE_APP_AUTH);
	if (!$uniacid) {
		itoast('授权登录新建小程序失败，请重试', url('wxapp/manage'), 'error');
	}

	$headimg = ihttp_request($account_info['authorizer_info']['head_img']);
	$qrcode = ihttp_request($account_info['authorizer_info']['qrcode_url']);
	file_put_contents(IA_ROOT . '/attachment/headimg_' . $acid . '.jpg', $headimg['content']);
	file_put_contents(IA_ROOT . '/attachment/qrcode_' . $acid . '.jpg', $qrcode['content']);

	cache_build_account($uniacid);
	itoast('授权登录成功', url('wxapp/post/design_method', array('uniacid' => $uniacid, 'choose_type'=>2)), 'success');
}

if ($do == 'confirm') {

	$auth_refresh_token = $_GPC['auth_refresh_token'];
	$auth_appid = $_GPC['auth_appid'];
	$level = intval($_GPC['level']);
	$acid = intval($_GPC['acid']);
	$uniacid = intval($_GPC['uniacid']);

	pdo_update('account_wxapp', array(
		'auth_refresh_token' => $auth_refresh_token,
		'encodingaeskey' => $account_platform->encodingaeskey,
		'token' => $account_platform->token,
		'level' => $level,
		'key' => $auth_appid,
	), array('acid' => $acid));
	pdo_update('account', array('isconnect' => '1', 'type' => ACCOUNT_TYPE_APP_AUTH, 'isdeleted' => 0), array('acid' => $acid));

	cache_delete(cache_system_key('uniaccount', array('uniacid' => $uniacid)));
	cache_delete(cache_system_key('accesstoken', array('acid' => $acid)));
	cache_delete(cache_system_key('account_auth_refreshtoken', array('acid' => $acid)));
	$url = url('wxapp/post/design_method', array('acid' => $acid, 'uniacid' => $uniacid, 'choose_type'=>2));

	itoast('更改小程序授权接入成功', $url, 'success');
}

if ($do == 'test') {
	$auth_appid = '123';
	$account_wxapp_data = array(
				'name' => trim($_GPC['name']),
				'description' => trim($_GPC['description']),
				'original' => trim($_GPC['original']),
				'level' => 1,
				'key' => trim($_GPC['appid']),
				'secret' => trim($_GPC['appsecret']),
				'type' => ACCOUNT_TYPE_APP_NORMAL,
			);
	$account_wxapp_data = array(
		'name' => '阿凡',
		'description' => '123',
		'original' => 'default',
		'level' => 1,
		'key' => trim($auth_appid),
		'secret' => 'empty',
		'type' => ACCOUNT_TYPE_APP_AUTH,
		'encodingaeskey'=>'ak',
		'auth_refresh_token'=>'authken',
		'token' => 'token',	);
	$uniacid = miniapp_account_create($account_wxapp_data, ACCOUNT_TYPE_APP_AUTH);
	if (!$uniacid) {
		itoast('授权登录新建小程序失败，请重试', url('wxapp/manage'), 'error');
	}
	itoast('授权登录成功', url('wxapp/post/design_method', array('uniacid' => $uniacid, 'choose_type'=>2)), 'success');
}