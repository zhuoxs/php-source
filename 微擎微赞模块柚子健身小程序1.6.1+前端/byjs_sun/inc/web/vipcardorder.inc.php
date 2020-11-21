<?php
global $_GPC, $_W;
// $action = 'ad';
// $title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$type=isset($_GPC['type'])?$_GPC['type']:'all';
$status=$_GPC['status'];
load()->func('tpl');
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=" WHERE  a.uniacid=:uniacid and a.good_name='会员卡' ";
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and (a.order_num LIKE  concat('%', :order_no,'%') or a.user_name LIKE  concat('%', :order_no,'%'))";
    $data[':order_no']=$op;
}
if($status){
    $op=$_GPC['keywords'];
    $where.= " and a.state=$status";
}
//if($_GPC['time']){
//    $start=strtotime($_GPC['time']['start']);
//    $end=strtotime($_GPC['time']['end']);
//    $where.=" and a.time >={$start} and a.time<={$end}";
//
//}
$sql="SELECT a.*,b.store_name as seller_name FROM ".tablename('byjs_sun_order') .  " a"  . " left join " . tablename("byjs_sun_store") . " b on a.store_id=b.id".$where." ORDER BY a.time DESC";
$data[':uniacid']=$_W['uniacid'];
$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('byjs_sun_order') .  " a"  . " left join " . tablename("byjs_sun_store") . " b on a.store_id=b.id".$where." ORDER BY a.time DESC",$data);


$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);
if($operation=='delete'){
    $res=pdo_delete('byjs_sun_order',array('id'=>$_GPC['id']));
    //$res=pdo_update('byjs_sun_order',array('is_delete'=>1),array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('ddgl',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($operation=='delivery'){

    $res=pdo_update('byjs_sun_order',array('state'=>3,'fh_time'=>time()),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('操作成功',$this->createWebUrl('ddgl',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
if($operation=='receipt'){

    $res=pdo_update('byjs_sun_order',array('state'=>4,'complete_time'=>time()),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){

        message('操作成功',$this->createWebUrl('ddgl',array()),'success');
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

        message('退款成功',$this->createWebUrl('vipcardorder',array()),'success');

    }else{
        message('退款失败','','error');



    }
}


include $this->template('web/vipcardorder');