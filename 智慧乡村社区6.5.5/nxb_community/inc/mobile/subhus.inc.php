<?php

global $_W,$_GPC;
	$mid=intval($_GPC['mid']);
	$bianma=$_GPC['bianma'];
	$hu_no=$_GPC['hu_no'];
	$fang_no=$_GPC['fang_no'];
	$huzhu=$_GPC['huzhu'];
	$phone=$_GPC['phone'];

	
	//查询户信息
	$hus=pdo_fetch("SELECT * FROM ".tablename('nx_information_hus')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));
	if(!empty($hus)){
		
		if($mid==$hus['mid']){
			//更新户记录
			$newdata = array(

				'hu_no'=>$hu_no,
				'fang_no'=>$fang_no,
				'huzhu'=>$huzhu,
				'phone'=>$phone,
			
			 );
			$result = pdo_update('nx_information_hus', $newdata,array('hid'=>$hus['hid']));
				
			if(!empty($result)){
				echo json_encode(array('status'=>1,'log'=>'更新成功!'));
			}else{
				echo json_encode(array('status'=>2,'log'=>'更新失败'));
			}		  
		}else{
			echo json_encode(array('status'=>0,'log'=>'户编码已存在!'));
		}
		
		
		
	}else{
		
	//新增户记录
		$newdata = array(
			'weid'=>$_W['uniacid'],
			'mid'=>$mid,
			'bianma'=>$bianma,
			'hu_no'=>$hu_no,
			'fang_no'=>$fang_no,
			'huzhu'=>$huzhu,
			'phone'=>$phone,
			 );
		$result = pdo_insert('nx_information_hus', $newdata);
				
		if(!empty($result)){
			echo json_encode(array('status'=>1,'log'=>'新增户成功!'));
		}else{
			echo json_encode(array('status'=>2,'log'=>'提交失败'));
		}		  


	
	}
		           
    

?>