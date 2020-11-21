<?php
global $_W, $_GPC;
$mesid=intval($_GPC['mesid']);
//查询户记录
$huslist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_hus')." WHERE weid=:weid ORDER BY hid DESC",array(':weid'=>$_W['uniacid']));

//查询户记录
$huslist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_hus')." WHERE weid=:weid ORDER BY hid DESC",array(':weid'=>$_W['uniacid']));
//查询干部记录
$cadrelist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_cadre')." WHERE weid=:weid ORDER BY cadid DESC",array(':weid'=>$_W['uniacid']));

if($mesid){
	$res=pdo_fetch("SELECT * FROM ".tablename('nx_information_message')." WHERE mesid=:mesid",array(':mesid'=>$mesid));
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
			
			
			 );
		$res = pdo_update('nx_information_message', $newdata,array('mesid'=>$mesid));
		if (!empty($res)) {
			message('恭喜，编辑成功！', $this -> createWebUrl('message'), 'success');
		} else {
			message('抱歉，编辑失败！', $this -> createWebUrl('message'), 'error');
		}

	}
}


	
include $this->template('web/message_edit');
?>