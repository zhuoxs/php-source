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
//获取商家信息详情
$seller=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_seller')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$member['mid']));   		
if($seller){
	if($seller['rz']==0){
		message('您的权限不足', $this -> createMobileUrl('mall',array()), 'error');
		return false;
	}
	if($seller['rz']==1){
		message('您的商家资质尚未通过审核，请稍后重试', $this -> createMobileUrl('mall',array()), 'error');
		return false;
	}
}else{
	message('您的权限不足', $this -> createMobileUrl('mall',array()), 'error');
	return false;
}



//获取该商家所有商品列表
$goodslist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_mall_goods')." WHERE weid=:uniacid AND mid=:mid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));


	include $this -> template('mall_mygoods');

	
	



?>