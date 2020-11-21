<?php
global $_W, $_GPC;
load()->web('tpl'); 


//查询户记录
$huslist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_hus')." WHERE weid=:weid ORDER BY hid DESC",array(':weid'=>$_W['uniacid']));

//添加贫困户
if ($_W['ispost']) {
	if (checksubmit('submit')) {
		
		$hid=intval($_GPC['hid']);
		$hus=pdo_fetch("SELECT * FROM ".tablename('nx_information_hus')." WHERE hid=:hid ",array(':hid'=>$hid));
		$bianma='';
		if(!empty($hus)){
			$bianma=$hus['bianma'];
		}
		
		$images=implode("|",$_GPC['photo']);
		$newdata = array(
			'weid'=>$_W['uniacid'],
			'hid'=>$hid,
			'bianma'=>$bianma,
			'photo'=>$images,
			'issuingauthority'=>$_GPC['issuingauthority'],
			'cardname'=>$_GPC['cardname'],
			'address'=>$_GPC['address'],
			'standard'=>$_GPC['standard'],
			'attribute'=>$_GPC['attribute'],
			'degree'=>$_GPC['degree'],
			'starttime'=>$_GPC['starttime'],
			'pname'=>$_GPC['pname'],
			'sex'=>$_GPC['sex'],
			'idcard'=>$_GPC['idcard'],			
			'yktcard'=>$_GPC['yktcard'],
			'zrk'=>$_GPC['zrk'],			
			'ldl'=>$_GPC['ldl'],
			'gdmj'=>$_GPC['gdmj'],
			'tgmj'=>$_GPC['tgmj'],				
			'ggmj'=>$_GPC['ggmj'],
			'fueltype'=>$_GPC['fueltype'],
			'wather'=>$_GPC['wather'],
			'broadcast'=>$_GPC['broadcast'],
			'house'=>$_GPC['house'],			
			'reason'=>$_GPC['reason'],
			'pctime'=>time(),
			 );
		$res = pdo_insert('nx_information_pinkuns', $newdata);
		if (!empty($res)) {
			message('恭喜，发布成功！', $this -> createWebUrl('poor'), 'success');
		} else {
			message('抱歉，发布失败！', $this -> createWebUrl('poor'), 'error');
		}

	}

}else{
	
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$poorlist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_pinkuns')." WHERE weid=:uniacid ORDER BY pid DESC LIMIT ". ($pindex -1) * $psize . ",{$psize}",array(':uniacid'=>$_W['uniacid']));
    $total = pdo_fetchcolumn("SELECT count(pid) FROM " . tablename('nx_information_pinkuns') ." WHERE weid=:uniacid ORDER BY pid DESC",array(':uniacid'=>$_W['uniacid']));
    $pager = pagination($total, $pindex, $psize);
	
	include $this->template('web/poor');	
	
}


?>