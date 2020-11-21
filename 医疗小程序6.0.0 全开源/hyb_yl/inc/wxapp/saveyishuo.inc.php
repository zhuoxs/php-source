<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$zid =$_GPC['zid'];
$op =$_GPC['op'];
$value = htmlspecialchars_decode($_GPC['yspic']);
$array = json_decode($value);
$object = json_decode(json_encode($array), true);

$value1 = htmlspecialchars_decode($_GPC['user']);
$array1 = json_decode($value1);
$user = json_decode(json_encode($array1), true);

$data =array(
  'zid'=>$zid,
  'uniacid'=>$uniacid,
  'hid'=>$_GPC['hid'],
  'yspic'=>serialize($object),
  'ystime'=>strtotime("now"),
  'user' =>serialize($user),
  'ystext' =>$_GPC['ystext'],
  );
if($op=='post'){
   $info = pdo_insert('hyb_yl_yishuo', $data);
   echo json_encode($info);
}

