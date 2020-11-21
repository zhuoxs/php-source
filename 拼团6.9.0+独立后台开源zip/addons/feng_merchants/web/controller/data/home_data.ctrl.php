<?php
	wl_load()->model('order');
	wl_load()->model('goods');
	$goods = goods_get_list(' and merchantid = '.MERCHANTID);
	$pv = 0;
	$uv = 0;
	foreach($goods['list'] as$key=>$value){
		$data1 = pdo_fetchall("select id from".tablename('tg_puv_record')."where uniacid={$_W['uniacid']} and goodsid={$value['id']}");
		$pv +=  count($data1);
		$data2 = pdo_fetchall("select distinct openid from".tablename('tg_puv_record')."where uniacid={$_W['uniacid']} and goodsid={$value['id']}");
		$uv +=  count($data2);
	}
	$data['pv'] = $pv;
	$data['uv'] = $uv;
	$orders = pdo_fetchall("select id from".tablename('tg_order')."where uniacid={$_W['uniacid']} and status in(0,1,2,3,4,6,7) and merchantid=".MERCHANTID);
	$ordersnum = count($orders);
//	wl_debug($orders);
	$money = 0;
	foreach($orders as$key=>$value){
		$money += $value['price'];
	}
	$ypv = 0;
	$yuv = 0;
	$yorders1 = 0;
	$yorders2 = 0;
	$yorders3 = 0;
	$ystd = strtotime('-1 day');$ystd = date("Y-m-d", $ystd);$ystd = strtotime($ystd." 00:00"); 
	$today=strtotime(date('Y-m-d'));
	foreach($goods['list'] as$key=>$value){
		$yesterdaypv = pdo_fetchall("select id from".tablename('tg_puv_record')."where uniacid={$_W['uniacid']} and createtime>'{$ystd}' and createtime<'{$today}' and goodsid={$value['id']}");
		$ypv += count($yesterdaypv);
		$yesterdayuv = pdo_fetchall("select distinct openid from".tablename('tg_puv_record')."where uniacid={$_W['uniacid']} and createtime>'{$ystd}' and createtime<'{$today}' and goodsid={$value['id']}");
		$yuv += count($yesterdayuv);
	}
	$yesterdayorders1 =  pdo_fetchall("select id from".tablename('tg_order')."where uniacid={$_W['uniacid']} and ptime>'{$ystd}' and ptime<'{$today}' and status in('1,2,3,4,6,7') and merchantid=".MERCHANTID);
	$yorders1 = count($yesterdayorders1);
	$yesterdayorders2 =  pdo_fetchall("select id from".tablename('tg_order')."where uniacid={$_W['uniacid']} and successtime >'{$ystd}' and successtime<'{$today}' and status in('1,2,3,4,6,7') and merchantid=".MERCHANTID);
	$yorders2 = count($yesterdayorders2);
	$yesterdayorders3 =  pdo_fetchall("select id from".tablename('tg_order')."where uniacid={$_W['uniacid']} and sendtime>'{$ystd}' and sendtime<'{$today}' and status in('1,2,3,4,6,7')  and merchantid=".MERCHANTID);
	$yorders3 = count($yesterdayorders3);
	include wl_template('data/home_data');