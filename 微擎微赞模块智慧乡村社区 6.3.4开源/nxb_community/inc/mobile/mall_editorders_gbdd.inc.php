<?php

	global $_W,$_GPC;

	$id=intval($_GPC['id']);

	
	
	//查询订单
	$order=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_orders')." WHERE id=:id",array(':id'=>$id));
	if($order){
		

		$newdata = array(
			
			'postatus'=>7				
		);
		$result = pdo_update('bc_community_mall_orders', $newdata,array('id'=>$id));
				
		if(!empty($result)){
			echo json_encode(array('status'=>1,'log'=>'已关闭'));
		}else{
			echo json_encode(array('status'=>2,'log'=>'操作失败'));
		}		 
			
		
	}else{
		echo json_encode(array('status'=>0,'log'=>'操作失败'));
	}

		
	

		           
    

?>