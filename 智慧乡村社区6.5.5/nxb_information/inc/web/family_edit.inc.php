<?php
global $_W, $_GPC;
$fid=intval($_GPC['fid']);
//查询户记录
$huslist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_hus')." WHERE weid=:weid ORDER BY hid DESC",array(':weid'=>$_W['uniacid']));

if($fid){
	$res=pdo_fetch("SELECT * FROM ".tablename('nx_information_family')." WHERE fid=:fid",array(':fid'=>$fid));
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
			'city'=>$_GPC['city'],
			'county'=>$_GPC['county'],
			'town'=>$_GPC['town'],
			'village'=>$_GPC['village'],
			'bianma'=>$bianma,
			'mbianma'=>$_GPC['mbianma'],
			'fname'=>$_GPC['fname'],
			'sex'=>$_GPC['sex'],
			'id_card'=>$_GPC['id_card'],
			'guanxi'=>$_GPC['guanxi'],
			'nation'=>$_GPC['nation'],
			'education'=>$_GPC['education'],
			'school'=>$_GPC['school'],			
			'healthy'=>$_GPC['healthy'],
			'skill'=>$_GPC['skill'],			
			'workers'=>$_GPC['workers'],
			'workerstime'=>$_GPC['workerstime'],
			'medicalinsurance'=>$_GPC['medicalinsurance'],				
			'tpattr'=>$_GPC['tpattr'],
			'pkhattr'=>$_GPC['pkhattr'],
			'reason'=>$_GPC['reason'],
			'wfh'=>$_GPC['wfh'],
			'ysaq'=>$_GPC['ysaq'],	
			'yskn'=>$_GPC['yskn'],		
			'income'=>$_GPC['income'],
			'tel'=>$_GPC['tel'],
			'domicile'=>$_GPC['domicile'],				
			'residence'=>$_GPC['residence'],
			'political'=>$_GPC['political'],
			'marriage'=>$_GPC['marriage'],
			'flow'=>$_GPC['flow'],
			'home'=>$_GPC['home'],			
			'identity'=>$_GPC['identity'],
			'birth'=>$_GPC['birth'],
			'remark'=>$_GPC['remark'],				

			
			 );
		$res = pdo_update('nx_information_family', $newdata,array('fid'=>$fid));
		if (!empty($res)) {
			message('恭喜，编辑成功！', $this -> createWebUrl('family'), 'success');
		} else {
			message('抱歉，编辑失败！', $this -> createWebUrl('family'), 'error');
		}

	}
}


	
include $this->template('web/family_edit');
?>