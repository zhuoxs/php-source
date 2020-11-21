<?php
global $_W, $_GPC;
$inid=intval($_GPC['inid']);

if(!empty($inid)){
	
	$result = pdo_delete('bc_community_information', array('inid' => $inid));
	if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('information'), 'success');
	} else {
			message('抱歉，删除失败！', $this -> createWebUrl('information'), 'error');
	}
	
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('information'), 'error');
}



	
	


?>