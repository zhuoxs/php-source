<?php
global $_W, $_GPC;
$all_net=$this->get_allnet(); 
$base=$this->get_base(); 
$title=$base['title'];
$mid=$this->get_mid();
$townid = $_GPC['town_id'];

//获取种养技术的分类
$list=pdo_fetchall("SELECT * FROM ".tablename('bc_community_coursetype')." WHERE weid=:uniacid AND town_id = $townid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));

$res = pdo_fetchall("SELECT * FROM " . tablename('bc_community_courselesson') . " WHERE weid=" . $_W['uniacid'] . " AND menpai=$townid ORDER BY id DESC ");

$cx='';
$id=intval($_GPC['id']);
if($id!=0){
	$cx=' AND typeid='.$id;
}	
	
	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 6;	
	$total = pdo_fetchcolumn("SELECT count(id) FROM " . tablename('bc_community_courselesson') . " WHERE weid=:uniacid ".$cx." ORDER BY id DESC", array(':uniacid' => $_W['uniacid']));
	$count = ceil($total / $psize);
	
	include $this -> template('technology');

?>