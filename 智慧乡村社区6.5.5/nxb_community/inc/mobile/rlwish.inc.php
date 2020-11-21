<?php
global $_W, $_GPC;
include 'common.php';
$base=$this->get_base(); 
$title=$base['title'];
$id=$_GPC['id'];
$mid=$this->get_mid();
$n='';
$user=pdo_fetchall("SELECT * FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));
if($user['realname'=='']){
	$n=$user['nickname'];
}else{
	$n=$user['realname'];
}
include $this -> template('rlwish');

?>