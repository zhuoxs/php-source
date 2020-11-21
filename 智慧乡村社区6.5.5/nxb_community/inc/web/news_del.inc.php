<?php
global $_W, $_GPC;
$nid=intval($_GPC['newsid']);

if(!empty($nid)){
	
	$result = pdo_delete('bc_community_news', array('nid' => $nid));
	if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('news'), 'success');
	} else {
			message('抱歉，删除失败！', $this -> createWebUrl('news'), 'error');
	}
	
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('news'), 'error');
}



	
	


?>