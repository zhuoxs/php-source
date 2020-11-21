<?php
global $_W, $_GPC;
load()->web('tpl'); 


//查询户记录
$huslist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_hus')." WHERE weid=:weid ORDER BY hid DESC",array(':weid'=>$_W['uniacid']));

//添加家庭成员
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
			'factime'=>time(),
			 );
		$res = pdo_insert('nx_information_family', $newdata);
		if (!empty($res)) {
			message('恭喜，发布成功！', $this -> createWebUrl('family'), 'success');
		} else {
			message('抱歉，发布失败！', $this -> createWebUrl('family'), 'error');
		}

	}

}else{
	
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$familylist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_family')." WHERE weid=:uniacid ORDER BY fid DESC LIMIT ". ($pindex -1) * $psize . ",{$psize}",array(':uniacid'=>$_W['uniacid']));
    $total = pdo_fetchcolumn("SELECT count(fid) FROM " . tablename('nx_information_family') ." WHERE weid=:uniacid ORDER BY fid DESC",array(':uniacid'=>$_W['uniacid']));
    $pager = pagination($total, $pindex, $psize);
	
	include $this->template('web/family');	
	
}


?>