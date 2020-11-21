<?php
global $_W, $_GPC;
$id=intval($_GPC['id']);

if($id){
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_nav')." WHERE id=:id",array(':id'=>$id));
}

if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'nicon'=>$_GPC['nicon'],
			'ntitle'=>$_GPC['ntitle'],
			'nurl'=>$_GPC['nurl'],
			 );
		$res = pdo_update('bc_community_mall_nav', $newdata,array('id'=>$id));
		if (!empty($res)) {
			message('恭喜，编辑成功！', $this -> createWebUrl('mall_nav'), 'success');
		} else {
			message('抱歉，编辑失败！', $this -> createWebUrl('mall_nav'), 'error');
		}

	}
}




include $this->template('web/mall_nav_edit');
?>