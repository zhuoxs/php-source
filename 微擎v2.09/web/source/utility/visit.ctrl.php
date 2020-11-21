<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('visit');
$dos = array('showjs');
$do = in_array($do, $dos) ? $do : 'showjs';

if ($do == 'showjs') {
	$type = 'web';
	$module_name = '';
	if ($_GPC['type'] == 'account') {
		$module_name = 'we7_account';
	} elseif ($_GPC['type'] == 'webapp') {
		$module_name = 'we7_webapp';
	}
	visit_update_today($type, $module_name);
}

echo '';
exit;