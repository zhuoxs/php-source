<?php
defined('IN_IA') or exit('Access Denied');

$ops = array('option', 'spec', 'item');
$op = in_array($op, $ops) ? $op : 'option';

if ($op == 'option') {
	$tag = random(32);
	include wl_template('goods/option');
}

if ($op == 'spec') {
	$spec = array(
		"id" => random(32),
		"title" => $_GPC['title']
	);
	include wl_template('goods/spec');
}

if ($op == 'item') {
	load()->func('tpl');
	$spec = array(
		"id" => $_GPC['specid']
	);
	$specitem = array(
		"id" => random(32),
		"title" => $_GPC['title'],
		"show" => 1
	);
	include wl_template('goods/spec_item');
}
