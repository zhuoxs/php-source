<?php
global $_W, $_GPC;
$meid=intval($_GPC['meid']);

if(!empty($meid)){
	
	$newsnum=pdo_fetchcolumn("SELECT count(nid) FROM ".tablename('bc_community_news')." WHERE weid=".$_W['uniacid']." AND nmenu=".$meid);
	if($newsnum!=0){
		message('抱歉，删除失败，这个栏目下有'.$newsnum.'篇帖子！需要清除本栏目下所有帖子才可以删除本栏目！', $this -> createWebUrl('menu'), 'error');
	}else{
		
		$result = pdo_delete('bc_community_menu', array('meid' => $meid));
			if (!empty($result)) {
				message('恭喜，删除成功！', $this -> createWebUrl('menu'), 'success');
			} else {
				message('抱歉，删除失败！', $this -> createWebUrl('menu'), 'error');
		}
	
		
		
	}
	
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('menu'), 'error');
}



	
	


?>