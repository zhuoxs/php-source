<?php
global $_W, $_GPC;
load() -> func('tpl');
$all_net=$this->get_allnet(); 
$base=$this->get_base(); 
$title=$base['title'];
$mid=$this->get_mid();

$user=pdo_fetch("SELECT * FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));
//获取所有小区列表
$communitylist=pdo_fetchall("SELECT * FROM".tablename('bc_community_community')."WHERE weid=:uniacid ORDER BY coid DESC",array(':uniacid'=>$_W['uniacid']));
		

include $this -> template('setup');

?>