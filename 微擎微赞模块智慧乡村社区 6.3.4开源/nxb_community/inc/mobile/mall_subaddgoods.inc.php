<?php

	global $_W,$_GPC;

	$mid=intval($_GPC['mid']);
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

	//查询用户的个人信息
	$user=pdo_fetch("SELECT * FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));
	if($user){
		//查询这个人的商户信息
		$seller=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_seller')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));
			
			if($seller['rz']==2){
				$newdata = array(
					'weid'=>$_W['uniacid'],
					'mid'=>$mid,
					'sid'=>$seller['id'],
					'pptid'=>$pptid,
					'ptid'=>$ptid,
					'is_hot'=>0,
					'pimg'=>$pimg,
					'photo'=>$photo,
					'ptitle'=>$ptitle,
					'price'=>$price,
					'punit'=>$punit,
					'pqty'=>$pqty,
					'pyqty'=>0,
					'pcontent'=>$pcontent,
					'pstatus'=>0,
					'pstrattime'=>'',
					'danyuan'=>$user['danyuan'],
					'pctime'=>time(),
					'menpai'=>$user['menpai'],
					'baseyf'=>$baseyf,
					'addyf'=>$addyf,
			 	);
				$result = pdo_insert('bc_community_mall_goods', $newdata);
				
				if(!empty($result)){
					echo json_encode(array('status'=>1,'log'=>'您的商品已提交，待审核!'));
				}else{
					echo json_encode(array('status'=>2,'log'=>'提交失败'));
				}		 
			}else{
				echo json_encode(array('status'=>0,'log'=>'提交失败'));
			}
		 
		
	}else{
		echo json_encode(array('status'=>0,'log'=>'提交失败'));
	}

		
	

		           
    

?>