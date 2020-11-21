<?php
/**
 * [weliam] Copyright (c) 2016/3/23
 * paytype.ctrl
 * 支付方式控制器
 */
defined('IN_IA') or exit('Access Denied');
session_start();
wl_load()->model('setting');

$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$wlUserAgent = WL_USER_AGENT; //用户进入方式。
$pagetitle = '支付方式'; //title。
$orderid = $_GPC['orderid']; //支付订单ID。

if($config['paytype']['balancestatus']==2){ //开启余额支付，获取余额。
	wl_load()->model('credit');
	$tgsetting=setting_get_by_name("member");
	$credit_type = $tgsetting['credit_type']?$tgsetting['credit_type']:1; //$credit_type=1为微擎积分余额。
	load()->model('mc');
	$uid = mc_openid2uid($_W['openid']);
	$credit=credit_get_by_uid($uid,$credit_type);
	$credit['credit2'] = $credit['credit2']>0?$credit['credit2']:0.00;
}


$creditType = $_GPC['creditType']?$_GPC['creditType']:'pay'; // =recharge为余额充值。
if($creditType=='recharge'){ //余额充值订单
	$goods['gname'] = $pagetitle = '余额充值';
	$order = pdo_fetch("select * from".tablename('tg_credit1rechargerecord')."where id={$orderid}");
	$order['pay_price'] = $order['num']; // 兼容：无论app还是微信充值 充值金额 都为 $order['pay_price']。
	$config['paytype']['balancestatus'] = $setting['helpbuy'] = $config['paytype']['deliverystatus'] = 0; //若为余额充值仅允许微信支付，其他支付置空。
}else{ //支付订单
	$order = model_order::getSingleOrder($orderid, '*');
	$goods = model_goods::getSingleGoods($order['g_id'], '*');
}
if($goods['is_hexiao']==3 && $order['lotteryid']>0)  $setting['helpbuy'] = $config['paytype']['deliverystatus'] = 0; //若为抽奖订单仅允许微信和余额支付，其他支付置空。
$_SESSION['goodsid'] = $order['g_id'];
if($order['status']!=0 && $order['status']!=5)wl_message("该订单已支付了."); // 判断订单是否已支付。
$attach = $_W['uniacid']."/".$order['orderno']; //app附带参数。

if(empty($order['openid'])){ //兼容缓存中openid为空的订单。
	Util::deleteCache('order', $orderid);
	$order = model_order::getSingleOrder($orderid, '*');
}

if($op =='display'){
	$helppay = FALSE; //是否代付。
	$setting=setting_get_by_name("helpbuy"); //代付设置。
	if($setting['helpbuy']==1){ // 代付开启且不为抽奖商品。
		$helpbuy_message = pdo_fetch("select name from".tablename('tg_helpbuy')."where uniacid={$_W['uniacid']}  order by rand() limit 1");
		$message = !empty($helpbuy_message['name'])?$helpbuy_message['name']:'等待真爱路过...';
		$config['share']['share_title'] = "我想对你说:";
		$config['share']['share_desc'] = $message;
		$config['share']['share_url'] = app_url('pay/paytype', array('orderid'=>$orderid));
		$config['share']['share_image'] = $goods['gimg'];
		if($order['openid']!=$_W['openid']){ //若支付的openid与订单openid不一致则为代付。
			wl_load()->model("member");
			$member = member_get_by_params(" openid='{$order['openid']}' ");
			$helppay = TRUE;
		}
	}
	include wl_template('pay/paytype');
}
if ($_W['isajax'] && $op =='ajax') {
	if($creditType == 'recharge') die(json_encode(array('errno'=>0,'message'=>"验证成功."))); //若为余额充值 直接返回验证成功。
	
	$ifGroup = $order['is_tuan']==1?1:0;
	$canBuyInfo = model_goods::ifCanBuy($order['g_id'], $_W['openid'], $order['gnum'], $ifGroup);//判断是否可买。
	
	if($canBuyInfo[0]) die(json_encode(array('errno'=>5,'message'=>$canBuyInfo[1]))); //不能购买返回验证。
	
	if($fansInfo['follow'] !=1 &&  $config['base']['guanzhu_buy']==2) die(json_encode(array('errno'=>4,'message'=>"您还未关注,不能购买.")));//$fansInfo在index.php,用户信息。
	
	$nowtuan = model_group::getSingleGroup($order['tuan_id'], '*'); //当前团情况。
	if(!empty($nowtuan) && $nowtuan['groupstatus'] != 3) //验证团是否结束。
		die(json_encode(array('errno'=>1,'message'=>"此团已结束,是否重新开团？",'url'=>app_url('order/orderconfirm',array('groupnum'=>$nowtuan['neednum'],'id'=>$nowtuan['goodsid'],'newtuan'=>'newtuan')))));
	
	if($order['ordertype']==1) //已被代付。
		die(json_encode(array('errno'=>2,'message'=>"此订单已被代付,去开团？",'url'=>app_url('order/orderconfirm',array('groupnum'=>$nowtuan['neednum'],'id'=>$nowtuan['goodsid'],'newtuan'=>'newtuan')))));
	
	if($goods['g_type']==3){  //抽奖团
		$lottery=pdo_fetch("select * from".tablename("tg_lottery")."where uniacid={$_W['uniacid']} and fk_goodsid={$goods['id']}");
		if($lottery['one_limit']==2){
			$ifbuy = pdo_fetch("select * from".tablename("tg_order")."where lotteryid={$lottery['id']} and status in(1,2,3,4,6) and openid = '{$_W['openid']}'");
			if($ifbuy) die(json_encode(array('errno'=>6,'message'=>"该活动不允许重复参与!")));
		}
	}
	pdo_update('tg_order',array('message'=>$_GPC['remark'],'othername'=>$_GPC['othername']), array('id'=>$orderid)); //若一切验证通过，若为代付更新代付信息。
	die(json_encode(array('errno'=>0,'message'=>"验证成功.")));
}

