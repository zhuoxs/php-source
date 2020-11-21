<?php 
defined('IN_IA') or exit('Access Denied');
$ops = array('list');
$op = in_array($op, $ops) ? $op : 'list';

if ($op == 'list') {
	$pluginsset = Plugins::getPlugins(2);
	include wl_template('app/plugins_list');
}
