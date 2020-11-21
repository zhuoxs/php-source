<?php
global $_W, $_GPC;
$mesid=intval($_GPC['mesid']);

if(!empty($mesid)){
	
	$result = pdo_delete('nx_information_message', array('mesid' => $mesid));
	if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('message'), 'success');
	} else {
			message('抱歉，删除失败！', $this -> createWebUrl('message'), 'error');
	}
	
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('message'), 'error');
}




	
	


?>