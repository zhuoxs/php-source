<?php
global $_W, $_GPC;
$breid=intval($_GPC['breid']);
//查询户记录
$huslist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_hus')." WHERE weid=:weid ORDER BY hid DESC",array(':weid'=>$_W['uniacid']));

if($breid){
	$res=pdo_fetch("SELECT * FROM ".tablename('nx_information_breed')." WHERE breid=:breid",array(':breid'=>$breid));
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
			'bname'=>$_GPC['bname'],
			'btel'=>$_GPC['btel'],
			'varieties'=>$_GPC['varieties'],
			'total'=>$_GPC['total'],
			'address'=>$_GPC['address'],
			'photo'=>$images,
			'price'=>$_GPC['price'],
			'grossincome'=>$_GPC['grossincome'],			
			'costexpenditure'=>$_GPC['costexpenditure'],
			'netincome'=>$_GPC['netincome'],
			
			
			 );
		$res = pdo_update('nx_information_breed', $newdata,array('breid'=>$breid));
		if (!empty($res)) {
			message('恭喜，编辑成功！', $this -> createWebUrl('breed'), 'success');
		} else {
			message('抱歉，编辑失败！', $this -> createWebUrl('breed'), 'error');
		}

	}
}


	
include $this->template('web/breed_edit');
?>