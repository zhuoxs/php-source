<?php
/**
 * [weliam] Copyright (c) 2016/3/23
 * 
 * 订单提交控制器
 */
defined('IN_IA') or exit('Access Denied');
wl_load()->model('account');
load()->func('communication');

 
$ops = array('display', 'post','createOrder');
$op = in_array($op, $ops) ? $op : 'display';
$pagetitle = !empty($config['tginfo']['sname']) ? '订单提交 - '.$config['tginfo']['sname'] : '订单提交';
session_start();
$openid = $_W['openid'];
$uid = $_W['member']['uid'];
$mid = pdo_getcolumn('tg_member',array('openid'=>$openid),'id');
$is_usecard = $price = $firstdiscount = $is_tuan = $tuan_first = $pay_price = $discount_fee =  0; //初始化判断参数

$id = $_SESSION['goodsid'] =  isset($_GPC['id']) ? intval($_GPC['id']) : $_SESSION['goodsid'];
$tuan_id = $_GPC['tuan_id']; //团编号 
$groupnum = $_SESSION['groupnum'] = isset($_GPC['groupnum']) ? intval($_GPC['groupnum']) : $_SESSION['groupnum']; // 定制：组团商品数量（单买为-1） 正常：组团人数（单买为1）
//wl_debug($groupnum);
$optionid = $_SESSION['optionid'] = isset($_GPC['optionid']) ? intval($_GPC['optionid']) : $_SESSION['optionid'];
if(empty($_GPC['num'])) $_GPC['num'] = $_SESSION['num']?$_SESSION['num']:1; //若没有传num则取session中的num，session中没有则默认为1
$num = $_SESSION['num'] =  isset($_GPC['num']) ? intval($_GPC['num']) : $_SESSION['num']; //需要购买的商品数量
if(empty($id))wl_message('缺少商品ID，请返回重试！');
if(empty($groupnum))wl_message('缺少组团人数，请返回重试！');
if(empty($num))wl_message('缺少购买数量，请返回重试！');
if($_GPC['newtuan']=='newtuan')$tuan_id=0; //新开团

$ifGroup = $groupnum;//判断是否可买
if($groupnum>1){
	$ifGroup = 1;
}elseif ($groupnum < 0) {
	$ifGroup = -1;
}else {
	$ifGroup = 0;
}
$canBuyInfo = model_goods::ifCanBuy($id, $_W['openid'], $num, $ifGroup);
if($canBuyInfo[0])wl_message($canBuyInfo[1]);

$addrid = isset($_GPC['addrid']) ? intval($_GPC['addrid']) : 0; // 选择地址后地址ID
$goods = model_goods::getSingleGoods($id, '*'); //获取商品信息

if($goods['forcegroup'] && empty($tuan_id) && $groupnum > 1){ //强制成团
	$tuan_id = pdo_fetch("SELECT groupnumber FROM ".tablename('tg_group')."WHERE uniacid = {$_W['uniacid']} AND goodsid = {$id} AND groupstatus = 3  ORDER BY lacknum ASC");
	$tuan_id = $tuan_id['groupnumber'];
}

if($tuan_id){  //查询这个团是否支付成功参加
	$nowtuan = model_group::getSingleGroup($tuan_id, "*");
	if($nowtuan['groupstatus'] != 3) wl_message("该团已结束，请重新开团");
	$myorder = pdo_fetch('select openid from'.tablename('tg_order')."where tuan_id = {$tuan_id} and openid = '{$openid}' and status in(1,2,3,4,6,7)");
	if(!empty($myorder) && $goods['repeatjoin']!=1) $tuan_id = '';
//	if($id != $nowtuan['goodsid']) $id = $_SESSION['goodsid'] = $nowtuan['goodsid'];
}
$goodsimg = !empty($goods['share_image']) ? $goods['share_image'] : $goods['gimg'];
if($goods['group_level_status']==2 && $goods['g_type']!=3){ //阶梯团
	$param_level = unserialize($goods['group_level']);
	foreach($param_level as$k=>$v){
		if($groupnum == $v['groupnum']){
			$goods['gprice'] = $v['groupprice'];
			break;
		}
	}		
}elseif($goods['hasoption']==1){ //规格  && $goods['g_type']!=3
	if (!empty($optionid)) {
		$option = pdo_fetch("select title,productprice,marketprice,costprice from" . tablename("tg_goods_option") . " where id=:id", array(":id" => $optionid));
	}else{
		wl_message('规格ID不存在，请刷新重试！');
	}
	$goods['gprice'] = $option['marketprice'];
	$goods['oprice'] = $option['productprice'];
	$goods['pfprice'] = $option['costprice'];
	$goods['optionname'] = $_W['isajax'] ? $option['title']. "（".$option['costprice']."）" : $option['title'];
}


