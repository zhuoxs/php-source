<?php

global $_W,$_GPC;
$base=$this->get_base(); 
	$uname=$_GPC['uname'];	
	$upsd=md5($_GPC['upsd']);
	
	//查询信息是否一致
	$user=pdo_fetch("SELECT * FROM ".tablename('bc_community_jurisdiction')." WHERE weid=:uniacid AND uname=:uname",array(':uniacid'=>$_W['uniacid'],':uname'=>$uname));

	if(!empty($user)){
		
			if( $user['upsd']==$upsd){
				//写入一条登录成功后的用户cookie
				
				cache_write('webtoken',$uname);
				cache_write('manageid',$user['id']);

				echo json_encode(array('status'=>1,'log'=>'登录成功！'));
			}else{
				echo json_encode(array('status'=>0,'log'=>'密码错误！'));
			}
			
		
		
	}else{
		echo json_encode(array('status'=>2,'log'=>'登录信息不存在！'));
	}  


	
	
		           
    

?>