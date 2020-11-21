<?php
global $_W, $_GPC;
load()->web('tpl'); 


//查询户记录
$huslist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_hus')." WHERE weid=:weid ORDER BY hid DESC",array(':weid'=>$_W['uniacid']));

//添加转移性收入记录
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
			'rarul'=>$_GPC['rarul'],
			'pname'=>$_GPC['pname'],
			'ptel'=>$_GPC['ptel'],
			'transfer'=>$_GPC['transfer'],
			'grossincome'=>$_GPC['grossincome'],
			'farmland'=>$_GPC['farmland'],
			'grassland'=>$_GPC['grassland'],
			'commonweal'=>$_GPC['commonweal'],
			'farmer'=>$_GPC['farmer'],			
			'seed'=>$_GPC['seed'],
			'allowances'=>$_GPC['allowances'],
			'birth'=>$_GPC['birth'],
			'poverty'=>$_GPC['poverty'],
			'insurance'=>$_GPC['insurance'],
			'pension'=>$_GPC['pension'],
			'advancedage'=>$_GPC['advancedage'],
			'disability'=>$_GPC['disability'],
			'sociology'=>$_GPC['sociology'],
			'other'=>$_GPC['other'],	
			'tractime'=>time(),
			 );
		$res = pdo_insert('nx_information_transfer', $newdata);
		if (!empty($res)) {
			message('恭喜，发布成功！', $this -> createWebUrl('transfer'), 'success');
		} else {
			message('抱歉，发布失败！', $this -> createWebUrl('transfer'), 'error');
		}

	}

}else{
	
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$breedlist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_transfer')." WHERE weid=:uniacid ORDER BY traid DESC LIMIT ". ($pindex -1) * $psize . ",{$psize}",array(':uniacid'=>$_W['uniacid']));
    $total = pdo_fetchcolumn("SELECT count(traid) FROM " . tablename('nx_information_transfer') ." WHERE weid=:uniacid ORDER BY traid DESC",array(':uniacid'=>$_W['uniacid']));
    $pager = pagination($total, $pindex, $psize);

	include $this->template('web/transfer');	
	
}


?>