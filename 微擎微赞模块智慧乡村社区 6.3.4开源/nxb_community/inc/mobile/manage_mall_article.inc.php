<?php
global $_W, $_GPC;
include 'common.php';
load()->func('tpl');
$base=$this->get_base(); 
$title=$base['title'];
//查询缓存是否存在，如果有，就直接登录后台，如果没有就显示登录页
$webtoken= cache_load('webtoken');
if($webtoken==''){
	include $this->template('manage_login');
}else{
	//通过缓存查找到管理员信息
	$manageid= cache_load('manageid');
	
	$manage=pdo_fetch("SELECT * FROM ".tablename('bc_community_jurisdiction')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],'id'=>$manageid));
	


	$artlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_mall_arttype')." WHERE weid=:uniacid AND status=1 ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));




	$nav=intval($_GPC['nav']);
	if($nav==0){
		$nav=1;
	}
	
	$id=intval($_GPC['id']);
	$cx='';
	if($id!=0){
		$cx=' AND pid='.$id;
	}
	
	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;	
	$total = pdo_fetchcolumn("SELECT count(id) FROM " . tablename('bc_community_mall_article') . " WHERE weid=:uniacid ".$cx." ORDER BY id DESC", array(':uniacid' => $_W['uniacid']));
	$count = ceil($total / $psize);
	
	
	include $this->template('manage_mall_article');
}





?>