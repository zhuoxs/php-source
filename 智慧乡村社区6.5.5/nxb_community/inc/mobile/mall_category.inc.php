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

//查询一级分类
$bigtype=pdo_fetchall("SELECT * FROM".tablename('bc_community_mall_category')."WHERE weid=:uniacid AND pid=0 ORDER BY id ASC",array(':uniacid'=>$_W['uniacid']));


	include $this -> template('mall_category');

	
	



?>