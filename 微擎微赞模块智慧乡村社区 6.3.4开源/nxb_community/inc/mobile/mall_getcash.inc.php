<?php

global $_W,$_GPC;
	$mid=intval($_GPC['mid']);
	$c=$_GPC['cash'];
	$danyuan=intval($_GPC['danyuan']);
	$menpai=intval($_GPC['menpai']);
	
	//新增提现记录
		$newdata = array(
			'weid'=>$_W['uniacid'],
			'mid'=>$mid,
			'amount'=>-$c,
			'type'=>2,
			'status'=>0,
			'remark'=>'提现',
			'ctime'=>time(),
			'etime'=>0,
			'danyuan'=>$danyuan,
			'menpai'=>$menpai,
		);
		$result = pdo_insert('bc_community_mall_wallet', $newdata);		
				
		if(!empty($result)){
			echo json_encode(array('status'=>1,'log'=>'您的申请已提交，待审核!'));
		}else{
			echo json_encode(array('status'=>2,'log'=>'提交失败'));
		}		  



		           
    

?>