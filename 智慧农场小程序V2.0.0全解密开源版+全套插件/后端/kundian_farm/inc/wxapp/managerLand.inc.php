<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/16 0016
 * Time: 15:39
 */
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
defined("IN_IA")or exit("Access denied");
!defined('ROOT_PATH') && define('ROOT_PATH', IA_ROOT . '/addons/kundian_farm/');
include ROOT_PATH.'inc/wxapp/function.inc.php';
include ROOT_PATH.'inc/common/common.func.php';
global $_GPC,$_W;
$uniacid=$_GPC['uniacid'];
$op=$_GPC['op'] ? $_GPC['op'] :"getLand";
$uid=$_GPC['uid'];
//获取全部种植信息
if($op=='getLand'){
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
    $landData=pdo_getall('cqkundian_farm_land_mine',$condition,'','','create_time desc',array($page,15));
    for ($i=0;$i<count($landData);$i++){
        $land=pdo_get('cqkundian_farm_land',array('uniacid'=>$uniacid,'id'=>$landData[$i]['lid']));
        $landData[$i]['land_name']=$land['land_name'];
        $landData[$i]['cover']=$land['cover'];

        $order=pdo_get('cqkundian_farm_land_order',array('uniacid'=>$uniacid,'id'=>$landData[$i]['order_id']));
        $landData[$i]['username']=$order['username'];
        $landData[$i]['total_price']=$order['total_price'];
        $order=pdo_get('cqkundian_farm_user',array('uniacid'=>$uniacid,'uid'=>$landData[$i]['uid']));
        $landData[$i]['avatar']=$order['avatarurl'];

        $landData[$i]['create_time']=date("Y-m-d",$landData[$i]['create_time']);
        $landData[$i]['exprie_time']=date("Y-m-d",$landData[$i]['exprie_time']);
    }
    $request['landData']=$landData;

    $farmSetData=getCommonSet(array('is_open_webthing'),array('uniacid'=>$uniacid));
    $request['farmSetData']=$farmSetData;
    echo json_encode($request);die;
}

//获取种植详细信息
if($op=='getLandDetail'){
    $mineid=$_GPC['mineid'];
    $landData=pdo_get('cqkundian_farm_land_mine',array('uniacid'=>$uniacid,'id'=>$mineid));
    $landOrder=pdo_get('cqkundian_farm_land_order',array('uniacid'=>$uniacid,'id'=>$landData['order_id']));
    $landData['username']=$landOrder['username'];
    $landData['phone']=$landOrder['phone'];
    $landData['order_number']=$landOrder['order_number'];
    $landData['exprie_time']=date("Y-m-d",$landData['exprie_time']);

    $seedData=pdo_getall('cqkundian_farm_send_mine',array('uniacid'=>$uniacid,'lid'=>$landData['id']));
    if(!empty($seedData)) {
        $seedOrder = pdo_get('cqkundian_farm_send_order', array('uniacid' => $uniacid, 'id' => $seedData[0]['order_id']));
        $seedOrderDetail = pdo_getall('cqkundian_farm_send_order_detail', array('uniacid' => $uniacid, 'order_id' => $seedOrder['id']));
        $seedOrder['orderDetail'] = $seedOrderDetail;
        $seedOrder['pay_time'] = date("Y-m-d H:i", $seedOrder['pay_time']);
    }else{
        $seedOrder=array();
    }
    $request=array(
        'landDetail'=>$landData,
        'seedData'=>$seedData,
        'seedOrder'=>$seedOrder,
    );
    echo json_encode($request);die;
}
//保存状态信息跟踪
if($op=='status_save'){
    $src=json_decode($_POST['src']);
    $update_data=array(
        'txt'=>$_GPC['txt'],
        'uniacid'=>$uniacid,
        'create_time'=>time(),
        'lid'=>$_GPC['lid'],
    );
    $update_data['src']=serialize($src);
    if(empty($_GPC['id'])){
        $res=pdo_insert('cqkundian_farm_send_status',$update_data);
    }else{
        $res=pdo_update('cqkundian_farm_send_status',$update_data,array('id'=>$_GPC['id'],'uniacid'=>$uniacid));
    }
    if($res){
        echo json_encode(array('code'=>1,'msg'=>'发布成功'));die;
    }else{
        echo json_encode(array('code'=>2,'msg'=>'发布失败'));die;
    }
}

//除草信息更新
if($op=='weeding'){
    $lid=$_GPC['lid'];
    $mineLand=pdo_get('cqkundian_farm_land_mine',array('uniacid'=>$uniacid,'id'=>$lid));
    //查找formid
    $formId='';
    $openid='';
    $formIdData=pdo_getall('cqkundian_farm_form_id',array('uniacid'=>$uniacid,'uid'=>$mineLand['uid']),'','','id asc');
    for ($i=0;$i<count($formIdData);$i++){
        if($formIdData[$i]['create_time']+(7*86400) > time()){
            $formId=$formIdData[$i]['formid'];
            $openid=$formIdData[$i]['openid'];
            pdo_delete('cqkundian_farm_form_id',array('uniacid'=>$uniacid,'id'=>$formIdData[$i]['id']));
            break;
        }else{
            pdo_delete('cqkundian_farm_form_id',array('uniacid'=>$uniacid,'id'=>$formIdData[$i]['id']));
        }
    }
    $res=pdo_update('cqkundian_farm_land_mine',array('weeding_update'=>time(),'weeding_tag'=>0),array('uniacid'=>$uniacid,'id'=>$lid));
    if($res){
        $page="/kundian_farm/pages/user/land/index/index?lid=".$lid;
        $res=sendServiceInfoToUser($uniacid,'除草','今日已除草！',$openid,$page,$formId);
        echo json_encode(array('code'=>200,'msg'=>'除草信息已更新！'));die;
    }else{
        echo json_encode(array('code'=>200,'msg'=>'除草信息更新失败!'));die;
    }
}
//杀虫信息更新
if($op=='killVer'){
    $lid=$_GPC['lid'];
    $mineLand=pdo_get('cqkundian_farm_land_mine',array('uniacid'=>$uniacid,'id'=>$lid));
    //查找formid
    $formId='';
    $openid='';
    $formIdData=pdo_getall('cqkundian_farm_form_id',array('uniacid'=>$uniacid,'uid'=>$mineLand['uid']),'','','id asc');
    for ($i=0;$i<count($formIdData);$i++){
        if($formIdData[$i]['create_time']+(7*86400) > time()){
            $formId=$formIdData[$i]['formid'];
            $openid=$formIdData[$i]['openid'];
            pdo_delete('cqkundian_farm_form_id',array('uniacid'=>$uniacid,'id'=>$formIdData[$i]['id']));
            break;
        }else{
            pdo_delete('cqkundian_farm_form_id',array('uniacid'=>$uniacid,'id'=>$formIdData[$i]['id']));
        }
    }
    $res=pdo_update('cqkundian_farm_land_mine',array('insecticide_update'=>time(),'insecticide_tag'=>0),array('uniacid'=>$uniacid,'id'=>$lid));
    if($res){
        $page="/kundian_farm/pages/user/land/index/index?lid=".$lid;
        $res=sendServiceInfoToUser($uniacid,'除草','今日已杀虫！',$openid,$page,$formId);
        echo json_encode(array('code'=>200,'msg'=>'杀虫信息已更新！'));die;
    }else{
        echo json_encode(array('code'=>200,'msg'=>'杀虫信息更新失败!'));die;
    }
}

