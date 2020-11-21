<?php
global $_W, $_GPC;
$plaid=intval($_GPC['plaid']);

if(!empty($plaid)){
	
	$result = pdo_delete('nx_information_plant', array('plaid' => $plaid));
	if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('plant'), 'success');
	} else {
			message('抱歉，删除失败！', $this -> createWebUrl('plant'), 'error');
	}
	
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('plant'), 'error');
}




	
	


?>