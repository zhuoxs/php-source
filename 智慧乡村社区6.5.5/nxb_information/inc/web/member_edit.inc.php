<?php
global $_W, $_GPC;
include 'common.php';
load()->web('tpl'); 
$mid=$_GPC['mid'];

	
	//获取用户信息
	$member=pdo_fetch("SELECT * FROM ".tablename('nx_information_member')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));
	
	
if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'idcard'=>$_GPC[''],
			'grade'=>$_GPC[''],
			'realname'=>$_GPC[''],
			'tel'=>$_GPC[''],
			'address'=>$_GPC[''],		
		);
		$res = pdo_update('nx_information_member', $newdata,array('mid'=>$mid));
		if (!empty($res)) {
			message('恭喜，编辑成功！', $this -> createWebUrl('member'), 'success');
		} else {
			message('抱歉，编辑失败！', $this -> createWebUrl('member'), 'error');
		}

	}
}
	
	

	
	
	include $this->template('web/member_edit');	
	


?>