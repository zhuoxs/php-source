<?php

class Follow {

  private static $t_local_fans = 'n1ce_mission_member';
  private static $t_allnumber = 'n1ce_mission_allnumber';
  private static $t_leader = 'n1ce_mission_qrlog';
  private static $t_follow = 'n1ce_mission_follow';
  private static $t_subfollow = 'n1ce_mission_subfollow';

  public function processSubscribe($uniacid, $leader_uid, $follower_uid, $rid) {
    // 调用者保证该follower没有上线、没有下线、没有出现在local fans表
    $ret = $this->addFollow($uniacid, $leader_uid, $follower_uid, $rid);
    WeUtility::logging("插入上下级",$ret);
    pdo_update(self::$t_allnumber,array('allnumber +='=>1),array('uniacid'=>$uniacid, 'rid'=>$rid ,'from_user'=>$leader_uid));
    return $ret;
  }
  public function getNumberByRid($uniacid,$rid,$from_user){
    $ret = pdo_get(self::$t_allnumber,array('uniacid'=>$uniacid,'rid'=>$rid,'from_user'=>$from_user),array('allnumber'));
    return $ret['allnumber'];
  }
  public function getFollowCountByChannel($weid, $channel) {
    $ret = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename(self::$t_follow) . " WHERE channel=:channel AND weid=:weid",
      array(":channel"=>$channel, ":weid"=>$weid));
    return $ret;
  }

  public function getAllChannelFollowCount($weid) {
    $ret = pdo_fetchall("SELECT channel, COUNT(*) cnt FROM " . tablename(self::$t_follow) . " WHERE weid=:weid GROUP BY channel",
      array(":weid"=>$weid), "channel");
    return $ret;
  }

  private function isLeader($uniacid, $leader, $rid) {
    $ret = pdo_fetch("SELECT * FROM " . tablename(self::$t_leader) . " WHERE from_user=:leader AND uniacid=:uniacid AND rid=:rid",
      array(":leader"=>$leader, ":uniacid"=>$uniacid,":rid"=>$rid));
    return $ret;
  }

  private function isFollower($uniacid, $follower, $rid, $next_scan) {
    if($next_scan == 1){
      $ret = pdo_fetch("SELECT * FROM " . tablename(self::$t_follow) . " WHERE follower=:follower AND uniacid=:uniacid",
      array(":follower"=>$follower, ":uniacid"=>$uniacid));
    }else{
      $ret = pdo_fetch("SELECT * FROM " . tablename(self::$t_follow) . " WHERE follower=:follower AND uniacid=:uniacid AND rid=:rid",
      array(":follower"=>$follower, ":uniacid"=>$uniacid, ":rid"=>$rid));
    }
    return $ret;
  }

  private function addSysCredit($weid, $from_user, $credit, $tag) {
    global $_W;
    yload()->classs('quickcenter', 'fans');
    $_fans = new Fans();
    $ret = $_fans->addCredit($weid, $from_user, $credit, 1, $tag);
    return $ret;
  }

  private function addLocalCredit($weid, $from_user, $credit, $type) {
    $ret = pdo_insert(self::$t_credit, array('weid'=>$weid, 'from_user'=>$from_user, 'type'=>$type, 'credit'=>$credit, 'createtime'=>time()));
    return $ret;
  }

  public function addFollow($uniacid, $leader_uid, $follower_uid, $rid) {
    WeUtility::logging('addFollow param', array($uniacid, $leader_uid, $follower_uid, $rid));
    $ret = $this->recordFollow($uniacid, $leader_uid, $follower_uid, $rid);
    return $ret;
  }

  public function unFollow($weid, $leader_uid, $follower_uid) {
    WeUtility::logging('unFollow param', array($weid, $leader_uid, $follower_uid));
    $ret = pdo_delete(self::$t_follow, array('weid'=>$weid, 'leader'=>$leader_uid, 'follower'=>$follower_uid));
    return $ret;
  }

  public function changeFollow($weid, $old_leader_uid, $new_leader_uid, $follower_uid) {
    $ret = 0;
    $channel = -1;
    $click_credit = 0;
    $hasLoop = $this->checkLoop($weid, $old_leader_uid, $new_leader_uid, $follower_uid);
    if (!$hasLoop) {
      if (empty($old_leader_uid)) {
        // 插入关系
        $ret = pdo_insert(self::$t_follow,
          array('weid'=>$weid, 'leader'=>$new_leader_uid, 'follower'=>$follower_uid, 'channel'=>$channel, 'credit'=>$click_credit, 'createtime'=>time()));
      } else if ($old_leader_uid != $new_leader_uid) {
        // 更新关系
        $ret = pdo_update(self::$t_follow, array('leader'=>$new_leader_uid, 'createtime'=>time()),
          array('weid'=>$weid, 'leader'=>$old_leader_uid, 'follower'=>$follower_uid));
      }
    }
    return $ret;
  }

  /* 算法：
   * 先循环查找new_leader_uid的上线，如果上线存在，则检查是否为follower_uid，如果上线不存在，则loop结束
   * 为了避免死循环，最多递归往上检查20个上线
   */
  private function checkLoop($weid, $old_leader_uid, $new_leader_uid, $follower_uid)
  {
    if ($new_leader_uid == $follower_uid) {
      return true; // 自己是自己的上线，禁止!
    }

    $hasLoop = true;
    $loopLimit = 20; /* 最多循环20次，如果查找20次还没有结束，则禁止此次操作确保安全 */
    $this_level_openid = $new_leader_uid;
    while ($loopLimit-- > 0) {
      $level = $this->getUpLevel($weid, $this_level_openid);
      if (empty($level)) {
        $hasLoop = false;
        break;
      } elseif ($level['leader'] == $follower_uid) {
        break;
      } else {
        $this_level_openid = $level['leader'];
      }
    }
    return $hasLoop;
  }

  public function recordFollow($uniacid, $leader_uid, $follower_uid, $rid) {
    if ($leader_uid != $follower_uid and !empty($leader_uid) and !empty($follower_uid))
    {
      //判断黑名单
      yload()->classs('n1ce_mission', 'wechatutil');
      $_wechatutil = new WechatUtil();
      $setting = $_wechatutil->getOtherSettings('n1ce_mission');
      if($setting['antispam_enable'] == 1){
        yload()->classs('n1ce_mission', 'antispam');
        $_spam = new AntiSpam();
        $count = $_spam->filter($uniacid, $leader_uid,$setting,$rid);
      }else{
        $count = 0;
      }
      WeUtility::logging("记录黑名单记录",$setting);
      if($count > 0){
        //提示作弊给作弊人
        if($count !== 101 && $setting['antispam_join'] !== '1'){
          yload()->classs('n1ce_mission', 'wechatapi');
          $_weapi = new WechatApi();
          $_weapi->sendText($leader_uid,$setting['antispam_word']);
        }
        if($setting['antispam_follow'] == 1){
          $ret = pdo_insert(self::$t_follow,
        array('uniacid'=>$uniacid, 'leader'=>$leader_uid, 'follower'=>$follower_uid, 'rid'=>$rid, 'createtime'=>time()));
          $f_id = pdo_insertid();
          if($setting['antispam_join'] !== '1'){
            pdo_update(self::$t_allnumber,array('allnumber +='=>1),array('uniacid'=>$uniacid, 'rid'=>$rid ,'from_user'=>$leader_uid));
          }
        }
        if($setting['antispam_join'] == 1){
          return $f_id;
        }
        exit(0);
      }
      // 记录follow关系
      $ret = pdo_insert(self::$t_follow,
        array('uniacid'=>$uniacid, 'leader'=>$leader_uid, 'follower'=>$follower_uid, 'rid'=>$rid, 'createtime'=>time()));
      return pdo_insertid();
    }

  }

  public function recordSiteScan($uniacid,$rid,$leader,$borrow_openid,$unionid){
    if($leader != $borrow_openid and !empty($leader) and !empty($borrow_openid)){
      $ret = pdo_insert(self::$t_subfollow,array('uniacid'=>$uniacid,'rid'=>$rid,'leader'=>$leader,'brrow_openid'=>$borrow_openid,'f_unionid'=>$unionid,'createtime'=>time()));
      return pdo_insertid();
    }
  }

  private function inBlackList($weid, $from_user) {
    global $_W;
    $b = pdo_fetch("SELECT * FROM " . tablename(self::$t_black) . " WHERE from_user=:f AND weid=:w LIMIT 1", array(':f'=>$from_user, ':w'=>$weid));
    if (!empty($b)) {
      $hit = 1 + $b['hit'];
      pdo_update(self::$t_black, array('hit'=>$hit), array('from_user'=>$from_user, 'weid'=>$weid));
    }
    return $b;
  }

  // 一键消失接口, 主要用于调试
  public function disappear($weid, $from_user) {
    $fans = pdo_fetch("SELECT * FROM " . tablename(self::$t_sys_fans) . " WHERE openid=:openid AND uniacid=:uniacid LIMIT 1",
      array(':openid'=>$from_user, ':uniacid'=>$weid));
    if (!empty($fans)) {
      $ret = pdo_delete(self::$t_sys_fans, array("openid"=>$from_user, "uniacid"=>$weid));
      $ret = pdo_delete(self::$t_sys_member, array("uid"=>$fans['uid'], "uniacid"=>$weid));
    }
    $ret = pdo_delete(self::$t_local_fans, array("from_user"=>$from_user, "weid"=>$weid));
    $ret = pdo_delete(self::$t_follow, array("follower"=>$from_user, "weid"=>$weid));
    $ret = pdo_delete(self::$t_follow, array("leader"=>$from_user, "weid"=>$weid));
  }

  public function isNewUser($uniacid, $from_user, $rid, $next_scan) {
    global $_W;
    WeUtility::logging('IsNewUser input:', array($uniacid, $from_user));
    $ret = pdo_fetch("SELECT * FROM " . tablename(self::$t_local_fans) . " WHERE  from_user=:from_user AND uniacid=:uniacid AND rid=:rid LIMIT 1",
      array(":from_user"=>$from_user, ":uniacid"=>$uniacid, ":rid"=>$rid));
    WeUtility::logging('isLocalFans', $ret);
    if (empty($ret)) {
      $ret = $this->isLeader($uniacid, $from_user, $rid);
      WeUtility::logging('isLeader', $ret);
    }
    if (empty($ret)) {
      $ret = $this->isFollower($uniacid, $from_user, $rid, $next_scan);
      WeUtility::logging('isFollower', $ret);
    }
    WeUtility::logging("isNewUser output", $ret);
    return  empty($ret);
  }

  public function isNewSubUser($uniacid, $borrow_openid, $rid) {
    global $_W;
    WeUtility::logging('IsNewUser input:', array($uniacid, $borrow_openid));
    $ret = pdo_fetch("SELECT * FROM " . tablename(self::$t_local_fans) . " WHERE  brrow_openid=:borrow_openid AND uniacid=:uniacid AND rid=:rid LIMIT 1",
      array(":borrow_openid"=>$borrow_openid, ":uniacid"=>$uniacid, ":rid"=>$rid));
    WeUtility::logging('isLocalFans', $ret);
    if (empty($ret)) {
      $ret = pdo_fetch("select * from " .tablename(self::$t_subfollow). " where uniacid=:uniacid and rid=:rid and brrow_openid=:borrow_openid",array(':uniacid'=>$uniacid,':rid'=>$rid,':borrow_openid'=>$borrow_openid));
      WeUtility::logging('isScan', $ret);
    }
    WeUtility::logging("isNewUser output", $ret);
    return  empty($ret);
  }

  public function addNewUser($weid, $from_user) {
    $ret = pdo_insert(self::$t_local_fans, array('weid'=>$weid, 'from_user'=>$from_user, 'createtime'=>time()));
    return $ret;
  }

  public function getUpLevel($weid, $this_level_openid) {
    $uplevel = pdo_fetch("SELECT * FROM " . tablename(self::$t_follow) . " WHERE weid=:weid AND follower=:follower LIMIT 1",
      array(":weid"=>$weid, ":follower"=>$this_level_openid));
    return $uplevel;
  }

}
