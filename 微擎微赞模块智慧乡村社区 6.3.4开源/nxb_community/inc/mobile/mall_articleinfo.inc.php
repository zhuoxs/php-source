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
//获取分类详情
$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_article')." WHERE id=:id",array(':id'=>$id));
if($res['photo']!=''){
	$images=explode("|",$res['photo']);
}

	include $this -> template('mall_articleinfo');

	
	



?>