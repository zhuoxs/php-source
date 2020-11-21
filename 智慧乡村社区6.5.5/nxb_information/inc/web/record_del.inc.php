<?php
global $_W, $_GPC;
$recid=intval($_GPC['recid']);

if(!empty($recid)){
	
	$result = pdo_delete('nx_information_record', array('recid' => $recid));
	if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('record'), 'success');
	} else {
			message('抱歉，删除失败！', $this -> createWebUrl('record'), 'error');
	}
	
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('record'), 'error');
}




	
	


?>