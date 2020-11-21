<?php
global $_W, $_GPC;
load()->web('tpl'); 



//添加管理角色
if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'weid'=>$_W['uniacid'],
			'mid'=>$_GPC['mid'],	
			'rolelevel'=>$_GPC['rolelevel'],	
			'rolename'=>$_GPC['rolename'],
			'password'=>md5($_GPC['password']),	
			'rostatus'=>$_GPC['rostatus'],
			'roctime'=>time(),	
			 );
		$res = pdo_insert('nx_information_role', $newdata);
		if (!empty($res)) {
			message('恭喜，发布成功！', $this -> createWebUrl('role'), 'success');
		} else {
			message('抱歉，发布失败！', $this -> createWebUrl('role'), 'error');
		}

	}

}else{
	
	
	
	//获取角色列表
	$rolelist=pdo_fetchall("SELECT * FROM".tablename('nx_information_role')."WHERE weid=:uniacid ORDER BY roid DESC",array(':uniacid'=>$_W['uniacid']));

	include $this->template('web/role');	
	
}


?>