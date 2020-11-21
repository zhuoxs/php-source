<?php
global $_W, $_GPC;
$cadid=intval($_GPC['cadid']);

if(!empty($cadid)){
	
	$result = pdo_delete('nx_information_cadre', array('cadid' => $cadid));
	if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('cadre'), 'success');
	} else {
			message('抱歉，删除失败！', $this -> createWebUrl('cadre'), 'error');
	}
	
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('cadre'), 'error');
}




	
	


?>