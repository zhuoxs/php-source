<?php
global $_W, $_GPC;
$id=intval($_GPC['id']);

if($id){
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_category')." WHERE id=:id",array(':id'=>$id));
}

if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'cicon'=>$_GPC['cicon'],
			'ctitle'=>$_GPC['ctitle'],
		
			 );
		$res = pdo_update('bc_community_mall_category', $newdata,array('id'=>$id));
		if (!empty($res)) {
			message('恭喜，编辑成功！', $this -> createWebUrl('mall'), 'success');
		} else {
			message('抱歉，编辑失败！', $this -> createWebUrl('mall'), 'error');
		}

	}
}




include $this->template('web/mall_cat_edit');
?>