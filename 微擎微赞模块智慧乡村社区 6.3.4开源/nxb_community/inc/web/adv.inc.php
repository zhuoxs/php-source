<?php
global $_W, $_GPC;
load()->web('tpl'); 



//添加类型
if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'weid'=>$_W['uniacid'],
			'title'=>$_GPC['title'],
			'img'=>$_GPC['img'],
			'url'=>$_GPC['url'],
			'createtime'=>time(),
			 );
		$res = pdo_insert('bc_community_adv', $newdata);
		if (!empty($res)) {
			message('恭喜，发布成功！', $this -> createWebUrl('adv'), 'success');
		} else {
			message('抱歉，发布失败！', $this -> createWebUrl('adv'), 'error');
		}

	}

}else{
	
	//获取广告列表
	$advlist=pdo_fetchall("SELECT * FROM".tablename('bc_community_adv')."WHERE weid=:uniacid ORDER BY aid DESC",array(':uniacid'=>$_W['uniacid']));

	include $this->template('web/adv');	
	
}


?>