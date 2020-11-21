<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$op =$_GPC['op'];
if($op =='post'){
  $idarr = htmlspecialchars_decode($_GPC['thims']);
  $array = json_decode($idarr);
  $thims = json_decode(json_encode($array), true);
  $week  = serialize($thims[0]['arr']);
  $week1 = serialize($thims[1]['arr']);
  $week2 = serialize($thims[2]['arr']);
  $week3 = serialize($thims[3]['arr']);
  $week4 = serialize($thims[4]['arr']);
  $week5 = serialize($thims[5]['arr']);
  $week6 = serialize($thims[6]['arr']);
  $zhuo=array(
    'uniacid'=>$uniacid,
    'z_yy_money'=>$z_yy_money,
    'time'=>date('Y-m-d',time()),
    'week'=>$week,
    'week1'=>$week1,
    'week2'=>$week2,
    'week3'=>$week3,
    'week4'=>$week4,
    'week5'=>$week5,
    'week6'=>$week6,
    'zid'=>$_GPC['zid'],
    'sid'=>$_GPC['sid']
    );
  $res = pdo_insert('hyb_yl_fuwutime',$zhuo);
  echo json_encode($res);
}


if($op=='select'){
    $zid = $_GPC['zid'];
    $sid = $_GPC['sid'];
    $res= pdo_get("hyb_yl_fuwutime",array('zid'=>$zid,'sid'=>$sid,'uniacid'=>$uniacid));
    $data =array(
           array(
              'name'=>'周一',
              'arr' =>unserialize($res['week'])
              ),
           array(
              'name'=>'周二',
              'arr' =>unserialize($res['week1'])
              ),
           array(
              'name'=>'周三',
              'arr' =>unserialize($res['week2'])
              ),
           array(
              'name'=>'周四',
              'arr' =>unserialize($res['week3'])
              ),
           array(
              'name'=>'周五',
              'arr' =>unserialize($res['week4'])
              ),
           array(
              'name'=>'周六',
              'arr' =>unserialize($res['week5'])
              ),
           array(
              'name'=>'周日',
              'arr' =>unserialize($res['week6'])
              ),
        );
   $info = array(
      'tid' =>$res['tid'],
      'data'=>$data
    );
  echo json_encode($info);

}