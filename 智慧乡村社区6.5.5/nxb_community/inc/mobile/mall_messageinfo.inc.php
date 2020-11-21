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
$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_messages')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$id));
$status=intval($res['status']);

if($status==0){
	
	$newdata=array(
		'status'=>1
	);
	pdo_update('bc_community_mall_messages',$newdata,array('id'=>$id));
}




include $this -> template('mall_messageinfo');

?>