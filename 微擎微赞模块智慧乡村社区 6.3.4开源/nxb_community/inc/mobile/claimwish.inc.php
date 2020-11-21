<?php

global $_W,$_GPC;
require_once('Ucpaas.class.php');
$code=$_GPC['code'];
$mobile=$_GPC['mobile'];
$name=$_GPC['name'];
$company=$_GPC['company'];
$nid=intval($_GPC['nid']);


	$param=$_GPC['p1'];
	$tel=$_GPC['p2'];


if($code!=$param || $mobile!=$tel){
	echo json_encode(array('status'=>0,'log'=>'验证码错误','code'=>$code,'tel'=>$mobile,'param'=>$param,'telphone'=>$tel));
}else{
	//进行心愿领取操作
	$newdata=array(			
		'wishrl'=>1,		
		'wishtel'=>$mobile,
		'wishname'=>$name,
		'wishcompany'=>$company,
	);
	$res=pdo_update('bc_community_news',$newdata,array('nid'=>$nid));
	if(!empty($res)){
			
		echo json_encode(array('status'=>1,'log'=>'领取成功'));
	}else{
		echo json_encode(array('status'=>2,'log'=>'领取失败','nid'=>$nid));
	}
	
}

	
	
		           
    

?>