<?php

	global $_W,$_GPC;

	$sid=intval($_GPC['sid']);
	$gid=intval($_GPC['gid']);
	
	$pstatus=intval($_GPC['pstatus']);
	

				$newdata = array(
					'pstatus'=>$pstatus,
					
			 	);
				$result = pdo_update('bc_community_mall_goods', $newdata,array('id'=>$gid));
				
				if(!empty($result)){
					
			//写入商品操作日志中
			//查询商户的信息
			$seller=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_seller')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$sid));   		
			
			if($seller){
				
				$data = array(
			
					'weid'=>1,
					'mid'=>$seller['mid'],
					'sid'=>$seller['id'],
					'townid'=>$seller['danyuan'],
					'villageid'=>$seller['menpai'],
					'type'=>1,
					'content'=>'管理员对商品ID为'.$gid.'的商品进行了状态'.$pstatus.'编辑。',
					'ctime'=>time()							
				);
				pdo_insert('bc_community_mall_log', $data);
			}
			
					
					
					
					echo json_encode(array('status'=>1,'log'=>'编辑成功!'));
				}else{
					echo json_encode(array('status'=>2,'log'=>'编辑失败','array'=>$newdata));
				}		 
		
	

		           
    

?>