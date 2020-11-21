<?php
/**
 * Created by PhpStorm.
 * User: 坤典团队
 * Date: 2018/9/17
 * Time: 13:37
 */
defined("IN_IA")or exit("Access Denied");
!defined('ROOT_PATH') && define('ROOT_PATH', IA_ROOT . '/addons/kundian_farm/');
require_once ROOT_PATH_FARM_FUND .'model/order.php';
require_once ROOT_PATH_FARM_FUND .'model/project.php';
require_once ROOT_PATH .'model/user.php';
require_once ROOT_PATH .'model/common.php';
$orderModel=new Order_KundianFarmPluginFundingModel('cqkundian_farm_plugin_funding_order');
$projectModel=new Project_KundianFarmPluginFundingModel('cqkundian_farm_plugin_funding_project');
$userModel=new User_KundianFarmModel('cqkundian_farm_user');
$commonModel=new Common_KundianFarmModel('cqkundian_farm_plugin_funding_set');
checklogin();  //验证是否登录
global $_W,$_GPC;
$uniacid=$_W['uniacid'];
$op=$_GPC['op'] ? $_GPC['op']:'order_list';

if($op=='order_list'){
    $condition=array('uniacid'=>$uniacid);
    $old_time = array(
        'start' => date("Y-m-d", strtotime('-30 days')),
        'end' => date('Y-m-d', strtotime('+1 days'))
    );
    if($_GPC['pid']){
        $condition['pid']=$_GPC['pid'];
    }
    $is_status=$_GPC['is_status'];
    if($_GPC['is_recycle']){
        $is_recycle=$_GPC['is_recycle'];
        $condition['is_recycle']=$is_recycle;
    }else{
        $condition['is_recycle']=0;
    }
    if($_GPC['is_pay']){
        $is_pay=$_GPC['is_pay'];
        if($is_pay==2){
            $condition['is_pay']=0;
        }else{
            $condition['is_pay']=1;
            $condition['is_send']=0;
        }
    }
    if($_GPC['is_send']){
        $is_send=$_GPC['is_send'];
        $condition['is_send']=$is_send;
        $condition['is_confirm']=0;
    }
    if($_GPC['is_confirm']){
        $is_confirm=$_GPC['is_confirm'];
        $condition['is_confirm']=$is_confirm;
    }
    if($_GPC['apply_delete']){
        $apply_delete=$_GPC['apply_delete'];
        $condition['apply_delete']=$apply_delete;
    }
    $time = $_GPC['time'];
    if ($time) {
        $condition['create_time >'] = strtotime($time['start']);
        $condition['create_time <'] = strtotime($time['end']);
        $old_time = $time;
    }
    if (!empty($_GPC['order_number'])) {
        $order_number = trim($_GPC['order_number']);
        $condition['order_number LIKE'] = '%' . $order_number . '%';
    }
    $flag=$_GPC['flag'];
    if($flag=='true'){
        outOrder($condition);
    }else {
        if ($_GPC['order_number'] || $_GPC['time']) {
            $list=$orderModel->getFundOrder($condition);
        } else {
            $total = pdo_getall('cqkundian_farm_plugin_funding_order', $condition);
            $pageIndex = $_GPC['page'] ? $_GPC['page'] : 1;
            $pager = pagination(count($total), $pageIndex, 10);
            $list=$orderModel->getFundOrder($condition,$pageIndex,10);
        }
        for ($i = 0; $i < count($list); $i++) {
            $project=$projectModel->getProjectById($list[$i]['pid'],$uniacid);
            if($project['begin_time']>time()){
                $list[$i]['project_status_code']=0;
            }elseif ($project['end_time']<time() || $project['target_money']<=$project['fund_money']){
                $list[$i]['project_status_code']=1;
            }else{
                $list[$i]['project_status_code']=2;
            }
            $spec=$projectModel->getProjectSpec(array('uniacid' => $uniacid, 'id' => $list[$i]['spec_id']),false);
            $list[$i]['project'] = $project;
            $list[$i]['spec'] = $spec;
            $list[$i]['create_time'] = date("Y-m-d", $list[$i]['create_time']);
            $list[$i]['address'] = unserialize($list[$i]['address']);
            $user=$userModel->getUserByUid($list[$i]['uid'],$uniacid);
            $list[$i]['nickname'] = $user['nickname'];
            $list[$i] = $orderModel->neatenOrder($list[$i]);
        }
    }
    include $this->template("web/order/order_list");
}

