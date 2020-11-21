<?php
/**
 * Created by PhpStorm.
 * User: 坤典团队
 * Date: 2018/9/14
 * Time: 14:14
 */
defined("IN_IA")or exit("Access Denied");
require_once ROOT_PATH_FARM_FUND.'model/project.php';
require_once ROOT_PATH.'model/live.php';
require_once ROOT_PATH .'model/common.php';
require_once ROOT_PATH .'model/user.php';
require_once ROOT_PATH .'model/notice.php';
require_once ROOT_PATH_FARM_FUND .'model/order.php';
global $_W,$_GPC;
$op=$_GPC['op'] ? $_GPC['op'] : 'getProject';
$uniacid=$_GPC['uniacid'];
$uid=$_GPC['uid'];
$projectModel=new Project_KundianFarmPluginFundingModel("cqkundian_farm_plugin_funding_project");
$liveModel=new Live_KundianFarmModel('cqkundian_farm_live');
$commonModel=new Common_KundianFarmModel("cqkundian_farm_plugin_funding_set");
$userModel=new User_KundianFarmModel('cqkundian_farm_user');
$orderModel=new Order_KundianFarmPluginFundingModel('cqkundian_farm_plugin_funding_order');
$notice=new Notice_KundianFarmModel($uniacid);
if($op=='getProject'){
    $request=array();
    if(empty($_GPC['page'])){
        $page=1;
    }else{
        $page=$_GPC['page'];
    }
    $cond=array('uniacid'=>$uniacid);
    $current=$_GPC['current'];
    if($current==2){
       $cond['end_time >']=time();
       $cond['is_return']=0;
    }
    if($current==3){
        $cond['end_time <']=time();
    }
    $project=$projectModel->getProjectList($cond,$page,10);
    for ($i=0;$i<count($project);$i++){
        $project[$i]=$projectModel->getProjectProgress($project[$i]);
        $spec=$projectModel->getLowSpec($uniacid);
        $project[$i]['low_price']=$spec['price'];
    }
    $request['project']=$project;
    echo json_encode($request);die;
}

if($op == 'getProDetail'){
    $request=array();
    $pid=$_GPC['pid'];
    $proDetail=$projectModel->getProjectDetailById($pid,$uniacid);
    $spec=$projectModel->getProjectSpec(array('uniacid'=>$uniacid,'pid'=>$pid));
    $proDetail['day']=ceil(($proDetail['end_time']-time())/86400);
    $proDetail=$projectModel->getProjectProgress($proDetail);
    $live=pdo_get('cqkundian_farm_live',['id'=>$proDetail['live_id'],'uniacid'=>$uniacid]);
    $proDetail['live_src']=$live['src'];
    $proDetail['live_cover']=$live['src'];
    $lowPrice=$projectModel->getLowSpec($uniacid);
    $proDetail['low_price']=$lowPrice['price'];
    $progress=$projectModel->getProgress(array('uniacid'=>$uniacid,'pid'=>$pid));

    //获取众筹配置信息
    $funding_set=$commonModel->getSetData(array('is_open_funding_share_bonus'),$uniacid);
    $request['funding_set']=$funding_set;
    $request['progress']=$progress;
    $request['proDetail']=$proDetail;
    $request['spec']=$spec;
    echo json_encode($request);die;
}

if($op=='getOrderProDetail'){
    $request=array();
    $pid=$_GPC['pid'];
    $count=$_GPC['count'];
    $spec_id=$_GPC['spec_id'];
    $proDetail=$projectModel->getProjectDetailById($pid,$uniacid);
    $spec=$projectModel->getProjectSpec(array('uniacid'=>$uniacid,'id'=>$spec_id),false);
    $request['proDetail']=$proDetail;
    $request['total_price']=$spec['price']*$count;
    $funding_set=$commonModel->getSetData(array('funding_risk_desc','is_open_funding_share_bonus'),$uniacid);
    $funding_set['funding_risk_desc']=explode("\n",$funding_set['funding_risk_desc']);
    $request['funding_set']=$funding_set;
    echo json_encode($request);die;
}

