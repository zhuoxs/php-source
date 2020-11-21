<?php
/**
 * [weliam] Copyright (c) 2016/3/23
 * order.ctrl
 * 订单控制器
 */
defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'list';
$pagetitle = !empty($config['tginfo']['sname']) ? '我的订单 - '.$config['tginfo']['sname'] : '我的订单';
if($op =='list'){
	$status = $_GPC['status']!=''?$_GPC['status']:'';
	$set = setting_get_list();
	if(empty($set)){
		$settings = $this->module['config'];
	}else{
		$settings = array();
		foreach($set as$key=>$value){
			
			$settingarray= $value['value'];
			if($settingarray){
				foreach($settingarray as $k=>$v){
				$settings[$k] = $v;
			}
			}
			
		}
	}
	$orderstatus = $settings['orderstatus'];	include wl_template('order/order_list');
}
if($op =='ajax'){
	$pindex = $_GPC['page'];
	$psize = $_GPC['pagesize'];
	$where['openid'] = $_W['openid'];
	$where['status<'] = 9;
	if($_GPC['status']!='') $where['status'] = $_GPC['status'];
	$orderData=model_order::getNumOrder('*', $where, 'id desc', $pindex, $psize, 1);
	$data['list'] = $orderData[0]?$orderData[0]:array();
	$data['total'] = count($orderData[0]);
	foreach($data['list'] as $key =>&$vlaue){
		$deteflag = 0;
		$goods = model_goods::getSingleGoods($vlaue['g_id'], '*');
		switch($vlaue['status']){
			case 0:$statusname='待付款';break;
			case 1:$statusname='组团中';break;
			case 2:$statusname=$vlaue['is_hexiao']==0?'待发货':'待消费';break;
			case 3:$statusname=$vlaue['is_hexiao']==0?'已发货':'已消费';break;
			case 4:$statusname=$vlaue['is_hexiao']==0?'已签收':'已消费';break;
			case 5:$statusname='已取消';$deteflag = 1;break;
			case 6:$statusname='待退款';break;
			case 7:$statusname='已退款';break;
			case 9:$statusname='已过期';$deteflag = 1;break;
			default:$statusname='待付款';
		}
		if(!empty($vlaue['lotteryid'])){
			$lottery=1;
			$lottery = pdo_fetch("select * from".tablename('tg_lottery')."where id = {$vlaue['lotteryid']}");
			if($lottery['pattern'] == 2){
				$tuan = pdo_fetch("select * from".tablename('tg_group')."where groupnumber = {$vlaue['tuan_id']}");
				switch($vlaue['lottery_status']){
					case 1: $myStatus = ($tuan['groupstatus']==2)?'未中':'待抽奖';break;
		    		case 2: $myStatus = '中奖';break;
					default:$myStatus = ($tuan['groupstatus']==2)?'组团失败，未能抽奖':'抽奖团组团中';break;
				}
			}else {
				switch($vlaue['lottery_status']){
		    		case 1: $myStatus = $lottery['dostatus']?'未中':'待抽奖';$lottery['dostatus']?$statusname='未中':$statusname='组团成功';break;
		    		case 2: $myStatus = '一等奖';break;
		    		case 3: $myStatus = '二等奖';break;
		    		case 4: $myStatus = '三等奖';break;
		    		case 5: $myStatus = $lottery['dostatus']?'一等奖':'待抽奖';break;
		    		case 6: $myStatus = $lottery['dostatus']?'二等奖':'待抽奖';break;
		    		case 7: $myStatus = $lottery['dostatus']?'三等奖':'待抽奖';break;
					default:$myStatus = $lottery['dostatus']?'组团失败，未能抽奖':'抽奖团组团中';break;
		    	}
			}
			
			$vlaue['myStatus'] = $myStatus;
			if($myStatus == '未中'){
				$deteflag = 1;
			}
		}else{
			$vlaue['myStatus'] = 0;
		}
		$vlaue['sytime'] = 0;
		if(!empty($goods['hexiaolimittime']) && $vlaue['status']==2){
			if($goods['hexiaolimittimetype'] == 1){
				$vlaue['sytime'] = $goods['hexiaolimittime']-time();
			}
			if($goods['hexiaolimittimetype'] == 2){
				$vlaue['sytime'] = $vlaue['ptime']+ $goods['hexiaolimittime']*24*3600-time();
			}
			 
		}
		//评价
		if($goods['comment'] != 2 && $vlaue['status'] == 4){
			$comment = Util::getSingelData('id', 'tg_discuss', array('orderid'=>$vlaue['id']));
			if(empty($comment)){
				$vlaue['tocom'] = 1;
			}else{
				$statusname = '已评价';
				$vlaue['tocom'] = 0;
			}
		}
		$vlaue['gimg'] = $goods['gimg'];
		$vlaue['date'] = date('Y-m-d H:i:s',$vlaue['createtime']);
		$vlaue['name'] = $goods['gname'];
		$vlaue['ga'] = $goods['a'];
		$vlaue['a'] = app_url('order/order/detail',array('id'=>$vlaue['id']));
		$vlaue['qrcodea'] = app_url('order/qrcode',array('id'=>$vlaue['id']));
		$vlaue['statusname'] = $statusname;
		$vlaue['deteflag'] = $deteflag;
		if($vlaue['status'] != 5 && $vlaue['status'] != 0 && $vlaue['is_tuan'] == 1)$vlaue['ta'] = app_url('order/group')."&tuan_id=".$vlaue['tuan_id'];
		if($vlaue['merchantid'])
			$vlaue['merchant_name'] = $goods['merchantname'];
		else
			$vlaue['merchant_name'] = $_W['account']['name'];
		
	}
	die(json_encode($data));
}