if($groupnum > 1){ //团购买
	$price = $goods['gprice'];
	$is_tuan = 1;
	if(empty($tuan_id)) $tuan_first = 1;
}elseif ($groupnum == -2) {   //批发价
	$price = $goods['pfprice'];    
}else{  //单独购买
	$price = $goods['oprice'];
}

if($goods['is_discount'] == 1) $firstdiscount = ($goods['firstdiscount']&& $tuan_first)? $goods['firstdiscount']:0; //判断团长优惠

if($goods['is_hexiao'] >= 1 ){ //判断提货点
	if(!empty($goods['hexiao_id'])){
		foreach($goods['hexiao_id'] as$key=>$value){
			if($value){
				$stores_pick[$key]['id'] = $value;
				$stores_pick[$key]['name'] =  pdo_fetchcolumn("select storename from".tablename('tg_store')."where id ={$value} and uniacid={$_W['uniacid']}");
				$stores_pick[$key]['storehours'] =  pdo_fetchcolumn("select storehours from".tablename('tg_store')."where id ={$value} and uniacid={$_W['uniacid']}");
				$stores_pick[$key]['storehours'] = unserialize($stores_pick[$key]['storehours']);
			}
		}
	}else {
		$stores_pick = pdo_getall('tg_store',array('uniacid' => $_W['uniacid'],'merchantid'=>$goods['merchantid']),array('id','storename','storehours'));
		foreach($stores_pick as$key=>&$sto){
			$sto['name'] = $sto['storename'];
			$sto['storehours'] = unserialize($sto['storehours']);
		}
	}
}
//拼团有礼
if($goods['give_coupon_id']){
	$goods['give_coupon_name'] = pdo_getcolumn('tg_coupon_template',array('id'=>$goods['give_coupon_id']),'name');
}
if($goods['give_gift_id']){
	$goods['give_gift_name'] = pdo_getcolumn('tg_goods',array('id'=>$goods['give_gift_id']),'gname');
}

$timesData = model_order::getMemberOrderNumWithGoods($openid, $goods['id']); /*判断购买次数*/
$times=$times[2];

$freightData= model_goods::getFreight($id, $addrid, $openid, $goods,$tuan_id);/*判断地区邮费*/
$shouldFreight = $freight= sprintf("%.2f", $freightData[0]); //运费
$adress_fee=$freightData[1];

if($goods['g_type']==3){  //抽奖团
	$lottery=pdo_fetch("select * from".tablename("tg_lottery")."where uniacid={$_W['uniacid']} and fk_goodsid={$goods['id']}");
	if($lottery['one_limit']==2){
		$ifbuy = pdo_fetch("select * from".tablename("tg_order")."where lotteryid={$lottery['id']} and status in(1,2,3,4,6) and openid = '{$_W['openid']}'");
		if($ifbuy) wl_message('该活动不允许重复参与！');
	}
}
$pay_price = sprintf("%.2f", $price * $num - $firstdiscount);//支付价格(不含邮费)

$dc = $_GPC['dc'] == 'yes'?TRUE:FALSE; //是否积分抵扣
$afterMarketingPrice = model_order::getAfterMarketingPrice($pay_price, $num,$goods['id'], $freight,$dc); //获取营销后的价格等参数
//wl_debug($afterMarketingPrice);
$pay_price = $afterMarketingPrice['pay_price'];  //营销后的价格98.5
$coupon = model_coupon::coupon_canuse($openid,$pay_price,$goods['id']);//获取可用优惠券

