<?php
global $_W, $_GPC;
$all_net=$this->get_allnet(); 
$base=$this->get_base(); 
$title=$base['title'];
$mid=$this->get_mid();

$meid=intval($_GPC['meid']);

//获取广告图片列表
$advlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_adv')." WHERE weid=:uniacid ORDER BY aid DESC",array(':uniacid'=>$_W['uniacid']));


//查询 通知公告  财务公开 政务公开 党务公开 政策法规这五个栏目的ID
$res1=pdo_fetch("SELECT * FROM ".tablename('bc_community_menu')." WHERE weid=:uniacid AND mtitle=:mtitle",array(':uniacid'=>$_W['uniacid'],':mtitle'=>'通知公告'));
if(!empty($res1)){
	$tzggid=$res1['meid'];
}else{
	$tzggid=0;
}
$res2=pdo_fetch("SELECT * FROM ".tablename('bc_community_menu')." WHERE weid=:uniacid AND mtitle=:mtitle",array(':uniacid'=>$_W['uniacid'],':mtitle'=>'财务公开'));
if(!empty($res2)){
	$cwgkid=$res2['meid'];
}else{
	$cwgkid=0;
}
$res3=pdo_fetch("SELECT * FROM ".tablename('bc_community_menu')." WHERE weid=:uniacid AND mtitle=:mtitle",array(':uniacid'=>$_W['uniacid'],':mtitle'=>'政务公开'));
if(!empty($res3)){
	$zwgkid=$res3['meid'];
}else{
	$zwgkid=0;
}
$res4=pdo_fetch("SELECT * FROM ".tablename('bc_community_menu')." WHERE weid=:uniacid AND mtitle=:mtitle",array(':uniacid'=>$_W['uniacid'],':mtitle'=>'党务公开'));
if(!empty($res4)){
	$dwgkid=$res4['meid'];
}else{
	$dwgkid=0;
}
$res5=pdo_fetch("SELECT * FROM ".tablename('bc_community_menu')." WHERE weid=:uniacid AND mtitle=:mtitle",array(':uniacid'=>$_W['uniacid'],':mtitle'=>'政策法规'));
if(!empty($res5)){
	$zcfgid=$res5['meid'];
}else{
	$zcfgid=0;
}

$zyfw=' AND meid IN('.$cwgkid.','.$cwgkid.','.$zwgkid.','.$dwgkid.','.$zcfgid.')';
$zyfw1=' AND nmenu IN('.$cwgkid.','.$cwgkid.','.$zwgkid.','.$dwgkid.','.$zcfgid.')';
//获取滑动分类列表
$menuscolist=pdo_fetchall("SELECT * FROM".tablename('bc_community_menu')."WHERE weid=:uniacid AND mtype=2 ".$zyfw." ORDER BY meid DESC",array(':uniacid'=>$_W['uniacid']));



if(!empty($meid) && $meid!=0){
	

	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 6;	
	$total = pdo_fetchcolumn("SELECT count(nid) FROM " . tablename('bc_community_news') . " WHERE weid=:uniacid AND nmenu=".$meid." ORDER BY nid DESC", array(':uniacid' => $_W['uniacid']));
	$count = ceil($total / $psize);
	include $this -> template('sqtz_index');
}else{

	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 6;	
	$total = pdo_fetchcolumn("SELECT count(nid) FROM " . tablename('bc_community_news') . " WHERE weid=:uniacid ".$zyfw1." ORDER BY nid DESC", array(':uniacid' => $_W['uniacid']));
	$count = ceil($total / $psize);
	include $this -> template('sqtz_index');
}
	
	



?>