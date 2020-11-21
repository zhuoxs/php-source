<?php

	global $_W,$_GPC;

	$mid=intval($_GPC['mid']);	
	$aid=intval($_GPC['aid']);	
	$contacts=$_GPC['contacts'];
	$mobile=$_GPC['mobile'];
	$city=$_GPC['city'];
	$address=$_GPC['address'];

	
	
if($aid!=0){
	
		
		$newdata = array(


			'contacts'=>$contacts,
			'mobile'=>$mobile,
			'city'=>$city,
			'address'=>$address,
			'ctime'=>time(),


			
		);
		$result = pdo_update('bc_community_mall_address', $newdata,array('id'=>$aid));
				
		if(!empty($result)){
			
			echo json_encode(array('status'=>1,'log'=>'已提交'));
			
		}else{
			
			echo json_encode(array('status'=>2,'log'=>'提交失败'));
			
		}	
		
		
	
}else{
	
		
		$newdata = array(
			
			'weid'=>$_W['uniacid'],
			'mid'=>$mid,
			'contacts'=>$contacts,
			'mobile'=>$mobile,
			'city'=>$city,
			'address'=>$address,
			'ctime'=>time(),
			
		);
		
		$result = pdo_insert('bc_community_mall_address', $newdata);
				
		if(!empty($result)){
			echo json_encode(array('status'=>1,'log'=>'已提交'));
		}else{
			echo json_encode(array('status'=>2,'log'=>'提交失败'));
		}	
		
		
		
		
			  
}

	
	
		           
    

?>