if($op=='move_into_recycle'){
    $id=$_GPC['order_id'];
    $type=$_GPC['type'];
    if($type==1){
        $update=array('is_recycle'=>1);
    }else{
        $update=array('is_recycle'=>0);
    }
    $res=$orderModel->updateFundOrder($update,array('uniacid'=>$uniacid,'id'=>$id));
    echo $res ? json_encode(array('status'=>1)): json_encode(array('status'=>1));die;
}

if($op=='deny_cancel_order'){
    $id=$_GPC['id'];
    $res=$orderModel->updateFundOrder(array('apply_delete'=>0),array('uniacid'=>$uniacid,'id'=>$id));
    if($res){
        message('操作成功',$this->createWebUrl('order'));
    }else{
        message('操作失败');
    }
}

if($op=='order_detail'){
    $id=$_GPC['id'];
    $orderData=$orderModel->getOrderById($id,$uniacid);
    $orderData['create_time']=date("Y-m-d H:i:s",$orderData['create_time']);
    if($orderData['is_send']==1){
        $orderData['send_time']=date("Y-m-d H:i:s",$orderData['send_time']);
    }
    if($orderData['is_confirm']==1){
        $orderData['confirm_time']=date("Y-m-d H:i:s",$orderData['confirm_time']);
    }
    $orderData=$orderModel->neatenOrder($orderData);
    $address=unserialize($orderData['address']);
    $project=$projectModel->getProjectById($orderData['pid'],$uniacid);
    $spec=$projectModel->getProjectSpec(array('uniacid'=>$uniacid,'id'=>$orderData['spec_id']),false);
    include $this->template('web/order/order_detail');
}

if($op=='send_goods'){
    $order_id=$_GPC['order_id'];
    $send_number=$_GPC['send_number'];
    $save_date=array(
        'send_number'=>$send_number,
        'express_company'=>$_GPC['express_company'],
        'is_send'=>1,
        'send_time'=>time(),
    );
    $res=$orderModel->updateFundOrder($save_date,array('uniacid'=>$uniacid,'id'=>$order_id));
    echo $res ? json_encode(array('status'=>1,'msg'=>'发货成功')) : json_encode(array('status'=>2,'msg'=>"发货失败"));die;
}

if($op=='confirmGoods'){
    $order_id=$_GPC['order_id'];
    $update_order=array(
        'is_confirm'=>1,
        'confirm_time'=>time()
    );
    $res=$orderModel->updateFundOrder($update_order,array('uniacid'=>$uniacid,'id'=>$order_id));
    echo $res ? json_encode(array('status'=>1,'msg'=>'收货成功')) : json_encode(array('status'=>2,'msg'=>"收货失败"));die;
}


if($op=='saveManagerRemark'){
    $order_id=$_GPC['order_id'];
    $manager_remark=$_GPC['manager_remark'];
    $res=$orderModel->updateFundOrder(array('manager_remark'=>$manager_remark),array('uniacid'=>$uniacid,'id'=>$order_id));
    echo $res ? json_encode(array('status'=>1,'msg'=>'操作成功')) : json_encode(array('status'=>2,'msg'=>"操作失败"));die;
}


if($op=='order_del'){
    $id=$_GPC['order_id'];
    $res=pdo_delete('cqkundian_farm_plugin_funding_order',array('uniacid'=>$uniacid,'id'=>$id));
    echo $res ? json_encode(array('status'=>1)): json_encode(array('status'=>2));die;
}

