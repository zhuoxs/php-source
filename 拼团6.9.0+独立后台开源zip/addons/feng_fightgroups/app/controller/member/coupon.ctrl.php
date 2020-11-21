<?php
/**
 * [weliam] Copyright (c) 2016/3/23
 * coupon.ctrl
 * 优惠券控制器
 */
defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$openid = $_W['openid'];
if($op =='display'){
	$where1 = "SELECT * FROM ".tablename('tg_coupon').' WHERE `openid` = :openid AND `use_time` != 0 ORDER BY `end_time` DESC ';
	$params1 = array(
		':openid' => $openid
	);
	//已过期
	$where2 = "SELECT * FROM ".tablename('tg_coupon').' WHERE `openid` = :openid AND `use_time` < :use_time AND `end_time` < :time ORDER BY `end_time` DESC ';
	$params2 = array(
		':openid' => $openid,
		':use_time' => 0,
		':time' => TIMESTAMP
	);
	//未使用
	$where3 = "SELECT * FROM ".tablename('tg_coupon').' WHERE `openid` = :openid AND `use_time` = :use_time AND `start_time` < :now1 AND `end_time` > :now2 ORDER BY `end_time` DESC ';
	$params3 = array(
		':openid' => $openid,
		':use_time' => 0,
		':now1' => TIMESTAMP,
		':now2' => TIMESTAMP
	);
	$pagetitle = !empty($config['tginfo']['sname']) ? '优惠券列表 - '.$config['tginfo']['sname'] : '优惠券列表';
	$coupon1 = pdo_fetchall($where1, $params1);
	if($coupon1){
		foreach ($coupon1 as $key1 => $value1) {
			$coupon1[$key1]['end_time'] = date('Y-m-d', $value1['end_time']);
		}
	}
	$coupon2 = pdo_fetchall($where2, $params2);
	if($coupon2){
		foreach ($coupon2 as $key2 => $value2) {
			$coupon2[$key2]['end_time'] = date('Y-m-d', $value2['end_time']);
		}
	}
	$coupon3 = pdo_fetchall($where3, $params3);
	if($coupon3){
		foreach ($coupon3 as $key3 => $value3) {
			$coupon3[$key3]['end_time'] = date('Y-m-d', $value3['end_time']);
		}
	}
	include wl_template('member/coupon_list');
}

if($op =='detail'){
	$id = $_GPC['id'];
	if(empty($_GPC['id'])) wl_message('优惠券不存在！');
	$coupon = model_coupon::coupon($_GPC['id']);
	$pagetitle = $coupon['name'];
	include wl_template('member/coupon_detail');
}

if($op =='get'){
	$id = $_GPC['id'];
	if(empty($_GPC['id'])) wl_message('优惠券不存在！');
	$coupon = model_coupon::coupon_templates($_GPC['id']);
	$pagetitle = $coupon['name'];
	include wl_template('member/coupon_get');
}

if($op =='post'){
	$id = $_GPC['id'];
	if(empty($_GPC['id'])) wl_json(0,'缺少优惠券id参数');
	$coupon = model_coupon::coupon_grant($openid,$_GPC['id']);
	if($coupon['errno'] != 1)
		wl_json(1);
	else
		wl_json(0,$coupon['message']);
}

if($op =='used'){
	$id = $_GPC['id'];
	if(empty($_GPC['id'])) wl_json(0,'缺少优惠券id参数');
	$coupon = model_coupon::coupon($_GPC['id']);
	$time = $coupon['use_time'] +1;
	$res = pdo_update('tg_coupon',array('use_time' => $time),array('id' => $id));
	if($res){
		wl_json(1);
	}else{
		wl_json(0);
	}
		
}