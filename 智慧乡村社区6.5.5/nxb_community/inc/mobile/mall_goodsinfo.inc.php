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
	message('参数有误！', $this -> createMobileUrl('mall_goods'), 'error');
	return false;
}
//获取商品详情
$goods=pdo_fetch("SELECT a.*,b.slogo,b.stitle,b.contacts,b.danyuan,b.menpai,b.rz,b.mobile FROM ".tablename('bc_community_mall_goods')." as a left join ".tablename('bc_community_mall_seller')." as b on a.sid=b.id WHERE a.weid=:uniacid AND a.id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$id));
$images=explode(",",$goods['photo']);
$num=count($images);
if($goods['pstatus']!=1){
	message('商品参数有误！', $this -> createMobileUrl('mall_goods'), 'error');
	return false;
}

	include $this -> template('mall_goodsinfo');

	
	



?>