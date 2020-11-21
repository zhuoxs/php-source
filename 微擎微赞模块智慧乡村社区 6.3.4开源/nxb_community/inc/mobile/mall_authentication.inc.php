<?php
global $_W, $_GPC;
include 'common.php';
load() -> func('tpl');
$all_net=$this->get_allnet(); 

$base=$this->get_base(); 
$title=$base['title'];
$mid=$this->get_mid(); 


$gz=$this->guanzhu(); 
//判断是否需要进入强制关注页
if($gz==1){
	if ($_W['fans']['follow']==0){
		include $this -> template('follow');
		exit;
	};
}else{
	//取得用户授权
	mc_oauth_userinfo();
}

//获取当前用户的信息
$member=$this->getmember(); 


	//获取用户信息详情
	$user=pdo_fetch("SELECT * FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));   		
	//获取商家信息详情
	$seller=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_seller')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));   		
	


	include $this -> template('mall_authentication');

	
	



?>