$pay_price = sprintf("%.2f", $pay_price + $afterMarketingPrice['payFreight']);//支付价格（含实际支付运费）
$typeid = intval($_GPC['typeid']); //判断自提还是快递
if(empty($typeid) && $goods['is_hexiao']==2) $typeid=2;
if(empty($typeid) && ($goods['is_hexiao']==0 || $goods['is_hexiao']==1)) $typeid=1;
if($typeid == 2 || $typeid==4){ //自提
	$pay_price = $pay_price - $afterMarketingPrice['payFreight']; //自提减去应该支付的运费
	$freight = 0;
}
//wl_debug($typeid);
if($afterMarketingPrice['deductMoney']>=$pay_price) $afterMarketingPrice['m4'] = FALSE;

$pay_price = sprintf("%.2f",$pay_price);

if ($_W['isajax']) {
	if($typeid == 2 || $typeid==4){ //自提
		$is_hexiao = 1;
		$str = Util::createBdeleteNumber();
		if(empty($_GPC['name']))wl_message("未填写提货人姓名");
		if(empty($_GPC['mobile']))wl_message("未填写提货人电话");
		if(empty($_GPC['stores_pick']))wl_message("未选择提货点");
		$adress_fee['cname'] = $_GPC['name'];
		$adress_fee['tel'] = $_GPC['mobile'];
	}
	
	$couponid = intval($_GPC['couponid']);
	if($couponid){
		$coutp = model_coupon::coupon_handle($openid, $couponid, $pay_price);
		if(!is_array($coutp)){
			$pay_price = currency_format($pay_price - $coutp);
			$is_usecard = 1;
			$discount_fee = $coutp;
		}else{
			wl_json(0,$coutp['message']);
		}
	}
	if($goods['g_type']==3){  //抽奖团
		$num = 1;
//		$price = $pay_price = $goods['gprice'];
		$firstdiscount = 0;
		$lottery = pdo_fetch("select id,endtime from".tablename('tg_lottery')."where fk_goodsid={$goods['id']}");
		$goods['endtime'] = $lottery['endtime'];
	}
	
	$dc = $_GPC['dc'];
	if($dc == 'yes'){
		$deduct[0] = $afterMarketingPrice['deductCredit'];
		$deduct[1] = $afterMarketingPrice['deductMoney'];
		$orderMarket['deduct'] = serialize($deduct);
	}
	$orderno = createUniontid();
	$data = array(
		'uniacid'     => $goods['uniacid'],
		'gnum'        => $num,
		'openid'      => $openid,
		'uid'      	  => $uid,
		'mid'         => $mid,
        'ptime'       => '',//支付成功时间
		'orderno'     => $orderno,
		'pay_price'   => $pay_price,
		'goodsprice'  => $price*$num,
		'freight'     => $freight,
		'first_fee'   => $firstdiscount,
		'status'      => 0,//订单状态：0未支,1支付，2待发货，3已发货，4已签收，5已取消，6待退款，7已退款
		'addressid'   => $adress_fee['id'],
		'addresstype' => $adress_fee['type'],//1公司2家庭
		'addname'     => $adress_fee['cname'],
		'mobile'      => $adress_fee['tel'],
		'address'     => $adress_fee['province'].$adress_fee['city'].$adress_fee['county'].$adress_fee['detailed_address'],
		'g_id'        => $id,
		'tuan_id'     => $tuan_id,
		'is_tuan'     => $is_tuan,
		'tuan_first'  => $tuan_first,
		'starttime'   => TIMESTAMP,
		'remark'      => $_GPC['remark'],
		'endtime'     => $goods['endtime'],
		'is_hexiao'   => $is_hexiao,
		'hexiaoma'    => $str,
		'credits'     => $goods['credits'],
		'optionname'  => $goods['optionname'],
		'optionid'    => $optionid,
		'couponid'    => $couponid,
		'is_usecard'  => $is_usecard,
		'discount_fee'=> $discount_fee,
		'createtime'  => TIMESTAMP,
		'bdeltime'    => $bdeltime,
		'merchantid'  => $goods['merchantid'],
		'giftid'=> $goods['give_gift_id'],
		'getcouponid'=> $goods['give_coupon_id'],
		'storeid'=> intval($_GPC['stores_pick']),
		'ordertype'=>$ordertype,
		'marketing'=>serialize($orderMarket)
	);
	if($goods['g_type']==3){ //抽奖团
		$data['lotteryid'] = $lottery['id'];
		$data['lottery_status'] = -1;
	}
	//同步插入订单到芸众商城
	$yunapi = IA_ROOT . '/addons/yun_shop/api.php';
	if (is_file($yunapi)) {
		$post_data = array(
	        'uniacid'     => $goods['uniacid'],
	        'goods_total' => $num,
	        'openid'      => $openid,
	        'uid'      	  => $uid,
	        'mid'         => $mid,
	        'order_sn'    => $orderno,
	        'price'       => $pay_price,
	        'goods_price' => $price*$num,
	        'status'      => 0,//订单状态：0未支,1支付，2待发货，3已发货，4已签收，5已取消，6待退款，7已退款
	        'realname'    => $adress_fee['cname'],
	        'mobile'      => $adress_fee['tel'],
	        'address'     => $adress_fee['province'].$adress_fee['city'].$adress_fee['county'].$adress_fee['detailed_address'],
	        'is_hexiao'   => $is_hexiao,
	        'hexiaoma'    => $str,
	        'province'    => $adress_fee['province'],
	        'city'        => $adress_fee['city'],
	        'county'      => $adress_fee['county'],
	        'detailed_address' => $adress_fee['detailed_address']
	    );
		//post到商城
	    $url = $_W['siteroot'] . 'addons/yun_shop/api.php?i=' .$_W['uniacid'].'&route=plugin.group-purchase.admin.purchase-orders.postOrders';
	    ihttp_request($url, $post_data, array('Content-Type' => 'application/x-www-form-urlencoded'), 1);
	}
	
	pdo_insert('tg_order', $data);
	$orderid = pdo_insertid();
	
//	if($typeid == 2 || $typeid==4) createQrcode::creategroupQrcode($data['orderno']);
	
	if(empty($tuan_id)){
		$torder = pdo_fetch("select id from".tablename('tg_order')."where uniacid={$data['uniacid']} and orderno='{$data['orderno']}'");
		$groupnumber = $torder['id'];
		if($data['is_tuan']==1){
			if(empty($torder)) wl_message("缺少组团人数！"); 
			$starttime = time();
			$endtime = $starttime + $goods['endtime']*3600;
			
			$data2 = array(
				'uniacid'     => $goods['uniacid'],
				'groupnumber' => $groupnumber,
				'groupstatus' => 3,//订单状态,1组团失败，2组团成功，3,组团中
				'goodsid'     => $goods['id'],
				'goodsname'   => $goods['gname'],
				'neednum'     => $groupnum,
				'lacknum'     => $groupnum,
				'starttime'   => $starttime,
				'endtime'     => $endtime,
				'price'       => $price,
				'merchantid'  => $goods['merchantid'],
				'lottery_id'  => $lottery_id,
				'lacktimetip' => $goods['lacktimetip']
			);
			if($goods['g_type']==3){ //抽奖团
				$data2['lottery_id'] = $lottery['id'];
				$data2['endtime'] = $lottery['endtime'];
				$data2['iflottery'] = 1;
				$data2['lottery_status'] = 1;
			}
			pdo_insert('tg_group', $data2);
			pdo_update('tg_order',array('tuan_id' => $groupnumber), array('id' => $groupnumber));
		}
	}
	
	$status = '0';
	if($goods['first_free']==1 && $is_tuan==1 && empty($tuan_id)){
		pdo_update('tg_group', array('lacknum' => $data2['lacknum'] - 1), array('groupnumber' => $orderid));
		pdo_update('tg_order',array('ptime' => TIMESTAMP,'status'=>1,'first_free'=>1), array('id' => $orderid));
		Util::deleteCache('group', $orderid);
		Util::deleteCache('order', $orderid);
		$status = '2';
	}else{
		$status = '1';
	}
	
	die(json_encode(array('orderid'=>$orderid,'status'=>$status)));
}
include wl_template('order/order_confirm');
