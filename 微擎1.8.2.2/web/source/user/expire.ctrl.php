<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('setting');

$dos = array('display', 'save_expire', 'change_status');
$do = in_array($do, $dos) ? $do : 'display';

$user_expire = setting_load('user_expire');
$user_expire = !empty($user_expire['user_expire']) ? $user_expire['user_expire'] : array();

if ($do == 'display') {
	$user_expire['day'] = !empty($user_expire['day']) ? $user_expire['day'] : 1;
	$user_expire['status'] = !empty($user_expire['status']) ? $user_expire['status'] : 0;
}

if ($do == 'save_expire') {
	$user_expire['day'] = !empty($_GPC['day']) ? intval($_GPC['day']) : 1;
	$result = setting_save($user_expire, 'user_expire');
	if (is_error($result)) {
		iajax(-1, '设置失败', url('user/expire'));
	}
	iajax(0, '设置成功', url('user/expire'));
}

if ($do == 'change_status') {
	$user_expire['status'] = empty($user_expire['status']) ? 1 :0;
	$result = setting_save($user_expire, 'user_expire');
	if (is_error($result)) {
		iajax(-1, '设置失败', url('user/expire'));
	}
	iajax(0, '设置成功', url('user/expire'));
}
template('user/expire');