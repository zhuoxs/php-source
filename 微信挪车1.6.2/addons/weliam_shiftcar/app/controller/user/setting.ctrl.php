<?php
defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '用户设置 - '.$_W['wlsetting']['base']['name'] : '用户设置';

if($op == 'display'){
	if($_W['ispost']){
		$status = $_GPC['harrystatus'];
		$harry1 = intval($_GPC['harry1']);
		$harry2 = intval($_GPC['harry2']);
		if($status == 'true'){
			$status = 1;
		}else{
			$status = 0;
		}
		if($_W['mid']){
			$re = pdo_update('weliam_shiftcar_member', array('harrystatus' => $status, 'harrytime1' => $harry1, 'harrytime2' => $harry2), array('id' => $_W['mid']));
			if($re){
				die(json_encode(array("result" => 1)));
			}else{
				die(json_encode(array("result" => 2)));
			}
		}else{
			die(json_encode(array("result" => 2)));
		}
	}
	include wl_template('user/setting');
}
