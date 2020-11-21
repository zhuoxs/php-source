<?php
global $_W, $_GPC;
load()->web('tpl'); 


//查询户记录
$huslist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_hus')." WHERE weid=:weid ORDER BY hid DESC",array(':weid'=>$_W['uniacid']));

//查询户记录
$huslist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_hus')." WHERE weid=:weid ORDER BY hid DESC",array(':weid'=>$_W['uniacid']));
//查询干部记录
$cadrelist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_cadre')." WHERE weid=:weid ORDER BY cadid DESC",array(':weid'=>$_W['uniacid']));




//添加帮扶信息记录
if ($_W['ispost']) {
	if (checksubmit('submit')) {
		
		$hid=intval($_GPC['hid']);
		$hus=pdo_fetch("SELECT * FROM ".tablename('nx_information_hus')." WHERE hid=:hid ",array(':hid'=>$hid));
		$bianma='';
		if(!empty($hus)){
			$bianma=$hus['bianma'];
		}
		
		
		
		$newdata = array(
			'weid'=>$_W['uniacid'],
			'hid'=>$hid,
			'bianma'=>$bianma,
			'cadid'=>$_GPC['cadid'],
			'familynum'=>$_GPC['familynum'],
			'labors'=>$_GPC['labors'],
			'tpdate'=>$_GPC['todate'],
			'aincome'=>$_GPC['aincome'],
			'bincome'=>$_GPC['bincome'],
			'economic'=>$_GPC['economic'],
			'area'=>$_GPC['area'],
			'waterarea'=>$_GPC['waterarea'],			
			'breed'=>$_GPC['breed'],
			'mesctime'=>time(),
			 );
		$res = pdo_insert('nx_information_message', $newdata);
		if (!empty($res)) {
			message('恭喜，发布成功！', $this -> createWebUrl('message'), 'success');
		} else {
			message('抱歉，发布失败！', $this -> createWebUrl('message'), 'error');
		}

	}

}else{
	
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$messagelist=pdo_fetchall("SELECT a.*,b.huzhu,c.cname FROM ".tablename('nx_information_message')." as a left join ".tablename('nx_information_hus')." as b on a.hid=b.hid left join ".tablename('nx_information_cadre')." as c on a.cadid=c.cadid WHERE a.weid=:uniacid ORDER BY mesid DESC LIMIT ". ($pindex -1) * $psize . ",{$psize}",array(':uniacid'=>$_W['uniacid']));
    $total = pdo_fetchcolumn("SELECT count(mesid) FROM " . tablename('nx_information_message') ." WHERE weid=:uniacid ORDER BY mesid DESC",array(':uniacid'=>$_W['uniacid']));
    $pager = pagination($total, $pindex, $psize);

	include $this->template('web/message');	
	
}


?>