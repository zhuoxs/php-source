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
$where=' WHERE  a.uniacid=:uniacid  and a.is_qiang=3';
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and (a.order_num LIKE  concat('%', :order_no,'%') or a.user_name LIKE  concat('%', :order_no,'%'))";
    $data[':order_no']=$op;
}
if($_GPC['op']=='build'){
    $build_id = $_GPC['build_id']; // 门店id
    $type = 1;
    $where.= " and a.build_id=$build_id";
}
if($status){
    $op=$_GPC['keywords'];
    if($status==4){
        $where.= " and a.state=2 and a.is_serve=1";
    }else{
        $where.= " and a.state=$status";
    }


}
if($_GPC['time']){
    $start=strtotime($_GPC['time']['start']);
    $end=strtotime($_GPC['time']['end']);
    $where.=" and a.time >={$start} and a.time<={$end}";

}
// 门店数据
$branch = pdo_getall('fyly_sun_branch',array('uniacid'=>$_W['uniacid']));

$sql="SELECT a.*,b.store_name as seller_name FROM ".tablename('fyly_sun_order') .  " a"  . " left join " . tablename("fyly_sun_store") . " b on a.store_id=b.id".$where." ORDER BY a.time DESC";
$data[':uniacid']=$_W['uniacid'];
$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('fyly_sun_order') .  " a"  . " left join " . tablename("fyly_sun_store") . " b on a.store_id=b.id".$where." ORDER BY a.time DESC",$data);

$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);
foreach ($list as $k=>$v){
    $list[$k]['b_name'] = pdo_getcolumn('fyly_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$v['build_id']),'name');
}
//更改服务状态
if($operation=='server'){

    $res=pdo_update('fyly_sun_order',array('is_serve'=>1),array('id'=>$_GPC['id']));

    if($res){
        message('成功',$this->createWebUrl('visaorder',array()),'success');
    }else{
        message('失败','','error');
    }
}

if($operation=='delete'){
    $res=pdo_delete('fyly_sun_order',array('id'=>$_GPC['id']));
    //$res=pdo_update('fyly_sun_order',array('is_delete'=>1),array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('visaorder',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($operation=='delivery'){

    $res=pdo_update('fyly_sun_order',array('state'=>3,'fh_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('visaorder',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
if($operation=='receipt'){

    $res=pdo_update('fyly_sun_order',array('state'=>4,'complete_time'=>time()),array('id'=>$_GPC['id']));
    if($res){

/////////////////分销/////////////////

        $set=pdo_get('fyly_sun_fxset',array('uniacid'=>$_W['uniacid']));
        $order=pdo_get('fyly_sun_order',array('id'=>$_GPC['id']));
        if($set['is_open']==1){
            if($set['is_ej']==2){//不开启二级分销
                $user=pdo_get('fyly_sun_fxuser',array('fx_user'=>$order['user_id']));
                if($user){
                    $userid=$user['user_id'];//上线id
                    $money=$order['money']*($set['commission']/100);//一级佣金
                    pdo_update('fyly_sun_user',array('commission +='=>$money),array('id'=>$userid));
                    $data6['user_id']=$userid;//上线id
                    $data6['son_id']=$order['user_id'];//下线id
                    $data6['money']=$money;//金额
                    $data6['time']=time();//时间
                    $data6['uniacid']=$_W['uniacid'];
                    pdo_insert('fyly_sun_earnings',$data6);
                }
            }else{//开启二级
                $user=pdo_get('fyly_sun_fxuser',array('fx_user'=>$order['user_id']));
                $user2=pdo_get('fyly_sun_fxuser',array('fx_user'=>$user['user_id']));//上线的上线
                if($user){
                    $userid=$user['user_id'];//上线id
                    $money=$order['money']*($set['commission']/100);//一级佣金
                    pdo_update('fyly_sun_user',array('commission +='=>$money),array('id'=>$userid));
                    $data6['user_id']=$userid;//上线id
                    $data6['son_id']=$order['user_id'];//下线id
                    $data6['money']=$money;//金额
                    $data6['time']=time();//时间
                    $data6['uniacid']=$_W['uniacid'];
                    pdo_insert('fyly_sun_earnings',$data6);
                }
                if($user2){
                    $userid2=$user2['user_id'];//上线的上线id
                    $money=$order['money']*($set['commission2']/100);//二级佣金
                    pdo_update('fyly_sun_user',array('commission +='=>$money),array('id'=>$userid2));
                    $data7['user_id']=$userid2;//上线id
                    $data7['son_id']=$order['user_id'];//下线id
                    $data7['money']=$money;//金额
                    $data7['time']=time();//时间
                    $data7['uniacid']=$_W['uniacid'];
                    pdo_insert('fyly_sun_earnings',$data7);
                }
            }
        }

/////////////////分销/////////////////





        message('操作成功',$this->createWebUrl('visaorder',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
if($operation=='refund'){
    $id=$_GPC['id'];
    include_once IA_ROOT . '/addons/fyly_sun/cert/WxPay.Api.php';
    load()->model('account');
    load()->func('communication');
    $WxPayApi = new WxPayApi();
    $input = new WxPayRefund();
    $path_cert = IA_ROOT . "/addons/fyly_sun/cert/".'apiclient_cert_' . $_W['uniacid'] . '.pem';
    $path_key = IA_ROOT . "/addons/fyly_sun/cert/".'apiclient_key_' . $_W['uniacid'] . '.pem';
    $account_info = $_W['account'];
    $refund_order =pdo_get('fyly_sun_order',array('id'=>$id));
    $res=pdo_get('fyly_sun_system',array('uniacid'=>$_W['uniacid']));
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
        pdo_update('fyly_sun_order',array('status'=>6),array('id'=>$id));

        message('退款成功',$this->createWebUrl('visaorder',array()),'success');

    }else{
        message('退款失败','','error');



    }
}

include $this->template('web/visaorder');