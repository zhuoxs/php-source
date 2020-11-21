<?php
defined('IN_IA') or exit('Access Denied');
$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '反馈 - '.$_W['wlsetting']['base']['name'] : '意见反馈';
if($_W['ispost']){
	$mess = trim($_GPC['mess_text']);
	if($_W['mid']){
		$re = pdo_insert('weliam_shiftcar_sug', array('content' => $mess,'uniacid'=>$_W['uniacid'],'mid' => $_W['mid'],'createtime' => time()));
		if($re){
			die(json_encode(array("result" => 1)));
		}else{
			die(json_encode(array("result" => 2)));
		}
	}else{
		die(json_encode(array("result" => 2)));
	}
}
include wl_template('app/sug');
