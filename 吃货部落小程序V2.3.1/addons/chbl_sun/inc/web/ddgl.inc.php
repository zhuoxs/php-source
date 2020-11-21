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
$where=' WHERE  a.uniacid=:uniacid  and a.out_trade_no=0';
if($_GPC['keywords']){
   $op=$_GPC['keywords'];
   $where.=" and (a.order_num LIKE  concat('%', :order_no,'%') or a.user_name LIKE  concat('%', :order_no,'%'))";	
   $data[':order_no']=$op;
}
if(!empty($_GPC['nametype'])){
    $nametype = $_GPC['nametype'];
    $key_name=$_GPC['key_name'];

    if($nametype=='key_goods'){
        $where.=" and a.good_name LIKE '%$key_name%'";
    }elseif($nametype=='key_bname'){
        $where.=" and b.store_name LIKE '%$key_name%'";
    }
}
if(!empty($_GPC['telphone'])){
    $tel = $_GPC['telphone'];
    $where.=" and a.tel LIKE '%$tel%'";
}
if($_GPC['express']==1){
//    if($_GPC['express_num'] || $_GPC['express_com']){
        if(!$_GPC['express_num'] || !$_GPC['express_com']){
            message('请填写快递单号或快递公司');
        }
        $res = pdo_update('chbl_sun_order',array('express_num'=>$_GPC['express_num'],'express_com'=>$_GPC['express_com'],'state'=>3,'fh_time'=>time()),array('id'=>$_GPC['id']));
        if($res){
            message('发货成功',$this->createWebUrl('ddgl',array()),'success');
        }
//    }
}

if($status){
   $op=$_GPC['keywords'];
   $where.= " and a.state=$status";
}
if($_GPC['time']){
   $start=strtotime($_GPC['time']['start']);
   $end=strtotime($_GPC['time']['end']);
  $where.=" and a.time >={$start} and a.time<={$end}";

}

$sql="SELECT a.*,b.store_name FROM ".tablename('chbl_sun_order') .  " a"  . " left join " . tablename("chbl_sun_store_active") . " b on a.store_id=b.id".$where." ORDER BY a.time DESC";
$data[':uniacid']=$_W['uniacid'];
$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('chbl_sun_order') .  " a"  . " left join " . tablename("chbl_sun_store_active") . " b on a.store_id=b.id".$where." ORDER BY a.time DESC",$data);


$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
//foreach ($list as $k=>$v){
//    if(!$list[$k]['store_id']){
//        $list[$k]['store_name'] = '平台商品';
//    }else{
//        $list[$k]['store_name'] = pdo_getcolumn('chbl_sun_store_active',array('uniacid'=>$_W['uniacid'],'id'=>$v['store_id']),'store_name');
//    }
//}

$pager = pagination($total, $pageindex, $pagesize);

//-------------------查看拼团是否成功start-----------------------


foreach ($list as $k=>$v){
    if($list[$k]['out_trade_no']==2){
        $list[$k]['groups_status'] = pdo_getcolumn('chbl_sun_user_groups',array('uniacid'=>$_W['uniacid'],'order_id'=>$v['id']),'status');
    }
}



//-------------------查看拼团是否成功end-----------------------

if($operation=='delete'){
	$res=pdo_delete('chbl_sun_order',array('id'=>$_GPC['id']));
   //$res=pdo_update('chbl_sun_order',array('is_delete'=>1),array('id'=>$_GPC['id']));
	if($res){
		message('删除成功',$this->createWebUrl('ddgl',array()),'success');
	}else{
		message('删除失败','','error');
	}
}
if($operation=='delivery'){
	
   $res=pdo_update('chbl_sun_order',array('state'=>3,'fh_time'=>time()),array('id'=>$_GPC['id']));
	if($res){
		message('操作成功',$this->createWebUrl('ddgl',array()),'success');
	}else{
		message('操作失败','','error');
	}
}
if($operation=='receipt'){
    $order = pdo_get('chbl_sun_order', array('id' => $_GPC['id']));
    $res=pdo_update('chbl_sun_order',array('state'=>4,'complete_time'=>time()),array('id'=>$_GPC['id']));
    $store_info = pdo_get('chbl_sun_store_active',array('uniacid'=>$_W['uniacid'],'id'=>$order['store_id']));
    if($store_info['store_commission']){
        $commission_cost = $store_info['store_commission'];
    }else{
        $commission_cost = pdo_getcolumn('chbl_sun_system',array('uniacid'=>$_W['uniacid']),'commission_cost');
    }
    if($commission_cost){
        $cost = $order['money']-($order['money'] * $commission_cost*0.01);
    }else{
        $cost = $order['money'];
    }
	if($res){
        pdo_update('chbl_sun_store_active',array('allprice +='=>$cost,'canbeput +='=>$cost),array('id'=>$order['store_id'],'uniacid'=>$_W['uniacid']));
        $order=pdo_get('chbl_sun_order',array('id'=>$_GPC['id']));
		message('操作成功',$this->createWebUrl('ddgl',array()),'success');
	}else{
		message('操作失败','','error');
	}
}
if($operation=='refund'){
    $id=$_GPC['id'];
    include_once IA_ROOT . '/addons/chbl_sun/cert/WxPay.Api.php';
    load()->model('account');
    load()->func('communication');
    $WxPayApi = new WxPayApi();
    $input = new WxPayRefund();
    $path_cert = IA_ROOT . "/addons/chbl_sun/cert/".'apiclient_cert_' . $_W['uniacid'] . '.pem';
    $path_key = IA_ROOT . "/addons/chbl_sun/cert/".'apiclient_key_' . $_W['uniacid'] . '.pem';
    $account_info = $_W['account'];
    $refund_order =pdo_get('chbl_sun_order',array('id'=>$id));  
    $res=pdo_get('chbl_sun_system',array('uniacid'=>$_W['uniacid']));
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
        pdo_update('chbl_sun_order',array('status'=>6),array('id'=>$id));           

        message('退款成功',$this->createWebUrl('ddgl',array()),'success');

    }else{
    message('退款失败','','error');
}
}




include $this->template('web/ddgl');