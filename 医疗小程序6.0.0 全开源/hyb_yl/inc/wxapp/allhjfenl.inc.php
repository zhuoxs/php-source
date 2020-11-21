<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];    
$op = $_GPC['op'];
if ($op == 'display') {
    $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_hjfenl') . "WHERE uniacid ='{$uniacid}' ");
    //最新患教
    $huanjiao = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_hjiaosite') . "WHERE uniacid ='{$uniacid}' AND h_leixing=0 order by h_id desc");
    foreach ($huanjiao as $key => $value) {
        $huanjiao[$key]['h_pic'] = $_W['attachurl'] . $huanjiao[$key]['h_pic'];
        $huanjiao[$key]['sfbtime'] = date('Y-m-d H:i:s', $huanjiao[$key]['sfbtime']);
    }
    $data = array('fenl' => $res, 'hjlist' => $huanjiao);
    echo json_encode($data);
}
if($op == 'geren'){
    //查询我的点赞总数
    $zid =$_GPC['zid'];
    $dianzan = pdo_fetch('SELECT SUM(`h_dianzan`) AS dianzan FROM' . tablename('hyb_yl_hjiaosite') . "WHERE uniacid ='{$uniacid}' AND zid='{$zid}'");
    $yuedu = pdo_fetch('SELECT SUM(`h_read`) AS yuedu FROM' . tablename('hyb_yl_hjiaosite') . "WHERE uniacid ='{$uniacid}' AND zid='{$zid}'");
    $zhuanfa = pdo_fetch('SELECT SUM(`h_zhuanfa`) AS zhuanfa FROM' . tablename('hyb_yl_hjiaosite') . "WHERE uniacid ='{$uniacid}' AND zid='{$zid}'");
    $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_hjfenl') . "WHERE uniacid ='{$uniacid}' ");
    //最新患教
    $huanjiao = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_hjiaosite') . "WHERE uniacid ='{$uniacid}' AND h_leixing=1 order by h_id desc");
    foreach ($huanjiao as $key => $value) {
        $huanjiao[$key]['h_pic'] = $_W['attachurl'] . $huanjiao[$key]['h_pic'];
        $huanjiao[$key]['sfbtime'] = date('Y-m-d H:i:s', $huanjiao[$key]['sfbtime']);
    }
    $data = array('fenl' => $res, 'hjlist' => $huanjiao,'dianzan'=>$dianzan,'yuedu'=>$yuedu,'zhuanfa'=>$zhuanfa);
    echo json_encode($data);
}
if ($op == 'post') {
    $h_id = $_GPC['h_id'];
    $h_leixing = intval($_GPC['h_leixing']);
  
    if($h_leixing ==1){
      $res = pdo_get('hyb_yl_hjiaosite', array('h_id' => $h_id, 'uniacid' => $uniacid));
      $zid =$res['zid'];
      $auth = pdo_fetch("SELECT * FROM".tablename("hyb_yl_zhuanjia")."WHERE uniacid='{$uniacid}' AND zid='{$zid}'");
      
      $res['h_thumb']=unserialize($res['h_thumb']);
      $num =count($res['h_thumb']);
      $dianzan = pdo_fetch('SELECT SUM(`h_dianzan`) AS dianzan FROM' . tablename('hyb_yl_hjiaosite') . "WHERE uniacid ='{$uniacid}' AND zid='{$zid}'");
      $yuedu = pdo_fetch('SELECT SUM(`h_read`) AS yuedu FROM' . tablename('hyb_yl_hjiaosite') . "WHERE uniacid ='{$uniacid}' AND zid='{$zid}'");
      $zhuanfa = pdo_fetch('SELECT SUM(`h_zhuanfa`) AS zhuanfa FROM' . tablename('hyb_yl_hjiaosite') . "WHERE uniacid ='{$uniacid}' AND zid='{$zid}'");
      for ($i=0; $i <$num ; $i++) { 
          $res['h_thumb'][$i] = $_W['attachurl'] . $res['h_thumb'][$i];
      }
      if (!empty($res['h_video'])) {
          $res['h_video'] = $_W['attachurl'] . $res['h_video'];
      }
      if(!empty($auth['z_thumbs'])){
        $auth['z_thumbs'] =$_W['attachurl'].$auth['z_thumbs'];
      }
      if(!empty($res)){
          $res['h_pic'] = $_W['attachurl'] . $res['h_pic'];
          $res['sfbtime'] = date("Y-m-d H:i:s", $res['sfbtime']);
          $res['auth'] =$auth;
          $res['h_text'] = strip_tags(htmlspecialchars_decode($res['h_text']));
          $res['dianzan'] =$dianzan;
          $res['yuedu'] =$yuedu;
          $res['zhuanfa']=$zhuanfa;
      }

    }else{
     //查平台
      $auth = pdo_fetch("SELECT * FROM".tablename("hyb_yl_bace")."WHERE uniacid='{$uniacid}'");
      $dianzan = pdo_fetch('SELECT SUM(`h_dianzan`) AS dianzan FROM' . tablename('hyb_yl_hjiaosite') . "WHERE uniacid ='{$uniacid}' AND h_leixing=0");
      $yuedu = pdo_fetch('SELECT SUM(`h_read`) AS yuedu FROM' . tablename('hyb_yl_hjiaosite') . "WHERE uniacid ='{$uniacid}' AND h_leixing=0");
      $zhuanfa = pdo_fetch('SELECT SUM(`h_zhuanfa`) AS zhuanfa FROM' . tablename('hyb_yl_hjiaosite') . "WHERE uniacid ='{$uniacid}' AND h_leixing=0 ");
      $auth['show_thumb'] =unserialize($auth['show_thumb']);
      $auth['bq_thumb'] =$_W['attachurl'].$auth['bq_thumb'];
      $auth['yy_thumb'] =$_W['attachurl'].$auth['yy_thumb'];
      $auth['yy_content'] = strip_tags(htmlspecialchars_decode($auth['yy_content']));
      $count = count($auth['show_thumb']);
      for ($i=0; $i <$count ; $i++) { 
         $auth['show_thumb'][$i] =$_W['attachurl'].$auth['show_thumb'][$i];
      }
      $res = pdo_get('hyb_yl_hjiaosite', array('h_id' => $h_id, 'uniacid' => $uniacid));
      $res['h_thumb']=unserialize($res['h_thumb']);
      $num =count($res['h_thumb']);
      for ($i=0; $i <$num ; $i++) { 
          $res['h_thumb'][$i] = $_W['attachurl'] . $res['h_thumb'][$i];
      }
      if (!empty($res['h_video'])) {
          $res['h_video'] = $_W['attachurl'] . $res['h_video'];
      }
      if(!empty($res)){
          $res['h_pic'] = $_W['attachurl'] . $res['h_pic'];
          $res['sfbtime'] = date("Y-m-d H:i:s", $res['sfbtime']);
          $res['auth'] =$auth;
          $res['h_text'] = strip_tags(htmlspecialchars_decode($res['h_text']));
          $res['dianzan'] =$dianzan;
          $res['yuedu'] =$yuedu;
          $res['zhuanfa']=$zhuanfa;
      }
    }


    echo json_encode($res);
}
if($op == 'remen'){
    //查询热门
    $res = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_hjfenl') . "WHERE uniacid ='{$uniacid}' ");
    //最新患教
    $huanjiao = pdo_fetchall('SELECT * FROM' . tablename('hyb_yl_hjiaosite') . "WHERE uniacid ='{$uniacid}' AND h_leixing=0 AND h_tuijian=1 order by h_id desc");
    foreach ($huanjiao as $key => $value) {
        $huanjiao[$key]['h_pic'] = $_W['attachurl'] . $huanjiao[$key]['h_pic'];
        $huanjiao[$key]['sfbtime'] = date('Y-m-d H:i:s', $huanjiao[$key]['sfbtime']);
    }
    $data = array('fenl' => $res, 'hjlist' => $huanjiao);
    echo json_encode($data);
}
