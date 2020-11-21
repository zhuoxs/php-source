<?php
global $_W, $_GPC;
$pid=intval($_GPC['pid']);

if(!empty($pid)){
	
	$result = pdo_delete('bc_community_proposal', array('pid' => $pid));
	if (!empty($result)) {
		echo json_encode(array('status'=>1,'log'=>'删除成功'));
	} else {
		echo json_encode(array('status'=>0,'log'=>'删除失败'));
	}
	
	
	
}


