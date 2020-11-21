<?php
global $_W, $_GPC;
$traid=intval($_GPC['traid']);

if(!empty($traid)){
	
	$result = pdo_delete('nx_information_transfer', array('traid' => $traid));
	if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('transfer'), 'success');
	} else {
			message('抱歉，删除失败！', $this -> createWebUrl('transfer'), 'error');
	}
	
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('transfer'), 'error');
}




	
	


?>