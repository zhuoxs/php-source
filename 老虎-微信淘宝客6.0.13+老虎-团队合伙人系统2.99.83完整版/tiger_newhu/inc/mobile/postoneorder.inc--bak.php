<?php
 global $_W,$_GPC;
 
 $isorderid=pdo_indexexists('tiger_newhu_tkorder', 'orderid');//索引存在,就删除
 if($isorderid){
	 pdo_query("ALTER TABLE " . tablename('tiger_newhu_tkorder') . " DROP KEY `orderid`;");
 }

			 $cfg = $this->module['config'];
			 $miyao=$_GPC['miyao'];
			 if($miyao!==$cfg['miyao']){
				exit(json_encode(array('status' => 2, 'content' => '密钥错误，请检测秘钥，或更新缓存！')));
			 }

			
			
				 




			 $content=htmlspecialchars_decode($_GPC['content']);
       $news=@json_decode($content, true);
			 if(empty($news)){
				 exit("wushuju");
			 }
			  

			 
			 function getdata($v,$a,$_W){//$a 2 相同订单插件,1不同订单号插入
			 //return $_W['uniacid'];
				 if($v["tk_status"]==3){
				 	$orderzt="订单结算";
				 }elseif($v["tk_status"]==12){
				 	$orderzt="订单付款";
				 }elseif($v["tk_status"]==13){
				 	$orderzt="订单失效";
				 }elseif($v["tk_status"]==14){
				 	$orderzt="订单成功";
				 }
				 
				 if($v['terminal_type']==1){
				 	$pt="PC";
				 }else{
				 	$pt="无线";
				 }	 
				 $tbsbuid6=substr($v["trade_parent_id"],-6);
				 $data=array(
				 	'weid'=>$_W['uniacid'],
				 	'addtime'=>strtotime($v["create_time"]),
				 	'orderid'=>$v["trade_parent_id"],
				 	'forderid'=>$v["trade_parent_id"],
				 	'zorderid'=>$v["trade_id"],
				 	'numid'=>$v["num_iid"],
				 	'shopname'=>$v["seller_shop_title"],
				 	'title'=>$v["item_title"],						
				 	'orderzt'=>$orderzt,
				 	'srbl'=>($v["income_rate"]*100)."%",
				 	'fcbl'=>"",
				 	'fkprice'=>$v["alipay_total_price"],
				 	'xgyg'=>$v["pub_share_pre_fee"],
				 	'jstime'=>strtotime($v["earning_time"]),
				 	'pt'=> $pt,
				 	'mtid'=>$v["site_id"],//媒体ID
				 	'mttitle'=>$v["site_name"],//媒体名称
				 	'tgwid'=>$v["adzone_id"],//推广位ID
				 	'tgwtitle'=>$v["adzone_name"],//推广位名称
				 	'ly'=>1,
				 	'tbsbuid6'=>$tbsbuid6,
				 	'createtime'=>TIMESTAMP,
				 );
				 
				 if($a==2){
							$aaa=pdo_insert ("tiger_newhu_tkorder", $data );
							return $aaa."<br>";
				 }else{
					 $ord=pdo_fetchall ( 'select * from ' . tablename ( $this->modulename . "_tkorder" ) . " where weid='{$_W['uniacid']}' and orderid='{$data['orderid']}'" );
					 print_r($ord);
					 if(!empty($ord)){//已存在,更新
						 $res=pdo_update("tiger_newhu_tkorder",$data, array ('orderid' =>$data['orderid'],'weid'=>$_W['uniacid']));
					 }else{
						 if(!empty($data['addtime'])){
								$res=pdo_insert ("tiger_newhu_tkorder", $data );
								return $res;
						 } 
					 }
				 }
				 
				 
			 }

			exit(json_encode(array('status' => 1, 'content' => '成功')));
