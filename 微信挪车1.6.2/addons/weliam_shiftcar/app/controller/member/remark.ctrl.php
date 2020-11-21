<?php
defined('IN_IA') or exit('Access Denied');
$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '留言 - '.$_W['wlsetting']['base']['name'] : '挪车留言';
if($_W['ispost']){
	$mess = trim($_GPC['mess_text']);
	if($_W['mid']){
		$re = pdo_update('weliam_shiftcar_member', array('message' => $mess), array('id' => $_W['mid']));
		if($re){
			die(json_encode(array("result" => 1)));
		}else{
			die(json_encode(array("result" => 2)));
		}
	}else{
		die(json_encode(array("result" => 2)));
	}
}
include wl_template('member/remark');
