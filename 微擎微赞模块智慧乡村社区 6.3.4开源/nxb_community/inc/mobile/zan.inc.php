<?php
	global $_W,$_GPC;
	include 'common.php';
	$mid=$this->get_mid();
	$newsid=intval($_GPC['newsid']);	

	//查询当前用户是否点过赞

	$res = pdo_fetch("SELECT * FROM " . tablename('bc_community_thumbs') . "  WHERE weid=" . $_W['uniacid'] . " AND mid=".$mid." AND newsid=".$newsid);	
	
	//如果没有，点赞表加记录
	if(empty($res)){
		$data = array(
		'weid'=>$_W['uniacid'],
		'mid'=>$mid,
		'newsid'=>$newsid,
		'thstatus'=>1,
		'thctime'=>time(),
		);
		$dz = pdo_insert('bc_community_thumbs', $data);
		if(!empty($dz)){
            echo json_encode(array('status'=>1,'log'=>'已点赞'));
        }else{
            echo json_encode(array('status'=>0,'log'=>'点赞失败'));
        }	
	}else{
		//如果有，则改变记录状态	
		$s='';
		if($res['thstatus']==1){
			$s=0;
		}
		if($res['thstatus']==0){
			$s=1;
		}
		
		$newdata = array(
			'thstatus'=>$s,						
			 );
		$qxz = pdo_update('bc_community_thumbs', $newdata,array('thid'=>$res['thid']));
		if($s==0){
            echo json_encode(array('status'=>2,'log'=>'已取消赞'));
        }else{
            echo json_encode(array('status'=>3,'log'=>'已点赞'));
        }	
	}
	


        
	

?>