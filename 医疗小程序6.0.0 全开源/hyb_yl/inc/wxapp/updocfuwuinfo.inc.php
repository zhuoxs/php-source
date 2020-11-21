<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];

$op =$_GPC['op'];
$zid = $_GPC['zid'];
if($op =="tuwen"){
	$tw_hy =$_GPC['tw_hy'];
	$tw_hy_num =$_GPC['tw_hy_num'];


	$tw_pt =$_GPC['tw_pt'];
	$tw_pt_num =$_GPC['tw_pt_num'];


	$fufeiuser = array(
	     'tw_hy'=>$tw_hy,
	     'tw_hy_num'=>$tw_hy_num,
		);

	$putonguser = array(
	     'tw_pt'=>$tw_pt,
	     'tw_pt_num'=>$tw_pt_num,
		);

	$data=array(
	    'fufeiuser'=>serialize($fufeiuser),
	     'putonguser'=>serialize($putonguser),
		);

	$res = pdo_update("hyb_yl_zhuanjia",array('twzixun'=>serialize($data)),array('zid'=>$zid,'uniacid'=>$uniacid));
	echo json_encode($res);
}
if($op =="dianhua"){
	$dh_hy =$_GPC['dh_hy'];
	$dh_hy_num =$_GPC['dh_hy_num'];


	$dh_pt =$_GPC['dh_pt'];
	$dh_pt_num =$_GPC['dh_pt_num'];


	$fufeiuser = array(
	     'dh_hy'=>$dh_hy,
	     'dh_hy_num'=>$dh_hy_num,
		);

	$putonguser = array(
	     'dh_pt'=>$dh_pt,
	     'dh_pt_num'=>$dh_pt_num,
		);

	$data=array(
	     'fufeiuser'=>serialize($fufeiuser),
	     'putonguser'=>serialize($putonguser),
		);

	$res = pdo_update("hyb_yl_zhuanjia",array('dianhuazix'=>serialize($data)),array('zid'=>$zid,'uniacid'=>$uniacid));
	echo json_encode($res);	
}
if($op =="zaixian"){
	$zx_hy =$_GPC['zx_hy'];
	$zx_hy_num =$_GPC['zx_hy_num'];


	$zx_pt =$_GPC['zx_pt'];
	$zx_pt_num =$_GPC['zx_pt_num'];


	$fufeiuser = array(
	     'zx_hy'=>$zx_hy,
	     'zx_hy_num'=>$zx_hy_num,
		);

	$putonguser = array(
	     'zx_pt'=>$zx_pt,
	     'zx_pt_num'=>$zx_pt_num,
		);

	$data=array(
	     'fufeiuser'=>serialize($fufeiuser),
	     'putonguser'=>serialize($putonguser),
		);

	$res = pdo_update("hyb_yl_zhuanjia",array('zaixian'=>serialize($data)),array('zid'=>$zid,'uniacid'=>$uniacid));
	echo json_encode($res);	
}




