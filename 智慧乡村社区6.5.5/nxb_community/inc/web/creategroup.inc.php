<?php
	global $_W,$_GPC;

	$gname=$_GPC['gname'];	
	$tels=$_GPC['tels'];

		$newdata = array(
			'weid'=>$_W['uniacid'],
			'gname'=>$gname,
			'gmember'=>$tels,
			'gstatus'=>0,
			'gctime'=>time(),
			 );
		$res = pdo_insert('bc_community_group', $newdata);
	
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>'创建群成功'));
        }else{
            echo json_encode(array('status'=>0,'log'=>'创建群失败'));
        }
	

?>