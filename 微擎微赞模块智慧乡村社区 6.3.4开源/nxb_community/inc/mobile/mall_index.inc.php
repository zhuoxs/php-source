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

//查询商城BANNER
$advlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_mall_banner')." WHERE weid=:uniacid ORDER BY id DESC LIMIT 5",array(':uniacid'=>$_W['uniacid']));
$num=pdo_fetchcolumn("SELECT count(id) FROM ".tablename('bc_community_mall_banner')." WHERE weid=".$_W['uniacid']);
if($num>=5){
	$num=4;
}else{
	$num=$num-1;
}
//查询导航菜单
$navlist=pdo_fetchall("SELECT * FROM".tablename('bc_community_mall_nav')."WHERE weid=:uniacid ORDER BY id ASC",array(':uniacid'=>$_W['uniacid']));

//查询大分类
$bigtype=pdo_fetchall("SELECT * FROM".tablename('bc_community_mall_category')."WHERE weid=:uniacid AND pid=0 ORDER BY id ASC",array(':uniacid'=>$_W['uniacid']));

//查询商品列表，按人气和推荐条件前50个商品
$cx='';
$t=intval($_GPC['t']);
if($t==1 || $t==0){
	$cx=" pyqty DESC,";
}else if($t==2){
	$cx=" is_hot DESC,";
}
$goodslist=pdo_fetchall("SELECT * FROM".tablename('bc_community_mall_goods')."WHERE weid=:uniacid AND pstatus=1 ORDER BY ".$cx." id ASC",array(':uniacid'=>$_W['uniacid']));




	include $this -> template('mall_index');

	
	



?>