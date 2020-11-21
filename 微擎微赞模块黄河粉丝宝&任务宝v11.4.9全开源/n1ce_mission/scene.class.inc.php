<?php
//
class Scene {

  private static $t_sys_qr = 'qrcode';
  private static $t_qr = 'n1ce_mission_qrlog';
  private static $t_scene_id = 'n1ce_mission_scene_id';
  private static $t_subfollow = 'n1ce_mission_subfollow';

  // 微信服务器保留图片3天，保险起见减去1个小时的提前量
  private static $WECHAT_MEDIA_EXPIRE_SEC = 255600; //(3 * 24 * 60 * 60 - 1 * 60 * 60) seconds; 3 days

  /**
   * @brief 获取当前weid可用的下一个SceneID
   */
  public function getNextAvaliableSceneID($uniacid) {
    //
    //
    // TODO: 采用遍历算法，直接根据QR活跃度，从self::$t_qr表中选择空槽
    //
    //

    $scene_id = pdo_fetchcolumn('SELECT scene_id FROM ' . tablename(self::$t_scene_id) . ' WHERE uniacid=:uniacid',
      array(':uniacid'=>$uniacid));
    if (empty($scene_id)) {
      $scene_id = 20000; // 20000以前的预留给普通模块
      WeUtility::logging('sc emtpy', $scene_id);
      pdo_insert(self::$t_scene_id, array('uniacid'=>$uniacid, 'scene_id'=>$scene_id));
    } else {
      $scene_id++;
      pdo_update(self::$t_scene_id, array('scene_id'=>$scene_id), array('uniacid'=>$uniacid));
    } 
    return $scene_id;
  }

  /**
   * @brief 获取uid用户的当前推广QR
   */
  public function getQR($uniacid, $from_user, $rid) {
    $qr = pdo_fetch("SELECT * FROM " . tablename(self::$t_qr)
      . " WHERE from_user=:from_user AND rid=:rid AND uniacid=:uniacid "
      . " ORDER BY createtime DESC LIMIT 1",
      array(
        ":rid"=>$rid,
        ":from_user"=>$from_user,
        ":uniacid"=>$uniacid));

    // 简单起见，当图片在微信服务器失效后（一般为3天），直接删除这一条规则, 由调用者负责具体后继处理方式
    return $qr;
  }

  /**
   * @brief 根据scene_id获取二维码信息
   */
  public function getQRByScene($uniacid, $scene_id, $rid) {
    $qr = pdo_fetch("SELECT * FROM " . tablename(self::$t_qr) . " WHERE scene_id=:scene_id AND uniacid=:uniacid AND rid=:rid",
      array(":scene_id"=>$scene_id, ":uniacid"=>$uniacid, ':rid'=>$rid));
    return $qr;
  }
  public function getQRByUnionid($uniacid, $unionid, $rid){
    $qr = pdo_fetch("SELECT * FROM " . tablename(self::$t_subfollow) . " WHERE f_unionid=:unionid AND uniacid=:uniacid AND rid=:rid",
      array(":unionid"=>$unionid, ":uniacid"=>$uniacid, ':rid'=>$rid));
    return $qr;
  }
  public function newQR($uniacid, $from_user, $scene_id, $qr_url, $media_id, $rid, $keyword) {
    $params = array(
      "uniacid"=>$uniacid,
      "from_user"=>$from_user,
      "scene_id"=>$scene_id,
      "qr_url"=>$qr_url,
      "media_id"=>$media_id,
      "rid"=>$rid,
      "createtime"=>time());
    $sys_params = array(
      "uniacid"=>$uniacid,
      "qrcid"=>$scene_id,
      "model"=>1,
      "type"=>"scene",
      "name"=>$from_user,
      "keyword"=>$keyword,
      "expire"=>30 * 24 * 3600,
      "createtime"=>time(),
      "status"=>1,
      "ticket"=>$media_id);
    $ret = pdo_insert(self::$t_qr, $params);
    $ret = pdo_insert(self::$t_sys_qr, $sys_params);
    return $ret;
  }

  public function updateQR($uniacid, $from_user, $scene_id, $media_id, $rid) {
    $ret = pdo_update(self::$t_qr,
      array(
        "media_id"=>$media_id,
        "createtime"=>time()),
      array(
        "from_user"=>$from_user,
        "rid"=>$rid,
        "uniacid"=>$uniacid));
    return $ret;
  }

}
