<?php

	global $_W,$_GPC;

	$sid=intval($_GPC['sid']);
	
	
	$rz=intval($_GPC['rz']);
	

				$newdata = array(
					'rz'=>$rz,
					
			 	);
				$result = pdo_update('bc_community_mall_seller', $newdata,array('id'=>$sid));
				
				if(!empty($result)){
			
					echo json_encode(array('status'=>1,'log'=>'编辑成功!'));
				}else{
					echo json_encode(array('status'=>2,'log'=>'编辑失败','array'=>$newdata));
				}		 
		
	

		           
    

?>