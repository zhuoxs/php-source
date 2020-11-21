<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/25 0025
 * Time: 09:25
 */
defined("IN_IA")or exit("Access Denied");
!defined('ROOT_PATH') && define('ROOT_PATH', IA_ROOT . '/addons/kundian_farm/');
include ROOT_PATH.'inc/wxapp/function.inc.php';
include ROOT_PATH.'inc/common/common.func.php';
global $_W,$_GPC;
$uniacid=$_W['uniacid'];
$op=$_GPC['op'] ? $_GPC['op'] : "index";
$uid=$_GPC['uid'];

if($op=='getYunDevice'){
    $result=getYunDeviceInfo($uniacid);
    $list=object_to_array($result);
    echo json_encode(array('deviceData'=>$list));die;
}

if($op=='getRelays'){
    $result=getRelays($uniacid);
    $list=object_to_array($result);
    echo json_encode(array('relays'=>$list['Relays']));die;
}

if($op=='controlRelays'){
    $id=$_GPC['id'];
    $status=$_GPC['status'];
    require_once ROOT_PATH.'inc/common/common.func.php';
    if($status==1){
        $res=controlRelays($uniacid,$id,0);
    }else{
        $res=controlRelays($uniacid,$id,1);
    }
    if($res==1){
        echo json_encode(array('code'=>1,'msg'=>'操作成功'));
    }else{
        echo json_encode(array('code'=>2,'msg'=>'操作失败'));
    }
}
