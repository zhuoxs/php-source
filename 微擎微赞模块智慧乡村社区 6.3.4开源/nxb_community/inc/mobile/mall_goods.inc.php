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

$id=intval($_GPC['id']);
$sid=intval($_GPC['sid']);
$cxid=$id;
$cx='';
if($id!=0){
	if($sid!=0){
		$cx=' AND ptid='.$sid;
		$cxid=$sid;
	}else{
		$cx=' AND pptid='.$id;
	}
	
}

$type=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_category')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$cxid));



$words=$_GPC['words'];
if($words!=''){
	$cx=" AND ptitle LIKE'%".$words."%' ";
	$cx1=$words;
}


	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;	
	$total = pdo_fetchcolumn("SELECT count(id) FROM " . tablename('bc_community_mall_goods') . " WHERE weid=:uniacid ".$cx." AND pstatus=1  ORDER BY id DESC", array(':uniacid' => $_W['uniacid']));
	$count = ceil($total / $psize);
	
	
	
	include $this -> template('mall_goods');

	
	



?>