<?php
global $_W, $_GPC;
include 'common.php';
load() -> func('tpl');
$base=$this->get_base(); 
$title=$base['title'];
//查询缓存是否存在，如果有，就直接登录后台，如果没有就显示登录页
$webtoken= cache_load('webtoken');
if($webtoken==''){
	include $this->template('manage_login');
}else{
	
	$nav=intval($_GPC['nav']);
	if($nav==0){
		$nav=1;
	}
	
	//通过缓存查找到管理员信息
	$manageid= cache_load('manageid');
	
	$manage=pdo_fetch("SELECT * FROM ".tablename('bc_community_jurisdiction')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],'id'=>$manageid));
	$v=0;
	if($manage['lev']==2 || $manage['lev']==3){		
		$v=1;		
	}
	
	//获取角色列表
	$rolelsit=pdo_fetchall("SELECT * FROM ".tablename('bc_community_authority')." WHERE weid=:uniacid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));
	//获取当前商品详情
	$id=intval($_GPC['id']);
	$goods=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_goods')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$id));

if(empty($goods)){
	message('商品信息有误，请联系管理员', $this -> createMobileUrl('manag_mall',array()), 'error');
	return false;
}
$images=explode(",",$goods['photo']);

//获取商品分类的一级分类
$catlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_mall_category')." WHERE weid=:uniacid AND pid=0 ORDER BY id ASC",array(':uniacid'=>$_W['uniacid']));
	

}
	



	
	
	
	
	include $this->template('manage_goodsinfo_edit');





?>