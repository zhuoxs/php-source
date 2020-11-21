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
	exit(json_encode(array('code' => 404, 'msg' => '你还未生成海报')));
}
$gid = trim($_GPC['gid']);
if(empty($gid)){
	exit(json_encode(array('code' => 404, 'msg' => '非法访问')));
}
//查看任务设置人数
$mission = pdo_get('n1ce_mission_prize',array('uniacid'=>$_W['uniacid'],'rid'=>$rid,'gid'=>$gid),array('miss_num'));
//获取商品信息
$goods = pdo_fetch("select * from " .tablename('n1ce_mission_goods'). " where id = :id",array(':id'=>$gid));
if($goods['quality'] <= 0){
	exit(json_encode(array('code' => 404, 'msg' => '手太慢, 已经兑换一空')));
}
//查询粉丝的任务人数
$people = pdo_get('n1ce_mission_allnumber',array('uniacid'=>$_W['uniacid'],'rid'=>$rid,'from_user'=>$from_user),array('allnumber'));
if($people['allnumber'] < $mission['miss_num']){
	exit(json_encode(array('code' => 404, 'msg' => '你还未达到兑换条件')));
}

$exchange = pdo_get('n1ce_mission_order',array('uniacid'=>$_W['uniacid'],'rid'=>$rid,'from_user'=>$from_user,'gid'=>$gid),array('id'));
if($exchange['id']){
	exit(json_encode(array('code' => 404, 'msg' => '非法访问')));
}
$goods = pdo_fetch("select * from " .tablename('n1ce_mission_goods'). " where id = :id",array(':id'=>$gid));
$data = array(
	'uniacid' => $_W['uniacid'],
	'rid' => $rid,
	'gid' => $gid,
	'from_user' => $from_user,
	'nickname' => $userInfo['nickname'],
	'headimgurl' => $userInfo['avatar'],
	'realname' => $_GPC['fullName'],
	'mobile' => $_GPC['tel'],
	'residedist' => $_GPC['residedist'],
	'sign' => time().$from_user,
	'tid' => time() . rand(1000, 2000),
	'fee' => $goods['get_price'] + $goods['postage'],
	'time' => time(),
);
file_put_contents(IA_ROOT . "/api/pay.log", var_export($data, true) . PHP_EOL, FILE_APPEND);//打印信息调试
pdo_insert('n1ce_mission_orderlog',$data);
if(pdo_insertid()){
	//$fee = ($goods['get_price'] + $goods['postage'])/100;
	exit(json_encode(array('code' => 101, 'orderid'=> pdo_insertid())));
}else{
	exit(json_encode(array('code' => 404, 'msg' => '重复请求')));
}