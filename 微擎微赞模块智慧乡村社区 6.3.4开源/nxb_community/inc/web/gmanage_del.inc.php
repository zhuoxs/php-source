<?php
global $_W, $_GPC;
$gmid=intval($_GPC['gmid']);

if(!empty($gmid)){
	
	$result = pdo_delete('bc_community_gmanage', array('gmid' => $gmid));
	if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('gmanage'), 'success');
	} else {
			message('抱歉，删除失败！', $this -> createWebUrl('gmanage'), 'error');
	}
	
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('gmanage'), 'error');
}



	
	


?>