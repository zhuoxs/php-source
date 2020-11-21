<?php
$orderno = $_GPC['mid'];
$result = $_GPC['result'];
$order = pdo_fetch("select * from".tablename('tg_order')."where uniacid='{$_W['uniacid']}' and orderno = '{$orderno}'"); // 二维码是根据orderno生成的
$goods = model_goods::getSingleGoods($order['g_id'], '*');
$all_stores = pdo_fetchall("select id from" . tablename('tg_store') . "where uniacid='{$_W['uniacid']}' and status=1");
$is_hexiao_member = FALSE;
$store = array();
$store_ids=array();
if(!empty($goods['hexiao_id'])) $store_ids = $goods['hexiao_id']; 
if(empty($store_ids)) {
	foreach($all_stores as $key=>$value){
		$store_ids[] = $value['id'];
	}
}
$con = '';
if(!empty($goods['merchantid'])){
	$con .=  " and merchantid={$goods['merchantid']}";
}
 //*判断是否是核销人员*/
$hexiao_member = pdo_fetch("select * from".tablename('tg_saler')."where openid='{$_W['openid']}' and  uniacid='{$_W['uniacid']}' and status=1  {$con} ");
if($hexiao_member){
	if($hexiao_member['storeid']==''){
		$store = $store_ids;
		$is_hexiao_member = TRUE;
	}else{
		$hexiao_ids = explode(',', substr($hexiao_member['storeid'],0,strlen($hexiao_member['storeid'])-1)); //核销员属于门店的id
		foreach($hexiao_ids as$key=> $value){
			if(in_array($value,$store_ids)){
				$store[] = $value;
				$is_hexiao_member = TRUE;
			}
		}
	}
	if(!empty($hexiao_member['merchantid']) && !empty($goods['merchantid'])){
		if($hexiao_member['merchantid'] != $goods['merchantid']){
			$is_hexiao_member = FALSE;
		}
	}
}
//门店信息
foreach($store as$key=>$value){
	if($value) $stores[$key] =  pdo_fetch("select * from".tablename('tg_store')."where id ='{$value}' and uniacid='{$_W['uniacid']}'");
}

if($_W['isajax']){
	$storeid = $_GPC['storeid'];
	$now = time();
	if($goods['hexiaolimittime']){
		if($goods['hexiaolimittimetype'] == 1){
			$if = $goods['hexiaolimittime'] - time();
		}
		if($goods['hexiaolimittimetype'] == 2){
			$if =$order['ptime'] + $goods['hexiaolimittime']*24*3600 - $now;
		}
		if($if<0){
			die(json_encode(array('errno'=>1,'message'=>'商品已过提货时间！')));
		}
	} 
	if($order['is_hexiao']==2){
		die(json_encode(array('errno'=>1,'message'=>'该订单已核销！')));
	}elseif($order['status']!=2){
		die(json_encode(array('errno'=>1,'message'=>'订单状态错误！')));
	}else{
		if(pdo_update('tg_order',array('status'=>4,'is_hexiao'=>2,'veropenid' => $_W['openid'],'sendtime'=>TIMESTAMP,'gettime'=>TIMESTAMP,'storeid'=>$storeid),array('orderno'=>$orderno))){
			pdo_insert("tg_merchant_money_record",array('merchantid'=>$order['merchantid'],'uniacid'=>$_W['uniacid'],'money'=>$order['price'],'orderid'=>$order['id'],'createtime'=>TIMESTAMP,'type'=>2,'detail'=>'二维码核销成功：核销订单号：'.$order['orderno']));
			if($order['pay_type']!=4)model_merchant::updateNoSettlementMoney($order['price'], $order['merchantid']);//更新可结算金额
			Util::deleteCache('order', $order['id']);
			message::comment_notice($order['id']);
			die(json_encode(array('errno'=>0,'message'=>'核销成功！')));
		}else{
			die(json_encode(array('errno'=>2,'message'=>'核销失败！')));
		}
	}
	
}
$qrcodeurl = urlencode($_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&m=feng_fightgroups&do=order&ac=check&mid=' . $order['orderno']);
include wl_template('order/check');