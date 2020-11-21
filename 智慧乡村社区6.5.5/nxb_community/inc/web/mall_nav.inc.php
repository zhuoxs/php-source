<?php
global $_W, $_GPC;
load()->web('tpl'); 



//添加
if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'weid'=>$_W['uniacid'],
			'nicon'=>$_GPC['nicon'],
			'ntitle'=>$_GPC['ntitle'],
			'nurl'=>$_GPC['nurl'],
			'danyuan'=>0,
			'menpai'=>0,
			'ctime'=>time(),
			 );
		$res = pdo_insert('bc_community_mall_nav', $newdata);
		if (!empty($res)) {
			message('恭喜，发布成功！', $this -> createWebUrl('mall_nav'), 'success');
		} else {
			message('抱歉，发布失败！', $this -> createWebUrl('mall_nav'), 'error');
		}

	}

}else{
	
	
	$navlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_mall_nav')." WHERE weid=:uniacid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));
	
	include $this->template('web/mall_nav');	
	
}


?>