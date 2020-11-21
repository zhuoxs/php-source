<?php
global $_W, $_GPC;
include 'common.php';
load()->func('tpl');
$base=$this->get_base(); 
$title=$base['title'];
//查询缓存是否存在，如果有，就直接登录后台，如果没有就显示登录页
$webtoken = $_SESSION['webtoken']; //cache_load('webtoken');


if($webtoken==''){
	header('Location: '.$_W['siteroot'].'web/index.php?c=user&a=login&referer='.urlencode($_W['siteroot'].'app/'.$this->createMobileUrl('manage_login_go')));
}else{
	//通过缓存查找到管理员信息
	$manageid = $_SESSION['manageid']; //cache_load('manageid');
	
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
	

if($manage['lev']==2){
	$townlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND lev=2 AND id=:id ORDER BY id DESC",array(':uniacid'=>$_W['uniacid'],':id'=>$townid));
	
}else if($manage['lev']==0 || $manage['lev']==1){
	//查询所有镇
	if($townid==0){
		$townlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND lev=2 ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));
	}else{
		$townlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND pid=:pid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid'],':pid'=>$townid));
	}
}


$town=intval($_GPC['town']);
$village=intval($_GPC['village']);


if($town!=0){
	$cx.=" AND danyuan=".$town;
}
if($village!=0){
	$cx.=" AND menpai=".$village;
}

$status=intval($_GPC['status']);
$cx.=" AND rz=".$status;
	

	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;	
	$total = pdo_fetchcolumn("SELECT count(id) FROM " . tablename('bc_community_mall_seller') . " WHERE weid=:uniacid ".$cx." ORDER BY id DESC", array(':uniacid' => $_W['uniacid']));
	$count = ceil($total / $psize);
	

	include $this->template('manage_mall_seller');
}





?>