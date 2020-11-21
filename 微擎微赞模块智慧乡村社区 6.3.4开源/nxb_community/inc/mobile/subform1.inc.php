<?php
global $_W, $_GPC;
load() -> func('tpl');

$all_net=$this->get_allnet(); 
$base=$this->get_base(); 
$title=$base['title'];
$mid=$this->get_mid();

//查询用户角色是否有权限发帖
$user=pdo_fetch("SELECT * FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));

if($user['grade']==1){
	message('抱歉！认证为村民才可以发布帖子！',$this->createMobileUrl('register',array()),'error');
}
if($user['grade']==0){
	message('抱歉！您提交的认证信息正在审核中，请稍后再访问！',$this->createMobileUrl('index',array()),'error');
}
	
//查询该用户是否被禁言，不能发帖子和留言评论

if(!empty($user)){
	$gag=$user['gag'];
	if($gag==1){
		message('抱歉！您被禁言了，不能发帖子和留言评论，请和管理员联系！',$this->createMobileUrl('index',array()),'error');
	}
}


	//如果是普通村民，获取分类状态为0的帖子分类表
	$mlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_menu')." WHERE weid=:uniacid AND jump=0 AND mtype=2 ORDER BY meid DESC",array(':uniacid'=>$_W['uniacid']));	
	include $this -> template('subform1');








?>