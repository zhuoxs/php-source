<?php
global $_W, $_GPC;
load()->web('tpl'); 



//添加村民信息
if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'weid'=>$_W['uniacid'],
			'realname'=>$_GPC['realname'],
			'identitycard'=>$_GPC['identitycard'],
			'inctime'=>time(),
			 );
		$res = pdo_insert('bc_community_information', $newdata);
		if (!empty($res)) {
			message('恭喜，发布成功！', $this -> createWebUrl('information'), 'success');
		} else {
			message('抱歉，发布失败！', $this -> createWebUrl('information'), 'error');
		}

	}

}else{
	
	//获取村民信息库所有记录
	$informationlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_information')." WHERE weid=:uniacid ORDER BY inid DESC",array(':uniacid'=>$_W['uniacid']));
	
	include $this->template('web/information');	
	
}


?>