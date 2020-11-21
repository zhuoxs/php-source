<?php

global $_W,$_GPC;
require_once('Ucpaas.class.php');


$config=$this->module['config'];
$rzcmid=$config['rzcmid'];

	$mid=intval($_GPC['mid']);
	
	$danyuan=$_GPC['dy'];
	$menpai=$_GPC['mp'];
	$realname=$_GPC['name'];
	$tele=$_GPC['tel'];

	$code=$_GPC['code'];
	$param=cache_load('code');
	$tel=$_GPC['p2'];


if($code!=$param || $tele!=$tel){
	echo json_encode(array('status'=>0,'log'=>'验证码错误','code'=>$code,'tel'=>$tele,'param'=>$param,'telphone'=>$tel));
}else{
	//进行更新会员信息操作
		$newdata = array(
			
			'danyuan'=>$danyuan,
			'menpai'=>$menpai,
			'tel'=>$tel,
			'realname'=>$realname,
			'grade'=>$rzcmid,
			'isrz'=>2,
			
		);
		$result = pdo_update('bc_community_member', $newdata,array('mid'=>$mid));
				
		if(!empty($result)){
			echo json_encode(array('status'=>1,'log'=>'已提交认证,平台审核中'));
		}else{
			echo json_encode(array('status'=>2,'log'=>'认证失败'));
		}		  
}

	
	
		           
    

?>