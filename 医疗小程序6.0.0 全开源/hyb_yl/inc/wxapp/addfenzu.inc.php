<?php
defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$op =$_GPC['op'];
$zid = $_GPC['zid'];
$data =array(
   'zid'     =>$_GPC['zid'],
   'uniacid' =>$uniacid,
   'fenzname'=>$_GPC['fenzname'],
    );
if($op=='display'){
  $res =pdo_fetchall("SELECT * FROM".tablename("hyb_yl_zhuanjiafenzu")."where uniacid='{$uniacid}' and zid='{$zid}' order by fenzuid desc");
  echo json_encode($res); 
}
if($op=='post'){
  $res =pdo_insert("hyb_yl_zhuanjiafenzu",$data);
  echo json_encode($res);
}
if($op=='update'){
 $fenzuid = $_GPC['fenzuid'];
 $res =pdo_update("hyb_yl_zhuanjiafenzu",$data,array('fenzuid'=>$fenzuid,'uniacid'=>$uniacid));
 echo json_encode($res);
}
if($op =="yidongfenz"){
 $id = $_GPC['id'];
 $data1= array(
    'fenzuid'=>0
 	);
 $res =pdo_update("hyb_yl_collect",$data1,array('id'=>$id,'uniacid'=>$uniacid));
 echo json_encode($res);
}
if($op =='xiugaibeizhu'){
 $id = $_GPC['id'];
 $beizhu = $_GPC['beizhu'];
 $data2= array(
    'beizhu'=>$beizhu
 	);
 $res =pdo_update("hyb_yl_collect",$data2,array('id'=>$id,'uniacid'=>$uniacid));
 echo json_encode($res);
}
if($op =='jieyue'){
 $id = $_GPC['id'];
 $jieyutext = $_GPC['jieyutext'];
 $data3= array(
    'jieyutext'=>$jieyutext,
    'ifqianyue' =>3
 	);
 $res =pdo_update("hyb_yl_collect",$data3,array('id'=>$id,'uniacid'=>$uniacid));
 echo json_encode($res);
}