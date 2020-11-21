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

$meid=intval($_GPC['meid']);
$id=intval($_GPC['id']);

if($id!=0){
	//获取当前镇子的详情
	$town=pdo_fetch("SELECT * FROM ".tablename('bc_community_town')." WHERE id=:id",array(':id'=>$id));
}else{
	$isrz=$member['isrz'];
	if($isrz==1){
		$id=$member['menpai'];
		$town=pdo_fetch("SELECT * FROM ".tablename('bc_community_town')." WHERE id=:id",array(':id'=>$id));
	}else{
		message('抱歉！您还没有认证村民哦！',$this->createMobileUrl('register',array()),'error');
	}
	
}


$images=explode("|",$town['photo']);
//获取广告图片列表
$advlist=$images;
$num=count($advlist);
$num=$num-1;

$rd=$town['rd']+1;

//增加浏览量值
$newdata = array(
	'rd'=>$rd,	
);
$res = pdo_update('bc_community_town', $newdata,array('id'=>$id));



//获取导航列表
$menutoplist=pdo_fetchall("SELECT * FROM".tablename('bc_community_menu')."WHERE weid=:uniacid AND mtype=1 AND townid=:townid ORDER BY meid DESC",array(':uniacid'=>$_W['uniacid'],':townid'=>$id));

$menuscolist=pdo_fetchall("SELECT * FROM".tablename('bc_community_menu')."WHERE weid=:uniacid AND mtype=2 AND townid=:townid ORDER BY meid DESC",array(':uniacid'=>$_W['uniacid'],':townid'=>$id));



if(!empty($meid) && $meid!=0){
	

	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 6;	
	$total = pdo_fetchcolumn("SELECT count(nid) FROM " . tablename('bc_community_news') . " WHERE weid=:uniacid AND nmenu=".$meid." AND townid=:id ORDER BY nid DESC", array(':uniacid' => $_W['uniacid'],':id'=>$id));
	$count = ceil($total / $psize);
	include $this -> template('village_index');
	
}else{

	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 6;	
	$total = pdo_fetchcolumn("SELECT count(nid) FROM " . tablename('bc_community_news') . " WHERE weid=:uniacid AND townid=:id ORDER BY nid DESC", array(':uniacid' => $_W['uniacid'],':id'=>$id));
	$count = ceil($total / $psize);
	include $this -> template('village_index');
	
}
	
	



?>