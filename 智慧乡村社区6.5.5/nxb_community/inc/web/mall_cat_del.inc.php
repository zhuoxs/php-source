<?php
global $_W, $_GPC;
$id=intval($_GPC['id']);

if(!empty($id)){
	
	//查询此分类下是否有二级分类
	$res=pdo_fetchall("SELECT * FROM ".tablename('bc_community_mall_category')." WHERE weid=:uniacid AND pid=:id ORDER BY id DESC",array(':uniacid'=>$_W['uniacid'],':id'=>$id));
	if(!empty($res)){
		message('此分类下还有二级分类，请先删除它的二级分类！', $this -> createWebUrl('mall'), 'success');
	}else{
		$result = pdo_delete('bc_community_mall_category', array('id' => $id));
		if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('mall'), 'success');
		} else {
			message('抱歉，删除失败！', $this -> createWebUrl('mall'), 'error');
		}
	}
	
	
	
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('mall'), 'error');
}



	
	


?>