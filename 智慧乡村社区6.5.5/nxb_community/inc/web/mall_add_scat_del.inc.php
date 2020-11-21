<?php
global $_W, $_GPC;
$id=intval($_GPC['id']);
$pid=intval($_GPC['pid']);

if(!empty($id)){
	
	//查询此分类下是否有商品
	$res=pdo_fetchall("SELECT * FROM ".tablename('bc_community_mall_category')." WHERE weid=:uniacid AND ptid=:id ORDER BY id DESC",array(':uniacid'=>$_W['uniacid'],':id'=>$id));
	if(!empty($res)){
		message('此分类下还有商品，请先删除它的所有商品！', $this -> createWebUrl('mall'), 'success');
	}else{
		$result = pdo_delete('bc_community_mall_category', array('id' => $id));
		if (!empty($result)) {
			message('恭喜，删除成功！', $this -> createWebUrl('mall_add_scat',array('id'=>$pid)), 'success');
		} else {
			message('抱歉，删除失败！', $this -> createWebUrl('mall_add_scat',array('id'=>$pid)), 'error');
		}
	}
	
	
	
	
	
}else{
	
	message('抱歉，删除失败！', $this -> createWebUrl('mall_add_scat',array('id'=>$pid)), 'error');
}



	
	


?>