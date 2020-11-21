<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/28 0028
 * Time: 上午 10:38
 */
defined("IN_IA")or exit("Access denied");
!defined('ROOT_PATH') && define('ROOT_PATH', IA_ROOT . '/addons/kundian_farm/');
include ROOT_PATH.'inc/wxapp/function.inc.php';
include ROOT_PATH.'inc/common/common.func.php';
include ROOT_PATH.'model/common.php';
$commonModel=new Common_KundianFarmModel('cqkundian_farm_set');
global $_GPC,$_W;
$uniacid=$_GPC['uniacid'];
$op=$_GPC['op'] ? $_GPC['op'] :"getSureOrder";
$uid=$_GPC['uid'];

if($op=='getSureOrder'){
    $request=array();
    $seed_id=$_GPC['seed_id'];
    $seedMine=pdo_get('cqkundian_farm_send_mine',array('id'=>$seed_id,'uniacid'=>$uniacid,'uid'=>$uid));
    $seedData=pdo_get('cqkundian_farm_send',array('id'=>$seedMine['sid'],'uniacid'=>$uniacid));
    $request['seedData']=$seedData;
    echo json_encode($request);die;
}

if($op=='addOrder'){
    $name=$_GPC['name'];
    $address=$_GPC['address'];
    $phone=$_GPC['phone'];
    $seed_id=$_GPC['seed_id'];
    $mine_land_id=$_GPC['mine_land_id'];
    $seedMine=pdo_get('cqkundian_farm_send_mine',array('id'=>$seed_id,'uniacid'=>$uniacid));
    $seedData=pdo_get('cqkundian_farm_send',array('id'=>$seedMine['sid'],'uniacid'=>$uniacid));
    $farmSetData=getCommonSet($uniacid,array('animal_send_price'));
    $insertData=array(
        'order_number'=>rand(100,999).time().rand(100,999),
        'uid'=>$uid,
        'status'=>0,
        'create_time'=>time(),
        'name'=>$name,
        'address'=>$address,
        'phone'=>$phone,
        'uniacid'=>$uniacid,
        'send_price'=>$farmSetData['animal_send_price'],
        'total_price'=>$farmSetData['animal_send_price'],    //只需要支付运费
        'order_type'=>4,
        'body'=>$seedData['send_name'].'摘取',
    );
    $order_res=pdo_insert('cqkundian_farm_shop_order',$insertData);
    $order_id=pdo_insertid();
    $insertDetail=array(
        'goods_id'=>$seed_id,
        'order_id'=>$order_id,
        'goods_name'=>$seedData['send_name'],
        'cover'=>$seedData['cover'],
        'price'=>$seedData['price'],
        'count'=>1,
        'uniacid'=>$uniacid,
        'spec_id'=>$mine_land_id,
    );
    $detail_res=pdo_insert('cqkundian_farm_shop_order_detail',$insertDetail);
    if($order_res && $detail_res){
        echo json_encode(array('code'=>1,'order_id'=>$order_id));die;
    }else{
        echo json_encode(array('code'=>2));die;
    }
}

if($op=='notify_send'){
    $seed_id=$_GPC['seed_id'];
    $order_id=$_GPC['order_id'];
    $prepay_id_str=$_GPC['prepay_id'];
    $orderData=pdo_get('cqkundian_farm_shop_order',array('id'=>$order_id,'uniacid'=>$uniacid));
    if($orderData['status']==1) {
        $update_animal = pdo_update('cqkundian_farm_send_mine', array('status' => 3), array('id' => $seed_id, 'uniacid' => $uniacid));

        //向用户推送消息
        $prepay_id = explode('=', $prepay_id_str);
        $wxData = pdo_get('cqkundian_farm_wx_set', array('uniacid' => $uniacid));
        $res_user_send = $commonModel->send_msg_to_user($orderData, $prepay_id[1], $_W['openid'], $uniacid, $page);

        //给店家推送消息
        $commonModel->sendWxTemplate($orderData,'种植配送订单',1,$uniacid);

        //发送QQ邮件
        $mailSet=$commonModel->getSetData(['is_open_QQMail_notice'],$uniacid);
        if($mailSet['is_open_QQMail_notice']==1){
            require_once ROOT_PATH.'inc/common/QQMailer.php';
            $mailer = new QQMailer(true,$uniacid);
            $mailRes=$mailer->sendMail($orderData,1);
        }

        echo json_encode(array('code' => 1));
        die;
    }else{
        echo json_encode(array('code' => 2));
        die;
    }
}



