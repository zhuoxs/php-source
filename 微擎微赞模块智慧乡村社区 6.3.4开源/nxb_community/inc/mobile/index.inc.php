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



//获取广告图片列表
$advlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_adv')." WHERE weid=:uniacid ORDER BY aid DESC LIMIT 5",array(':uniacid'=>$_W['uniacid']));
$num=pdo_fetchcolumn("SELECT count(aid) FROM ".tablename('bc_community_adv')." WHERE weid=".$_W['uniacid']);
if($num>=5){
	$num=4;
}else{
	$num=$num-1;
}

//获取导航列表
$menutoplist=pdo_fetchall("SELECT * FROM".tablename('bc_community_menu')."WHERE weid=:uniacid AND mtype=1 AND townid=0 ORDER BY meid DESC",array(':uniacid'=>$_W['uniacid']));
//底部导航的焦点色处理
$ft=1;
//获取本市所有镇级列表
$town=pdo_fetchall("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND lev=2 ORDER BY paixu ASC,id DESC",array(':uniacid'=>$_W['uniacid']));
$townnum=count($town);

//获取村庄热度表的列表
$ldtown=pdo_fetchall("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND lev=3 ORDER BY rd DESC,id DESC",array(':uniacid'=>$_W['uniacid']));



	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 6;	
	$total = pdo_fetchcolumn("SELECT count(nid) FROM " . tablename('bc_community_news') . " WHERE weid=:uniacid AND nmenu=".$meid." ORDER BY nid DESC", array(':uniacid' => $_W['uniacid']));
	$count = ceil($total / $psize);
	
	
	include $this -> template('index');

	
	



?>