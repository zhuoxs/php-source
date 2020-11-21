<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$op =$_GPC['op'];
$teamtype = $_GPC['teamtype'];

if($op =='post'){
  $t_id =$_GPC['t_id'];
  $res = pdo_get('hyb_yl_zhuanjteam',array('uniacid'=>$uniacid,'t_id'=>$t_id));
  return $this->result(0, 'success', $res);
}

if($op =='display'){
    $zid = $_GPC['zid'];
    $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_zhuanjteam') . "as a left join" . tablename('hyb_yl_zhuanjia') . "as b on b.zid=a.zid where a.uniacid='{$uniacid}' AND a.zid='{$zid}' AND a.teamtype='{$teamtype}' ");
  foreach ($res as $key => $value) {
      $tt_id =$value['t_id'];
      $res[$key]['teampic'] = $_W['attachurl'] . $res[$key]['teampic'];
      $res[$key]['z_thumbs'] = $_W['attachurl'] . $res[$key]['z_thumbs'];
      $res[$key]['docnum'] =pdo_fetch("SELECT count(*) as docnum FROM".tablename("hyb_yl_yaoqingdoc")."where uniacid ='{$uniacid}' AND t_id='{$tt_id}'");
  }
  //查询团队的医护
  $info =array(
     'data'=>$res,
    );
 echo json_encode($info);
}

if($op =='join'){
      $zid = $_GPC['zid'];
      $teamtype = intval($_GPC['teamtype']);
      $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_zhuanjteam') . "as a left join" . tablename('hyb_yl_yaoqingdoc') . "as b on b.t_id=a.t_id left join".tablename("hyb_yl_zhuanjia")."as c on c.zid=a.zid where a.uniacid='{$uniacid}' AND b.zid='{$zid}' AND a.teamtype='{$teamtype}'  ");

      foreach ($res as $key => $value) {
      $tt_id =$value['t_id'];
      $res[$key]['teampic'] = $_W['attachurl'] . $res[$key]['teampic'];
     
      $res[$key]['docnum'] =pdo_fetch("SELECT count(*) as docnum FROM".tablename("hyb_yl_yaoqingdoc")."where uniacid ='{$uniacid}' AND t_id='{$tt_id}'");
        $res[$key]['yao_time']=date("Y-m-d H:i:s",$res[$key]['yao_time']);
        $res[$key]['z_thumbs'] =$_W['attachurl'].$res[$key]['z_thumbs'];
        if($res[$key]['yao_type'] ==0){
              $res[$key]['textname'] ="邀请中";
        }
        if($res[$key]['yao_type'] ==1){
              $res[$key]['textname']="已同意";
        }
        if($res[$key]['yao_type'] ==2){
             $res[$key]['textname'] ="已拒绝";
        }
      }
      echo json_encode($res);
}
if($op =='delete'){
   $t_id =$_GPC['t_id'];
   $res = pdo_delete("hyb_yl_zhuanjteam",array('uniacid'=>$uniacid,'t_id'=>$t_id));
   echo json_encode($res);
}
if($op=='allteam'){
  $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_zhuanjteam') . "as a left join" . tablename('hyb_yl_zhuanjia') . "as b on b.zid=a.zid where a.uniacid='{$uniacid}' AND a.teamtype='{$teamtype}' order by a.t_id desc");
  foreach ($res as $key => $value) {
      $tt_id =$value['t_id'];
      $res[$key]['teampic'] = $_W['attachurl'] . $res[$key]['teampic'];
      $res[$key]['z_thumbs'] = $_W['attachurl'] . $res[$key]['z_thumbs'];
      $res[$key]['docnum'] =pdo_fetch("SELECT count(*) as docnum FROM".tablename("hyb_yl_yaoqingdoc")."where uniacid ='{$uniacid}' AND t_id='{$tt_id}'");
  }
  echo json_encode($res);
}