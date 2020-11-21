<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];

$op =$_GPC['op'];

//所有区域
if($op =='quyu'){

  $res =pdo_fetchall("SELECT * FROM".tablename("hyb_yl_address")."where pid=0 and displayorder!=1 and visible=1");
  //查询他下面的所有二级
  foreach ($res as $key => $value) {
      $pid =$value['id'];
      $res[$key]['erji']=pdo_fetchall("SELECT * FROM".tablename("hyb_yl_address")."where pid='{$pid}'");
  }
  echo json_encode($res);
}
//区域医院
if($op =='yiyuan'){
 $par_id =$_GPC['par_id'];
 $res =pdo_fetchall("SELECT * FROM".tablename("hyb_yl_addresshospitai")."where par_id='{$par_id}' and uniacid='{$uniacid}' and parentid=0");
 foreach ($res as $key => $value) {
   //查询所有医生
    $hosid = $value['id'];
    $res[$key]['alldoc'] = pdo_fetchall("SELECT * FROM".tablename("hyb_yl_zhuanjia")."as a left join".tablename("hyb_yl_addresshospitai")."as b on b.id=a.hosid where a.uniacid='{$uniacid}' and a.hosid='{$hosid}'");
    foreach ($res[$key]['alldoc'] as $key1 => $value1) {
      $res[$key]['alldoc'][$key1]['z_thumbs'] =$_W['attachurl'].$res[$key]['alldoc'][$key1]['z_thumbs'];
    }
 }
  echo json_encode($res);
}

if($op =='keshi'){
 $id =$_GPC['id'];
 $res =pdo_fetchall("SELECT * FROM".tablename("hyb_yl_addresshospitai")."where parentid='{$id}' and uniacid='{$uniacid}'");
 foreach ($res as $key => $value) {
  //查询当前医院的素有专家
  $res[$key]['alldoc'] = pdo_fetchall("SELECT * FROM".tablename("hyb_yl_zhuanjia")."as a left join".tablename("hyb_yl_addresshospitai")."as b on b.id=a.hosid where a.uniacid='{$uniacid}' and a.hosid='{$id}'");
    foreach ($res[$key]['alldoc'] as $key1 => $value1) {
      $res[$key]['alldoc'][$key1]['z_thumbs'] =$_W['attachurl'].$res[$key]['alldoc'][$key1]['z_thumbs'];
    }
 	$res[$key]['hos_pic'] =$_W['attachurl'].$res[$key]['hos_pic'];
 }
  echo json_encode($res);
}

if($op =='keshidoc'){
 $nksid =$_GPC['nksid'];

 $res =pdo_fetchall("SELECT * FROM".tablename("hyb_yl_addresshospitai")." as a left join ".tablename("hyb_yl_zhuanjia")."as b on b.nksid=a.id where b.nksid='{$nksid}' and a.uniacid='{$uniacid}' and z_yy_type=1 ");
 foreach ($res as $key => $value) {
  $res[$key]['alldoc'] = pdo_fetchall("SELECT * FROM".tablename("hyb_yl_zhuanjia")."as a left join".tablename("hyb_yl_addresshospitai")."as b on b.id=a.hosid where a.uniacid='{$uniacid}' and a.nksid='{$nksid}'");
    foreach ($res[$key]['alldoc'] as $key1 => $value1) {
      $res[$key]['alldoc'][$key1]['z_thumbs'] =$_W['attachurl'].$res[$key]['alldoc'][$key1]['z_thumbs'];
    }
 	$res[$key]['z_thumbs'] =$_W['attachurl'].$res[$key]['z_thumbs'];
 }
  echo json_encode($res);
}
//