if($op=='return_order'){
    $order_id=$_GPC['order_id'];
    $orderData=$orderModel->getOrderById($order_id,$uniacid);
    $project=$projectModel->getProjectSpec(array('id'=>$orderData['pid'],'uniacid'=>$uniacid),false);
    $list1=pdo_getall('cqkundian_farm_manager_set',$condition);
    $messageSet=array();
    foreach ($list1 as $key => $value) {
        $messageSet[$value['ikey']]=$value['value'];
    }
    $fundSet=$commonModel->getSetData(array('ikey'=>'funding_return_sms','uniacid'=>$uniacid),$uniacid);
    if($orderData['return_type']==1 && $orderData['is_return']==0){
        if($project['end_time']<time() || $project['target_money']<=$project['fund_money']){
            $lirun=$orderData['total_price']*($project['return_percent']/100);
            $money=$orderData['total_price']+$lirun;

            $orderData['address']=unserialize($orderData['address']);
            $res=$userModel->updateUser(array('money +=' => $money), array('uid' => $orderData['uid'], 'uniacid' => $uniacid));
            $userModel->insertRecordMoney($orderData['uid'], $money, 1, '众筹' . $project['project_name'] . '分红', $uniacid);
            $res1=$orderModel->updateFundOrder(array('is_return' => 1,'return_time'=>time()), array('id' => $orderData['id'], 'uniacid' => $uniacid));
            $phone=$orderData['address']['phone'];
            $project_name=$project['project_name'];
            $sms_param="{name:'$phone',project:'$project_name'}";
            $commonModel->sendAliyunSms($messageSet,$fundSet['funding_return_sms'],$orderData['address']['phone'],$sms_param);
            if($res && $res1){
                echo json_encode(array('status'=>1,'msg'=>'操作成功'));die;
            }else{
                echo json_encode(array('status'=>1,'msg'=>'操作失败'));die;
            }

        }else{
            echo json_encode(array('status'=>2,'msg'=>'该项目还没有结束，不支持分红!'));
        }
    }else{
        echo json_encode(array('status'=>2,'msg'=>'该订单不支持分红'));die;
    }

}


/**
 * 导出订单
 * @param $condition 订单导出条件
 */
function outOrder($condition){
    $orderModel=new Order_KundianFarmPluginFundingModel('cqkundian_farm_plugin_funding_order');
    $data[][0]=array('订单编号','订单金额','下单时间','订单状态','支付方式','收货人姓名','联系电话','快递单号','快递公司','说明');
    $listCount = pdo_getall("cqkundian_farm_plugin_funding_order", $condition, '', '', 'create_time desc');
    //循环遍历整理卡券信息
    $orderData=array();
    for ($i=0;$i<count($listCount);$i++){
        $orderData[$i]['order_number']=' '.$listCount[$i]['order_number'];
        $orderData[$i]['total_price']=$listCount[$i]['total_price'];
        $orderData[$i]['create_time']=' '.date("Y-m-d H:i:s",$listCount[$i]['create_time']);
        $orderStatus=$orderModel->neatenOrder($listCount[$i]);
        $orderData[$i]['status_txt']=$orderStatus['status_txt'];
        $address=unserialize($listCount[$i]['address']);
        $orderData[$i]['pay_method']=$listCount[$i]['pay_method'];
        $orderData[$i]['name']='  '.$address['name'];
        $orderData[$i]['phone']='  '.$address['phone'];
        $orderData[$i]['send_number']='  '.$listCount[$i]['send_number'];
        $orderData[$i]['express_company']='  '.$listCount[$i]['express_company'];
        $orderData[$i]['body']=$listCount[$i]['body'];
    }
    $data[]=$orderData;
    require_once "Org/PHPExcel.class.php";
    require_once "Org/PHPExcel/Writer/Excel5.php";
    require_once "Org/PHPExcel/IOFactory.php";
    require_once "Org/function.php";
    $filename="订单";
    getExcel($filename,$data);
}