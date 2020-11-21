<?php
global $_W, $_GPC;
load()->web('tpl'); 



//添加
if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'weid'=>$_W['uniacid'],
			'pid'=>0,
			'cicon'=>$_GPC['cicon'],
			'ctitle'=>$_GPC['ctitle'],
			'status'=>1,
			'danyuan'=>0,
			'menpai'=>0,
			'ctime'=>time(),
			 );
		$res = pdo_insert('bc_community_mall_category', $newdata);
		if (!empty($res)) {
			message('恭喜，发布成功！', $this -> createWebUrl('mall'), 'success');
		} else {
			message('抱歉，发布失败！', $this -> createWebUrl('mall'), 'error');
		}

	}

}else{
	
	
	$catlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_mall_category')." WHERE weid=:uniacid AND pid=0 ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));
	
	include $this->template('web/mall');	
	
}


?>