<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('setting');
load()->classs('oauth2/oauth2client');
$dos = array('display', 'save_setting');
$do = in_array($do, $dos) ? $do : 'display';

$_W['page']['title'] = '登录配置';

$types = OAuth2Client::supportLoginType();

$type = trim($_GPC['type']);
$type = !empty($type) && in_array($type, $types) ? $type : 'qq';

if ($do == 'save_setting') {
	if ($_W['isajax'] && $_W['ispost']) {
		$appid = trim($_GPC['appid']);
		$appsecret = trim($_GPC['appsecret']);
		$authstate = trim($_GPC['authstate']);

		$data = array();
		$data[$type]['appid'] = !empty($appid) ? $appid : $_W['setting']['thirdlogin'][$type]['appid'];
		$data[$type]['appsecret'] = !empty($appsecret) ? $appsecret : $_W['setting']['thirdlogin'][$type]['appsecret'];
		$data[$type]['authstate'] = !empty($authstate) ? (empty($_W['setting']['thirdlogin'][$type]['authstate']) ? 1 : 0) : $_W['setting']['thirdlogin'][$type]['authstate'];
		$_W['setting']['thirdlogin'][$type] = $data[$type];
		$result = setting_save($_W['setting']['thirdlogin'], 'thirdlogin');
		if($result) {
			iajax(0, '修改成功！', referer());
		}else {
			iajax(1, '修改失败！', referer());
		}
	}
}

if ($do == 'display') {
	if (empty($_W['setting']['thirdlogin'])) {
		foreach ($types as $login_type) {
			$_W['setting']['thirdlogin'][$login_type]['appid'] = '';
			$_W['setting']['thirdlogin'][$login_type]['appsecret'] = '';
			$_W['setting']['thirdlogin'][$login_type]['authstate'] = '';
		}
		setting_save($_W['setting']['thirdlogin'], 'thirdlogin');
	}
	$siteroot_parse_array = parse_url($_W['siteroot']);
}
template('system/thirdlogin');