<?php
global $_W, $_GPC;
load()->web('tpl'); 



//添加
if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'weid'=>$_W['uniacid'],
			'simg'=>$_GPC['simg'],
			'surl'=>$_GPC['surl'],
			'stitle'=>$_GPC['stitle'],
			'danyuan'=>0,
			'menpai'=>0,
			'ctime'=>time(),
			 );
		$res = pdo_insert('bc_community_mall_banner', $newdata);
		if (!empty($res)) {
			message('恭喜，发布成功！', $this -> createWebUrl('mall_adv'), 'success');
		} else {
			message('抱歉，发布失败！', $this -> createWebUrl('mall_adv'), 'error');
		}

	}

}else{
	
	
	$bannerlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_mall_banner')." WHERE weid=:uniacid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));
	
	include $this->template('web/mall_adv');	
	
}


?>