if($op=='addOrder'){
    $address=array(
        'name'=>$_GPC['name'],
        'phone'=>$_GPC['phone'],
        'address'=>$_GPC['address'],
    );
    $project=$projectModel->getProjectDetailById($_GPC['pid'],$uniacid);
    $insertData=array(
        'order_number'=>$commonModel->getUniqueOrderNumber(),
        'pid'=>$_GPC['pid'],
        'spec_id'=>$_GPC['spec_id'],
        'total_price'=>$_GPC['total_price'],
        'create_time'=>time(),
        'remark'=>$_GPC['remark'],
        'address'=>serialize($address),
        'uniacid'=>$uniacid,
        'uid'=>$uid,
        'count'=>$_GPC['count'],
        'body'=>'众筹'.$project['project_name'],
        'return_type'=>$_GPC['return_type'],
    );
    $res=pdo_insert('cqkundian_farm_plugin_funding_order',$insertData);
    $order_id=pdo_insertid();
    if($res){
        echo json_encode(array('order_id'=>$order_id,'code'=>1,'msg'=>'订单生成成功'));die;
    }else{
        echo json_encode(array('order_id'=>$order_id,'code'=>2,'msg'=>'订单生成失败'));die;
    }
}

if($op=='notify'){
    $order_id=$_GPC['orderid'];
    $prepay_id_str=$_GPC['prepay_id'];
    $orderData=$orderModel->getOrderById($order_id,$uniacid);
    if($orderData['is_pay']==1) {
        $user=$userModel->getUserByUid($orderData['uid'],$uniacid);
        $projectModel->updateProject($orderData['pid'],$orderData['pra_price'],1,1,$uniacid);
        $prepay_id = explode('=', $prepay_id_str);
        $page = '/kundian_farm/pages/funding/orderList/index';
        $notice->isPaySendNotice($orderData,$prepay_id[1],$user['openid'],$uniacid,$page);
        //给店家推送消息
//        $commonModel->sendWxTemplate($orderData,'众筹订单通知',1,$uniacid);
        //向用户推送消息
//        $prepay_id = explode('=', $prepay_id_str);

//        $res=$commonModel->send_msg_to_user($orderData,$prepay_id[1],$user['openid'],$uniacid,$page);

        //发送QQ邮件
//        $mailSet=pdo_get('cqkundian_farm_set',['ikey'=>'is_open_QQMail_notice','uniacid'=>$uniacid]);
//        if($mailSet['value']==1){
//            require_once ROOT_PATH.'inc/common/QQMailer.php';
//            $mailer = new QQMailer(false,$uniacid);
//            $orderData['body']='活动报名';
//            $mailRes=$mailer->sendMail($orderData,1);
//        }

        echo json_encode(array('code' => 1,'msg'=>$res));
        die;
    } else {
        echo json_encode(array('code' => 2,'orderData'=>$orderData));
        die;
    }
}

if($op=='getProgress'){
    $request=array();
    $pid=$_GPC['pid'];
    $data=$projectModel->getProgressList(array('uniacid'=>$uniacid,'pid'=>$pid));
    for ($i=0;$i<count($data);$i++){
        $data[$i]['create_time_day']=date('m/d',$data[$i]['pro_time']);
        $data[$i]['create_time_hour']=date('H:i',$data[$i]['pro_time']);
        $data[$i]['src']=unserialize($data[$i]['src']);
        for ($j=0;$j<count($data[$i]['src']);$j++){
            $data[$i]['src'][$j]=tomedia($data[$i]['src'][$j]);
        }
    }
    $request['progress']=$data;
    echo json_encode($request);die;
}


if($op=='getReturnInfo'){
    $request=array();
    $returnInfo=$commonModel->getSetData(array('funding_thing_desc','funding_bonus_desc','is_open_funding_share_bonus'),$uniacid);
    $request['returnInfo']=$returnInfo;
    echo json_encode($request);die;
}

if($op=='getContractInfo'){
    $request=array();
    $contract=$commonModel->getSetData(array('fund_contract'),$uniacid);
    $request['contract']=$contract;
    echo json_encode($request);die;
}
