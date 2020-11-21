<?php
defined('IN_IA') or exit('Access Denied');
$ops = array('auth','notice','get');
$op = in_array($_GPC['op'], $ops) ? $_GPC['op'] : 'auth';
wl_load()->model('api');

if($op == 'auth'){
	$mobile = $_GPC['mobile'];
	if(!empty($mobile)){
		send_authmsg($mobile);
	}
	die(json_encode(array("result" => 2)));
}
