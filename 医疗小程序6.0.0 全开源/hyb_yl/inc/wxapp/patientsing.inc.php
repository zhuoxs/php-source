<?php
defined('IN_IA') or exit('Access Denied');
global $_W,$_GPC;
$uniacid = $_W['uniacid'];
$openid = $_GPC['openid'];
$dateTime = date("Y-m-d",TIMESTAMP);
$dateTime1 = strtotime($dateTime);
$description =$_GPC['description'];
$op =$_GPC['op'];
if($op =='sing'){
  $res = pdo_get('hyb_yl_myjifen',array('openid'=>$openid,'dateTime'=>$dateTime1,'description'=>$description));
  if($res){
      echo 1;
  }else{
      $data =array(
     'uniacid'=>$uniacid,
     'openid' =>$_GPC['openid'],
     'dateTime'=>$dateTime1,
     'type'=>$_GPC['type'],
     'description'=>$_GPC['description'],
     'credit'=>$_GPC['credit'],
      );
     pdo_insert('hyb_yl_myjifen',$data);
     echo 0;
  }
}
if($op =='display'){
   $pdo_get = pdo_get('hyb_yl_jifensite',array('uniacid'=>$uniacid));
   $pdo_get['guize'] =htmlspecialchars_decode($pdo_get['guize']);
   $res  = pdo_get('hyb_yl_myjifen',array('openid'=>$openid,'dateTime'=>$dateTime1,'description'=>$description));
   $data =array(
     'jfsite'=>$pdo_get,
     'ifqian'=>$res
    );
   echo json_encode($data);
}
if($op =='myjifen'){
  //是我的总积分
   $type = $_GPC['type'];
   if($type ==0 ){
       $pdo_getall = pdo_getall('hyb_yl_myjifen', array('openid' => $openid), array() , '' , 'dateTime DESC');
   }else{
       $pdo_getall = pdo_getall('hyb_yl_myjifen', array('openid' => $openid,'type'=>$type), array() , '' , 'dateTime DESC');
   }

   foreach ($pdo_getall as $key => $value) {
     $pdo_getall[$key ]['dateTime']=date("Y-m-d",$pdo_getall[$key ]['dateTime']);
   }
   $sum = pdo_fetch("SELECT SUM(credit) AS `credit` FROM ".tablename('hyb_yl_myjifen')."where uniacid='{$uniacid}' and openid='{$openid}' ");
   $data =array(
   'getall'=>$pdo_getall,
   'sum' =>$sum
    );
   echo json_encode($data);
}


