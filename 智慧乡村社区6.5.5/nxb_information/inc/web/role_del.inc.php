<?php
global $_W, $_GPC;
$roid=intval($_GPC['roid']);

if(!empty($roid)){
	
	$result = pdo_delete('nx_information_role', array('roid' => $roid));
	if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('role'), 'success');
	} else {
			message('抱歉，删除失败！', $this -> createWebUrl('role'), 'error');
	}
	
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('role'), 'error');
}



	
	


?>