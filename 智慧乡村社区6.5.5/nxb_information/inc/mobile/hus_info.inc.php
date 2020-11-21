<?php
global $_W, $_GPC;
include 'common.php';
$all_net=$this->get_allnet(); 
$base=$this->get_base(); 
$title=$base['modularname'];
if ($_W['fans']['follow']==0){
	include $this -> template('follow');
	exit;
};


$mid=$this->get_mid();

//查询是否有登录缓存，如果没有就跳转
$user=cache_load('user');
if(empty($user)){
	header("location:".$this->createMobileUrl('index'));
}


$hid=intval($_GPC['hid']);
$res=pdo_fetch("SELECT * FROM ".tablename('nx_information_hus')." WHERE weid=:weid AND hid=:hid",array(':weid'=>$_W['uniacid'],':hid'=>$hid));


include $this -> template('hus_info');

?>