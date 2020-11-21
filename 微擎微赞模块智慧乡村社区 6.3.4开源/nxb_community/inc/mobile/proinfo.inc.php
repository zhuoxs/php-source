<?php
global $_W, $_GPC;
include 'common.php';
mc_oauth_userinfo();
$all_net=$this->get_allnet(); 
$base=$this->get_base(); 
$title=$base['title'];
$pid=$_GPC['pid'];
$mid=$this->get_mid();


$res=pdo_fetch("SELECT a.*,b.tname,c.realname,c.avatar FROM ".tablename('bc_community_proposal')." as a left join ".tablename('bc_community_type')." as b on a.ptype=b.tid left join ".tablename('bc_community_member')." as c on a.mid=c.mid WHERE a.weid=:uniacid AND pid=:pid",array(':uniacid'=>$_W['uniacid'],':pid'=>$pid));

$images=explode("|",$res['pimg']);


include $this -> template('proinfo');

?>