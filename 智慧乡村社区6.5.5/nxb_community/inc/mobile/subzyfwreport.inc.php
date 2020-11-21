<?php

global $_W,$_GPC;


$mobile=$_GPC['mobile'];
$name=$_GPC['name'];
$mid=intval($_GPC['mid']);
$nid=intval($_GPC['nid']);

//查询是否报过名
$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_report')." WHERE weid=:uniacid AND mid=:mid AND newsid=:nid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid,':nid'=>$nid));
if(!empty($res)){
	echo json_encode(array('status'=>2,'log'=>'这个活动您已经报过名了~'));
}else{
	
	
	//加入报名记录
	$newdata=array(	
		'weid'=>$_W['uniacid'],
		'mid'=>$mid,
		'newsid'=>$nid,		
		'telephone'=>$mobile,
		'username'=>$name,
		'createtime'=>time(),
		
	);
	$result=pdo_insert('bc_community_report',$newdata);
	if(!empty($result)){
			
		echo json_encode(array('status'=>1,'log'=>'报名成功'));
	}else{
		echo json_encode(array('status'=>0,'log'=>'报名失败'));
	}
	
}

	
	

	
	
		           
    

?>