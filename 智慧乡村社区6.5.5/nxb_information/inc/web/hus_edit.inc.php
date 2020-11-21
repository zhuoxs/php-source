<?php
global $_W, $_GPC;
$hid=intval($_GPC['hid']);

if($hid){
	$res=pdo_fetch("SELECT * FROM ".tablename('nx_information_hus')." WHERE hid=:hid",array(':hid'=>$hid));
}

if ($_W['ispost']) {
	if (checksubmit('submit')) {
		
		$newdata = array(
			'bianma'=>$_GPC['bianma'],	
			'hu_no'=>$_GPC['hu_no'],
			'fang_no'=>$_GPC['fang_no'],	
			'huzhu'=>$_GPC['huzhu'],
			'phone'=>$_GPC['phone'],
			'data'=>$_GPC['data'],
			 );
		$res = pdo_update('nx_information_hus', $newdata,array('hid'=>$hid));
		if (!empty($res)) {
			message('恭喜，编辑成功！', $this -> createWebUrl('hus'), 'success');
		} else {
			message('抱歉，编辑失败！', $this -> createWebUrl('hus'), 'error');
		}

	}
}


	
include $this->template('web/hus_edit');
?>