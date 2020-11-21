<?php


global $_W, $_GPC;
include 'common.php';
load() -> func('tpl');
$all_net=$this->get_allnet(); 

$base=$this->get_base(); 
$title=$base['title'].' - 乡村旅游';
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
$weid = $_W['uniacid'];
//获取当前用户的信息
$member=$this->getmember();
$id = intval($_GPC['town_id']);
$tour = pdo_fetch("SELECT * FROM ".tablename('bc_community_tour_info')." WHERE weid=$weid AND town_id = $id");
$tour['photoalbum'] = unserialize($tour['photoalbum']);
$town = pdo_fetch("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=$weid AND  id = $id");

include $this -> template('tour_info');

?>