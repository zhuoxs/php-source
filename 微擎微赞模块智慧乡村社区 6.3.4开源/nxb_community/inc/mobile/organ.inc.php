<?php
global $_W, $_GPC;
include 'common.php';
load() -> func('tpl');
$all_net=$this->get_allnet(); 

$base=$this->get_base(); 
$title=$base['title'];
$mid=$this->get_mid(); 

$townid=intval($_GPC['id']);

//获取乡镇列表



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
//获取当前村镇详情
$town=pdo_fetch("SELECT name FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$townid));

//获取乡村组织分类列表
$organlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_organlev')." WHERE weid=:uniacid AND villageid=:villageid ORDER BY id ASC",array(':uniacid'=>$_W['uniacid'],':villageid'=>$townid));



include $this -> template('organ');

?>