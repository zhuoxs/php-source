<?php
global $_W, $_GPC;
$roid=intval($_GPC['roid']);

if($roid){
	$res=pdo_fetch("SELECT * FROM ".tablename('nx_information_role')." WHERE roid=:roid",array(':roid'=>$roid));
}

if ($_W['ispost']) {
	if (checksubmit('submit')) {
		if($_GPC['password']==''){
			message('密码不能为空哦！', $this -> createWebUrl('role'), 'error');
		}
		$newdata = array(
			'mid'=>$_GPC['mid'],	
			'rolelevel'=>$_GPC['rolelevel'],	
			'rolename'=>$_GPC['rolename'],
			'password'=>md5($_GPC['password']),	
			'rostatus'=>$_GPC['rostatus'],		
			 );
		$res = pdo_update('nx_information_role', $newdata,array('roid'=>$roid));
		if (!empty($res)) {
			message('恭喜，编辑成功！', $this -> createWebUrl('role'), 'success');
		} else {
			message('抱歉，编辑失败！', $this -> createWebUrl('role'), 'error');
		}

	}
}


	
include $this->template('web/role_edit');
?>