<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->func('communication');

$dos = array('mail');
$do = in_array($do, $dos) ? $do : 'mail';
permission_check_account_user('profile_setting');
$_W['page']['title'] = '邮件通知参数配置';

if ($do == 'mail') {
	if (checksubmit('submit')) {
		$notify['mail'] = array(
			'username' => $_GPC['username'],
			'password' => $_GPC['password'],
			'smtp' => $_GPC['smtp'],
			'sender' => $_GPC['sender'],
			'signature' => $_GPC['signature'],
		);
		$setting = array('notify' => iserializer($notify));
		$original_setting = uni_setting_load('notify');
		pdo_update('uni_settings', $setting, array('uniacid' => $_W['uniacid']));
		$result = ihttp_email($notify['mail']['username'], $_W['account']['name'] . '验证邮件'.date('Y-m-d H:i:s'), '如果您收到这封邮件则表示您系统的发送邮件配置成功！');
		if (is_error($result)) {
			$setting = array('notify' => iserializer($original_setting));
			pdo_update('uni_settings', $setting, array('uniacid' => $_W['uniacid']));
			itoast('配置失败，请检查配置信息', url('profile/notify'), 'info');
		} else {
			cache_delete(cache_system_key('unisetting', array('uniacid' => $_W['uniacid'])));
			itoast('配置成功！', url('profile/notify',array('do' => 'mail')), 'success');
		}
	}
	$notify_setting = uni_setting_load('notify');
	$mail_setting = empty($notify_setting['notify']['mail'])? array() : $notify_setting['notify']['mail'];
}
template('profile/notify');