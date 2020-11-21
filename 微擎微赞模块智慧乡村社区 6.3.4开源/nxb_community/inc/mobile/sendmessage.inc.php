<?php
    global $_W,$_GPC;
	$u='';
	$u=$_GPC['u'];	
	if(empty($u)){
		message('抱歉！您不具备权限！',$this->createMobileUrl('index',array()),'error');	
	}
	
	
	//获取短信管理群列表
	$grouplist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_group')." WHERE weid=:uniacid AND gstatus=0 ORDER BY gid DESC",array(':uniacid'=>$_W['uniacid']));
    
  	include $this -> template('sendmessage');

?>