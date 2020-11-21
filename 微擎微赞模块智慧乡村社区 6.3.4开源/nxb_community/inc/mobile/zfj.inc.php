<?php
global $_W, $_GPC;
$all_net=$this->get_allnet(); 
$base=$this->get_base(); 
$title=$base['title'];
$mid=$this->get_mid();
$meid=intval($base['zdymunuid']);

	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 6;	
	$total = pdo_fetchcolumn("SELECT count(nid) FROM " . tablename('bc_community_news') . " WHERE weid=:uniacid AND nmenu=".$meid." ORDER BY nid DESC", array(':uniacid' => $_W['uniacid']));
	$count = ceil($total / $psize);

include $this -> template('zfj');

?>