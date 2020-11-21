<?php

	global $_W,$_GPC;

	$id=intval($_GPC['id']);

	//运费，转成浮点型，保留两位小数
	$yf=$_GPC['v'];
	$yf=sprintf("%.2f", $yf);
	
	//查询订单
	$order=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_orders')." WHERE id=:id",array(':id'=>$id));
	if($order){
		
		$orderprice=$order['goodsprice']+$yf;
		$newdata = array(
			'yf'=>$yf,
			'orderprice'=>$orderprice,					
		);
		$result = pdo_update('bc_community_mall_orders', $newdata,array('id'=>$id));
				
		if(!empty($result)){
			echo json_encode(array('status'=>1,'log'=>'修改成功','yf'=>$yf,'orderprice'=>$orderprice));
		}else{
			echo json_encode(array('status'=>2,'log'=>'提交失败'));
		}		 
			
		
	}else{
		echo json_encode(array('status'=>0,'log'=>'提交失败'));
	}

		
	

		           
    

?>