<?php
global $_W, $_GPC;
load()->web('tpl'); 



//基础设置
if ($_W['ispost']) {
	if (checksubmit('submit')) {


	$res=pdo_fetch("SELECT * FROM".tablename('bc_community_jurisdiction')."WHERE weid=:uniacid AND lev=0 AND pid=0",array(':uniacid'=>$_W['uniacid']));
	
	if(empty($res)){
		$newdata = array(
			'weid'=>$_W['uniacid'],
			'lev'=>$_GPC['lev'],
			'pid'=>0,
			'uname'=>$_GPC['uname'],
			'upsd'=>md5($_GPC['upsd']),
			'townid'=>0,
			'ctime'=>time(),
			 );
		$res = pdo_insert('bc_community_jurisdiction', $newdata);
		if (!empty($res)) {
			message('恭喜，设置成功！', $this -> createWebUrl('jurisdiction'), 'success');
		} else {
			message('抱歉，设置失败！', $this -> createWebUrl('jurisdiction'), 'error');
		}
	}else{
		$newdata = array(
			'uname'=>$_GPC['uname'],
			'upsd'=>md5($_GPC['upsd']),
			 );
		$res = pdo_update('bc_community_jurisdiction', $newdata,array('id'=>$res['id']));
		if (!empty($res)) {
			message('恭喜，设置成功！', $this -> createWebUrl('jurisdiction'), 'success');
		} else {
			message('抱歉，设置失败！', $this -> createWebUrl('jurisdiction'), 'error');
		}
	}


		

	}

}else{
	
	//获取权限设置
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_jurisdiction')." WHERE weid=:uniacid AND lev=0 AND pid=0",array(':uniacid'=>$_W['uniacid']));

	include $this->template('web/jurisdiction');	
	
}


?>