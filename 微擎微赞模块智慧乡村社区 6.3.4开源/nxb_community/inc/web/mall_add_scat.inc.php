<?php
global $_W, $_GPC;
load()->web('tpl'); 

$pid=intval($_GPC['id']);
if($pid!=0){
	$mallcat=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_category')." WHERE id=:pid",array(':pid'=>$pid));
}else{
	message('参数有误！', $this -> createWebUrl('mall'), 'error');
}

//添加
if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'weid'=>$_W['uniacid'],
			'pid'=>$pid,
			'cicon'=>$_GPC['cicon'],
			'ctitle'=>$_GPC['ctitle'],
			'status'=>1,
			'danyuan'=>0,
			'menpai'=>0,
			'ctime'=>time(),
			 );
		$res = pdo_insert('bc_community_mall_category', $newdata);
		if (!empty($res)) {
			message('恭喜，发布成功！', $this -> createWebUrl('mall_add_scat',array('id'=>$pid)), 'success');
		} else {
			message('抱歉，发布失败！', $this -> createWebUrl('mall_add_scat',array('id'=>$pid)), 'error');
		}

	}

}else{
	
	
	$catlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_mall_category')." WHERE weid=:uniacid AND pid=:pid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid'],':pid'=>$pid));
	
	include $this->template('web/mall_add_scat');	
	
}


?>