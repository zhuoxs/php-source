<?php

		global $_W,$_GPC;




		$id=intval($_GPC['id']);
		
		$mid=intval($_GPC['mid']);

	

		$newdata = array(
			
			'pstatus'=>1,
			
		);
		$result = pdo_update('bc_community_mall_goods', $newdata,array('id'=>$id));
				
		if(!empty($result)){
			//写入商品操作日志中
			//查询商户的信息
			$seller=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_seller')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));   		
			
			if($seller){
				
				$data = array(
			
					'weid'=>1,
					'mid'=>$seller['mid'],
					'sid'=>$seller['id'],
					'townid'=>$seller['danyuan'],
					'villageid'=>$seller['menpai'],
					'type'=>1,
					'content'=>'商家 '.$seller['stitle'].'对商品ID为'.$id.'的商品进行了上架状态变更。',
					'ctime'=>time()							
				);
				pdo_insert('bc_community_mall_log', $data);
			}

			echo json_encode(array('status'=>1,'log'=>'已上架'));
		}else{
			echo json_encode(array('status'=>2,'log'=>'上架失败'));
		}		  


	
	
		           
    

?>