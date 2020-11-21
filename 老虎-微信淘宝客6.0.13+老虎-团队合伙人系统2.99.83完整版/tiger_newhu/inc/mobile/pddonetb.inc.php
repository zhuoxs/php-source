<?php
global $_W, $_GPC;

   $cfg = $this->module['config'];
   $miyao=$_GPC['miyao'];
   if($miyao!==$cfg['miyao']){
   	exit(json_encode(array('status' => 2, 'content' => '密钥错误，请检测秘钥，或更新缓存！')));
   }
   
   $content=htmlspecialchars_decode($_GPC['content']);
   
   $news=@json_decode($content, true);
   //exit(json_encode($news['order_list_get_response']['order_list']));
   if(empty($news['order_list_get_response']['order_list'])){
	   exit(json_encode(array('status' => 2, 'content' => '暂无数据！')));
   }
   
	foreach($news['order_list_get_response']['order_list'] as $k=>$v){
		$row = pdo_fetch("SELECT * FROM " . tablename($this->modulename.'_pddorder') . " WHERE weid='{$_W['uniacid']}' and order_sn='{$v['order_sn']}'");
		//file_put_contents(IA_ROOT."/addons/tiger_newhu/inc/mobile/pdd--ordernews.txt","\naaaaa:".json_encode($v),FILE_APPEND);
		//file_put_contents(IA_ROOT."/addons/tiger_newhu/inc/mobile/pdd--ordernews.txt","\nbbbbb:". $v['goods_name'],FILE_APPEND);
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
			'createtime'=>time()
		);
		if (!empty($row)){
			file_put_contents(IA_ROOT."/addons/tiger_newhu/inc/mobile/pdd--ordernews.txt","\nupdate:". json_encode($data),FILE_APPEND);
            pdo_update($this->modulename."_pddorder", $data, array('order_sn' => $v['order_sn'],'weid'=>$_W['uniacid']));
        }else{
			file_put_contents(IA_ROOT."/addons/tiger_newhu/inc/mobile/pdd--ordernews.txt","\ninsert:".json_encode($data),FILE_APPEND);
            pdo_insert($this->modulename."_pddorder", $data);
        }
	}
	exit(json_encode("拼多多-----".date('Y-m-d H:i:s',$beginToday).'--'.date('Y-m-d H:i:s',$endToday).'订单更新成功'));
     ?>