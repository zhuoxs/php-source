<?php
global $_W, $_GPC;
$hid=intval($_GPC['hid']);

if(!empty($hid)){
	
	$result = pdo_delete('nx_information_hus', array('hid' => $hid));
	if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('hus'), 'success');
	} else {
			message('抱歉，删除失败！', $this -> createWebUrl('hus'), 'error');
	}
	
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('hus'), 'error');
}



	
	


?>