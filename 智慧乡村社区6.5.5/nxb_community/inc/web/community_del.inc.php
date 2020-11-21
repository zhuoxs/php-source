<?php
global $_W, $_GPC;
$coid=intval($_GPC['coid']);

if(!empty($coid)){
	
	$result = pdo_delete('bc_community_community', array('coid' => $coid));
	if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('community'), 'success');
	} else {
			message('抱歉，删除失败！', $this -> createWebUrl('community'), 'error');
	}
	
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('community'), 'error');
}



	
	


?>