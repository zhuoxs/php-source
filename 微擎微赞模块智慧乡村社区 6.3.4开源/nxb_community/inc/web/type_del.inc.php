<?php
global $_W, $_GPC;
$tid=intval($_GPC['tid']);

if(!empty($tid)){
	
	$result = pdo_delete('bc_community_type', array('tid' => $tid));
	if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('type'), 'success');
	} else {
			message('抱歉，删除失败！', $this -> createWebUrl('type'), 'error');
	}
	
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('type'), 'error');
}



	
	


?>