<?php
global $_W, $_GPC;
load()->func('tpl'); 



//基础设置
if ($_W['ispost']) {
	if (checksubmit('submit')) {

	//获取基础设置详情
	$base=pdo_fetch("SELECT * FROM".tablename('nx_information_base')."WHERE weid=:uniacid",array(':uniacid'=>$_W['uniacid']));
	if(empty($base)){
		$newdata = array(
			'weid'=>$_W['uniacid'],
			'modularname'=>$_GPC['modularname'],
			'code'=>$_GPC['code'],
			'logo'=>$_GPC['logo'],
			'gzbg'=>$_GPC['gzbg'],
			'remark'=>$_GPC['remark'],
			'sharetitle'=>$_GPC['sharetitle'],
			'sharetext'=>$_GPC['sharetext'],
			'shareimg'=>$_GPC['shareimg'],
			'shareurl'=>$_GPC['shareurl'],
			'bctime'=>time(),
			 );
		$res = pdo_insert('nx_information_base', $newdata);
		if (!empty($res)) {
			message('恭喜，设置成功！', $this -> createWebUrl('base'), 'success');
		} else {
			message('抱歉，设置失败！', $this -> createWebUrl('base'), 'error');
		}
	}else{
		$newdata = array(
			'modularname'=>$_GPC['modularname'],
			'code'=>$_GPC['code'],
			'logo'=>$_GPC['logo'],
			'gzbg'=>$_GPC['gzbg'],
			'remark'=>$_GPC['remark'],
			'sharetitle'=>$_GPC['sharetitle'],
			'sharetext'=>$_GPC['sharetext'],
			'shareimg'=>$_GPC['shareimg'],
			'shareurl'=>$_GPC['shareurl'],
			 );
		$res = pdo_update('nx_information_base', $newdata,array('bid'=>$base['bid']));
		if (!empty($res)) {
			message('恭喜，设置成功！', $this -> createWebUrl('base'), 'success');
		} else {
			message('抱歉，设置失败！', $this -> createWebUrl('base'), 'error');
		}
	}


		

	}

}else{
	
	//获取基础设置详情
	$base=pdo_fetch("SELECT * FROM".tablename('nx_information_base')."WHERE weid=:uniacid",array(':uniacid'=>$_W['uniacid']));

	include $this->template('web/base');	
	
}


?>