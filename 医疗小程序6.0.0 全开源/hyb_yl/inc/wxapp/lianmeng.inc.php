<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$op = $_GPC['op'];
$hosid = $_GPC['id'];
if($op =='desc'){
  //查看联盟简介
	$res =pdo_get("hyb_yl_addresshospitai",array('uniacid'=>$uniacid,'id'=>$hosid));
	$res['hos_pic'] =$_W['attachurl'].$res['hos_pic'];
	// $res['hos_desc'] = strip_tags(htmlspecialchars_decode($res['hos_desc']));
	$res['hos_thumb'] =$_W['attachurl'].$res['hos_thumb'];
	echo json_encode($res);
}

