<?php

	global $_W,$_GPC;

	$mid=intval($_GPC['mid']);
	$gid=intval($_GPC['gid']);
	$ptitle=$_GPC['ptitle'];
	$pptid=$_GPC['pptid'];
	$ptid=$_GPC['ptid'];
	//价格，转成浮点型，保留两位小数
	$price=$_GPC['price'];
	$price=sprintf("%.2f", $price);
	
	$pqty=intval($_GPC['pqty']);
	$punit=$_GPC['punit'];
	//基础运费，转成浮点型，保留两位小数
	$baseyf=$_GPC['baseyf'];
	$baseyf=sprintf("%.2f", $baseyf);
	
	//累计运费，转成浮点型，保留两位小数
	$addyf=$_GPC['addyf'];
	$addyf=sprintf("%.2f", $addyf);
	
	$pcontent=$_GPC['pcontent'];
	$pimg=$_GPC['pimg'];
	$photo=$_GPC['photo'];

				$newdata = array(
					'pptid'=>$pptid,
					'ptid'=>$ptid,
					'pimg'=>$pimg,
					'photo'=>$photo,
					'ptitle'=>$ptitle,
					'price'=>$price,
					'punit'=>$punit,
					'pqty'=>$pqty,
					'pcontent'=>$pcontent,
					'baseyf'=>$baseyf,
					'addyf'=>$addyf,
			 	);
				$result = pdo_update('bc_community_mall_goods', $newdata,array('id'=>$gid));
				
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
					'content'=>'商家 '.$seller['stitle'].'对商品ID为'.$gid.'的商品进行了编辑。',
					'ctime'=>time()							
				);
				pdo_insert('bc_community_mall_log', $data);
			}
			
					
					
					
					echo json_encode(array('status'=>1,'log'=>'编辑成功!'));
				}else{
					echo json_encode(array('status'=>2,'log'=>'编辑失败','array'=>$newdata));
				}		 
		
	

		           
    

?>