<?php 
/**
 * [weliam] Copyright (c) 2016/4/4
 * 阶梯团
 */

defined('IN_IA') or exit('Access Denied');

$ops = array('list', 'create', 'edit', 'ajax');
$op = in_array($op, $ops) ? $op : 'list';
if ($op == 'list') {
	$_W['page']['title'] = '应用和营销  - 赠品列表';
	$data  =   pdo_fetchall("select * from".tablename('tg_gift')."where uniacid={$_W['uniacid']}");
	foreach($data  as$key=>&$value){
		$value['goods'] = model_goods::getSingleGoods($value['goodsid'], '*');
		if($value['starttime']>TIMESTAMP){
			$value['status'] = '未开始';
		}elseif($value['endtime']<TIMESTAMP){
			$value['status'] = '已结束';
		}else{
			$value['status'] = '进行中';
		}
	}
	include wl_template('application/gift/gift_list');
}
if ($op == 'create' || $op == 'edit') {
	if (empty($starttime) || empty($endtime)) {
		$starttime = strtotime('-1 month');
		$endtime = time();
	}
	$id = $_GPC['id'];
	$data =   pdo_fetchall("select * from".tablename('tg_goods')."where uniacid={$_W['uniacid']}");
	if($id){
		$gift =   pdo_fetch("select * from".tablename('tg_gift')."where uniacid={$_W['uniacid']} and id={$id}");
		$gift['goods'] = model_goods::getSingleGoods($gift['goodsid'], '*');
	}
	if (checksubmit('submit')) {
		$time = $_GPC['time'];
		$goods = $_GPC['goods'];
		$goods['uniacid'] = $_W['uniacid'];
		$goods['starttime'] = strtotime($time['start']);
		$goods['endtime'] = strtotime($time['end']);
		if (empty($id)) {
			if(pdo_insert('tg_gift',$goods))
				message('创建成功', web_url('application/gift/list'), 'success');exit;
			
		} else {
			pdo_update('tg_gift',$goods);
			message('修改成功', web_url('application/gift/list'), 'success');exit;
		}
	}
	
	include wl_template('application/gift/gift_edit');
}

if ($op == 'ajax') {
	$id = $_GPC['id'];
	$goods = model_goods::getSingleGoods($id, '*');
	die(json_encode($goods));
}
