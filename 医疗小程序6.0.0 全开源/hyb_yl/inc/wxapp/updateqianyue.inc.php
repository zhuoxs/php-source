<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$op = $_GPC['op'];
$id = $_GPC['id'];
if($op == 'quxiao'){
  $data =array(
  'ifqianyue'=>4
  	);
  $res = pdo_update("hyb_yl_collect",$data,array('uniacid'=>$uniacid,'id'=>$id));
  echo json_encode($res);
}
if($op =='jieyue'){
  $data =array(
  'ifqianyue'=>3
  	);
  $res = pdo_update("hyb_yl_collect",$data,array('uniacid'=>$uniacid,'id'=>$id));
  echo json_encode($res);
}
