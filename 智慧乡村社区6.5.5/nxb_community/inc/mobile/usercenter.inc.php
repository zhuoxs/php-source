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


//判断用户是否认证
if($member['isrz']==0){
	message('您尚未认证村民！', $this -> createMobileUrl('register'), 'error');
		
}else if($member['isrz']==2){
	message('您尚未通过认证审核,请稍后重试！', $this -> createMobileUrl('index'), 'error');
}



$ft=5;
$usernum=pdo_fetchcolumn("SELECT count(mid) FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND grade!=1 AND grade!=0",array(':uniacid'=>$_W['uniacid']));
include $this -> template('usercenter');

?>