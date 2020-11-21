<?php
global $_W, $_GPC;
$plaid=intval($_GPC['plaid']);
//查询户记录
$huslist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_hus')." WHERE weid=:weid ORDER BY hid DESC",array(':weid'=>$_W['uniacid']));

if($plaid){
	$res=pdo_fetch("SELECT * FROM ".tablename('nx_information_plant')." WHERE plaid=:plaid",array(':plaid'=>$plaid));
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
			'rarul'=>$_GPC['rarul'],
			'pname'=>$_GPC['pname'],
			'ptel'=>$_GPC['ptel'],
			'management'=>$_GPC['management'],
			'varieties'=>$_GPC['varieties'],
			'area'=>$_GPC['area'],
			'address'=>$_GPC['address'],
			'photo'=>$images,
			'yield'=>$_GPC['yield'],
			'price'=>$_GPC['price'],
			'grossincome'=>$_GPC['grossincome'],			
			'costexpenditure'=>$_GPC['costexpenditure'],
			'netincome'=>$_GPC['netincome'],
			
			
			 );
		$res = pdo_update('nx_information_plant', $newdata,array('plaid'=>$plaid));
		if (!empty($res)) {
			message('恭喜，编辑成功！', $this -> createWebUrl('plant'), 'success');
		} else {
			message('抱歉，编辑失败！', $this -> createWebUrl('plant'), 'error');
		}

	}
}


	
include $this->template('web/plant_edit');
?>