<?php
global $_W, $_GPC;
     $cfg=$this->module['config'];
     
    include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/pdd.php"; 
	$pddset=pdo_fetch("select * from ".tablename('tuike_pdd_set')." where weid='{$_W['uniacid']}'");
	$owner_name=$pddset['ddjbbuid'];	
	$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));//今天开始时间
	$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;//今天结束时间
//	echo $beginToday."---".$endToday;
//	exit;	
	$start_time=$beginToday;
	$end_time=$endToday;
	$page=1;
	//echo $end_time;
	$res=pddtgworder1($owner_name,$page,$start_time,$end_time,$p_id);				
	if(!empty($orderlist['error_response']['error_msg'])){
		//message($orderlist['error_response']['error_msg'], referer(), 'success');
		//echo $orderlist['error_response']['error_msg'];
		//exit;
	}
	$orderlist=$res['order_list_get_response']['order_list'];
	foreach($orderlist as $k=>$v){
		$row = pdo_fetch("SELECT * FROM " . tablename($this->modulename.'_pddorder') . " WHERE weid='{$_W['uniacid']}' and order_sn='{$v['order_sn']}'");
		$data=array(
			"weid"=>$_W['uniacid'],
			"order_sn" =>$v['order_sn'],
            "goods_id" => $v['goods_id'],
            "goods_name" => $v['goods_name'],
            "goods_thumbnail_url" => $v['goods_thumbnail_url'],
            "goods_quantity" => $v['goods_quantity'],
            "goods_price" => $v['goods_price']/100,
            "order_amount" => $v['order_amount']/100,
            "order_create_time" => $v['order_create_time'],
            "order_settle_time" => $v['order_settle_time'],
            "order_verify_time" => $v['order_verify_time'],
            "order_receive_time" => $v['order_receive_time'],
            "order_pay_time" => $v['order_pay_time'],
            "promotion_rate" => $v['promotion_rate']/10,
            "promotion_amount" => $v['promotion_amount']/100,
            "batch_no" => $v['batch_no'],
            "order_status" =>$v['order_status'],
            "order_status_desc" => $v['order_status_desc'],
            "verify_time" => $v['verify_time'],
            "order_group_success_time" => $v['order_group_success_time'],
            "order_modify_at" => $v['order_modify_at'],
            "status" => $v['status'],
            "type" => $v['type'],
            "group_id" => $v['group_id'],
            "auth_duo_id" => $v['auth_duo_id'],
            "custom_parameters" => $v['custom_parameters'],
            "p_id" => $v['p_id'],
		);
		if (!empty($row)){
            pdo_update($this->modulename."_pddorder", $data, array('order_sn' => $v['order_sn'],'weid'=>$_W['uniacid']));
        }else{
            pdo_insert($this->modulename."_pddorder", $data);
        }
	}
	exit(json_encode("拼多多-----".date('Y-m-d H:i:s',$beginToday).'--'.date('Y-m-d H:i:s',$endToday).'订单更新成功'));
     ?>