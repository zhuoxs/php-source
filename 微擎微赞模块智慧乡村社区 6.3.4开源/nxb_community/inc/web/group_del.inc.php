<?php
global $_W, $_GPC;
$gid=intval($_GPC['gid']);

if(!empty($gid)){
	
	$result = pdo_delete('bc_community_group', array('gid' => $gid));
	if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('group'), 'success');
	} else {
			message('抱歉，删除失败！', $this -> createWebUrl('group'), 'error');
	}
	
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('group'), 'error');
}



	
	


?>