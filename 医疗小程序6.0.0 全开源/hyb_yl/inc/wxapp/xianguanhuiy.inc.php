<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$op = $_GPC['op'];
$hosid = $_GPC['id'];
if($op =='display'){
  //查看联盟简介

	$res =pdo_fetchall("select * from".tablename('hyb_yl_lianmenghuiy')."where uniacid='{$uniacid}' and hosid='{$hosid}'");
	foreach ($res as $key => $value) {
	$res[$key]['hy_thumb'] =$_W['attachurl'].$res[$key]['hy_thumb'];
	$res[$key]['hos_desc'] = strip_tags(htmlspecialchars_decode($res[$key]['hos_desc']));
	$res[$key]['hy_time'] = date("Y-m-d H:i:s",$res[$key]['hy_time']);
	}

	echo json_encode($res);
}
if($op =='post'){
	$hy_id =$_GPC['hy_id'];
	$res =pdo_get("hyb_yl_lianmenghuiy",array('hy_id'=>$hy_id,'uniacid'=>$uniacid));
	echo json_encode($res);
}