if($op =='detail'){
	$id = intval($_GPC['id']);
	if($id){
		$order = model_order::getSingleOrder($id, '*');
		if($_W['openid'] == $order['openid']){
			switch($order['lottery_status']){
				case -1:$order['lottery_status']='抽奖订单组团中';break;
				case 0:$order['lottery_status']='无抽奖资格';break;
				case 1:$order['lottery_status']='待抽奖';break;
				case 2:$order['lottery_status']='一等奖';break;
				case 3:$order['lottery_status']='二等奖';break;
				case 4:$order['lottery_status']='三等奖';break;
				case 5:$order['lottery_status']='一等奖';break;
				case 6:$order['lottery_status']='二等奖';break;
				case 7:$order['lottery_status']='三等奖';break;
				default:$statusname='无';
			}
			$goods = model_goods::getSingleGoods($order['g_id'], '*');
			$order['merchant_name'] = $order['merchantname'];
			if($order['is_hexiao']==1){
				$stores = pdo_fetch("select * from".tablename('tg_store')."where id ='{$order['storeid']}' and uniacid='{$_W['uniacid']}'"); //门店信息
				$stores['storehours'] = unserialize($stores['storehours']);
				$qrcodeurl = urlencode($_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&m=feng_fightgroups&do=order&ac=check&mid=' . $order['orderno']);
			}
			if($order['couponid'] != 0){
				$coupon = model_coupon::coupon_template($order['couponid']);
			}
			if($order['getcouponid']){
				$order['give_coupon_name'] = pdo_getcolumn('tg_coupon_template',array('id'=>$order['getcouponid']),'name');
			}
			if($order['giftid']){
				$order['give_gift_name'] = pdo_getcolumn('tg_goods',array('id'=>$order['giftid']),'gname');
			}
		}else {
			wl_debug('非法路径');			
		}
	}
	include wl_template('order/order_detail');
}

if($op =='cancel'){
	$orderid = $_GPC['orderid'];
	$order = model_order::getSingleOrder($orderid, '*');
	if($orderid && empty($order['ptime'])){
		if(pdo_update('tg_order',array('status' => 5),array('id' => $orderid))){
			Util::deleteCache('order', $orderid);
//			$goods = model_goods::getSingleGoods($order['g_id'], 'gname');;
//			message::cancelorder($_W['openid'], $order['pay_price'], $goods['gname'], $orderid, '');
			wl_json(1);
		}else{
			wl_json(0,'取消订单失败！');
		}
	}else{
		wl_json(0,'缺少订单号');
	}
}

if($op =='delete'){
	$orderid = $_GPC['orderid'];
	$order = model_order::getSingleOrder($orderid, '*');
	if($orderid){
		if(pdo_update('tg_order',array('status' => 10),array('id' => $orderid))){
			Util::deleteCache('order', $orderid);
			wl_json(1);
		}else{
			wl_json(0,'删除订单失败！');
		}
	}else{
		wl_json(0,'缺少订单号');
	}
}

if($op =='topay'){
	$orderid = $_GPC['orderid'];
	if($orderid){
		$order = model_order::getSingleOrder($orderid, '*');
		if($order['status'] == 0){
			$goods = model_goods::getSingleGoods($order['g_id'], '*');
			if($goods['isshow'] == 1){
				wl_json(1);
			}else{
				wl_json(0,'商品已下架或售罄');
			}
		}else{
			wl_json(0,'订单状态错误');
		}
	}else{
		wl_json(0,'缺少订单号');
	}
}

if($op =='receipt'){
	$orderid = $_GPC['orderid'];
	$order = model_order::getSingleOrder($orderid, '*');
	if($orderid){
		if(pdo_update('tg_order',array('status' => 4),array('id' => $orderid))){
			if($order['is_tuan']==1){
				$group = model_group::getSingleGroup($order['tuan_id'],"*");
				/*查询是否所有人都收货完成*/
				$goods = model_goods::getSingleGoods($order['g_id'], '*');
				if($goods['randrefundstatus']==1 && $goods['randrefundnum']>0){
					$tuan = pdo_fetchall("select id,status,price from".tablename('tg_order')."where tuan_id='{$order['tuan_id']}' and status=4");
					if(count($tuan) == $group['neednum']){
						//收货人数等于团人数
						//随机退款
						$orderRefund = array_rand($tuan,$goods['randrefundnum']);
						if(is_array($orderRefund)){
							foreach($orderRefund as $item){
								$thisOrder = $tuan[$item];
								model_order::refundMoney($thisOrder['id'], $thisOrder['price'], '商品活动，随机退款！');
								pdo_update('tg_order',array('adminremark'=>'商品活动，随机退款单'),array('id'=>$thisOrder['id']));
							}
						}else{
							$thisOrder = $tuan[$orderRefund];
							model_order::refundMoney($thisOrder['id'], $thisOrder['price'], '商品活动，随机退款！');
							pdo_update('tg_order',array('adminremark'=>'商品活动，随机退款单'),array('id'=>$thisOrder['id']));
						}
					}
				}
			}
			//同步订单状态到芸众商城
			$yunapi = IA_ROOT . '/addons/yun_shop/api.php';
			if (is_file($yunapi)) {
				$post_data = array('status' => 3,'order_sn' => $order['orderno']);
				//post到商城
	            $url = $_W['siteroot'] . 'addons/yun_shop/api.php?i=' .$_W['uniacid'].'&route=plugin.group-purchase.admin.purchase-orders.completeOrder';
	            ihttp_request($url, $post_data, array('Content-Type' => 'application/x-www-form-urlencoded'), 1);
			}
			message::comment_notice($orderid);
			wl_json(1);
		}else{
			wl_json(0,'确认收货失败！');
		}
	}else{
		wl_json(0,'缺少订单号');
	}
}

if($op =='tip'){
	$now = time();
	$addresss = Util::getCache('orderTip','update2');
	if(empty($addresss) || ($now - $addresss['time'])>24*3600){
		$addresss = pdo_fetchall("SELECT openid FROM".tablename('tg_order')."WHERE openid<>'' and mobile<>'虚拟' limit 1,10000");
		$addresss['time'] = time();
		Util::setCache('orderTip','update2',$addresss);
	}
	$index = rand(0,count($addresss)-2);
	$address = $addresss[$index] ;
	$member = pdo_fetch("select nickname,avatar from ".tablename('tg_member')." where  openid='{$address['openid']}'");
	$list['nickname'] = mb_substr($member['nickname'], 0,4,'utf-8');	
	$list['avatar'] = $member['avatar'];	
	$list['city'] = mb_substr($address['address'], 0,4,'utf-8');
	$sec = rand(1,10);
	$list['sec'] = $sec;
	die(json_encode($list));
}
