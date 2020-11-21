<?php
global $_W, $_GPC;
$id=intval($_GPC['id']);

if($id!=0){
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_authority')." WHERE id=:id",array(':id'=>$id));
}

if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'authortitle'=>$_GPC['authortitle'],		
			 );
		$res = pdo_update('bc_community_authority', $newdata,array('id'=>$id));
		if (!empty($res)) {
			message('恭喜，编辑成功！', $this -> createWebUrl('authority'), 'success');
		} else {
			message('抱歉，编辑失败！', $this -> createWebUrl('authority'), 'error');
		}

	}
}




include $this->template('web/authority_edit');
?>