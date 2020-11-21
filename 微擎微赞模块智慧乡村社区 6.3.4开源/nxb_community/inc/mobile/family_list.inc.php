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

//查询用户的户编码
$bianma=0;
$res=pdo_fetch("SELECT * FROM ".tablename('nx_information_hus')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));
if($res){
	$bianma=$res['bianma'];
}

	

	$count=0;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;	
	$total = pdo_fetchcolumn("SELECT count(fid) FROM " . tablename('nx_information_family') . " WHERE weid=:uniacid AND bianma=:bianma ORDER BY fid DESC", array(':uniacid' => $_W['uniacid'],':bianma'=>$res['bianma']));
	$count = ceil($total / $psize);
	
include $this -> template('family_list');

?>