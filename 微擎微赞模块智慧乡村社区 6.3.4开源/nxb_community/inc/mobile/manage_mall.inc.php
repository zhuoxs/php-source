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
	

	
//查询所有镇
if($townid==0){
	$townlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND lev=2 ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));
}else{
	$townlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND pid=:pid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid'],':pid'=>$townid));
}
//查询所有大类列表	
$catlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_mall_category')." WHERE weid=:uniacid AND pid=0 ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));

$town=intval($_GPC['town']);
$village=intval($_GPC['village']);
$bigtype=intval($_GPC['bigtype']);
$smalltype=intval($_GPC['smalltype']);

if($town!=0){
	$cx.=" AND danyuan=".$town;
}
if($village!=0){
	$cx.=" AND menpai=".$village;
}
if($bigtype!=0){
	$cx.=" AND pptid=".$bigtype;
}
if($smalltype!=0){
	$cx.=" AND ptid=".$smalltype;
}

$status=intval($_GPC['status']);
$cx.=" AND pstatus=".$status;
	
	

	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;	
	$total = pdo_fetchcolumn("SELECT count(mid) FROM " . tablename('bc_community_mall_goods') . " WHERE weid=:uniacid ".$cx." ORDER BY id DESC", array(':uniacid' => $_W['uniacid']));
	$count = ceil($total / $psize);
	

	include $this->template('manage_mall');
}





?>