<?php
defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '首页 - '.$_W['wlsetting']['base']['name'] : '首页';

if($op == 'display'){
	$member = $_W['wlmember'];
	if($_W['ispost']){
		$status = $_GPC['harrystatus'];
		if($status == 'true'){
			$status = 1;
		}else{
			$status = 0;
		}
		if($_W['mid']){
			$re = pdo_update('weliam_shiftcar_member', array('mstatus' => $status), array('id' => $_W['mid']));
			if($re){
				die(json_encode(array("result" => 1)));
			}else{
				die(json_encode(array("result" => 2)));
			}
		}else{
			die(json_encode(array("result" => 2)));
		}
	}
	$advs = newadv::get_adv(1);
	include wl_template('home/index');
}
