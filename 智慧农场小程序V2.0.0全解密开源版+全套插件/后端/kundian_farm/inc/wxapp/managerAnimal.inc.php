<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/30 0030
 * Time: 16:30
 */
defined("IN_IA")or exit("Access denied");
global $_GPC,$_W;
$uniacid=$_GPC['uniacid'];
$op=$_GPC['op'] ? $_GPC['op'] :"getAniaml";
$uid=$_GPC['uid'];


if($op=='getAnimal'){
    $request=array();
    $current=$_GPC['current'];
    if(empty($_GPC['page'])){
        $page=1;
    }else{
        $page=$_GPC['page']+1;
    }
    $condition['uniacid']=$uniacid;
    if($current!=6){
        $condition['status']=$current;
    }
    $animalData=pdo_getall('cqkundian_farm_animal_adopt',$condition,'','','create_time desc',array($page,15));
    for ($i=0;$i<count($animalData);$i++){
        $animal=pdo_get('cqkundian_farm_animal',array('uniacid'=>$uniacid,'id'=>$animalData[$i]['aid']));
        $animalData[$i]['animal_name']=$animal['animal_name'];
        $animalData[$i]['cover']=$animal['animal_src'];

        $order=pdo_get('cqkundian_farm_animal_order',array('uniacid'=>$uniacid,'id'=>$animalData[$i]['order_id']));
        $animalData[$i]['num']=$order['count'];
        $animalData[$i]['username']=$order['username'];
        $animalData[$i]['total_price']=$order['total_price'];
        $order=pdo_get('cqkundian_farm_user',array('uniacid'=>$uniacid,'uid'=>$animalData[$i]['uid']));
        $animalData[$i]['avatar']=$order['avatarurl'];


        $animalData[$i]['predict_ripe']=date("Y-m-d",$animalData[$i]['predict_ripe']);
        $animalData[$i]['create_time']=date("Y-m-d",$animalData[$i]['create_time']);
    }
    $request['animalData']=$animalData;
    echo json_encode($request);die;
}

//获取认养详细信息
if($op=='getAnimalDetail'){
    $adoptid=$_GPC['adoptid'];
    $animalData=pdo_get('cqkundian_farm_animal_adopt',array('uniacid'=>$uniacid,'id'=>$adoptid));
    $animalOrder=pdo_get('cqkundian_farm_animal_order',array('uniacid'=>$uniacid,'id'=>$animalData['order_id']));
    $animalData['username']=$animalOrder['username'];
    $animalData['phone']=$animalOrder['phone'];
    $animalData['num']=$animalOrder['count'];
    $animalData['order_number']=$animalOrder['order_number'];
    $animalData['exprie_time']=date("Y-m-d",$animalOrder['exprie_time']);
    $animal=pdo_get('cqkundian_farm_animal',array('uniacid'=>$uniacid,'id'=>$animalData['aid']));
    $animalOrder['animal_name']=$animal['animal_name'];
    $animalOrder['cover']=$animal['animal_src'];
    $animalData['predict_ripe']=date("Y-m-d",$animalData['predict_ripe']);
    $animalOrder['create_time']=date("Y-m-d",$animalData['create_time']);
    $request=array(
        'animalData'=>$animalData,
        'animal_order'=>$animalOrder,
    );
    echo json_encode($request);die;
}

//保存状态跟踪信息
if($op=='status_save'){
    $src=json_decode($_POST['src']);
    $update_data=array(
        'txt'=>$_GPC['txt'],
        'uniacid'=>$uniacid,
        'create_time'=>time(),
        'adopt_id'=>$_GPC['adoptid'],
    );
    $update_data['src']=serialize($src);
    if(empty($_GPC['id'])){
        $res=pdo_insert('cqkundian_farm_animal_adopt_status',$update_data);
    }else{
        $res=pdo_update('cqkundian_farm_animal_adopt_status',$update_data,array('id'=>$_GPC['id'],'uniacid'=>$uniacid));
    }
    if($res){
        echo json_encode(array('code'=>1,'msg'=>'发布成功'));die;
    }else{
        echo json_encode(array('code'=>2,'msg'=>'发布失败'));die;
    }
}