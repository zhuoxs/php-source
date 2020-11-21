<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('cloud');
load()->model('setting');

$dos = array('display', 'save_sms_sign', 'change_status');
$do = in_array($do, $dos) ? $do : 'display';

$setting_sms_sign = setting_load('site_sms_sign');
$setting_sms_sign = !empty($setting_sms_sign['site_sms_sign']) ? $setting_sms_sign['site_sms_sign'] : '';

if ($do == 'display') {
	$cloud_sms_info = cloud_sms_info();
	$cloud_sms_signs = $cloud_sms_info['sms_sign'];
	$setting_sms_sign['sign'] = !empty($setting_sms_sign['sign']) ? $setting_sms_sign['sign'] : 0;
	$setting_sms_sign['day'] = !empty($setting_sms_sign['day']) ? $setting_sms_sign['day'] : 1;
	$setting_sms_sign['status'] = !empty($setting_sms_sign['status']) ? $setting_sms_sign['status'] : 0;
}

if ($do == 'save_sms_sign') {
	$setting_sms_sign['sign'] = trim($_GPC['sign']);
	$setting_sms_sign['day'] = !empty($_GPC['day']) ? intval($_GPC['day']) : 1;
	$result = setting_save($setting_sms_sign, 'site_sms_sign');
	if (is_error($result)) {
		iajax(-1, '设置失败', url('user/sms-sign'));
	}
	iajax(0, '设置成功', url('user/sms-sign'));
}

if ($do == 'change_status') {
	$setting_sms_sign['status'] = empty($setting_sms_sign['status']) ? 1 :0;
	$result = setting_save($setting_sms_sign, 'site_sms_sign');
	if (is_error($result)) {
		iajax(-1, '设置失败', url('user/sms-sign'));
	}
	iajax(0, '设置成功', url('user/sms-sign'));
}
template('user/sms-sign');