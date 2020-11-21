<?php

global $_W,$_GPC;

	$mid=intval($_GPC['mid']);
	
	$name=$_GPC['name'];
	$psd=md5($_GPC['psd']);
	
	//查询管理角色表里信息是否一致
	$user=pdo_fetch("SELECT * FROM ".tablename('nx_information_role')." WHERE weid=:uniacid AND mid=:mid AND rostatus=0",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));
	
	if(!empty($user)){
		if($user['rolename']==$name && $user['password']==$psd){
			//写入一条登录成功后的用户cookie
			cache_write('user',$_W['openid']);
			
			
			
			echo json_encode(array('status'=>1,'log'=>'登录成功！'));
		}else{
			echo json_encode(array('status'=>0,'log'=>'用户名或密码错误！'));
		}
		
	}else{
		echo json_encode(array('status'=>2,'log'=>'您没有登录权限，请联系管理员！'));
	}		  


	
	
		           
    

?>