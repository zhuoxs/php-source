<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$op =$_GPC['op'];
if($op =="add"){
        $openid =$_GPC['openid'];
        $name =$_GPC['name'];
        $touxiang =$_GPC['touxiang'];
        $yisid =$_GPC['yisid'];
        $data =array(
         'uniacid'=>$uniacid,
         'openid'=>$openid,
         'name' =>$name,
         'touxiang'=>$touxiang,
         'yisid'=>$yisid,
         'pingtext'=>$_GPC['pingtext'],
         'createTime'=>strtotime("now"),
            );
        $res =pdo_insert("hyb_yl_huanjiaopingl",$data);
   
       echo json_encode($res);
}
if($op =="all"){
  $yisid =$_GPC['yisid'];

  $res =pdo_fetchall("SELECT * FROM".tablename("hyb_yl_huanjiaopingl")."where uniacid=:uniacid and yisid=:yisid",array('uniacid'=>$uniacid,'yisid'=>$yisid));
  foreach ($res as $key => $value) {
    $res[$key]['createTime'] =date("Y-m-d H:i:s",$res[$key]['createTime']);

  }
  echo json_encode($res);
}