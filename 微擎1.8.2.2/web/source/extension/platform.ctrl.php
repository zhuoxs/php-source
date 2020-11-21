<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
setting_load('platform');
if(empty($_W['setting']['platform'])) {
	$_W['setting']['platform'] = array(
		'token' => random(32),
		'encodingaeskey' => random(43),
		'appsecret' => '',
		'appid' => '',
		'authstate' => 1
	);
	setting_save($_W['setting']['platform'],'platform');
}
$url = parse_url($_W['siteroot']);
if(checksubmit('submit')) {
	$data = array(
		'token' => trim($_GPC['platform_token']),
		'encodingaeskey' => trim($_GPC['encodingaeskey']),
		'appsecret' => trim($_GPC['appsecret']),
		'appid' => trim($_GPC['appid']),
		'authstate' => intval($_GPC['authstate'])
	);
	setting_save($data,'platform');
	message('更新成功', referer(), 'success');
}
if (!function_exists('mcrypt_module_open')) {
	message('抱歉，您的系统不支持加解密 mcrypt 模块，无法进行平台接入');
}
load()->classs('weixin.platform');
$account_platform = new WeiXinPlatform();
$authurl = $account_platform->getAuthLoginUrl();
template('extension/platform');