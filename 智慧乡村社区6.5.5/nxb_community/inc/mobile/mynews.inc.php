<?php
global $_W, $_GPC;
$all_net=$this->get_allnet(); 
$base=$this->get_base(); 
$title=$base['title'];
$mid=$this->get_mid();

	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 6;	
	$total = pdo_fetchcolumn("SELECT count(nid) FROM " . tablename('bc_community_news') . " WHERE weid=:uniacid AND mid=:mid ORDER BY nid DESC", array(':uniacid' => $_W['uniacid'],':mid'=>$mid));
	$count = ceil($total / $psize);
	
	include $this -> template('mynews');

?>