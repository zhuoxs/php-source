<?php
/**
 * [weliam] Copyright (c) 2016/3/23
 * goods.ctrl
 * 我的团控制器
 */
defined('IN_IA') or exit('Access Denied');
$_SESSION['goodsid']='';
$_SESSION['tuan_id']='';
$_SESSION['groupnum']='';
$op = $_GPC['op'];
$content = '';
$pagetitle = !empty($config['tginfo']['sname']) ? '我的团 - '.$config['tginfo']['sname'] : '我的团';
if(!empty($op))
	$where['groupstatus'] = $op;
else
	$where['groupstatus'] = 3;
$reslut = $_GPC['result'];
$share_data = $this->module['config'];
$ordersData=model_order::getNumOrder('*', array('openid'=>$_W['openid'],'#is_tuan#'=>'(1,2,3)','#status#'=>'(1,2,3,4,6,7)'), 'ptime desc', 0, 0, 0);
$orders = $ordersData[0];
foreach ($orders as $key => $order) {
	$goods = model_goods::getSingleGoods($order['g_id'], '*');
	Util::deleteCache('group', $order['tuan_id']);
	$thistuan = model_group::getSingleGroup($order['tuan_id'], '*',$where);
	if(empty($thistuan)){
		unset($orders[$key]);
	}else{
		$orders[$key]['groupnum'] = $goods['groupnum'];
		if(!empty($thistuan['price']))
			$orders[$key]['gprice'] = $thistuan['price'];
		else
			$orders[$key]['gprice'] = $goods['gprice'];
		$orders[$key]['gid'] = $goods['id'];
		$orders[$key]['gname'] = $goods['gname'];
		$orders[$key]['gimg'] = $goods['gimg'];
        $orders[$key]['itemnum'] = $thistuan['lacknum'];
		$orders[$key]['groupstatus'] = $thistuan['groupstatus'];
	}
}
include wl_template('order/mygroup');