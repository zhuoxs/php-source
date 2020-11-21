<?php
global $_W, $_GPC;
$mid=intval($_GPC['mid']);

if(!empty($mid)){
	$result = pdo_delete('bc_community_member', array('mid' => $mid));
	if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('member'), 'success');
	} else {
			message('抱歉，删除失败！', $this -> createWebUrl('member'), 'error');
	}

	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('member'), 'error');
}



	
	


?>