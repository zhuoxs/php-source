<?php
global $_W, $_GPC;
$all_net=$this->get_allnet(); 
$base=$this->get_base(); 
$title=$base['title'];
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




include $this -> template('search');

?>