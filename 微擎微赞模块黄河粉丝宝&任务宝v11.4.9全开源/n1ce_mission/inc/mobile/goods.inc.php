<?php 
global $_W,$_GPC;
$mc = mc_oauth_userinfo();
$rid = $_GPC['rid'];
yload()->classs('n1ce_mission', 'fans');
$_fans = new Fans();
$from_user = $_fans->getRealOpenid($mc['openid'],$_SESSION['oauth_openid'],$rid,$this->module['config']['borrow'],$mc['unionid']);

$notice = $this->module['config'];
if($notice['antispam_enable'] == 1){
	$b = pdo_fetch("SELECT * FROM " . tablename('n1ce_mission_blacklist') . " WHERE from_user=:f AND uniacid=:w LIMIT 1", array(':f'=>$from_user, ':w'=>$_W['uniacid']));
	if($b && $notice['antispam_join'] !== 1){
		message($notice['antispam_word'],'','error');
	}
}

$userInfo = $_fans->refresh($from_user);
$join = pdo_get('n1ce_mission_qrlog',array('uniacid'=>$_W['uniacid'],'rid'=>$rid,'from_user'=>$from_user),array('id'));
if(empty($join['id'])){
	message('你还未生成海报','','error');
}
$gid = trim($_GPC['gid']);
if(empty($gid)){
	message('非法访问','','info');
}
//获取商品信息
$goods = pdo_fetch("select * from " .tablename('n1ce_mission_goods'). " where id = :id",array(':id'=>$gid));
$goods_img = unserialize($goods['goods_img']);
//查看任务设置人数
$mission = pdo_get('n1ce_mission_prize',array('uniacid'=>$_W['uniacid'],'rid'=>$rid,'gid'=>$gid),array('miss_num'));
//查询粉丝的任务人数
$people = pdo_get('n1ce_mission_allnumber',array('uniacid'=>$_W['uniacid'],'rid'=>$rid,'from_user'=>$from_user),array('allnumber'));
//是否已经兑换
$exchange = pdo_get('n1ce_mission_order',array('uniacid'=>$_W['uniacid'],'rid'=>$rid,'from_user'=>$from_user,'gid'=>$gid),array('id','status'));
if(($people['allnumber'] - $mission['miss_num']) >= 0){
	$num = 0;
}else{
	$num = $mission['miss_num'] - $people['allnumber'];
}
if($exchange['id']){
	$num = -1;
}
$address = $_W['siteroot'].'app/'.str_replace('./', '', $this->createMobileUrl('address',array('rid'=>$rid,'gid'=>$gid,'from_user'=>$from_user)));

include $this->template('n1ce_goods');