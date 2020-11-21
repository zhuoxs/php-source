<?php
global $_W, $_GPC;
include 'common.php';
load()->web('tpl'); 
$gid=$_GPC['gid'];


	//获取会员列表
	$member=pdo_fetchall("SELECT * FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND grade!=0 AND grade!=1 ORDER BY mid DESC",array(':uniacid'=>$_W['uniacid']));

	//获取短信群列信息
	$group=pdo_fetch("SELECT * FROM ".tablename('bc_community_group')." WHERE weid=:uniacid AND gid=:gid",array(':uniacid'=>$_W['uniacid'],':gid'=>$gid));
	
	include $this->template('web/group_edit');	
	


?>