<?php
	global $_W,$_GPC;
	$gid=$_GPC['gid'];
	$gname=$_GPC['gname'];	
	$tels=$_GPC['tels'];
	$gstatus=$_GPC['gstatus'];
		$newdata = array(
			'gname'=>$gname,
			'gmember'=>$tels,
			'gstatus'=>$gstatus
			 );
		$res = pdo_update('bc_community_group', $newdata,array('gid'=>$gid));
	
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>'编辑群成功'));
        }else{
            echo json_encode(array('status'=>0,'log'=>'编辑群失败'));
        }
	

?>