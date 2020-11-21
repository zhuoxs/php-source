<?php
global $_W, $_GPC;
$pid=intval($_GPC['pid']);
//查询户记录
$huslist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_hus')." WHERE weid=:weid ORDER BY hid DESC",array(':weid'=>$_W['uniacid']));

if($pid){
	$res=pdo_fetch("SELECT * FROM ".tablename('nx_information_pinkuns')." WHERE pid=:pid",array(':pid'=>$pid));
}

if ($_W['ispost']) {
	if (checksubmit('submit')) {
		$hid=intval($_GPC['hid']);
		$hus=pdo_fetch("SELECT * FROM ".tablename('nx_information_hus')." WHERE hid=:hid ",array(':hid'=>$hid));
		$bianma='';
		if(!empty($hus)){
			$bianma=$hus['bianma'];
		}
		
		
			
		$images=$_GPC['photo'];
		if(empty($images)){
			$images=$res['photo'];
		}
		
		
		$newdata = array(
			
	
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
			
			
			 );
		$res = pdo_update('nx_information_pinkuns', $newdata,array('pid'=>$pid));
		if (!empty($res)) {
			message('恭喜，编辑成功！', $this -> createWebUrl('poor'), 'success');
		} else {
			message('抱歉，编辑失败！', $this -> createWebUrl('poor'), 'error');
		}

	}
}


	
include $this->template('web/poor_edit');
?>