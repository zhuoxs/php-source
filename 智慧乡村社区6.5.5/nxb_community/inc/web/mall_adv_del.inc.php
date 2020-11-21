<?php
global $_W, $_GPC;
$id=intval($_GPC['id']);

if(!empty($id)){
	
	$result = pdo_delete('bc_community_mall_banner', array('id' => $id));
	if (!empty($result)) {
		message('恭喜，删除成功！', $this -> createWebUrl('mall_adv'), 'success');
	} else {
		message('抱歉，删除失败！', $this -> createWebUrl('mall_adv'), 'error');
	}
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('mall_adv'), 'error');
}



	
	


?>