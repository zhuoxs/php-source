<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

if(checksubmit('submit')){
	if($_GPC["is_counp_his"]!=$_GPC['is_counp']){
		$data = array();
    	$data['is_counp']  = $_GPC['is_counp'];
    	$res = pdo_update('mzhk_sun_coupon', $data,array('uniacid'=>$_W['uniacid']));
		$res2 = pdo_update('mzhk_sun_system', $data,array('uniacid'=>$_W['uniacid']));
	}
	if($_GPC["is_ptopen_his"]!=$_GPC['is_ptopen']){
		$data = array();
    	$data['is_ptopen']  = $_GPC['is_ptopen'];
    	$res = pdo_update('mzhk_sun_goods', $data,array('uniacid'=>$_W['uniacid']));
	}
	if($_GPC["is_jkopen_his"]!=$_GPC['is_jkopen']){
		$data = array();
    	$data['is_jkopen']  = $_GPC['is_jkopen'];
    	$res = pdo_update('mzhk_sun_goods', $data,array('uniacid'=>$_W['uniacid']));
	}
	if($_GPC["is_qgopen_his"]!=$_GPC['is_qgopen']){
		$data = array();
    	$data['is_qgopen']  = $_GPC['is_qgopen'];
    	$res = pdo_update('mzhk_sun_goods', $data,array('uniacid'=>$_W['uniacid']));
	}
	if($_GPC["is_kjopen_his"]!=$_GPC['is_kjopen']){
		$data = array();
    	$data['is_kjopen']  = $_GPC['is_kjopen'];
    	$res = pdo_update('mzhk_sun_goods', $data,array('uniacid'=>$_W['uniacid']));
	}
	if($_GPC["is_hyopen_his"]!=$_GPC['is_hyopen']){
		$data = array();
    	$data['is_hyopen']  = $_GPC['is_hyopen'];
    	$res = pdo_update('mzhk_sun_goods', $data,array('uniacid'=>$_W['uniacid']));
	}

    message('编辑成功',$this->createWebUrl('ygquan',array()),'success');

}

$coupon=pdo_get('mzhk_sun_system',array('uniacid'=>$_W['uniacid']),array("is_counp"));
$pt_goods=pdo_get('mzhk_sun_goods',array('uniacid'=>$_W['uniacid'],'lid'=>3),array("is_ptopen"));
$jk_goods=pdo_get('mzhk_sun_goods',array('uniacid'=>$_W['uniacid'],'lid'=>4),array("is_jkopen"));
$qg_goods=pdo_get('mzhk_sun_goods',array('uniacid'=>$_W['uniacid'],'lid'=>5),array("is_qgopen"));
$kj_goods=pdo_get('mzhk_sun_goods',array('uniacid'=>$_W['uniacid'],'lid'=>2),array("is_kjopen"));
$hy_goods=pdo_get('mzhk_sun_goods',array('uniacid'=>$_W['uniacid'],'lid'=>6),array("is_hyopen"));

$item["is_counp"] = $coupon["is_counp"];
$item["is_ptopen"] = $pt_goods["is_ptopen"];
$item["is_jkopen"] = $jk_goods["is_jkopen"];
$item["is_qgopen"] = $qg_goods["is_qgopen"];
$item["is_kjopen"] = $kj_goods["is_kjopen"];
$item["is_hyopen"] = $hy_goods["is_hyopen"];

include $this->template('web/ygquan');