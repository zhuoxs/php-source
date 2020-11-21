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


if($user==1){
	header("location:".$this->createMobileUrl('formtype')."");
	
}






include $this -> template('index');

?>