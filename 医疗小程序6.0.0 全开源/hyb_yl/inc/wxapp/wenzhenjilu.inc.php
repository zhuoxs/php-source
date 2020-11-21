<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$openid = $_GPC['openid'];
$op=$_GPC['op'];
if($op =='display'){
   $res = pdo_fetchall("select a.*,c.nksname,c.goby  from(select max(m_id) as m_id from". tablename('hyb_yl_chat_msg_wz') ."where ifkf!=3 and f_id='{$openid}' group by docid ) b left join ".tablename('hyb_yl_chat_msg_wz')." a on a.m_id=b.m_id  left join".tablename("hyb_yl_zhuanjia")."as c on c.zid=a.docid ");
   foreach ($res as $key => $value) {
       $res[$key ]['add_time'] =date("Y-m-d H:i:s",$res[$key ]['add_time']);
   } 
   echo json_encode($res);
}
if($op =='del'){
  
  $f_id =$_GPC['f_id'];
  $t_id =$_GPC['t_id'];
  $pdo = pdo_fetchall("SELECT * FROM".tablename("hyb_yl_chat_msg_wz")."where uniacid ='{$uniacid}' and (t_id ='{$t_id}' and f_id='{$f_id}') or (f_id ='{$t_id}' and t_id ='{$f_id}') ");
  // var_dump("SELECT * FROM".tablename("hyb_yl_chat_msg_wz")."where uniacid ='{$uniacid}' and (t_id ='{$t_id}' and f_id='{$f_id}') or (f_id ='{$t_id}' and t_id ='{$f_id}') ");
  foreach ($pdo as $key => $value) {
      $m_id =$value['m_id'];
      $res = pdo_delte("hyb_yl_chat_msg_wz",array('m_id'=>$m_id));
  }
  echo json_encode($res);
}
if($op =='over'){
  $m_id =$_GPC['m_id'];
  $getone = pdo_get("hyb_yl_chat_msg_wz",array('m_id'=>$m_id));

  $t_id =$getone['t_id'];
  $f_id =$getone['f_id'];
  $pdo = pdo_fetchall("SELECT * FROM".tablename("hyb_yl_chat_msg_wz")."where uniacid ='{$uniacid}' and (t_id ='{$t_id}' and f_id='{$f_id}') or (f_id ='{$t_id}' and t_id ='{$f_id}') ");
  // var_dump("SELECT * FROM".tablename("hyb_yl_chat_msg_wz")."where uniacid ='{$uniacid}' and (t_id ='{$t_id}' and f_id='{$f_id}') or (f_id ='{$t_id}' and t_id ='{$f_id}') ");
  foreach ($pdo as $key => $value) {
      $m_id =$value['m_id'];
      $data = array(
       'if_over'=>1
        );
      $res = pdo_update("hyb_yl_chat_msg_wz",$data,array('m_id'=>$m_id));
  }
  echo json_encode($res);
}


if($op=='duihua'){
    $f_id = $_REQUEST['fid'];
    $ifkf = $_GPC['ifkf'];
    //var_dump($f_id);onMvv0JR5x5pCKCyDBEsrImStobk
    $t_id = $_REQUEST['tid'];
    $openid = $_REQUEST['openid'];
    //查询用户信息
    $user_curr = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_userinfo") . " where uniacid=:uniacid and openid=:openid", array(":uniacid" => $uniacid, ":openid" => $openid));
    if ($user_curr['u_id'] == $t_id) {
        $f_id = $_REQUEST['tid'];
        $t_id = $_REQUEST['fid'];

    }
    $data = array('r_state' => 1);
    $res = pdo_update("hyb_yl_chat_msg_wz", $data, array("f_id" => $t_id, 't_id' => $f_id));
    $list = pdo_fetchall("SELECT a.*,b.z_thumbs,b.zid,b.goby FROM " . tablename("hyb_yl_chat_msg_wz") . "as a left join".tablename("hyb_yl_zhuanjia")."as b on b.zid=a.kfid where a.uniacid=:uniacid and ((a.f_id=:f_id and a.t_id=:t_id) or (a.f_id=:ft_id and a.t_id=:tf_id))  ORDER BY a.m_id ASC ", array(":uniacid" => $uniacid, ":f_id" => $f_id, ":t_id" => $t_id, ":ft_id" => $t_id, ":tf_id" => $f_id));
    foreach ($list as $key => $msg) {
        $typetext =$msg['typetext'];
        $msg['t_msg'] = $msg['t_msg'];
        $list[$key]['time'] = date("Y-m-d H:i:s", $msg['add_time']);
        $list[$key ]['f_ipic'] =unserialize($list[$key ]['f_ipic']);
        $count = count($list[$key ]['f_ipic']);
        for ($i = 0;$i < $count;$i++) {
            $list[$key ]['f_ipic'][$i] = $_W['attachurl'] . $list[$key ]['f_ipic'][$i];
        } 
        $tmpStr = json_encode($msg['t_msg']); //暴露出unicode
        $tmpStr1 = preg_replace_callback('/\\\\\\\\/i', function ($a) {
            return '\\';
        }, $tmpStr); //将两条斜杠变成一条，其他不动
        $t_msg1 = json_decode($tmpStr1);
        $t_msg = str_replace('"', '', $t_msg1);
        if ($ifkf == $msg['ifkf'] ) {
            $list[$key]['is_show_right'] = 1;
            $list[$key]['is_img'] = false;
            $list[$key]['show_rignt'] = true;
            $list[$key]['content'] = $t_msg;
            if($typetext == 2){
              $list[$key]['content'] = $_W['attachurl'].$list[$key]['content'];
            }
             if($typetext == 1){
              $list[$key]['content'] = $_W['attachurl'].$list[$key]['content'];
            }
            $list[$key]['z_thumbs'] = $_W['attachurl'].$list[$key]['z_thumbs'];
            //查询用户信息
            $user = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_userinfo") . " where uniacid=:uniacid and u_id=:u_id", array(":uniacid" => $uniacid, ":u_id" => $f_id));
            $list[$key]['head_owner'] = $user['u_thumb'];
            $list[$key]['nickname_owner'] = $user['u_name'];
            } else {

           $list[$key ]['f_ipic'] =unserialize($list[$key ]['f_ipic']);
           $count = count($list[$key ]['f_ipic']);
            for ($i = 0;$i < $count;$i++) {
                $list[$key ]['f_ipic'][$i] = $_W['attachurl'] . $list[$key ]['f_ipic'][$i];
            }
            $list[$key]['is_show_right'] = 0;
            $list[$key]['is_img'] = false;
            $list[$key]['show_rignt'] = false;
            $list[$key]['content'] = $t_msg;
            if($typetext == 2){
              $list[$key]['content'] = $_W['attachurl'].$list[$key]['content'];
            }
             if($typetext == 1){
              $list[$key]['content'] = $_W['attachurl'].$list[$key]['content'];
            }
            $list[$key]['z_thumbs'] = $_W['attachurl'].$list[$key]['z_thumbs'];
            //查询用户信息
            $user = pdo_fetch("SELECT * FROM " . tablename("hyb_yl_userinfo") . " where uniacid=:uniacid and u_id=:u_id", array(":uniacid" => $uniacid, ":u_id" => $t_id));
            $list[$key]['head_owner'] = $user['u_thumb'];
            $list[$key]['nickname_owner'] = $user['u_name'];
        }
    }
    $result = array('chat_list' => $list);
    return $this->result(0, "success", $result);
}