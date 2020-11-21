<?php
global $_W, $_GPC;
include 'common.php';
mc_oauth_userinfo();
$all_net=$this->get_allnet(); 
$base=$this->get_base(); 
$title=$base['title'];
$all_net=$this->get_allnet(); 
$id=$_GPC['id'];
$mid=$this->get_mid();

$user=pdo_fetch("SELECT * FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));
$isrz=$user['isrz'];
//进入这个页面须是认证村民，查询用户是否是村民身份
/*
$user=pdo_fetch("SELECT * FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));
if($user['grade']==1){
	message('抱歉！认证为本村村民才可查看和回复帖子！',$this->createMobileUrl('register',array()),'error');
}
if($user['grade']==0){
	message('抱歉！您提交的认证信息正在审核中，请稍后再访问！',$this->createMobileUrl('index',array()),'error');
}	
*/

$res=pdo_fetch("SELECT a.*,b.mtitle,c.nickname,c.avatar FROM ".tablename('bc_community_news')." as a left join ".tablename('bc_community_menu')." as b on a.nmenu=b.meid left join ".tablename('bc_community_member')." as c on a.mid=c.mid WHERE a.weid=:uniacid AND nid=:newsid",array(':uniacid'=>$_W['uniacid'],':newsid'=>$id));
$hits=intval($res['browser']);
$hits=$hits+1;
	$newdata=array(
		'browser'=>$hits
	);
	pdo_update('bc_community_news',$newdata,array('nid'=>$res['nid']));


$images=explode("|",$res['nimg']);

$sharelink=$this->createMobileUrl('newsinfo',array('id'=>$res['nid']));
$shareimg='';

if(!empty($images)){
	$shareimg=tomedia($images[0]);
}else{
	$shareimg='{MODULE_URL}myui/img/logo.png';
}

include $this -> template('newsinfo');

?>