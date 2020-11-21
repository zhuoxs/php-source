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

$id=intval($_GPC['id']);
if($id==0){
	message('参数错误！', $this -> createMobileUrl('mall'), 'error');
	return false;
}
$order=pdo_fetch("SELECT a.*,b.ptitle,b.pimg,b.punit FROM ".tablename('bc_community_mall_orders')." as a left join ".tablename('bc_community_mall_goods')." as b on a.pid=b.id WHERE a.weid=:uniacid AND a.id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$id));
$n=intval($_GPC['n']);
if($n==1){
	//如果是商家，查询商家微信用户是否是该订单的商家
	$seller=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_seller')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));
	
	if(empty($seller) || $seller['id']!=$order['sid']){
		message('权限不足！', $this -> createMobileUrl('mall'), 'error');
		return false;
	}
}


	include $this -> template('mall_orderinfo');

	
	



?>