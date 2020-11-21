<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$zid =$_GPC['zid'];
$op =$_GPC['op'];
$hj_type =$_GPC['hj_type'];
$value = htmlspecialchars_decode($_GPC['hj_pic']);
$array = json_decode($value);
$object = json_decode(json_encode($array), true);
$data =array(
  'zid'=>$zid,
  'uniacid'=>$uniacid,
  'h_text'=>$_GPC['hj_tex'],
  'h_leixing'=>1,
  'h_thumb'=>serialize($object),
  'sfbtime'=>strtotime("now"),
  'h_flname' =>$_GPC['hj_id'],
  'h_title' =>$_GPC['hj_title'],
  'h_pic' =>$_GPC['hj_thumb'],
  'h_admin'=>$_GPC['z_name']
  );
if($op=='post'){
   $info = pdo_insert('hyb_yl_hjiaosite', $data);
   echo json_encode($info);
}

