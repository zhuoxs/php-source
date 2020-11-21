<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
load()->model('system');

if ($do == 'check_table') {
	$wrong_tables = array();
	$table_pre = $_W['config']['db']['tablepre'] . '_%';
	$tables = pdo_fetchall("SHOW TABLE STATUS LIKE '{$table_pre}'", array(), 'Name');

	foreach ($tables as $table_name => $table_info) {
		if (!in_array($table_info['Engine'], array('MyISAM', 'InnoDB'))) {
			unset($tables[$table_name]);
		}
	}

	$tables_str = implode('`,`', array_keys($tables));
	$check_result = pdo_fetchall("CHECK TABLE `" . $tables_str . '`');
	foreach ($check_result as $check_info) {
		if ($check_info['Msg_text'] != 'OK' && $check_info['Msg_type'] != 'warning') {
			$wrong_tables[$check_info['Table']] = $check_info;
		}
	}
	iajax(0, $wrong_tables);
}

$system_check_items = system_check_items();
foreach ($system_check_items as $check_item_name => &$check_item) {
	$check_item['check_result'] = $check_item['operate']($check_item_name);
}

$check_num = count($system_check_items);
$check_wrong_num = 0;
foreach ($system_check_items as $check_key => $check_val) {
	if ($check_val['check_result'] === false) {
		$check_wrong_num += 1;
	}
}

cache_write(cache_system_key('system_check'), array('check_items' => $system_check_items, 'check_num' => $check_num, 'check_wrong_num' => $check_wrong_num));

template('system/check');
