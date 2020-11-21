<?php
global $_W, $_GPC;
$traid=intval($_GPC['traid']);
//查询户记录
$huslist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_hus')." WHERE weid=:weid ORDER BY hid DESC",array(':weid'=>$_W['uniacid']));

if($traid){
	$res=pdo_fetch("SELECT * FROM ".tablename('nx_information_transfer')." WHERE traid=:traid",array(':traid'=>$traid));
}

if ($_W['ispost']) {
	if (checksubmit('submit')) {
		$hid=intval($_GPC['hid']);
		$hus=pdo_fetch("SELECT * FROM ".tablename('nx_information_hus')." WHERE hid=:hid ",array(':hid'=>$hid));
		$bianma='';
		if(!empty($hus)){
			$bianma=$hus['bianma'];
		}
		
		
		
		
		$newdata = array(
			

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
			
			
			
			 );
		$res = pdo_update('nx_information_transfer', $newdata,array('traid'=>$traid));
		if (!empty($res)) {
			message('恭喜，编辑成功！', $this -> createWebUrl('transfer'), 'success');
		} else {
			message('抱歉，编辑失败！', $this -> createWebUrl('transfer'), 'error');
		}

	}
}


	
include $this->template('web/transfer_edit');
?>