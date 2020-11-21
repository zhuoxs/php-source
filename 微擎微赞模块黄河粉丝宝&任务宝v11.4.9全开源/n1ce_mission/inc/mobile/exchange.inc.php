<?php
//你这傻逼，你爸爸的代码好看吗，日你妈，MMB
global $_W,$_GPC;
$rid = $_GPC['rid'];
yload()->classs('n1ce_mission', 'fans');
$_fans = new Fans();
$from_user = $_GPC['from_user'];
$userInfo = $_fans->refresh($from_user);
$join = pdo_get('n1ce_mission_qrlog',array('uniacid'=>$_W['uniacid'],'rid'=>$rid,'from_user'=>$from_user),array('id'));
if(empty($join['id'])){
	message('你还未生成海报','','error');
}
$gid = trim($_GPC['gid']);
if(empty($gid)){
	message('非法访问','','info');
}
$notice = $this->module['config'];
if($notice['antispam_enable'] == 1){
	$b = pdo_fetch("SELECT * FROM " . tablename('n1ce_mission_blacklist') . " WHERE from_user=:f AND uniacid=:w LIMIT 1", array(':f'=>$from_user, ':w'=>$_W['uniacid']));
	if($b && $notice['antispam_join'] !== 1){
		message($notice['antispam_word'],'','error');
	}
}
//获取商品信息
$goods = pdo_fetch("select * from " .tablename('n1ce_mission_goods'). " where id = :id",array(':id'=>$gid));
if($goods['quality'] <= 0){
	message('手太慢, 已经兑换一空', '', 'error');
}
//查看任务设置人数
$mission = pdo_get('n1ce_mission_prize',array('uniacid'=>$_W['uniacid'],'rid'=>$rid,'gid'=>$gid),array('miss_num'));
//查询粉丝的任务人数
$people = pdo_get('n1ce_mission_allnumber',array('uniacid'=>$_W['uniacid'],'rid'=>$rid,'from_user'=>$from_user),array('allnumber'));
if($people['allnumber'] < $mission['miss_num']){
	message('你还未达到兑换条件',$this->createMobileUrl('goods',array('rid'=>$rid,'gid'=>$gid)),'info');
}
if(checksubmit()){
	$exchange = pdo_get('n1ce_mission_order',array('uniacid'=>$_W['uniacid'],'rid'=>$rid,'from_user'=>$from_user,'gid'=>$gid),array('id'));
	if($exchange['id']){
		message('你已经兑换过了',$this->createMobileUrl('goods',array('rid'=>$rid,'gid'=>$gid)),'info');
	}
	$data = array(
		'uniacid' => $_W['uniacid'],
		'rid' => $rid,
		'gid' => $gid,
		'from_user' => $from_user,
		'nickname' => $userInfo['nickname'],
		'headimgurl' => $userInfo['avatar'],
		'realname' => $_GPC['fullName'],
		'mobile' => $_GPC['tel'],
		'residedist' => $_GPC['area'].$_GPC['address'],
		'sign' => time().$from_user,
		'time' => time(),
	);
	// var_dump($data);die();
	file_put_contents(IA_ROOT . "/api/error.log", var_export($data, true) . PHP_EOL, FILE_APPEND);//打印信息调试
	pdo_insert('n1ce_mission_order',$data);
	if(pdo_insertid()){
		pdo_update('n1ce_mission_goods',array('quality -='=>1),array('id'=>$gid));
		pdo_update('n1ce_mission_prize',array('prizesum -='=>1),array('uniacid'=>$_W['uniacid'],'gid'=>$gid));
		message('提交成功',$this->createMobileUrl('goods',array('rid'=>$rid,'gid'=>$gid)),'success');
	}else{
		message('重复提交',$this->createMobileUrl('goods',array('rid'=>$rid,'gid'=>$gid)),'error');
	}
}else{
	message('非法访问','','info');
}