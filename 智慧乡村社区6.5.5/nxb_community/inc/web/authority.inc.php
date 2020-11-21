<?php
global $_W, $_GPC;
load()->web('tpl'); 



//添加问题类型
if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'weid'=>$_W['uniacid'],
			'authortitle'=>$_GPC['authortitle'],
			'createtime'=>time(),
			 );
		$res = pdo_insert('bc_community_authority', $newdata);
		if (!empty($res)) {
			message('恭喜，发布成功！', $this -> createWebUrl('authority'), 'success');
		} else {
			message('抱歉，发布失败！', $this -> createWebUrl('authority'), 'error');
		}

	}

}else{
	
	//获取问题类型列表
	$typelist=pdo_fetchall("SELECT * FROM".tablename('bc_community_authority')."WHERE weid=:uniacid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));
	
	include $this->template('web/authority');	
	
}


?>