<?php
global $_W, $_GPC;
$id=intval($_GPC['id']);


	
	
	$result = pdo_delete('bc_community_town', array('id' => $id));
	if (!empty($result)) {
		echo json_encode(array('status'=>1,'log'=>'删除成功'));
	} else {
		echo json_encode(array('status'=>0,'log'=>'删除失败'));
	}
	
	
	
