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
//获取商家信息
$seller=$this->getseller();
if($seller && $seller['rz']==2){
	$stid=intval($_GPC['stid']);
	$cx='';
	$cx1='';
	if($stid!=0){
		$cx=' AND postatus='.$stid;
		$cx1=' AND a.postatus='.$stid;
	}

	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 6;	
	$total = pdo_fetchcolumn("SELECT count(id) FROM " . tablename('bc_community_mall_orders') . " WHERE weid=:uniacid AND sid=:sid ".$cx." ORDER BY id DESC", array(':uniacid' => $_W['uniacid'],':sid'=>$seller['id']));
	$count = ceil($total / $psize);



	include $this -> template('mall_orders');

	
	
	
}else{
	message('权限不足！', $this -> createMobileUrl('mall_authentication'), 'error');
	return false;
}




?>