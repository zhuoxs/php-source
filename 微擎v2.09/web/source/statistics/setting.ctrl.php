<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('statistics');

$dos = array('display', 'edit_setting');
$do = in_array($do, $dos) ? $do : 'display';
permission_check_account_user('statistics_visit_setting');

$statistics_setting = (array)uni_setting_load(array('statistics'), $_W['uniacid']);
$statistics_setting = $statistics_setting['statistics'];
if ($do == 'display') {
	$highest_visit = empty($statistics_setting['owner']) ? 0 : $statistics_setting['owner'];
	$interval = empty($statistics_setting['interval']) ? 0 : $statistics_setting['interval'];
}
if ($do == 'edit_setting') {
	$type = trim($_GPC['type']);
	$new_highest_visit = intval($_GPC['highest_visit']);
	$new_interval = intval($_GPC['interval']);
	if (!empty($statistics_setting)) {
		$highest_visit = $statistics_setting;
		if ($type == 'highest_visit') {
			$highest_visit['owner'] = $new_highest_visit;
		} elseif ($type == 'interval') {
			$highest_visit['interval'] = $new_interval;
		}
	} else {
		if ($type == 'highest_visit') {
			$highest_visit = array('owner' => $new_highest_visit);
		} elseif ($type == 'interval') {
			$highest_visit = array('interval' => $new_interval);
		}
	}
	$result = uni_setting_save('statistics', iserializer($highest_visit));
	if (!empty($result)) {
		cache_delete(cache_system_key('unisetting', array('uniacid' => $_W['uniacid'])));
		cache_delete(cache_system_key('statistics', array('uniacid' => $uniacid)));
		iajax(0, '修改成功！');
	} else {
		iajax(-1, '修改失败！');
	}
}
template('statistics/setting');