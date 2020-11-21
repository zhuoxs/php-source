<?php
global $_W, $_GPC;
$proid=intval($_GPC['proid']);

if(!empty($proid)){
	
	$result = pdo_delete('nx_information_project', array('proid' => $proid));
	if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('project'), 'success');
	} else {
			message('抱歉，删除失败！', $this -> createWebUrl('project'), 'error');
	}
	
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('project'), 'error');
}




	
	


?>