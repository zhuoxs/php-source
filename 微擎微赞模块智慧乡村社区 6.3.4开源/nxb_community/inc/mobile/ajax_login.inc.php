<?php
    global $_W,$_GPC;
	$user=$_GPC['user'];
	$psd=$_GPC['pd'];
	
    $res=pdo_fetch("SELECT * FROM ".tablename('bc_community_gmanage')." WHERE weid=:uniacid AND gmname=:gmname",array(':uniacid'=>$_W['uniacid'],':gmname'=>$user));
    
	if(!empty($res)){
		if($res['gmpassword']==$psd){
			echo json_encode(array('status'=>1,'log'=>'登录成功'));
		}else{
			echo json_encode(array('status'=>0,'log'=>'用户名或密码不正确'));
		}		           
    }else{
        echo json_encode(array('status'=>0,'log'=>'用户名或密码不正确'));
    }
    
  

?>