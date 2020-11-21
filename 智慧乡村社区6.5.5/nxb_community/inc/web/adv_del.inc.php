<?php
global $_W, $_GPC;
$aid=intval($_GPC['aid']);

if(!empty($aid)){
	
	$result = pdo_delete('bc_community_adv', array('aid' => $aid));
	if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('adv'), 'success');
	} else {
			message('抱歉，删除失败！', $this -> createWebUrl('adv'), 'error');
	}
	
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('adv'), 'error');
}



	
	


?>