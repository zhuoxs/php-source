<?php
global $_W, $_GPC;
load()->web('tpl'); 



//添加干部记录
if ($_W['ispost']) {
	if (checksubmit('submit')) {
		
		
		$images=implode("|",$_GPC['avatar']);
		
		$newdata = array(
			'weid'=>$_W['uniacid'],
			'mid'=>0,
			'cname'=>$_GPC['cname'],
			'post'=>$_GPC['post'],
			'company'=>$_GPC['company'],
			'avatar'=>$images,
			'phone'=>$_GPC['phone'],
			'sex'=>$_GPC['sex'],
			'idcard'=>$_GPC['idcard'],
			'nomberone'=>$_GPC['nomberone'],
			'duizhang'=>$_GPC['duizhang'],
			'starttime'=>$_GPC['starttime'],
			'endtime'=>$_GPC['endtime'],
			'techang'=>$_GPC['techang'],
			'zhengzhi'=>$_GPC['zhengzhi'],
			'xueli'=>$_GPC['xueli'],
			'address'=>$_GPC['address'],
			'remark'=>$_GPC['remark'],
			'cadctime'=>time(),
			 );
		$res = pdo_insert('nx_information_cadre', $newdata);
		if (!empty($res)) {
			message('恭喜，发布成功！', $this -> createWebUrl('cadre'), 'success');
		} else {
			message('抱歉，发布失败！', $this -> createWebUrl('cadre'), 'error');
		}

	}

}else{
	
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$cadrelist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_cadre')." WHERE weid=:uniacid ORDER BY cadid DESC LIMIT ". ($pindex -1) * $psize . ",{$psize}",array(':uniacid'=>$_W['uniacid']));
    $total = pdo_fetchcolumn("SELECT count(cadid) FROM " . tablename('nx_information_cadre') ." WHERE weid=:uniacid ORDER BY cadid DESC",array(':uniacid'=>$_W['uniacid']));
    $pager = pagination($total, $pindex, $psize);

	include $this->template('web/cadre');	
	
}


?>