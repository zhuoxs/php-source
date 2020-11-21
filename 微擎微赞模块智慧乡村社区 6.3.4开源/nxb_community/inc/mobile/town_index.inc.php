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
//获取当前镇子的详情
$town=pdo_fetch("SELECT * FROM ".tablename('bc_community_town')." WHERE id=:id",array(':id'=>$id));

$images=explode("|",$town['photo']);
//获取广告图片列表
$advlist=$images;
$num=count($advlist);
$num=$num-1;

//获取本镇所有的村列表
$townlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND lev=3 AND pid=:pid  ORDER BY paixu ASC,id DESC LIMIT 300",array(':uniacid'=>$_W['uniacid'],':pid'=>$id));
$townnum=count($townlist);

//获取导航列表
$menutoplist=pdo_fetchall("SELECT * FROM".tablename('bc_community_menu')."WHERE weid=:uniacid AND mtype=1 AND townid=:townid ORDER BY meid DESC",array(':uniacid'=>$_W['uniacid'],':townid'=>$id));

$menuscolist=pdo_fetchall("SELECT * FROM".tablename('bc_community_menu')."WHERE weid=:uniacid AND mtype=2 AND townid=:townid  ORDER BY meid DESC",array(':uniacid'=>$_W['uniacid'],':townid'=>$id));



if(!empty($meid) && $meid!=0){
	

	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 6;	
	$total = pdo_fetchcolumn("SELECT count(nid) FROM " . tablename('bc_community_news') . " WHERE weid=:uniacid AND nmenu=".$meid." AND townid=:id ORDER BY nid DESC", array(':uniacid' => $_W['uniacid'],':id'=>$id));
	$count = ceil($total / $psize);
	include $this -> template('town_index');
	
}else{

	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 6;	
	$total = pdo_fetchcolumn("SELECT count(nid) FROM " . tablename('bc_community_news') . " WHERE weid=:uniacid AND townid=:id ORDER BY nid DESC", array(':uniacid' => $_W['uniacid'],':id'=>$id));
	$count = ceil($total / $psize);
	include $this -> template('town_index');
	
}
	
	



?>