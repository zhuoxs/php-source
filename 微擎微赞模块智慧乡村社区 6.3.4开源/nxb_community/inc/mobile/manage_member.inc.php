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
	$townid=$manage['townid'];
	$nav=intval($_GPC['nav']);
	if($nav==0){
		$nav=1;
	}
	$cx='';
	if($manage['lev']==2){
		$cx=' AND danyuan='.$townid;
	}else if($manage['lev']==3){
		$cx=' AND menpai='.$townid;
	}
	
	$ord=intval($_GPC['ord']);
	if($ord==1){
		$cx.=" AND isrz=0 ";
	}else if($ord==2){
		$cx.=" AND isrz=1 ";
	}
	
	

	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;	
	$total = pdo_fetchcolumn("SELECT count(mid) FROM " . tablename('bc_community_member') . " WHERE weid=:uniacid ".$cx." ORDER BY mid DESC", array(':uniacid' => $_W['uniacid']));
	$count = ceil($total / $psize);
	

	include $this->template('manage_member');
}





?>