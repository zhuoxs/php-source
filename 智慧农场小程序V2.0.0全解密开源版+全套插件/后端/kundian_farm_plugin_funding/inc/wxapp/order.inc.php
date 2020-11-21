<?php

defined("IN_IA")or exit("Access Denied");
!defined('ROOT_PATH_FARM_FUND') && define('ROOT_PATH_FARM_FUND', IA_ROOT . '/addons/kundian_farm_plugin_funding/');
require_once ROOT_PATH_FARM_FUND .'model/order.php';
require_once ROOT_PATH_FARM_FUND .'model/project.php';
$orderModel=new Order_KundianFarmPluginFundingModel('cqkundian_farm_plugin_funding_order');
$projectModel=new Project_KundianFarmPluginFundingModel('cqkundian_farm_plugin_funding_project');
global $_W,$_GPC;
$op=$_GPC['op'] ? $_GPC['op'] : 'getOrderData';
$uniacid=$_GPC['uniacid'];
$uid=$_GPC['uid'];

if($op=='getOrderData'){
	$request=array();
	if(empty($_GPC['page'])){
		$page=1;
	}else{
		$page=$_GPC['page'];
	}
	$condition=array('uid'=>$uid, 'uniacid'=>$uniacid,'is_recycle'=>0);
	$currentIndex=$_GPC['currentIndex'];
	if($currentIndex==2){
	    $condition['is_pay']=0;
    }elseif ($currentIndex==3){
	    $condition['is_pay']=1;
	    $condition['is_send']=0;
    }elseif ($currentIndex==4){
	    $condition['is_pay']=1;
	    $condition['is_send']=1;
	    $condition['is_confirm']=0;
    }
	$orderData=$orderModel->getFundOrder($condition,$page,10);
    for ($i=0; $i <count($orderData) ; $i++) {
         $project=$projectModel->getProjectById($orderData[$i]['pid'],$uniacid);
        $spec=$projectModel->getProjectSpec($orderData[$i]['spec_id'],false);
		 $project['profit_send_time']=date("Y-m-d",$project['profit_send_time']);
		 if($orderData[$i]['is_return']==1){
             $project['profit_send_time']=date("Y-m-d",$orderData[$i]['return_time']);
         }
		 $orderData[$i]['project']=$project;
		 $orderData[$i]['spec']=$spec;
		 $orderData[$i]=$orderModel->neatenOrder($orderData[$i]);
	}
	$request['orderData']=$orderData;
	echo json_encode($request);die;
}

if($op=='cancelOrder'){
    $orderid=$_GPC['orderid'];
    $condition=array('id'=>$orderid,'uniacid'=>$uniacid);
    $orderData=$orderModel->getOrderById($orderid,$uniacid);
    if($orderData['is_pay']==0){
        $updateData=array('apply_delete'=>2);
        $res=$orderModel->updateFundOrder(array('apply_delete'=>2),$condition);
        echo $res ? json_encode(array('code'=>1,'msg'=>'取消成功')) : json_encode(array('code'=>1,'msg'=>'取消失败'));
    }else{
        $res=$orderModel->updateFundOrder(array('apply_delete'=>1),$condition);
        echo $res ? json_encode(array('code'=>1,'msg'=>'退款申请已提交')) : json_encode(array('code'=>1,'msg'=>'申请失败'));
    }
}

if($op=='confirmOrder'){
    $orderid=$_GPC['orderid'];
    $updateData=array('is_confirm'=>1,'confirm_time'=>time());
    $res=$orderModel->updateFundOrder($updateData,array('id'=>$orderid,'uniacid'=>$uniacid));
    echo $res ? json_encode(array('code'=>1,'msg'=>'收货成功')) : json_encode(array('code'=>2,'msg'=>'收货失败'));die;
}

if($op=='orderDetail'){
    $request=array();
    $orderid=$_GPC['orderid'];
    $orderData=$orderModel->getOrderById($orderid,$uniacid);
    $project=$projectModel->getProjectById($orderData['pid'],$uniacid);
    $spec=$projectModel->getProjectSpec(array('id'=>$orderData['spec_id'],'uniacid'=>$uniacid),false);
    $project['profit_send_time']=date("Y-m-d",$project['profit_send_time']);
    if($orderData['is_return']==1){
        $project['profit_send_time']=date("Y-m-d",$orderData['return_time']);
    }
    $orderData['create_time']=date("Y-m-d H:i:s",$orderData['create_time']);
    $orderData['project']=$project;
    $orderData['spec']=$spec;
    $orderData=$orderModel->neatenOrder($orderData);
    $orderData['address']=unserialize($orderData['address']);
    $request['orderData']=$orderData;
    echo json_encode($request);die;
}




