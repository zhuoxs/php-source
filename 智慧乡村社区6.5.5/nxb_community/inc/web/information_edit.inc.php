<?php
global $_W, $_GPC;
$inid=intval($_GPC['inid']);

if($inid){
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_information')." WHERE inid=:inid",array(':inid'=>$inid));
}

if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'realname'=>$_GPC['realname'],
			'identitycard'=>$_GPC['identitycard'],			
			 );
		$result = pdo_update('bc_community_information', $newdata,array('inid'=>$inid));
		if (!empty($result)) {
			cache_delete('webtoken');
			cache_delete('manageid');
			message('恭喜，编辑成功！', $this -> createWebUrl('information'), 'success');
		} else {
			message('抱歉，编辑失败！', $this -> createWebUrl('information'), 'error');
		}

	}
}




include $this->template('web/information_edit');


?>