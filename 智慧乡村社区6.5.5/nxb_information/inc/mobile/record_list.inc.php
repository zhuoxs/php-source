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
$mesid=intval($_GPC['mesid']);
$cx='';
if($mesid!=0){
	$cx=' AND mesid='.$mesid; 
}
//查询是否有登录缓存，如果没有就跳转
$user=cache_load('user');
if(empty($user)){
	header("location:".$this->createMobileUrl('index'));
}


	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;	
	$total = pdo_fetchcolumn("SELECT count(recid) FROM " . tablename('nx_information_record') . " WHERE weid=:uniacid ".$cx." ORDER BY recid DESC", array(':uniacid' => $_W['uniacid']));
	$count = ceil($total / $psize);
	
include $this -> template('record_list');

?>