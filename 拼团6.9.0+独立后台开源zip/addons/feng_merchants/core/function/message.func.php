<?php

	function daipay_success($openid, $price,$name,$orderno, $goodsname,$time, $message, $url) {
		global $_W;
		wl_load() -> model('setting');
		$setting = setting_get_by_name("message");
		$m_daipay = $setting['m_daipay'];
		$postdata  = array(
					"first"=>array( "value"=> "亲，您的朋友代帮你支付了一笔订单","color"=>"#4a5077"),
					"keyword1"=>array('value' => $orderno, "color" => "#4a5077"),
					"keyword2"=>array('value' => $name, "color" => "#4a5077"),
					"keyword3"=>array('value' => "￥".$price."[".$goodsname."]", "color" => "#4a5077"),
					"keyword4"=>array('value' => $time, "color" => "#4a5077"),
					"keyword5"=>array('value' => $message, "color" => "#4a5077"),
					"remark"=>array("value"=>'点击查看详情', "color" => "#4a5077"),
				);
		   sendTplNotice($openid, $m_daipay, $postdata,$url);
	}
	function pay_success($openid, $price, $goodsname, $url) {
		global $_W;
		wl_load() -> model('setting');
		$setting = setting_get_by_name("message");
		$m_pay = $setting['m_pay'];
		$postdata  = array(
					"first"=>array( "value"=> "您已成功付款!!!","color"=>"#4a5077"),
					"orderMoneySum"=>array('value' => "￥ ".$price, "color" => "#4a5077"),
					"orderProductName"=>array('value' => $goodsname, "color" => "#4a5077"),
					"remark"=>array("value"=>'点击查看详情', "color" => "#4a5077"),
				);
		   sendTplNotice($openid, $m_pay, $postdata,$url);
	}

	function group_success($tuan_id, $url) {
		global $_W;
		wl_load() -> model('setting');
		$setting = setting_get_by_name("message");
		$m_tuan = $setting['m_tuan'];
		$alltuan = pdo_fetchall("select openid from" . tablename('tg_order') . "where tuan_id = '{$tuan_id}' and status in(1,2,3,4)");
		$tuan_first_order = pdo_fetch("select openid,g_id from" . tablename('tg_order') . "where tuan_first=1 and tuan_id='{$tuan_id}'");
		$profile = pdo_fetch("select nickname from" . tablename('mc_mapping_fans') . "where openid = '{$tuan_first_order['openid']}'");
		$goods = pdo_fetch("select gname from" . tablename('tg_goods') . "where id = '{$tuan_first_order['g_id']}'");
		$postdata  = array(
					"first"=>array( "value"=> "恭喜组团成功！！！","color"=>"#4a5077"),
					"Pingou_ProductName"=>array('value' => $goods['gname'], "color" => "#4a5077"),
					"Weixin_ID"=>array('value' => $profile['nickname'], "color" => "#4a5077"),
					"remark"=>array("value"=>"点击查看", "color" => "#4a5077"),
				);
		foreach ($alltuan as $num => $all) {
			   sendTplNotice($all['openid'], $m_tuan, $postdata,$url);
		}
	}
	function send_success($orderno, $openid, $express, $expressn, $url) {
		global $_W;
		wl_load() -> model('setting');
		$setting = setting_get_by_name("message");
		$m_send = $setting['m_send'];
		$postdata  = array(
					"first"=>array( "value"=> "亲，您的商品已发货!!!","color"=>"#4a5077"),
					"keyword1"=>array('value' => $orderno, "color" => "#4a5077"),
					"keyword2"=>array('value' => $express, "color" => "#4a5077"),
					"keyword3"=>array("value"=>$expressn, "color" => "#4a5077"),
					"remark"=>array("value"=>"", "color" => "#4a5077"),
				);
			   sendTplNotice($openid, $m_send, $postdata,$url);
	}
	 function refund_success($openid, $price,  $url) {
		global $_W;
		wl_load() -> model('setting');
		$setting = setting_get_by_name("message");
		$m_ref = $setting['m_ref'];
		$postdata  = array(
					"first"=>array( "value"=> "您已成退款成功！","color"=>"#4a5077"),
					"reason"=>array('value' => "拼团失败", "color" => "#4a5077"),
					"refund"=>array('value' => "￥".$price, "color" => "#4a5077"),
					"remark"=>array("value"=>"", "color" => "#4a5077"),
				);
		   sendTplNotice($openid, $m_ref, $postdata,$url);
	}
	function cancelorder($openid, $price, $goodsname, $orderno,  $url) {
		global $_W;
		wl_load() -> model('setting');
		$setting = setting_get_by_name("message");
		$m_cancle = $setting['m_cancle'];
		$content = "取消订单通知";
		$postdata  = array(
					"first"=>array( "value"=> "取消订单通知","color"=>"#4a5077"),
					"keyword5"=>array('value' => "￥".$price."[未支付]", "color" => "#4a5077"),
					"keyword3"=>array('value' => $goodsname, "color" => "#4a5077"),
					"keyword2"=>array("value"=>$_W['uniaccount']['name'], "color" => "#4a5077"),
					"keyword1"=>array("value"=>$orderno, "color" => "#4a5077"),
					"keyword4"=>array("value"=>"1", "color" => "#4a5077"),
					"remark"=>array("value"=>"", "color" => "#4a5077"),
				);
		   sendTplNotice($openid, $m_cancle, $postdata,$url);
		
	}


?>