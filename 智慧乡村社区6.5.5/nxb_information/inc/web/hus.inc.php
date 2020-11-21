<?php
global $_W, $_GPC;
load()->web('tpl'); 



//添加户
if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'weid'=>$_W['uniacid'],
			'mid'=>0,	
			'bianma'=>$_GPC['bianma'],	
			'hu_no'=>$_GPC['hu_no'],
			'fang_no'=>$_GPC['fang_no'],	
			'huzhu'=>$_GPC['huzhu'],
			'phone'=>$_GPC['phone'],
			'data'=>$_GPC['data'],
			'husctime'=>time(),	
			 );
		$res = pdo_insert('nx_information_hus', $newdata);
		if (!empty($res)) {
			message('恭喜，发布成功！', $this -> createWebUrl('hus'), 'success');
		} else {
			message('抱歉，发布失败！', $this -> createWebUrl('hus'), 'error');
		}

	}

}else{
	
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$huslist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_hus')." WHERE weid=:uniacid ORDER BY hid DESC LIMIT ". ($pindex -1) * $psize . ",{$psize}",array(':uniacid'=>$_W['uniacid']));
    $total = pdo_fetchcolumn("SELECT count(hid) FROM " . tablename('nx_information_hus') ." WHERE weid=:uniacid ORDER BY hid DESC",array(':uniacid'=>$_W['uniacid']));
    $pager = pagination($total, $pindex, $psize);
	
	include $this->template('web/hus');	
	
}


?>