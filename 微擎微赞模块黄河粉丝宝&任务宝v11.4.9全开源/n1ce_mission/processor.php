<?php
/**
 * 黄河·任务宝模块处理程序
 *
 * @author 
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

require IA_ROOT . '/addons/n1ce_mission/loader.php';
include 'huanghe_function.php';

class N1ce_missionModuleProcessor extends WeModuleProcessor {
  private static $t_reply = 'n1ce_mission_reply';

  public function respond() {
    global $_W;
    $fans =  $this->refreshUserInfo($this->message['from']);
    $rule = $this->message['content'];
    $settings = $this->module['config'];
    //获取活动基本信息并判断状态
    $reply = $this->getActivityBasic($fans,$settings);
    
    WeUtility::logging("return",$reply);
    $resp = 'success';
    WeUtility::logging("Processor:SUBSCRIBE", $this->message);
    if ($this->message['msgtype'] == 'text') {
      WeUtility::logging('respond2');
      // 通过输入关键字进入
      $this->replyCallBack($settings,$reply,$fans['openid']);
      $text = $this->respondText($fans, $reply, $rule);
    } else if ($this->message['msgtype'] == 'event' and $this->message['event'] == 'CLICK') {
      WeUtility::logging('respond2');
      // 通过点击菜单，模拟输入关键字进入
      $this->replyCallBack($settings,$reply,$fans['openid']);
      
      $text = $this->respondText($fans, $reply, $rule);
    } else if ($this->message['msgtype'] == 'event') {
      // 其它事件：扫码、关注
      if ($this->message['event'] == 'subscribe' && 0 === strpos($this->message['eventkey'], 'qrscene_')) {
        // 关注。这里需要区分两种情况：其它途径关注；扫专属二维码关注
        //并发处理
        if($this->limitFollowerTime($_W['uniacid'],$fans['openid'])){
          return 'success';
        }
        $resp = $this->respondSubscribe($reply, $fans, $this->rule);
        if($resp == 'we7'){
          //微擎参数二维码
          $this->replyCallBack($settings,$reply,$fans['openid']);
          $text = $this->respondText($fans, $reply, $rule);
          return 'success';
        }else{
          if(($reply['sub_post'] == 2) && empty($reply['area'])){
            $this->respAgain($fans, $reply, $rule);
          }
        }
      } elseif ($this->message['event'] == 'SCAN') {
        // 二维码扫码
        if($reply['isall'] == 1){
          $msg = str_replace('#昵称#', $fans['nickname'], $reply['miss_resub']);
          $this->sendText($fans['openid'],$msg);
        }else{
          $resp = $this->respondSubscribe($reply, $fans, $this->rule);
          if($resp == 'we7'){
            //微擎参数二维码
            $this->replyCallBack($settings,$reply,$fans['openid']);
            $text = $this->respondText($fans, $reply, $rule);
            return 'success';
          }
        }
        if(($reply['again'] == 2) && empty($reply['area'])){
          $this->respAgain($fans, $reply, $rule);
        }
      } else if ($this->message['event'] == 'subscribe') {
      	//直接关注 or 订阅号关注回复触发
        WeUtility::logging('subscribe n1ce_mission');
        if($reply['posttype'] == 2){
          /**绑定开放平台**/
          $unionid = $this->getUserUnionid($this->message['from']);
          //并发处理
          if($this->limitFollowerTime($_W['uniacid'],$fans['openid'])){
            return 'success';
          }
          
          $resp = $this->respondOtherSubscribe($reply,$fans,$unionid,$this->rule);
          if(($reply['sub_post'] == 2) && ($reply['isred'] == 2) && empty($reply['area'])){
            $this->replyCallBack($settings,$reply,$fans['openid']);
            $this->respondText($fans, $reply, $rule);
          }
        }else{
          // 模拟输入关键字进入
          $this->replyCallBack($settings,$reply,$fans['openid']);
          
          $text = $this->respondText($fans, $reply, $rule);
        }
      }
    }
    return $resp;
  }
  //135编辑器 学而思 等大平台 可以自己用redis或者其他缓存来处理并发
  private function limitFollowerTime($uniacid,$openid){
    pdo_insert('n1ce_mission_antilog',array('uniacid'=>$uniacid,'check_sign'=>$openid.time()));
    if(pdo_insertid()){
      return false;
    }else{
      return true;
    }
  }
  private function insertNewMsg($createtime,$from_user,$rid){
    global $_W;
    $data = array(
      'uniacid' => $_W['uniacid'],
      'rid' => $rid,
      'check_sign' => $createtime.$from_user,
    );
    pdo_insert('n1ce_mission_msgid',$data);
    return pdo_insertid();
  }
  //订阅号处理
  private function respondOtherSubscribe($reply,$fans,$unionid,$rid){
  	global $_W;
  	$follower = $fans['openid'];
  	if(empty($unionid)){
  		return $this->respText(base64_decode('5qih5Z2X6K6+572u5YCf5p2D5LiN5a6M5pW077yM6K+35LuU57uG5qOA5p+l6K6+572uIQ=='));
  	}
    if($reply['tagid']){
      $account_api = WeAccount::create();
      $account_api->fansTagTagging($follower, array($reply['tagid']));
    }
  	yload()->classs('n1ce_mission', 'wechatapi');
    yload()->classs('n1ce_mission', 'scene');
    yload()->classs('n1ce_mission', 'follow');
    yload()->classs('n1ce_mission', 'fans');
    yload()->classs('n1ce_mission','wechatutil');
    $_scene = new Scene();
    $_follow = new Follow();
    $_weapi = new WechatAPI();
    $_fans = new Fans();
    $_wechatutil = new WechatUtil();
    // 2. 读取qr表，找到分享者uid
    $qr = $_scene->getQRByUnionid($_W['uniacid'], $unionid, $rid);
    if (empty($qr)) {
      WeUtility::logging('subscribe', 'qr not found using scene ' . $unionid);
      return $this->respText($reply['first_action']);
    }
    // 3. 将本次引流事件记录到follow表
    $leaderid = $qr['leader'];
    $leader = $_fans->refresh($leaderid);
    // 4. 推送指定消息给用户
    $resp ="";
    if ($_follow->isNewUser($_W['uniacid'], $follower, $rid, $reply['next_scan'])) {
      WeUtility::logging('record followship', $qr);
      //fans有位置限制
      if($reply['area']){
        pdo_insert('n1ce_mission_flog',array('uniacid'=>$_W['uniacid'],'follower'=>$follower,'leaderid'=>$leaderid,'status'=>2,'createtime'=>time()));
        $limit_scan = str_replace('#验证地址#', $_wechatutil->createMobileUrl('scan', 'n1ce_mission',array('rid' => $rid,'from_user' => $follower,'logid'=>pdo_insertid(),'rule'=>$this->message['content'])), $reply['limit_scan']);
        $_weapi->sendText($follower,$limit_scan);
        return 'success';
      }
      //记录follower 并 更新leaderid 的邀请总数量
      $ret = $_follow->processSubscribe($_W['uniacid'], $leaderid, $follower, $rid);

      if($ret){
      	//提醒扫码者信息
      	
      	$this->notifySelfMsg($reply['miss_sub'],$leader,$fans,$_weapi);
      	WeUtility::logging("提醒扫码者信息",$reply['miss_sub']);
      	//提醒上级多一位下级 && 奖品发送
      	$this->notifyLeaderCustom($_weapi, $leader, $fans, $reply);

      }else{
      	return;
      }

    }else{
    	$text = str_replace('#昵称#', $fans['nickname'], $reply['miss_resub']);
      $_weapi->sendText($follower,$text);
    }
    return $this->respText($resp);
  }
  private function respAgain($fans, $reply, $rule){
    if (!empty($reply)) {
      WeUtility::logging("Going Running taskscan", $url . "==>" . json_encode($ret));
      yload()->classs('n1ce_mission', 'wechatutil');
      $url = WechatUtil::createMobileUrl('RunTask', 'n1ce_mission', array('from_user'=>$fans['openid'], 'rid'=>$reply['rid'], 'rule'=>$rule,'expire'=>$reply['expire']));
      load()->func('communication');
      $ret = ihttp_request($url,'','',3);
      WeUtility::logging("Running task", $url . "==>" . json_encode($ret));
    }
    return '';
  }
  private function respondText($fans, $reply, $rule) {
    global $_W;
    //存储用户信息
    //排行榜
    yload()->classs('n1ce_mission', 'wechatutil');
    $rank = WechatUtil::createMobileUrl('rank', 'n1ce_mission', array('rid'=>$reply['rid']));
    //respond text
    if ($reply['first_info']) {
  		$activity_time = date('Y-m-d H:i', $reply['starttime'])."~".date('Y-m-d H:i', $reply['endtime']);
  		$info = str_replace('#时间#', $activity_time, $reply['first_info']);
      $info = str_replace('#昵称#', $fans['nickname'], $info);
  		$info = str_replace('#排行榜#', $rank, $info);
  		$this->sendText($fans['openid'], $info);
  		
  	}
  	if ($reply['miss_wait']) {
      $miss_wait = str_replace('#昵称#', $fans['nickname'], $reply['miss_wait']);
  		$miss_wait = str_replace('#排行榜#', $rank, $miss_wait);
  		$this->sendText($fans['openid'], $miss_wait);
  	}
    // start a reponser thread using curl
    if (!empty($reply)) {
      WeUtility::logging("Going Running task", $url . "==>" . json_encode($ret));
      $url = WechatUtil::createMobileUrl('RunTask', 'n1ce_mission', array('from_user'=>$fans['openid'], 'rid'=>$reply['rid'], 'rule'=>$rule,'expire'=>$reply['expire']));
      load()->func('communication');
      //异步
      $ret = ihttp_request($url,'','',3);
      WeUtility::logging("Running task", $url . "==>" . json_encode($ret));
    }
    //  exit
    return '';
  }
  private function respondSubscribe($reply, $fans, $rid) {
    global $_W;
    /* 有新用户通过二维码订阅本账号, 处理流程如下：
     * 1. 判断是否设置scene id，如果没有设置则直接回复默认消息，如果设置了scene id，则读取scene id
     * 2. 读取qr表，找到分享者uid，channel
     * 3. 将本次引流事件记录到follow表
     * 4. 推送channel指定消息给用户
     */
    $follower = $fans['openid'];
    $scene_id = $this->message['scene'];
    if (empty($scene_id)) {
      return;
    }
    if($reply['tagid']){
      $account_api = WeAccount::create();
      $status = $account_api->fansTagTagging($follower, array($reply['tagid']));
      WeUtility::logging('打标签', $reply['tagid']); 
    }

    yload()->classs('n1ce_mission', 'wechatapi');
    yload()->classs('n1ce_mission', 'scene');
    yload()->classs('n1ce_mission', 'follow');
    yload()->classs('n1ce_mission', 'fans');
    yload()->classs('n1ce_mission','wechatutil');
    $_scene = new Scene();
    $_follow = new Follow();
    $_weapi = new WechatAPI();
    $_fans = new Fans();
    $_wechatutil = new WechatUtil();
    // 2. 读取qr表，找到分享者uid
    $qr = $_scene->getQRByScene($_W['uniacid'], $scene_id, $rid);
    if (empty($qr)) {
      WeUtility::logging('subscribe', 'qr not found using scene ' . $scene_id);
      return 'we7';
    }

    // 3. 将本次引流事件记录到follow表
    $leaderid = $qr['from_user'];
    $leader = $_fans->refresh($leaderid);
    // 4. 推送指定消息给用户
    $resp ="";
    //未设置模板消息提醒
    if (empty($reply['temp_join']) && $reply['msgtype'] == 1) {
      WeUtility::logging('subscribe', 'channel not found using temp_join ' . $reply['temp_join']);
      return $this->respText('请联系管理员设置模板消息哦!不设置模板消息不记录上下级关系的～');
    }
    //是否允许其他活动取消的粉丝帮助扫码加人气
    if ($_follow->isNewUser($_W['uniacid'], $follower, $rid, $reply['next_scan'])) {
      WeUtility::logging('record followship', $qr); 
      //fans有位置限制
      if($reply['area']){
        pdo_insert('n1ce_mission_flog',array('uniacid'=>$_W['uniacid'],'follower'=>$follower,'leaderid'=>$leaderid,'status'=>2,'createtime'=>time()));
        $limit_scan = str_replace('#验证地址#', $_wechatutil->createMobileUrl('scan', 'n1ce_mission',array('rid' => $rid,'from_user' => $follower,'logid'=>pdo_insertid(),'rule'=>$this->message['content'])), $reply['limit_scan']);
        $_weapi->sendText($follower,$limit_scan);
        return 'success';
      }
      //记录follower 并 更新leaderid 的邀请总数量
      $ret = $_follow->processSubscribe($_W['uniacid'], $leaderid, $follower, $rid);

      if($ret){
      	//提醒扫码者信息
      	
      	$this->notifySelfMsg($reply['miss_sub'],$leader,$fans,$_weapi);
      	WeUtility::logging("提醒扫码者信息",$reply['miss_sub']);
      	//提醒上级多一位下级 && 奖品发送
      	$this->notifyLeaderFollow($_weapi, $leader, $fans, $reply);

      }else{
      	return;
      }

    }else{
    	$text = str_replace('#昵称#', $fans['nickname'], $reply['miss_resub']);
      $_weapi->sendText($follower,$text);
    }
    return $this->respText($resp);
  }
  private function notifyLeaderFollow($weapi, $leader, $follower, $reply){
  	yload()->classs('n1ce_mission','follow');
  	yload()->classs('n1ce_mission','prize');
  	
  	$_follow = new Follow();
  	$_prize = new Prize();
  	$allnumber = $_follow->getNumberByRid($reply['uniacid'],$reply['rid'],$leader['openid']);
  	
    $prize = $_prize->getPrizeByNumber($reply['uniacid'],$reply['rid'],$allnumber);
  	$next = $_prize->getNextByNumber($reply['uniacid'],$reply['rid'],$allnumber);
  	$code = $prize['code'];
  	$data = $prize['data'];
    $l_status = "";
  	if($code == '101'){
  		//满足条件发奖品
  		WeUtility::logging('发奖品1');
  		$_prize->sendPrize($data,$allnumber,$leader,$follower,$reply);
      if($next['code'] == '102'){
        $next_data = $next['data'];
        $news_data = str_replace('#奖品#', $next_data['prize_name'], $reply['next_step']);
        $news_data = str_replace('#库存#', $next_data['prizesum'], $news_data);
        $news_data = str_replace('#人气值#', $allnumber, $news_data);
        $news_data = str_replace('#差值#', $next_data['miss_num']-$allnumber, $news_data);
        // $news[] = array(
        //   'title' => urlencode('待办任务通知'),
        //   'description' => urlencode($news_data),
        //   'picurl' => '',
        //   'url' => '',
        // );
        $news_status = $weapi->sendText($leader['openid'],$news_data);
      }
  		WeUtility::logging('发奖品2');
  	}elseif ($code == '102') {
  		//还需要邀请人
  		$remark_on = str_replace('#奖品#', $data['prize_name'], $reply['remark_on']);
  		
  		$remark_on = str_replace('#库存#', $data['prizesum'], $remark_on);
  		
  		$remark_on = str_replace('#差值#', $data['miss_num']-$allnumber, $remark_on);

  		$postdata = array(
  			'first' => array(
  				'value' => "又一位小伙伴[".$follower['nickname']."]认可你的人气啦,人气值 +1,总人气值(".$allnumber.")",
          'color' => '#173177',
  			),
  			'keyword1' => array(
  				'value' => "系统会员编号[".$follower['uid']."]",
          'color' => '#173177',
  			),
  			'keyword2' => array(
  				'value' => date("Y-m-d H:i:s",time()),
          'color' => '#173177',
  			),
  			'remark' => array(
  				'value' => $remark_on,
  				'color' => '#FF0000',
  			),
  		);
  		$news[] = array(
        'title' => urlencode('新成员加入通知'),
        'description' => urlencode($postdata['first']['value'].'\n会员ID：'.$postdata['keyword1']['value'].'\n完成时间：'.$postdata['keyword2']['value'].'\n'.$postdata['remark']['value']),
        'picurl' => '',
        'url' => '',
      );
      if($reply['msgtype'] == 2){
        $status = $weapi->sendNews($news,$leader['openid']);
      }else{
        $result = $weapi->sendTempMsg($leader['openid'], $reply['temp_join'], $postdata, $url = '', $topcolor = '#FF683F');
      }
  	}elseif ($code == '103') {
  		//所有任务已经完成
  	}
    return $l_status;
  }
  //客服消息处理
  private function notifyLeaderCustom($weapi, $leader, $follower, $reply){
  	yload()->classs('n1ce_mission','follow');
  	yload()->classs('n1ce_mission','prize');
  	
  	$_follow = new Follow();
  	$_prize = new Prize();
  	$allnumber = $_follow->getNumberByRid($reply['uniacid'],$reply['rid'],$leader['openid']);
  	
  	$prize = $_prize->getPrizeByNumber($reply['uniacid'],$reply['rid'],$allnumber);
    $next = $_prize->getNextByNumber($reply['uniacid'],$reply['rid'],$allnumber);
  	$code = $prize['code'];
  	$data = $prize['data'];
  	if($code == '101'){
  		//满足条件发奖品
  		WeUtility::logging('发奖品1');
  		$_prize->sendPrizeMsg($data,$allnumber,$leader,$follower,$reply);
  		WeUtility::logging('发奖品2');
      if($next['code'] == '102'){
        $next_data = $next['data'];
        $news_data = str_replace('#奖品#', $next_data['prize_name'], $reply['next_step']);
        $news_data = str_replace('#库存#', $next_data['prizesum'], $news_data);
        $news_data = str_replace('#人气值#', $allnumber, $news_data);
        $news_data = str_replace('#差值#', $next_data['miss_num']-$allnumber, $news_data);
        // $news[] = array(
        //   'title' => urlencode('待办任务通知'),
        //   'description' => urlencode($news_data),
        //   'picurl' => '',
        //   'url' => '',
        // );
        $news_status = $weapi->sendText($leader['openid'],$news_data);
      }
  	}elseif ($code == '102') {
  		//还需要邀请人
  		$remark_on = str_replace('#奖品#', $data['prize_name'], $reply['miss_back']);
  		$remark_on = str_replace('#库存#', $data['prizesum'], $remark_on);
  		$remark_on = str_replace('#差值#', $data['miss_num']-$allnumber, $remark_on);
  		$remark_on = str_replace('#昵称#', $follower['nickname'], $remark_on);
  		$remark_on = str_replace('#人气值#', $allnumber, $remark_on);
  		$result = $weapi->sendText($leader['openid'],$remark_on);
  	}elseif ($code == '103') {
  		//所有任务已经完成
  		return '';
  	}
  }
  //对新关注扫码者提示
  private function notifySelfMsg($msg, $leader, $follower, $weapi){
  	$msg = str_replace('#昵称#', $follower['nickname'], $msg);
  	$msg = str_replace('#上级#', $leader['nickname'], $msg);
  	$weapi->sendText($follower['openid'],$msg);
	//是否生成海报
	//todo
  }
  /*
  * 活动时间判断
  */
  private function getActivityBasic($fans,$settings){
  	global $_W;
  	$reply = pdo_fetch("SELECT * FROM " . tablename(self::$t_reply) . " WHERE rid = :rid LIMIT 1", array(':rid' => $this->rule));
    WeUtility::logging("Reply", json_encode($reply) . json_encode($this->rule));
    if (!empty($reply)) {
  		if ($reply['starttime'] > time()) {
  			$data = $this->sendText($fans['openid'],$reply['miss_start']);
  			WeUtility::logging("msg",$data);
  			exit();
  		} elseif ($reply['endtime'] < time()) {
  			$data = $this->sendText($fans['openid'],$reply['miss_end']);
  			exit();
  		}
  	}
  	if($reply['status'] == 2){
  		$this->sendText($fans['openid'],$reply['miss_cut']);
  		exit();
  	}
  	//空头像滚蛋
  	if(empty($fans['avatar'])){
  		$this->sendText($fans['openid'],"用户基础信息不完整,无法参与活动！");
  		exit();
  	}
  	//判断性别
  	if(($reply['sex'] == 2 && $fans['gender'] == 2) || ($reply['sex'] == 2 && $fans['gender'] == 0)){//boy
  		$this->sendText($fans['openid'],$reply['limit_sex']);
  		exit();
  	}
  	if(($reply['sex'] == 3 && $fans['gender'] == 1) || ($reply['sex'] == 3 && $fans['gender'] == 0)){//girl
  		$this->sendText($fans['openid'],$reply['limit_sex']);
  		exit();
  	}
    return $reply;
  }
  // 借权+位置限制返回信息并退出
  private function replyCallBack($settings,$reply,$from_user){
  	yload()->classs('n1ce_mission','area');
  	$_area = new Area();
  	if($settings['borrow'] == 2){
      //借权
      if($reply['posttype'] == 2){

        if($this->getUserUnionid($from_user)){
          $_area->borrow($settings,$reply,$from_user,$this->getUserUnionid($from_user),$this->message['content']);
        }else{
          $this->sendText($from_user,"此订阅号未绑定开放平台,请联系管理员处理");
          exit();
        }
        
      }else{
        $_area->onlyArea($settings,$reply,$from_user,$this->message['content']);
      }
  	}elseif($settings['borrow'] == 1 && $reply['area']){
  		$_area->onlyArea($settings,$reply,$from_user,$this->message['content']);
  	}else{
  		return true;
  	}
  }

  private function refreshUserInfo($from_user) {
    global $_W;
    yload()->classs('n1ce_mission', 'fans');
    $_fans = new Fans();
    $userInfo = $_fans->refresh($from_user);
    WeUtility::logging('refresh', $userInfo);
    return $userInfo;
  }
  public function getUserUnionid($from_user){
	global $_W;
	yload()->classs('n1ce_mission', 'fans');
    $_fans = new Fans();
    $unionid = $_fans->getUniodid($from_user);
    WeUtility::logging('getUniodid', $unionid);
	return $unionid;
  }
  private function sendText($openid,$info){
	global $_W;
	$message = array(
		'msgtype' => 'text',
		'text' => array('content' => urlencode($info)),
		'touser' => $openid,
	);
	$account_api = WeAccount::create();
	$status = $account_api->sendCustomNotice($message);
	return $status;
  }

  private function http_request($url, $post = '', $extra = array(), $timeout = 60000)
  {
    $timeout = intval($timeout / 1000);
    $timeout = (0 == $timeout) ? 1 : $timeout;
    $urlset = parse_url($url);
    if(empty($urlset['path'])) {
      $urlset['path'] = '/';
    }
    if(!empty($urlset['query'])) {
      $urlset['query'] = "?{$urlset['query']}";
    }
    if(empty($urlset['port'])) {
      $urlset['port'] = $urlset['scheme'] == 'https' ? '443' : '80';
    }
    if (strexists($url, 'https://') && !extension_loaded('openssl')) {
      if (!extension_loaded("openssl")) {
        message('请开启您PHP环境的openssl');
      }
    }
    if(function_exists('curl_init') && function_exists('curl_exec')) {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $urlset['scheme']. '://' .$urlset['host'].($urlset['port'] == '80' ? '' : ':'.$urlset['port']).$urlset['path'].$urlset['query']);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_HEADER, 1);
      if($post) {
        curl_setopt($ch, CURLOPT_POST, 1);
        if (is_array($post)) {
          $filepost = false;
          foreach ($post as $name => $value) {
            if (substr($value, 0, 1) == '@') {
              $filepost = true;
              $post[$name] = class_exists('CURLFile', false) ? new CURLFile(substr($value, 1)) : $value;
              break;
            }
          }
          if (!$filepost) {
            $post = http_build_query($post);
          }
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
      }
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
      curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSLVERSION, 1);
      if (defined('CURL_SSLVERSION_TLSv1')) {
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
      }
      curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1');
      if (!empty($extra) && is_array($extra)) {
        $headers = array();
        foreach ($extra as $opt => $value) {
          if (strexists($opt, 'CURLOPT_')) {
            curl_setopt($ch, constant($opt), $value);
          } elseif (is_numeric($opt)) {
            curl_setopt($ch, $opt, $value);
          } else {
            $headers[] = "{$opt}: {$value}";
          }
        }
        if(!empty($headers)) {
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
      }
      $data = curl_exec($ch);
      $status = curl_getinfo($ch);
      $errno = curl_errno($ch);
      $error = curl_error($ch);
      curl_close($ch);
      if($errno || empty($data)) {
        return error(1, $error);
      } else {
        load()->func('communication');
        return ihttp_response_parse($data);
      }
    }
    $method = empty($post) ? 'GET' : 'POST';
    $fdata = "{$method} {$urlset['path']}{$urlset['query']} HT"."TP/1.1\r\n";
    $fdata .= "Host: {$urlset['host']}\r\n";
    if(function_exists('gzdecode')) {
      $fdata .= "Accept-Encoding: gzip, deflate\r\n";
    }
    $fdata .= "Connection: close\r\n";
    if (!empty($extra) && is_array($extra)) {
      foreach ($extra as $opt => $value) {
        if (!strexists($opt, 'CURLOPT_')) {
          $fdata .= "{$opt}: {$value}\r\n";
        }
      }
    }
    $body = '';
    if ($post) {
      if (is_array($post)) {
        $body = http_build_query($post);
      } else {
        $body = urlencode($post);
      }
      $fdata .= 'Content-Length: ' . strlen($body) . "\r\n\r\n{$body}";
    } else {
      $fdata .= "\r\n";
    }
    if($urlset['scheme'] == 'https') {
      $fp = fsockopen('ssl://' . $urlset['host'], $urlset['port'], $errno, $error);
    } else {
      $fp = fsockopen($urlset['host'], $urlset['port'], $errno, $error);
    }
    stream_set_blocking($fp, true);
    stream_set_timeout($fp, $timeout);
    if (!$fp) {
      return error(1, $error);
    } else {
      fwrite($fp, $fdata);
      $content = '';
      while (!feof($fp))
        $content .= fgets($fp, 512);
      fclose($fp);
      load()->func('communication');
      return ihttp_response_parse($content, true);
    }
  }
}