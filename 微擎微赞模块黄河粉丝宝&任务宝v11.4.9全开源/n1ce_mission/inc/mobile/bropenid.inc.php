<?php

global $_W,$_GPC;
$borrow = mc_oauth_userinfo();
$from_user = $_GPC['from_user'];
$rid = $_GPC['rid'];
$open = $_GPC['open'];
$rule = $_GPC['rule'];
$fans = pdo_get('n1ce_mission_member',array('uniacid'=>$_W['uniacid'],'from_user'=>$from_user,'rid'=>$rid),array('id'));

$data = array(
	'uniacid' => $_W['uniacid'],
	'rid' => $rid,
	'from_user' => $from_user,
	'brrow_openid' => $_SESSION['oauth_openid'],
	'status' => 2,
	'nickname' => $borrow['nickname'],
	'headimgurl' => $borrow['avatar'],
	'createtime' => TIMESTAMP,
);
if($fans['id']){
	if($borrow['openid']){
		pdo_update('n1ce_mission_member',$data,array('id'=>$fans['id']));
	}
}else{
	pdo_insert('n1ce_mission_member',$data);
}
include $this->template('bropenid');