<?php
global $_GPC, $_W;
// $action = 'ad';
// $title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$type=isset($_GPC['type'])?$_GPC['type']:'all';
$status=$_GPC['status'];
load()->func('tpl');
if($_GPC['express']==1){
//    if($_GPC['express_num'] || $_GPC['express_com']){
    if(!$_GPC['express_num'] || !$_GPC['express_com']){
        message('请填写快递单号或快递公司');
    }
    $res = pdo_update('chbl_sun_order',array('express_num'=>$_GPC['express_num'],'express_com'=>$_GPC['express_com'],'state'=>3,'fh_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
        message('发货成功',$this->createWebUrl('groupsorder',array()),'success');
    }
//    }
}
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=' WHERE  a.uniacid=:uniacid  and a.out_trade_no=2';
if($_GPC['keywords']){
   $op=$_GPC['keywords'];
   $where.=" and (a.order_num LIKE  concat('%', :order_no,'%') or a.user_name LIKE  concat('%', :order_no,'%'))";	
   $data[':order_no']=$op;
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
$sql="SELECT a.*,b.store_name FROM ".tablename('chbl_sun_order') .  " a"  . " left join " . tablename("chbl_sun_store_active") . " b on a.store_id=b.id".$where." ORDER BY a.time DESC";
$data[':uniacid']=$_W['uniacid'];
$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('chbl_sun_order') .  " a"  . " left join " . tablename("chbl_sun_store_active") . " b on a.store_id=b.id".$where." ORDER BY a.time DESC",$data);


$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);


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
		message('删除成功',$this->createWebUrl('groupsorder',array()),'success');
	}else{
		message('删除失败','','error');
	}
}
if($operation=='delivery'){
	
   $res=pdo_update('chbl_sun_order',array('state'=>3,'fh_time'=>time()),array('id'=>$_GPC['id']));
	if($res){
		message('操作成功',$this->createWebUrl('groupsorder',array()),'success');
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
/////////////////分销/////////////////

        $set=pdo_get('chbl_sun_fxset',array('uniacid'=>$_W['uniacid']));
        $order=pdo_get('chbl_sun_order',array('id'=>$_GPC['id']));
        if($set['is_open']==1){
            if($set['is_ej']==2){//不开启二级分销
       $user=pdo_get('chbl_sun_fxuser',array('fx_user'=>$order['user_id']));
       if($user){
            $userid=$user['user_id'];//上线id
            $money=$order['money']*($set['commission']/100);//一级佣金
            pdo_update('chbl_sun_user',array('commission +='=>$money),array('id'=>$userid));
            $data6['user_id']=$userid;//上线id
            $data6['son_id']=$order['user_id'];//下线id
            $data6['money']=$money;//金额
            $data6['time']=time();//时间
            $data6['uniacid']=$_W['uniacid'];
            pdo_insert('chbl_sun_earnings',$data6);
          }
      }else{//开启二级
       $user=pdo_get('chbl_sun_fxuser',array('fx_user'=>$order['user_id']));
          $user2=pdo_get('chbl_sun_fxuser',array('fx_user'=>$user['user_id']));//上线的上线
          if($user){
            $userid=$user['user_id'];//上线id
            $money=$order['money']*($set['commission']/100);//一级佣金
            pdo_update('chbl_sun_user',array('commission +='=>$money),array('id'=>$userid));
            $data6['user_id']=$userid;//上线id
            $data6['son_id']=$order['user_id'];//下线id
            $data6['money']=$money;//金额
            $data6['time']=time();//时间
            $data6['uniacid']=$_W['uniacid'];
            pdo_insert('chbl_sun_earnings',$data6);
          }
          if($user2){
            $userid2=$user2['user_id'];//上线的上线id
            $money=$order['money']*($set['commission2']/100);//二级佣金
            pdo_update('chbl_sun_user',array('commission +='=>$money),array('id'=>$userid2));
            $data7['user_id']=$userid2;//上线id
            $data7['son_id']=$order['user_id'];//下线id
            $data7['money']=$money;//金额
            $data7['time']=time();//时间
            $data7['uniacid']=$_W['uniacid'];
            pdo_insert('chbl_sun_earnings',$data7);
          }
        }
        }
      
/////////////////分销/////////////////





		message('操作成功',$this->createWebUrl('groupsorder',array()),'success');
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

        message('退款成功',$this->createWebUrl('groupsorder',array()),'success');

    }else{
    message('退款失败','','error');



}
}


/*if(checksubmit('export_submit', true)) {
    //$time=date("Y-m-d");
    $time=date('Y-m-d ',strtotime('-1 day'));
    $time="'%$time%'";
        $count = pdo_fetchcolumn("SELECT COUNT(*) FROM". tablename("chbl_sun_order")." WHERE time LIKE ".$time);
        $pagesize = ceil($count/5000);
        //array_unshift( $names,  '活动名称'); 

        $header = array(
            'item'=>'序号',
            'seller_name' => '酒店名称',
           'order_no' => '订单号', 
           'name' => '联系人', 
           'tel' => '联系电话',
           'room_type' => '房型',
           'arrival_time' => '到店时间',
           'departure_time' => '离店时间',
           'status' => '订单状态',
           'is_rz' => '是否入住',
           'online_price' => '金额'

        );

        
        
        $keys = array_keys($header);
        $html = "\xEF\xBB\xBF";
        foreach ($header as $li) {
            $html .= $li . "\t ,";
        }
        $html .= "\n";
        for ($j = 1; $j <= $pagesize; $j++) {
            $sql = "select a.*,b.store_name as seller_name from " . tablename("chbl_sun_order")."  a"  . " inner join " . tablename("chbl_sun_store")." b on a.store_id=b.id  WHERE a.time LIKE ".$time."  limit " . ($j - 1) * 5000 . ",5000 ";
            $list = pdo_fetchall($sql);
   
            

        }
        
            if (!empty($list)) {
                $size = ceil(count($list) / 500);
                for ($i = 0; $i < $size; $i++) {
                    $buffer = array_slice($list, $i * 500, 500);
                    $user = array();
                    foreach ($buffer as $k =>$row) {
                        $row['item']= $k+1;
                        if($row['status']==0){
                            $row['status']='待付款';
                        }elseif($row['status']==1){
                            $row['status']='已付款';
                        }elseif($row['status']==2){
                            $row['status']='已取消';
                        }elseif($row['status']==3){
                            $row['status']='已评价';
                        }elseif($row['status']==4){
                            $row['status']='已完成';
                        }elseif($row['status']==5){
                            $row['status']='待退款';
                        }elseif($row['status']==6){
                            $row['status']='已退款';
                        }elseif($row['status']==7){
                            $row['status']='退款拒绝';
                        }
                        if($row['is_rz']==1){
                            $row['is_rz']='未入住';
                        }elseif($row['is_rz']==2){
                            $row['is_rz']='已入住';
                        }
                        $good=pdo_getall('wpdc_goods',array('order_id'=>$row['id']));
                        for($i=0;$i<count($good);$i++){
                            $date6='';
                            $date6 .=$good[$i]['name'].'*'.$good[$i]['number']."(".$good[$i]['spec'].")";
                        }
                        $row['goods']=$date6;
                        foreach ($keys as $key) {
                            $data5[] = $row[$key];
                        }
                        $user[] = implode("\t ,", $data5) . "\t ,";
                        unset($data5);
                    }
                    $html .= implode("\n", $user) . "\n";
                }
            }
        
        header("Content-type:text/csv");
        header("Content-Disposition:attachment; filename=订单数据.csv");
        echo $html;
        exit();
    }*/
include $this->template('web/groupsorder');