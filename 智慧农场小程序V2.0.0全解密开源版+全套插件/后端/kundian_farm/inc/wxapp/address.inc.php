<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/17 0017
 * Time: 下午 4:14
 */
defined("IN_IA")or exit("Access denied");
global $_GPC,$_W;
$uniacid=$_GPC['uniacid'];
$op=$_GPC['op'] ? $_GPC['op'] :"address_list";
$uid=$_GPC['uid'];
if($op=='address_list'){
    $request=array();
    $addressData=pdo_getall('cqkundian_farm_address',array('uniacid'=>$uniacid,'uid'=>$uid));
    $request['addressData']=$addressData;
    echo json_encode($request);die;
}

//添加/编辑地址信息
if($op=='add_address'){
    $data=array(
        'name'=>$_GPC['name'],
        'address'=>$_GPC['address'],
        'phone'=>$_GPC['phone'],
        'region'=>$_GPC['region'],
        'uid'=>$uid,
        'uniacid'=>$uniacid,
        'is_default'=>$_GPC['is_default'],
    );
    if($_GPC['is_default']==1){
        pdo_update('cqkundian_farm_address',array('is_default'=>0),array('uid'=>$uid,'uniacid'=>$uniacid));
    }
    if(empty($_GPC['aid'])) {
        $res = pdo_insert('cqkundian_farm_address', $data);
    }else{
        $res=pdo_update('cqkundian_farm_address',$data,array('uniacid'=>$uniacid,'id'=>$_GPC['aid']));
    }
    if($res){
        echo json_encode(array('code'=>1));die;
    }else{
        echo json_encode(array('code'=>2));die;
    }
}

//获取地址详细信息
if($op=="getAddressDetail"){
    $aid=$_GPC['aid'];
    $address=pdo_get('cqkundian_farm_address',array('id'=>$aid,'uniacid'=>$uniacid,'uid'=>$uid));
    echo json_encode(array('address'=>$address));die;
}

//修改默认地址
if($op=='updateDefault'){
    $aid=$_GPC['aid'];
    pdo_update('cqkundian_farm_address',array('is_default'=>0),array('uniacid'=>$uniacid,'uid'=>$uid));
    $res=pdo_update('cqkundian_farm_address',array('is_default'=>1),array('uniacid'=>$uniacid,'uid'=>$uid,'id'=>$aid));
    if($res){
        echo json_encode(array('code'=>1));die;
    }else{
        echo json_encode(array('code'=>2));die;
    }
}

//删除地址信息
if($op=='deleteAddress'){
    $aid=$_GPC['aid'];
    $res=pdo_delete('cqkundian_farm_address',array('id'=>$aid,'uniacid'=>$uniacid,'uid'=>$uid));
    if($res){
        echo json_encode(array('code'=>1));die;
    }else{
        echo json_encode(array('code'=>2));die;
    }
}