<?php
global $_W, $_GPC;
include 'common.php';
$base=$this->get_base(); 
$title=$base['title'];
$id=$_GPC['id'];
$mid=$this->get_mid();

//查询志愿服务帖子的详情
$news=pdo_fetch("SELECT * FROM ".tablename('bc_community_news')." WHERE weid=:uniacid AND nid=:nid",array(':uniacid'=>$_W['uniacid'],':nid'=>$id));


$n='';
$user=pdo_fetch("SELECT * FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));
$lev=$user['grade'];

if($user['realname'=='']){
	$n=$user['nickname'];
}else{
	$n=$user['realname'];
}
include $this -> template('zyfwreport');

?>