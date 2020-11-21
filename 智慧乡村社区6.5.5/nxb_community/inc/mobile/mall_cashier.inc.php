<?php
global $_W,$_GPC;
include 'common.php';

$mid=intval($_GPC['mid']);
$g_num=intval($_GPC['g_num']);
$g_id=intval($_GPC['g_id']);
$g_sid=intval($_GPC['g_sid']);
$g_aid=intval($_GPC['g_aid']);
$orid=intval($_GPC['orid']);
$remark=$_GPC['remark'];

//通过mid获取商户信息
$seller=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_seller')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$g_sid));
if(empty($seller)){
	echo json_encode(array('status'=>0,'log'=>'商户信息不正确'));
}
//获取商品信息
$product=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_goods')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$g_id));
if(empty($product)){
	echo json_encode(array('status'=>0,'log'=>'产品信息不正确'));
}

//获取地址信息
$address=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_address')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$g_aid));
if(empty($address)){
	echo json_encode(array('status'=>0,'log'=>'收货地址不正确'));
}

//计算运费和总价
$order_yf=$product['addyf']*($g_num-1)+$product['baseyf'];
$orderprice=$product['price']*$g_num;
$order_amount=$product['price']*$g_num+$order_yf;
//订单快照
$order_kz="商品ID:".$g_id." 商品标题:".$product['ptitle']." 单价:".$product['price']." 购买数量:".$g_num.", 收货人:".$address['contacts'].", 联系电话:".$address['mobile'].", 收货地址:".$address['city'].$address['address']." 订单创建时间:".gettime(time());                           

if($orid!=0){

	$order=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_orders')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$orid));
	if($order){


	//更新订单状态
	$data = array(
		
		'poinfo'=>$order_kz,
		'pnum'=>$g_num,
		'oneprice'=>$product['price'],
		'goodsprice'=>$orderprice,
		'yf'=>$order_yf,
		'orderprice'=>$order_amount,
		'shuser'=>$address['contacts'].' '.$address['mobile'],
		'shaddress'=>$address['city'].$address['address'],
		'remark'=>$remark

		);
	$res = pdo_update('bc_community_mall_orders', $data,array('id'=>$orid));

	if($res){
		if($remark!=''){
			echo json_encode(array('status'=>2,'log'=>'已提交订单给商家进行邮费确认','poid'=>$orid));
		}else{
			echo json_encode(array('status'=>1,'log'=>'重新生成订单','poid'=>$orid));
		}
        
    }else{
        echo json_encode(array('status'=>0,'log'=>'重新生成订单失败'));
    }	

	
	}
}else{
	
	
	//生成订单编号
$pocode=date('ymdhis').substr(microtime(),2,4);

	//生成一条状态未支付的订单记录
	$data = array(
		'weid'=>$_W['uniacid'],
		'pocode'=>$pocode,
		'pcover'=>$product['pimg'],
		'poinfo'=>$order_kz,
		'mid'=>$mid,
		'pid'=>$g_id,
		'sid'=>$g_sid,
		'pnum'=>$g_num,
		'oneprice'=>$product['price'],
		'goodsprice'=>$orderprice,
		'yf'=>$order_yf,
		'orderprice'=>$order_amount,
		'postatus'=>9,//未支付订单状态为9
		'remark'=>'',
		'shuser'=>$address['contacts'].' '.$address['mobile'],
		'shaddress'=>$address['city'].$address['address'],
		'express'=>'',
		'poctime'=>time(),
		'potime1'=>0,
		'potime2'=>0,
		'potime3'=>0,
		'potime4'=>0,
		'potime5'=>0,
		'potime6'=>0,
		'danyuan'=>$seller['danyuan'],
		'menpai'=>$seller['menpai'],
		'remark'=>$remark
		);
	$res = pdo_insert('bc_community_mall_orders', $data);
	
	
	
	
	if($res){
		$poid = pdo_insertid();
        if($remark!=''){
			echo json_encode(array('status'=>2,'log'=>'已提交订单给商家进行邮费确认','poid'=>$poid));
		}else{
			echo json_encode(array('status'=>1,'log'=>'生成订单','poid'=>$poid));
		}
    }else{
        echo json_encode(array('status'=>0,'log'=>'生成订单失败'));
    }	

	
	
	
}



	
?>