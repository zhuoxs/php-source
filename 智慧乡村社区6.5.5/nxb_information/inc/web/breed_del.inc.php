<?php
global $_W, $_GPC;
$breid=intval($_GPC['breid']);

if(!empty($breid)){
	
	$result = pdo_delete('nx_information_breed', array('breid' => $breid));
	if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('breed'), 'success');
	} else {
			message('抱歉，删除失败！', $this -> createWebUrl('breed'), 'error');
	}
	
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('breed'), 'error');
}




	
	


?>