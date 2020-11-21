<?php
defined('IN_IA') or exit('Access Denied');
//通知患者医生已经回复
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$op =$_GPC['op'];
$zid =$_GPC['zid'];
//查询当天七天之内的时间戳
//今天的
if($op =='zhou'){
    $date =date("Y-m-d",strtotime("today"));
    //七天前的
    $qidata = date("Y-m-d",strtotime("-7 day")); 

    //转为时间戳
    $newdate = strtotime($date);
    $newqitian = strtotime($qidata);


    $newdate1= mktime(0,0,0,date('m'),date('d'),date('Y')); 
    $newdate2= mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1; 


    //查询等于今天和七天前的数据
    $res =pdo_fetchall("SELECT * FROM".tablename("hyb_yl_docshouyi")."where uniacid='{$uniacid}' and (times <'{$newdate2}' and times >'{$newdate1}' or times>'{$newqitian}') and z_ids='{$zid}'");
        if(!$res){
        $res =array(
            array(
             'time'=>date($year.'-m-d'),
             'money'=>0,
                ),
            array(
             'time'=>date($year.'-m-d'),
             'money'=>0,
                ),
             array(
             'time'=>date($year.'-m-d'),
             'money'=>0,
                ),
            array(
             'time'=>date($year.'-m-d'),
             'money'=>0,
                ),
            );
    }else{
    foreach ($res as $key => $value) {
       $res[$key]['time']=date("Y-m-d",$res[$key]['times']);
       $res[$key]['money']=$res[$key]['symoney'];
    }
    }

    echo json_encode($res);
       
}
if($op =='nian'){
 $year = $_GPC['year'];
 $res =pdo_fetchall("SELECT * FROM".tablename("hyb_yl_docshouyi")."where uniacid='{$uniacid}' and z_ids='{$zid}' and year='{$year}'");

    if(!$res){
        $res =array(
            array(
             'time'=>date($year.'-m-d'),
             'money'=>0,
                ),
            array(
             'time'=>date($year.'-m-d'),
             'money'=>0,
                ),
             array(
             'time'=>date($year.'-m-d'),
             'money'=>0,
                ),
            array(
             'time'=>date($year.'-m-d'),
             'money'=>0,
                ),
            );
    }else {
       foreach ($res as $key => $value) {
       $res[$key]['summoney']=pdo_fetchall("SELECT SUM(symoney) AS `sum` FROM".tablename("hyb_yl_docshouyi")."where uniacid='{$uniacid}' and z_ids='{$zid}' and year='{$year}'");
       $res[$key]['num']=pdo_fetchall("SELECT count(symoney) AS `num` FROM".tablename("hyb_yl_docshouyi")."where uniacid='{$uniacid}' and z_ids='{$zid}' and year='{$year}'");
       $res[$key]['time']=date("Y-m-d",$res[$key]['times']);
       $res[$key]['money']=$res[$key]['symoney'];
      }
    }
echo json_encode($res);
}
