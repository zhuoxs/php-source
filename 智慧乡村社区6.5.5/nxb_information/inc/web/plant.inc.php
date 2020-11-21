<?php
global $_W, $_GPC;
load()->web('tpl'); 


//查询户记录
$huslist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_hus')." WHERE weid=:weid ORDER BY hid DESC",array(':weid'=>$_W['uniacid']));

//添加种植性收入记录
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
			'plactime'=>time(),
			 );
		$res = pdo_insert('nx_information_plant', $newdata);
		if (!empty($res)) {
			message('恭喜，发布成功！', $this -> createWebUrl('plant'), 'success');
		} else {
			message('抱歉，发布失败！', $this -> createWebUrl('plant'), 'error');
		}

	}

}else{
	
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$plantlist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_plant')." WHERE weid=:uniacid ORDER BY plaid DESC LIMIT ". ($pindex -1) * $psize . ",{$psize}",array(':uniacid'=>$_W['uniacid']));
    $total = pdo_fetchcolumn("SELECT count(plaid) FROM " . tablename('nx_information_plant') ." WHERE weid=:uniacid ORDER BY plaid DESC",array(':uniacid'=>$_W['uniacid']));
    $pager = pagination($total, $pindex, $psize);
	
	include $this->template('web/plant');	
	
}


?>