<?php

	global $_W,$_GPC;

	$mid=intval($_GPC['mid']);	
	$stitle=$_GPC['stitle'];
	$content=$_GPC['content'];
	$tese=$_GPC['tese'];
	$contacts=$_GPC['contacts'];
	$mobile=$_GPC['mobile'];
	$address=$_GPC['address'];
	$idcard=$_GPC['idcard'];
	$cashcard=$_GPC['cashcard'];
	$scover=$_GPC['scover'];
	$slogo=$_GPC['slogo'];
	
	//获取用户信息详情
	$user=pdo_fetch("SELECT * FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));   		
	//获取商家信息详情
	$seller=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_seller')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));   		
	

if(!empty($seller)){
	
		//更新商家认证信息
		$newdata = array(


			'slogo'=>$slogo,
			'scover'=>$scover,
			'stitle'=>$stitle,
			'content'=>$content,
			'tese'=>$tese,
			'contacts'=>$contacts,
			'mobile'=>$mobile,
			'address'=>$address,
			'rz'=>3,

			
		);
		$result = pdo_update('bc_community_mall_seller', $newdata,array('id'=>$seller['id']));
				
		if(!empty($result)){
			
			echo json_encode(array('status'=>1,'log'=>'已提交'));
			
		}else{
			
			echo json_encode(array('status'=>2,'log'=>'提交失败1'));
			
		}	
		
		
	
}else{
	
		//写入一条待审核的商家用户记录
		$newdata = array(
			
			'weid'=>$_W['uniacid'],
			'mid'=>$mid,
			'idcard'=>$idcard,
			'cashcard'=>$cashcard,
			'slogo'=>$slogo,
			'scover'=>$scover,
			'stitle'=>$stitle,
			'content'=>$content,
			'browse'=>0,
			'tese'=>$tese,
			'contacts'=>$contacts,
			'mobile'=>$mobile,
			'address'=>$address,
			'longitude'=>'',
			'latitude'=>'',
			'ctime'=>time(),
			'danyuan'=>$user['danyuan'],
			'menpai'=>$user['menpai'],
			'rz'=>0,
			
		);
		
		$result = pdo_insert('bc_community_mall_seller', $newdata);
				
		if(!empty($result)){
			echo json_encode(array('status'=>1,'log'=>'已提交认证,平台审核中'));
		}else{
			echo json_encode(array('status'=>2,'log'=>'提交失败2'));
		}	
		
		
		
		
			  
}

	
	
		           
    

?>