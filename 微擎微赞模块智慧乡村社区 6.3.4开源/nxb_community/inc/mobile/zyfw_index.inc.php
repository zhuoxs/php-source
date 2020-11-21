<?php
global $_W, $_GPC;
$all_net=$this->get_allnet(); 
$base=$this->get_base(); 
$title=$base['title'];
$mid=$this->get_mid();

$meid=intval($_GPC['meid']);

//获取广告图片列表
$advlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_adv')." WHERE weid=:uniacid ORDER BY aid DESC",array(':uniacid'=>$_W['uniacid']));


//查询 微心愿 好人好事 志愿活动这三个栏目的ID
$res1=pdo_fetch("SELECT * FROM ".tablename('bc_community_menu')." WHERE weid=:uniacid AND mtitle=:mtitle",array(':uniacid'=>$_W['uniacid'],':mtitle'=>'微心愿'));
if(!empty($res1)){
	$wxyid=$res1['meid'];
}else{
	$wxyid=0;
}
$res2=pdo_fetch("SELECT * FROM ".tablename('bc_community_menu')." WHERE weid=:uniacid AND mtitle=:mtitle",array(':uniacid'=>$_W['uniacid'],':mtitle'=>'好人好事'));
if(!empty($res2)){
	$hrhsid=$res2['meid'];
}else{
	$hrhsid=0;
}
$res3=pdo_fetch("SELECT * FROM ".tablename('bc_community_menu')." WHERE weid=:uniacid AND mtitle=:mtitle",array(':uniacid'=>$_W['uniacid'],':mtitle'=>'志愿活动'));
if(!empty($res3)){
	$zyhdid=$res3['meid'];
}else{
	$zyhdid=0;
}


$zyfw=' AND meid='.$wxyid.' OR meid='.$hrhsid.' OR meid='.$zyhdid;
$zyfw1=' AND nmenu='.$wxyid.' OR nmenu='.$hrhsid.' OR nmenu='.$zyhdid;
//获取滑动分类列表
$menuscolist=pdo_fetchall("SELECT * FROM".tablename('bc_community_menu')."WHERE weid=:uniacid AND mtype=2 ".$zyfw." ORDER BY meid DESC",array(':uniacid'=>$_W['uniacid']));



if(!empty($meid) && $meid!=0){
	

	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 6;	
	$total = pdo_fetchcolumn("SELECT count(nid) FROM " . tablename('bc_community_news') . " WHERE weid=:uniacid AND nmenu=".$meid." ORDER BY nid DESC", array(':uniacid' => $_W['uniacid']));
	$count = ceil($total / $psize);
	include $this -> template('zyfw_index');
}else{

	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 6;	
	$total = pdo_fetchcolumn("SELECT count(nid) FROM " . tablename('bc_community_news') . " WHERE weid=:uniacid ".$zyfw1." ORDER BY nid DESC", array(':uniacid' => $_W['uniacid']));
	$count = ceil($total / $psize);
	include $this -> template('zyfw_index');
}
	
	



?>