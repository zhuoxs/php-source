<?php
global $_W, $_GPC;
$pid=intval($_GPC['pid']);

if(!empty($pid)){
	
	$result = pdo_delete('bc_community_proposal', array('pid' => $pid));
	if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('proposal'), 'success');
	} else {
			message('抱歉，删除失败！', $this -> createWebUrl('proposal'), 'error');
	}
	
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('proposal'), 'error');
}



	
	


?>