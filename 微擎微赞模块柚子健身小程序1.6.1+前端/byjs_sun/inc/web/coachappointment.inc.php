<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$type=isset($_GPC['type'])?$_GPC['type']:'all';
$status=$_GPC['status'];
load()->func('tpl');
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=" WHERE  uniacid=:uniacid ";
//if($_GPC['keywords']){
//    $op=$_GPC['keywords'];
//    $where.=" and (name LIKE  concat('%', :order_no,'%'))";
//    $data[':order_no']=$op;
//}
if($status){
    $op=$_GPC['keywords'];
    $where.= " and a.state=$status";
}

$sql="select t1.id,t1.coach_name,t.*,t.id as aid from ".tablename("byjs_sun_appointmentcoach")." as t inner join ( select id,coach_name from ".tablename("byjs_sun_coach")."where uniacid= ".$_W['uniacid']." ) t1  on t.coach_id=t1.id";

$data[':uniacid']=$_W['uniacid'];
$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('byjs_sun_appointmentcoach') .$where." ORDER BY time DESC",$data);


$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
//print_r($list);die;
$pager = pagination($total, $pageindex, $pagesize);
if($operation=='delete'){
    $res=pdo_delete('byjs_sun_appointmentcoach',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    //$res=pdo_update('byjs_sun_order',array('is_delete'=>1),array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('coachappointment',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($operation=='confirm'){

    $res=pdo_update('byjs_sun_appointmentcoach',array('state'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('操作成功',$this->createWebUrl('coachappointment',array()),'success');
    }else{
        message('操作失败','','error');
    }
}

if($operation=='refund'){
    $id=$_GPC['id'];
    include_once IA_ROOT . '/addons/byjs_sun/cert/WxPay.Api.php';
    load()->model('account');
    load()->func('communication');
    $WxPayApi = new WxPayApi();
    $input = new WxPayRefund();
    $path_cert = IA_ROOT . "/addons/byjs_sun/cert/".'apiclient_cert_' . $_W['uniacid'] . '.pem';
    $path_key = IA_ROOT . "/addons/byjs_sun/cert/".'apiclient_key_' . $_W['uniacid'] . '.pem';
    $account_info = $_W['account'];
    $refund_order =pdo_get('byjs_sun_order',array('id'=>$id));
    $res=pdo_get('byjs_sun_system',array('uniacid'=>$_W['uniacid']));
    $appid=$res['appid'];
    $key=$res['wxkey'];
    $mchid=$res['mchid'];
    $out_trade_no=$refund_order['out_trade_no'];
    $fee = $refund_order['money'] * 100;
    $input->SetAppid($appid);
    $input->SetMch_id($mchid);
    $input->SetOp_user_id($mchid);
    $input->SetRefund_fee($fee);
    $input->SetTotal_fee($fee);
    // $input->SetTransaction_id($refundid);
    $input->SetOut_refund_no($id);

    $input->SetOut_trade_no($out_trade_no);

    $result = $WxPayApi->refund($input, 6, $path_cert, $path_key, $key);
    // var_dump($result);die;
    if ($result['result_code'] == 'SUCCESS') {//退款成功
        //更改订单操作
        pdo_update('byjs_sun_order',array('status'=>6),array('id'=>$id,'uniacid'=>$_W['uniacid']));

        message('退款成功',$this->createWebUrl('ddgl',array()),'success');

    }else{
        message('退款失败','','error');



    }
}



include $this->template('web/coachappointment');