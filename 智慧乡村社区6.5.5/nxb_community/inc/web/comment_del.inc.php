<?php
global $_W, $_GPC;
$cid=intval($_GPC['cid']);

if(!empty($cid)){
	
	$result = pdo_delete('bc_community_comment', array('cid' => $cid));
	if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('comment'), 'success');
	} else {
			message('抱歉，删除失败！', $this -> createWebUrl('comment'), 'error');
	}
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('comment'), 'error');
}



	
	


?>