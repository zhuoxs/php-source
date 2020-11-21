<?php
global $_W, $_GPC;
$id=intval($_GPC['id']);

if(!empty($id)){
	
	$result = pdo_delete('bc_community_mall_nav', array('id' => $id));
	if (!empty($result)) {
		message('恭喜，删除成功！', $this -> createWebUrl('mall_nav'), 'success');
	} else {
		message('抱歉，删除失败！', $this -> createWebUrl('mall_nav'), 'error');
	}
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('mall_nav'), 'error');
}



	
	


?>