<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$op =$_GPC['op'];
$id =$_GPC['zid'];

$openid = $_GPC['openid'];
//查询是否会员

 //查询当天是否存在免费次数 如果存在就输出存在的次数，如果不存在就走医生服务包次数

if($op =="dangtian"){


$question = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_userinfo") . " where `openid`='{$openid}' and uniacid = '{$uniacid}' ", array(":uniacid" => $uniacid));
$question['adminguanbi']=date("Y-m-d H:i:s",$question['adminguanbi']);

$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));//当天开始时间戳
$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;//当天结束时间戳
$res = pdo_fetch("SELECT * FROM".tablename("hyb_yl_question")."where uniacid=:uniacid and dttjtime >='{$beginToday}' and dttjtime<='{$endToday}' and user_openid= '{$openid}'",array("uniacid"=>$uniacid));
if($res){
    echo json_encode($res);
   }else{
    //
    $zj_xiangqing = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_zhuanjia") . " as a left join " . tablename("hyb_yl_addresshospitai") . " as b on a.nksid=b.id where a.zid='{$id}' and a.uniacid='{$uniacid}'", array("uniacid" => $_W['uniacid']));
    $zj_xiangqing['twzixun'] =unserialize($zj_xiangqing['twzixun']);
    $zj_xiangqing['fufeiuser']=unserialize($zj_xiangqing['twzixun']['fufeiuser']);
    $zj_xiangqing['putonguser']=unserialize($zj_xiangqing['twzixun']['putonguser']);
    if($question['admintype'] ==1){
       //会员
        $data =array(
        'tw_num'=>$zj_xiangqing['fufeiuser']['tw_hy_num'],
        'tw_money'=>$zj_xiangqing['fufeiuser']['tw_hy'],
        );
     }else{
        //非会员
        $data =array(
        'tw_num'=>$zj_xiangqing['putonguser']['tw_pt_num'],
        'tw_money'=>$zj_xiangqing['putonguser']['tw_pt'],
        );
     }

    echo json_encode($data);
   }
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


