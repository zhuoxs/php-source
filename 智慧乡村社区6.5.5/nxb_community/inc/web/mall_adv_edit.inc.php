<?php
global $_W, $_GPC;
$id=intval($_GPC['id']);

if($id){
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_banner')." WHERE id=:id",array(':id'=>$id));
}

if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'simg'=>$_GPC['simg'],
			'surl'=>$_GPC['surl'],
			'stitle'=>$_GPC['stitle'],
			 );
		$res = pdo_update('bc_community_mall_banner', $newdata,array('id'=>$id));
		if (!empty($res)) {
			message('恭喜，编辑成功！', $this -> createWebUrl('mall_adv'), 'success');
		} else {
			message('抱歉，编辑失败！', $this -> createWebUrl('mall_adv'), 'error');
		}

	}
}




include $this->template('web/mall_adv_edit');
?>