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

$reslist = pdo_fetchall("SELECT a.*,b.huzhu FROM " . tablename('nx_information_transfer') . " as a left join ".tablename('nx_information_hus')." as b on a.hid=b.hid WHERE a.weid=:uniacid AND a.bianma=:bianma ORDER BY traid DESC",array(':uniacid'=>$_W['uniacid'],':bianma'=>$bianma));	

include $this -> template('transfer_list');

?>