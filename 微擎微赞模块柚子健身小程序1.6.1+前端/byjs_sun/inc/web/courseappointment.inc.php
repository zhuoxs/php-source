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

// $sql="select t1.id,t1.course_name,t1.course_coach,t1.course_time,t.time,t.name,t.phone,t.state,t.id as aid from ".tablename("byjs_sun_appointment")." as t inner join ( select id,course_name,course_coach,course_time from ".tablename("byjs_sun_course")."where uniacid= ".$_W['uniacid']." ) t1  on t.course_id=t1.id";
$sql="select a.*,b.course_name,b.course_time,c.coach_name from ".tablename('byjs_sun_appointment')."a left join ".tablename('byjs_sun_course')."b on a.course_id=b.id left join ".tablename('byjs_sun_coach')."c on c.id =a.coach_id where a.uniacid=".$_W['uniacid'];

// $sql="select t.id,t.course_name,t.course_coach,t.course_time,t1.time,t1.name,t1.phone,t1.state,t1.id as aid from ".tablename("byjs_sun_course")." as t inner join ( select id,course_id,name,phone,time,state from ".tablename("byjs_sun_appointment")."where uniacid= ".$_W['uniacid']." ) t1  on t1.course_id=t.id";
$data[':uniacid']=$_W['uniacid'];
$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('byjs_sun_appointment') .$where." ORDER BY time DESC",$data);


$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
//print_r($list);die;
$pager = pagination($total, $pageindex, $pagesize);
if($operation=='delete'){
    $res=pdo_delete('byjs_sun_appointment',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    //$res=pdo_update('byjs_sun_order',array('is_delete'=>1),array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('courseappointment',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($operation=='confirm'){

    $res=pdo_update('byjs_sun_appointment',array('state'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('操作成功',$this->createWebUrl('courseappointment',array()),'success');
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



include $this->template('web/courseappointment');