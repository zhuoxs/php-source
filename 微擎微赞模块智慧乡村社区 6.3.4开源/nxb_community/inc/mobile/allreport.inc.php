<?php
global $_W, $_GPC;
$all_net=$this->get_allnet(); 
$base=$this->get_base(); 
$title=$base['title'];
$mid=$this->get_mid();
$nid=$_GPC['id'];

//查询相关志愿活动的帖子详情
$news=pdo_fetch("SELECT * FROM ".tablename('bc_community_news')." WHERE weid=:uniacid AND nid=:nid",array(':uniacid'=>$_W['uniacid'],':nid'=>$nid));


	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 6;	
	$total = pdo_fetchcolumn("SELECT count(reid) FROM " . tablename('bc_community_report') . " WHERE weid=:uniacid AND newsid=:nid ORDER BY reid DESC", array(':uniacid' => $_W['uniacid'],':nid'=>$nid));
	$count = ceil($total / $psize);
	
	include $this -> template('allreport');

?>