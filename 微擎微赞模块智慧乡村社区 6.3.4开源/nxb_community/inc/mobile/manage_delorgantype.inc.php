<?php
global $_W, $_GPC;

$id=intval($_GPC['id']);

	//查询此组织分类下是否有成员,有成员就不能直接删除
	$res=pdo_fetchall("SELECT * FROM ".tablename('bc_community_organuser')." WHERE weid=:uniacid AND organid=:organid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid'],':organid'=>$id));
	

	if(!empty($res)){
		echo json_encode(array('status'=>2,'log'=>'该组织有成员,请删除这个组织下所有成员可删除这个分类'));
	}else{
		$result = pdo_delete('bc_community_organlev', array('id' => $id));
		if (!empty($result)) {
			echo json_encode(array('status'=>1,'log'=>'删除成功'));
		} else {
			echo json_encode(array('status'=>0,'log'=>'删除失败'));
		}
	
	}
	
	
	
	
