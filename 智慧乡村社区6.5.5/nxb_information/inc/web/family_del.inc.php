<?php
global $_W, $_GPC;
$fid=intval($_GPC['fid']);

if(!empty($fid)){
	
	$result = pdo_delete('nx_information_family', array('fid' => $fid));
	if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('family'), 'success');
	} else {
			message('抱歉，删除失败！', $this -> createWebUrl('family'), 'error');
	}
	
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('family'), 'error');
}



	
	


?>