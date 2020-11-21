<?php
global $_W,$_GPC;
$unsub = pdo_fetch("select * from " .tablename('n1ce_mission_unsub'). " where uniacid = :uniacid",array(':uniacid'=>$_W['uniacid']));
if(checksubmit()){
	$data = array(
		'uniacid' => $_W['uniacid'],
		'un_tips' => htmlspecialchars_decode(str_replace('&quot;','&#039;',$_GPC['un_tips']),ENT_QUOTES),
		'createtime' => time(),
	);
	if($unsub['id']){
		pdo_update('n1ce_mission_unsub',$data,array('id'=>$unsub['id']));
	}else{
		pdo_insert('n1ce_mission_unsub',$data);
	}
	message('操作成功',$this->createWebUrl('unsubscribe'),'success');
}
include $this->template('unsubscribe');