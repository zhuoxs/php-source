<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('cloud');
load()->model('setting');

$dos = array('display', 'save_sms_sign');
$do = in_array($do, $dos) ? $do : 'display';

$setting_sms_sign = setting_load('site_sms_sign');
$setting_sms_sign = !empty($setting_sms_sign['site_sms_sign']) ? $setting_sms_sign['site_sms_sign'] : array();

if ($do == 'display') {
	$sms_info = cloud_sms_info();
	$cloud_sms_signs = !empty($sms_info) ? $sms_info['sms_sign'] : array();
	$setting_sms_sign['register'] = !empty($setting_sms_sign['register']) ? $setting_sms_sign['register'] : '';
	$setting_sms_sign['find_password'] = !empty($setting_sms_sign['find_password']) ? $setting_sms_sign['find_password'] : '';
	$setting_sms_sign['user_expire'] = !empty($setting_sms_sign['user_expire']) ? $setting_sms_sign['user_expire'] : '';
}

if ($do == 'save_sms_sign') {
	$setting_sms_sign['register'] = safe_gpc_string($_GPC['register']);
	$setting_sms_sign['find_password'] = safe_gpc_string($_GPC['find_password']);
	$setting_sms_sign['user_expire'] = safe_gpc_string($_GPC['user_expire']);
	$result = setting_save($setting_sms_sign, 'site_sms_sign');
	if (is_error($result)) {
		iajax(-1, '设置失败', url('cloud/sms-sign'));
	}
	iajax(0, '设置成功', url('cloud/sms-sign'));
}
template('cloud/sms-sign');