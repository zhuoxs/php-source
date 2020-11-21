<?php
//简单反击作弊
class AntiSpam {
  private static $t_follow = 'n1ce_mission_follow';
  private static $t_black = 'n1ce_mission_blacklist';

  public function black($uniacid, $leader) {
      if (!empty($leader)) {
        $b = pdo_fetch("SELECT * FROM " . tablename(self::$t_black) . " WHERE from_user=:f AND uniacid=:w LIMIT 1", array(':f'=>$leader, ':w'=>$uniacid));
        if (empty($b)) {
          pdo_insert(self::$t_black, array('uniacid'=>$uniacid, 'from_user'=>$leader,'access_time'=>time()));
        }
      }
      return '';
  }
  /*
   * 返回true或者false
   * 如果返回0，则表示没有作弊嫌疑
   * 如果返回大于0，则有作弊嫌疑，返回值表示垃圾因子，越大越垃圾
   */
  public function filter($uniacid, $leader, $setting, $rid) {
    global $_W;
    /* 算法暂时比较简单: $time_threshold分钟内带来的粉丝数超过了$user_threshold人
      */
    $b = pdo_fetch("SELECT * FROM " . tablename(self::$t_black) . " WHERE from_user=:f AND uniacid=:w LIMIT 1", array(':f'=>$leader, ':w'=>$uniacid));
    if($b){
      return '101';
    }
    $time_threshold = $setting['antispam_time_threshold'];
    $user_threshold = $setting['antispam_user_threshold'];
    $since = TIMESTAMP - $time_threshold;
    $result = pdo_fetch("SELECT count(*) as count FROM " . tablename(self::$t_follow)
         . " WHERE leader = :leader AND uniacid = :uniacid AND rid = :rid AND createtime > :since",
         array(':leader'=>$leader, ':uniacid'=>$uniacid, ':rid'=>$rid ,':since'=>$since));
    WeUtility::logging("记录黑名单记录111",$result);
    $count = $result['count'] + 1;
    if ($count < $user_threshold) {
       $count = 0;
    }

   // 拉黑这狗日的
   if ($count > 0)  {
     $this->black($uniacid, $leader);
   }
   return $count;

  }
}
