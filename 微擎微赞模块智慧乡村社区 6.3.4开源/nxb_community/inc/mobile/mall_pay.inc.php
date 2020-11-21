<?php
global $_W, $_GPC;
include 'common.php';
load() -> func('tpl');
$all_net=$this->get_allnet(); 

$base=$this->get_base(); 
$title=$base['title'];
$mid=$this->get_mid(); 


$gz=$this->guanzhu(); 
//判断是否需要进入强制关注页
if($gz==1){
	if ($_W['fans']['follow']==0){
		include $this -> template('follow');
		exit;
	};
}else{
	//取得用户授权
	mc_oauth_userinfo();
}

//获取当前用户的信息
$member=$this->getmember(); 

//查询当前用户是否有收货地址记录
$address=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_address')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));
$g_aid=0;
if($address){
	$g_aid=$address['id'];
}

$id=intval($_GPC['id']);
//查询当前商品详情
$goods=pdo_fetch("SELECT a.*,b.slogo,b.stitle,b.contacts,b.danyuan,b.menpai,b.rz,b.mobile FROM ".tablename('bc_community_mall_goods')." as a left join ".tablename('bc_community_mall_seller')." as b on a.sid=b.id WHERE a.weid=:uniacid AND a.id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$id));
$orid=intval($_GPC['orid']);
$pnum=1;
if($orid!=0){
	$order=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_orders')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$orid));
	$pnum=$order['pnum'];
}


	include $this -> template('mall_pay');

	
	



?>