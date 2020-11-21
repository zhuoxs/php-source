<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$op =$_GPC['op'];
if($op =="huiyuanka"){
 $res = pdo_fetchall("SELECT * FROM".tablename("hyb_yl_adminusersite")."where uniacid=:uniacid order by admin_id asc ",array("uniacid"=>$uniacid));
 echo json_encode($res);
}

if($op =="addhuiyuan"){
	$u_id = $_GPC['u_id'];
    $admin_id = $_GPC['admin_id'];
    $adminuserdj =$_GPC['adminuserdj'];
    $admininfo = pdo_get("hyb_yl_adminusersite",array('uniacid'=>$uniacid,'admin_id'=>$admin_id));
    $now = strtotime('now');
    $tianshu =$admininfo['aduserdenqx'];
    $info=$admininfo['types'];
    $ca=date('Y-m-d H:i:s',strtotime("+".$tianshu.$info)) ;
    //转为时间戳
    $adminguanbi = strtotime($ca);
   //  var_dump($2month);
    $data =array(
         'adminoptime'=>strtotime('now'),
         'adminguanbi'=>$adminguanbi,
         'admintype'  =>1,
         'adminuserdj'=>$adminuserdj
    	);
    $res = pdo_update("hyb_yl_userinfo",$data,array("uniacid"=>$uniacid,'u_id'=>$u_id));

	 echo json_encode($res);
}

if($op =='uphuiyuan'){
	$u_id = $_GPC['u_id'];
    $admin_id = $_GPC['admin_id'];
    $adminuserdj =$_GPC['adminuserdj'];
    $admininfo = pdo_get("hyb_yl_adminusersite",array('uniacid'=>$uniacid,'admin_id'=>$admin_id));
    $now = strtotime('now');
    $tianshu =$admininfo['aduserdenqx'];
    $info=$admininfo['types'];
    $ca=date('Y-m-d H:i:s',strtotime("+".$tianshu.$info)) ;
    //转为时间戳
    $adminguanbi = strtotime($ca);
   //  var_dump($2month);
    $data =array(
         'adminoptime'=>strtotime('now'),
         'adminguanbi'=>$adminguanbi,
         'admintype'  =>1,
         'adminuserdj'=>$adminuserdj
    	);
    $res = pdo_update("hyb_yl_userinfo",$data,array("uniacid"=>$uniacid,'u_id'=>$u_id));
	echo json_encode($res);
}


