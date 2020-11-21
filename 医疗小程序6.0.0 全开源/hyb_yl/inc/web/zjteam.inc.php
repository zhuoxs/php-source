<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$op =$_GPC['op'];
$zid =$_GPC['zid'];
if($op =="zjteam"){
    
    $zjteam = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_zhuanjteam")." where uniacid=:uniacid and zid=:zid",array(":uniacid"=>$uniacid,'zid'=>$zid));
    foreach ($zjteam as $key => $value) {
       $zjteam[$key]['cltime'] =date("Y-m-d H:i:s",$zjteam[$key]['cltime']);
     }
 }
if($op =="post"){
  $t_id =$_GPC['t_id'];
  $res = pdo_get("hyb_yl_zhuanjteam",array('uniacid'=>$uniacid,'t_id'=>$t_id));
  $data =array(
    'teamname'=>$_GPC['teamname'],
    'teamaddress'=>$_GPC['teamaddress'],
    'teamtext'=>$_GPC['teamtext'],
    'teampic'=>$_GPC['teampic'],
    'cltime'=>strtotime('now'),
    'iftj'=>$_GPC['iftj'],
    );
  if(checksubmit('tijiao')){
     if(empty($t_id)){
        pdo_insert("hyb_yl_zhuanjteam",$data);
        message("添加成功!",$this->createWebUrl("zjteam",array("op"=>"zjteam",'zid'=>$zid)),"success");
     }else{
        pdo_update("hyb_yl_zhuanjteam",$data,array('t_id'=>$t_id,'uniacid'=>$uniacid));
        message("更新成功!",$this->createWebUrl("zjteam",array("op"=>"zjteam",'zid'=>$zid)),"success");
     }

  }

}


include $this->template('zjteam/zjteam');