<?php
global $_W, $_GPC;
$id=intval($_GPC['id']);

if($id!=0){
	
	$result = pdo_delete('bc_community_authority', array('id' => $id));
	if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('authority'), 'success');
	} else {
			message('抱歉，删除失败！', $this -> createWebUrl('authority'), 'error');
	}
	
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('authority'), 'error');
}



	
	


?>