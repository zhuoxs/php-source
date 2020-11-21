<?php
/**
 * 黄河·任务宝模块微站定义
 *
 * @author 
 * @url 
 */
//你这傻逼，你爸爸的代码好看吗，日你妈，MMB
defined('IN_IA') or exit('Access Denied');
define('JS', '../addons/n1ce_mission/style/js/');
define('CSS', '../addons/n1ce_mission/style/css/');
define('IMG', '../addons/n1ce_mission/template/images/');
require IA_ROOT . '/addons/n1ce_mission/loader.php';
include 'monUtil.class.php';
class N1ce_missionModuleSite extends WeModuleSite {
	public $table_reply = 'n1ce_mission_reply';
	public $table_log = 'n1ce_mission_orderlog';
	public $table_order = 'n1ce_mission_order';
	public function doWebClearfans(){
		global $_W,$_GPC;
		pdo_delete('n1ce_mission_follow',array('id'=>$_GPC['id']));
		message(error(0, '删除成功！'), referer(), 'ajax');
	}
	public function doMobileShowpost(){
		global $_W,$_GPC;
		yload()->classs('n1ce_mission', 'fans');
	    $_fans = new Fans();
	    
		$from_user = $_GPC['from_user'];
		$userInfo = $_fans->refresh($from_user);
		$rid = $_GPC['rid'];
		$rule = $_GPC['rule'];
		$reply = pdo_fetch("SELECT * FROM " . tablename('n1ce_mission_reply') . " WHERE rid = :rid AND uniacid = :uniacid ORDER BY `id` DESC", array(':rid' => $rid, ':uniacid' => $_W['uniacid']));
		$this->respondText($userInfo, $reply, $rule);
		return true;
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
	//粉丝位置限制
	public function doMobileScan(){
		global $_W,$_GPC;
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		if (strpos($user_agent, 'MicroMessenger') === false) {
			message('请在微信客户端打开','','error');
		}
		$mc = mc_oauth_userinfo();
		$rid = $_GPC['rid'];
		$from_user = $_GPC['from_user'];
		$brrow_openid = $_SESSION['oauth_openid'];
		$rule = $_GPC['rule'];
		$lid = $_GPC['logid'];

		$fans_info = pdo_get('n1ce_mission_flog',array('id'=>$lid),array('follower'));
		if($fans_info['follower'] !== $from_user){
			message('粉丝信息错误,请重试！','','error');
		}
		include $this->template('scan-fans');
	}
	public function doMobileFansgps(){
		global $_W,$_GPC;
		yload()->classs('n1ce_mission', 'wechatapi');
		yload()->classs('n1ce_mission', 'fans');
		yload()->classs('n1ce_mission', 'follow');
		$_weapi = new WechatAPI();
		$_fans = new Fans();
		$_follow = new Follow();
		$rid = $_GPC['rid'];
		$rule = $_GPC['rule'];
		$from_user = $_GPC['from_user'];
		$brrow_openid = $_GPC['brrow_openid'];
		$lid = $_GPC['logid'];
		$fans_info = pdo_get('n1ce_mission_flog',array('id'=>$lid),array('follower','status','leaderid'));
		if($fans_info['follower'] !== $from_user){
			$_weapi->sendText($fans_info['follower'],'老铁,请按照正常流程为好友增加人气哦！！');
			exit();
		}
		$fans = $_fans->refresh($fans_info['follower']);
		$reply = pdo_fetch("SELECT * FROM " . tablename('n1ce_mission_reply') . " WHERE rid = :rid AND uniacid = :uniacid ORDER BY `id` DESC", array(':rid' => $rid, ':uniacid' => $_W['uniacid']));
		if($fans_info['status'] == 1){
			$msg = str_replace('#昵称#', $fans['nickname'], $reply['miss_resub']);
			$_weapi->sendText($fans_info['follower'],$msg);
			exit();
		}
		
		$loc="";
		if (!empty($_GPC['latitude']) && !empty($_GPC['longitude'])){
			$loc=$_GPC['latitude'].",".$_GPC['longitude'];
		}else{
			$_weapi->sendText($fans_info['follower'],'没有获取到你的位置信息,请点击上方蓝色字重试一次吧！');
			exit();
		}
		$url="http://api.map.baidu.com/geocoder/v2/?ak=QzgbmMn6BtTtW4hwFI5NLYx2&location=".$loc."&output=json";
		$ret=json_decode(file_get_contents($url),true);
		if($reply['xzlx'] == 1){
			$clientcity=$ret['result']['addressComponent']['province'];
		}elseif($reply['xzlx'] == 2){
			$clientcity=$ret['result']['addressComponent']['district'];
		}else{
			$clientcity=$ret['result']['addressComponent']['city'];
		}
		$clientcity = str_replace('市','',$clientcity);
		$clientcity = str_replace('省','',$clientcity);
		if(strpos($reply['area'],$clientcity)===false){	
			$_weapi->sendText($fans_info['follower'],$reply['limit_error']);
			exit();
		}
		$leader = $_fans->refresh($fans_info['leaderid']);
		//记录follower 并 更新leaderid 的邀请总数量
	    $ret = $_follow->processSubscribe($_W['uniacid'], $fans_info['leaderid'], $fans_info['follower'], $rid);

	    if($ret){
	    	//更新临时表
	    	pdo_update('n1ce_mission_flog',array('status'=>1),array('id'=>$lid));
	    	//
	    	$newdata = array(
	    		'uniacid' => $_W['uniacid'],
	    		'rid' => $rid,
	    		'from_user' => $from_user,
				'brrow_openid' => $brrow_openid,
				'status' => 1,
				'createtime' => TIMESTAMP,
	    	);
	      	//提醒扫码者信息
	       $this->notifySelfMsg($reply['miss_sub'],$leader,$fans,$_weapi);
	      	WeUtility::logging("提醒扫码者信息",$reply['miss_sub']);
	      	//提醒上级多一位下级 && 奖品发送
	       if($reply['posttype'] == 2){
	       		$this->notifyLeaderCustom($_weapi, $leader, $fans, $reply);
	       		$newdata['unionid'] = $_fans->getUniodid($from_user);
	       }else{
	       		$this->notifyLeaderFollow($_weapi, $leader, $fans, $reply);
	       }
	       pdo_insert('n1ce_mission_member',$newdata);
	       if($reply['sub_post'] == 2){
	       	yload()->classs('n1ce_mission', 'responser');
		    $_responser = new Responser();
		    if($reply['expire']){
		    	$expire = $reply['expire']*3600;
		    }else{
		    	$expire = 2592000; 
		    }
		    $_responser->respondText($_W['uniacid'], $from_user, intval($rid), $rule,$expire);
		    exit(0);
	       }
	    }else{
	       $_weapi->sendText($fans_info['follower'],'系统错误～请重试！');
	    }
	    exit();
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
	//是否拉黑
	public function isBlack($from_user){
		global $_W;
		$b = pdo_fetch("SELECT * FROM " . tablename('n1ce_mission_blacklist') . " WHERE from_user=:f AND uniacid=:w LIMIT 1", array(':f'=>$from_user, ':w'=>$_W['uniacid']));
		return $b;
	}
	public function doWebHandblack(){
		global $_W,$_GPC;
		pdo_insert('n1ce_mission_blacklist', array('uniacid'=>$_W['uniacid'], 'from_user'=>$_GPC['from_user'],'access_time'=>time()));
		message(error(0, '拉黑成功！'), referer(), 'ajax');
	}
	public function doWebDeleteblack(){
		global $_W,$_GPC;
		pdo_delete('n1ce_mission_blacklist',array('from_user'=>$_GPC['from_user'],'uniacid'=>$_W['uniacid']));
		message(error(0, '解除黑名单成功！'), referer(), 'ajax');
	}
	public function doWebTempurl(){
		global $_W,$_GPC;
		$short_id = $_GPC['short_id'];
		load()->func( 'communication' );
		$account = WeAccount::create();
	    $token = $account->getAccessToken();
	    $url = "https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=".$token;
	    $data = array('template_id_short'=>$short_id);
	    $json = ihttp_post($url,json_encode($data));
		$temp = @json_decode($json['content'],true);
		if($temp['errmsg'] == 'ok'){
			return json_encode(array('template_id'=>$temp['template_id'],'code'=>'101'));
		}else{
			return json_encode(array('msg'=>$temp['errmsg'],'code'=>'404'));
		}
	}
	public function cutUid($uid){
		$frist = substr($uid, 0, 1 );
		$delete_last = substr(strrev($uid),0,1);
		return $frist.'**'.$delete_last;
	}
	public function doWebAddnum(){
		global $_GPC;
		pdo_update('n1ce_mission_allnumber',array('allnumber'=>$_GPC['miss_num']),array('id'=>$_GPC['id']));
		message(error(0, '修改成功'), referer(), 'ajax');
	}
	public function doMobileCheckCode(){
		global $_W,$_GPC;
		$gid = $_GPC['gid'];
		$goods = pdo_fetch("select usecode from " .tablename('n1ce_mission_goods'). " where id = :id",array(':id'=>$gid));
		if($goods['usecode'] == $_GPC['code']){
			pdo_update('n1ce_mission_order',array('status'=>1),array('id'=>$_GPC['id']));
			echo json_encode(array('code'=>'101'));
		}else{
			echo json_encode(array('code'=>'404','msg'=>'核销密码错误'));
		}
	}
	public function doMobileSearch(){
		global $_W,$_GPC;
		
		$user_name = $_GPC['user_name'];
		$user_tel = $_GPC['user_tel'];
		$ret = pdo_fetch("select id,ex_name,ex_num from " .tablename('n1ce_mission_express'). " where uniacid = :uniacid and realname LIKE '%$user_name%' and mobile LIKE '%$user_tel%' order by id desc",array(':uniacid'=>$_W['uniacid']));
		
		if($ret['id']){
			//api限制每个网址每天查询5000次,需要携带网址
			$apiUrl = base64_decode("aHR0cDovL2FwaS54bXNpeGlhbi5jb20vYXBwL2luZGV4LnBocD9pPTEmYz1lbnRyeSZkbz1leHByZXNzJm09bjFjZV9haXdvcmQ=").'&name='.$ret['ex_name'].'&num='.$ret['ex_num'].'&siteroot='.$_W['siteroot'].'m='.$this->modulename;
			$url = file_get_contents($apiUrl);
			echo json_encode(array('code'=>101,'ex_num'=>$ret['ex_num'],'ex_name'=>$ret['ex_name'],'url100'=>$url));
		}else{
			echo json_encode(array('code'=>'404','msg'=>'快递点还未录入信息'));
		}
	}
	public function doWebsendcmsg(){
		global $_W,$_GPC;
		
		$msginfo = $_GPC['msginfo'];
		$from_user = $_GPC['from_user'];
		$status = $this->we7Custom($msginfo,$from_user);
		if(is_error($status)){
			message(error(1, '发送失败'.$status['message']), referer(), 'ajax');
		}
		message(error(0, '发送成功'), referer(), 'ajax');
	}
	public function doMobilePaysucess(){
		global $_W;
		include $this->template('paysucess');
	}
	public function goodstitle($id){
		$goods = pdo_get('n1ce_mission_goods',array('id'=>$id),array('title'));
		return $goods['title'];
	}
	public function payResult($params) {
		global $_W;
		if ($params['result'] == 'success' && $params['from'] == 'notify') {
			$tid = $params['tid'];
			$order = pdo_fetch("select * from " .tablename('n1ce_mission_orderlog'). " where tid = :tid",array(':tid'=>$tid));
			$data = array(
				'uniacid' => $_W['uniacid'],
				'rid' => $order['rid'],
				'gid' => $order['gid'],
				'from_user' => $order['from_user'],
				'nickname' => $order['nickname'],
				'headimgurl' => $order['headimgurl'],
				'realname' => $order['realname'],
				'mobile' => $order['mobile'],
				'residedist' => $order['residedist'],
				'sign' => time().$order['from_user'],
				'time' => time(),
			);
			pdo_insert('n1ce_mission_order',$data);
			if(pdo_insertid()){
				pdo_update('n1ce_mission_goods',array('quality -='=>1),array('id'=>$order['gid']));
			}
		}
		if ($params['from'] == 'return') {
	        if ($params['result'] == 'success') {
	            message('支付成功！', '../../app/' . $this->createMobileUrl('paysucess'), 'success');
	        }
	    }
	}
	/**海报缓存**/
	public function doWebclearPost(){
		global $_W,$_GPC;
		$rid = $_GPC['rid'];
		pdo_update('n1ce_mission_qrlog',array('createtime'=>1),array('rid'=>$rid,'uniacid'=>$_W['uniacid']));
		return true;
	}
	//订阅号二维码扫描
	public function doMobileSubpost(){
		global $_W,$_GPC;
		yload()->classs('n1ce_mission','scene');
		yload()->classs('n1ce_mission','follow');
		if($_W['container'] !== 'wechat'){
			message('请通过微信打开链接','','error');
		}
		$userinfo = mc_oauth_userinfo();
		$scene_id = $_GPC['scene_id'];
		$rid = $_GPC['rid'];
		$unionid = $userinfo['unionid'];
		$suburl = $this->module['config']['suburl'];
		if(empty($unionid) || empty($suburl)){
			message(base64_decode('5qih5Z2X6K6+572u5YCf5p2D5LiN5a6M5pW077yM6K+35LuU57uG5qOA5p+l6K6+572uIQ=='),'','info');
		}
		if(empty($rid) || empty($scene_id)){
			message('系统错误','','info');
		}

		$qr = Scene::getQRByScene($_W['uniacid'], $scene_id, $rid);
		//订阅号临时表存储扫描上下级关系 
		//记录 上级from_user 下级 brrow_openid unionid rid time
		//关注后 查询临时表 然后根据时间排序 回复状态
		if (Follow::isNewSubUser($_W['uniacid'], $userinfo['openid'], $rid)) {
			$ret = Follow::recordSiteScan($_W['uniacid'],$rid,$qr['from_user'],$_SESSION['oauth_openid'],$unionid);
		}
		header("location:" . $suburl);
	}
	//卡券领取 
	//TODO改进
	public function doMobileCardurl(){
		global $_GPC,$_W;
		if($_W['container'] !== 'wechat'){
			message('请通过微信打开链接','','error');
		}
		$card_id = $_GPC['card_id'];
		$openid = $_W['openid'];
		$cardArry = $this->getCard($card_id,$openid);
		include $this->template('getcard');
	}
	//任务
	public function doMobileRunTask(){
		global $_W,$_GPC;
		ignore_user_abort(true);
	    yload()->classs('n1ce_mission', 'responser');
	    $_responser = new Responser();
	    if($_GPC['expire']){
	    	$expire = $_GPC['expire']*3600;
	    }else{
	    	$expire = 2592000; 
	    }
	    $_responser->respondText($_W['uniacid'], $_GPC['from_user'], intval($_GPC['rid']), $_GPC['rule'],$expire);
	    exit(0);
	}
	/**
	 * 活动暂停
	 * @黄河 QQ 541535641
	 */
	public function doWebSetstatus(){
		global $_GPC, $_W;
        $rid = intval($_GPC['rid']);
        $status = intval($_GPC['status']);
        $result = pdo_update('n1ce_mission_reply',array('status' => $status),array('rid' => $rid));
        if(is_error($result)){
        	message('更新活动状态失败~',$this->createWebUrl('manage'),'error');
        }else{
        	message('更新活动状态成功~！',$this->createWebUrl('manage'),'success');
        }
	}
	public function doWebdelete() {
        global $_GPC, $_W;
        $rid = intval($_GPC['rid']);
        $rule = pdo_fetch("SELECT id, module FROM " . tablename('rule') . " WHERE id = :id and uniacid=:uniacid", array(':id' => $rid, ':uniacid' => $_W['uniacid']));
        if (empty($rule)) {
            message('抱歉，要修改的规则不存在或是已经被删除！');
        }
        if (pdo_delete('rule', array('id' => $rid))) {
            pdo_delete('rule_keyword', array('rid' => $rid));
            //删除统计相关数据
            pdo_delete('stat_rule', array('rid' => $rid));
            pdo_delete('stat_keyword', array('rid' => $rid));
			pdo_delete('n1ce_mission_reply', array('rid' => $rid));
			pdo_delete('n1ce_mission_member',array('rid' => $rid));
			pdo_delete('n1ce_mission_follow',array('rid' => $rid));
			pdo_delete('n1ce_mission_user', array('rid' => $rid));
			pdo_delete('n1ce_mission_allnumber',array('rid' => $rid));
			pdo_delete('n1ce_mission_prize', array('rid' => $rid));
        }
        message('规则操作成功！', $this->createWebUrl('manage', array('op' => 'display')), 'success');
    }
    public function doWebSendred(){
		global $_W ,$_GPC;
		checklogin();
		$settings = $this->module['config'];
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if($operation=="send"){
			$id = $_GPC['id'];
			$rid = $_GPC['rid'];
			$money = $_GPC['money'];
			$openid = $_GPC['openid'];
			if($settings['affiliate'] == 2){
				$res = $this->sendSubRedPacket($openid, $money);
			}else{
				$res = $this->sendRedPacket($openid,$money);
			}
			if($res === true){
				pdo_query('update ' . tablename('n1ce_mission_user') . ' set status = 1 where uniacid = :uniacid and id = :id', array(':uniacid' => $_W['uniacid'],':id' => $id));
				message('恭喜你，红包发送成功', $this->createWebUrl('userdetail',array('op'=>"finish",'rid' => $rid)), 'success');
			}else{
				message($res,'','error');
			}
			
		}	
	}

	// 数据出
	public function doWebExport(){
		global $_W,$_GPC;
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$rid = $_GPC['rid'];
		if($operation == "finish_mission"){
			$sql = 'select * from ' . tablename('n1ce_mission_user') . 'where uniacid = :uniacid and rid = :rid order by miss_num DESC ';
			$prarm = array(':uniacid' => $_W['uniacid'],':rid' => $rid);
			$list = pdo_fetchall($sql, $prarm);
			$str = $this->encode("粉丝昵称")."\t".$this->encode("任务完成人数")."\t".$this->encode("奖品状态")."\t".$this->encode("时间")."\n";
			
			foreach ($list as $vo) {
				$prize = "";
				if($vo['type'] == 1){
					$prize = "现金红包";
				}elseif($vo['type'] == 2){
					$prize = "微信卡券";
				}elseif($vo['type'] == 3){
					$prize = "有赞商品";
				}elseif($vo['type'] == 4){
					$prize = "微擎积分";
				}elseif($vo['type'] == 5){
					$prize = "自定义链接";
				}elseif($vo['type'] == 6){
					$prize = "有赞抽奖";
				}
				if($vo['status'] == 1){
					$prize .= "——领取成功";
				}elseif($vo['status'] == 2){
					$prize .= "——领取失败";
				}
				$str .= $vo['nickname'] . "\t" . $vo['miss_num'] . "\t" . $prize . "\t" . date('Y-m-d H:i',$vo['time']) . "\n";
			}
			$filename = '任务完成数据' . date('YmdHis') . '.xls';
			$this->export_csv( $filename, $str );
		}elseif($operation == "get_prize"){
			$sql = 'select * from ' . tablename('n1ce_mission_user') . 'where uniacid = :uniacid and rid = :rid and status = 1 order by miss_num DESC ';
			$prarm = array(':uniacid' => $_W['uniacid'],':rid' => $rid);
			$list = pdo_fetchall($sql, $prarm);
			$str = $this->encode("粉丝昵称")."\t".$this->encode("任务完成人数")."\t".$this->encode("奖品状态")."\t".$this->encode("时间")."\n";
			
			foreach ($list as $vo) {
				$prize = "";
				if($vo['type'] == 1){
					$prize = "现金红包";
				}elseif($vo['type'] == 2){
					$prize = "微信卡券";
				}elseif($vo['type'] == 3){
					$prize = "有赞商品";
				}elseif($vo['type'] == 4){
					$prize = "微擎积分";
				}elseif($vo['type'] == 5){
					$prize = "自定义链接";
				}elseif($vo['type'] == 6){
					$prize = "有赞抽奖";
				}
				if($vo['status'] == 1){
					$prize .= "——领取成功";
				}
				$str .= $vo['nickname'] . "\t" . $vo['miss_num'] . "\t" . $prize . "\t" . date('Y-m-d H:i',$vo['time']) . "\n";
			}
			$filename = '奖品领取成功数据' . date('YmdHis') . '.xls';
			$this->export_csv( $filename, $str );
		}
	}
	/**
	 * demo
	 */
	public function doWebDemoyouzan(){
		global $_W, $_GPC;
		include 'youzan_function.php';
		$youzan_access_token = $this->youzan_access_token();
		$openid = "owbm40ZTd0M1vRBj97spTXqvE_g";
		$tags = "测试活动";
		$res = he_youzan_addtags($youzan_access_token,$openid,$tags);
		if($res['response']){
			message('打标签成功','','success');
		}else{
			message($res['error_response']['msg']);
		}
	}
	/**
	 * @有赞授权模块
	 */
	public function doWebYouzanOuth()
	{
		global $_W, $_GPC;
		$youzan = $this->getYouzan();
		if (empty($youzan['client_id']) || empty($youzan['client_secret'])) {
			message('未正确设置有赞基础参数配置,请联系管理员！','','error');
		}
		$redirect_uri = $_W['siteroot'] . 'addons/n1ce_mission/n1ce.php?i=' . $_W['uniacid'];
		$url = "https://open.youzan.com/oauth/authorize?client_id=" . $youzan['client_id'] . "&response_type=code&state=youzan&redirect_uri=" . $redirect_uri;
		header("location:" . $url);
		die;
	}
	/**
	 * 模块接收
	 */
	public function doMobileShoptoken(){
		global $_W,$_GPC;
		$state = $_GPC['state'];
		$code = $_GPC['code'];
		if($state !== "youzan"){
			message('非法来源','','error'); 
		}
		if(empty($_GPC['code'])){
			message('授权失败，请重新授权！','','error');
		}
		$youzan_token = $this->youzan_token($code);
		// var_dump($youzan_token);die();
		$have_token = pdo_fetch("select * from " .tablename('n1ce_mission_token'). " where uniacid = :uniacid limit 1",array(':uniacid' => $_W['uniacid']));
		$data = array(
				'uniacid' => $_W['uniacid'],
				'access_token' => $youzan_token['access_token'],
				'refresh_token' => $youzan_token['refresh_token'],
				'scope' => $youzan_token['scope'],
				'token_type' => $youzan_token['token_type'],
				'expires_in' => $youzan_token['expires_in'],
				'createtime' => TIMESTAMP,
				'endtime' => TIMESTAMP + $youzan_token['expires_in'],
			);
		if($have_token['id']){
			pdo_update('n1ce_mission_token',$data,array('id'=>$have_token['id']));
		}else{
			pdo_insert('n1ce_mission_token',$data);
		}
		message('授权成功，点击确定返回！',$this->createMobileUrl('yzset'),'success');
	}
	public function doMobileYzset(){
		global $_W;
		$return_url = $_W['siteroot'] . "web/index.php?c=profile&a=module&do=setting&m=n1ce_mission";
		header("location:" . $return_url);
		die;
	}
	/**
	 *  根据code获取有赞授权的access_token
	 */
	public function youzan_token($code)
	{
		global $_W, $_GPC;
		load()->func('communication');
		$youzan = $this->getYouzan();
		$redirect_uri = $_W['siteroot'] . 'addons/n1ce_mission/n1ce.php?i=' . $_W['uniacid'];
		$gettokenurl = "https://open.youzan.com/oauth/token?client_id=" . $youzan['client_id'] . "&client_secret=" . $youzan['client_secret'] . "&grant_type=authorization_code&code=" . $code . "&redirect_uri=" . $redirect_uri;
		$result = ihttp_get($gettokenurl);
		$auth = @json_decode($result['content'], true);
		return $auth;
	}
	public function youzan_access_token()
	{
		global $_W, $_GPC;
		$youzan = pdo_fetch("select * from " .tablename('n1ce_mission_token'). " where uniacid = :uniacid",array(':uniacid' => $_W['uniacid']));
		if ($youzan['endtime'] <= TIMESTAMP) {
			$oauth = $this->refreshToken($youzan['refresh_token']);
			$data = array('access_token' => $oauth['access_token'], 'refresh_token' => $oauth['refresh_token'], 'expires_in' => $youzan['expires_in'], 'scope' => $youzan['scope'], 'token_type' => $youzan['token_type'], 'endtime' => TIMESTAMP + $youzan['expires_in'], 'createtime' => TIMESTAMP);
			pdo_update('n1ce_mission_token', $data, array('id' => $youzan['id']));
			return $oauth['access_token'];
		} else {
			return $youzan['access_token'];
		}
	}
	public function refreshToken($refresh_token)
	{
		global $_W, $_GPC;
		load()->func('communication');
		$youzan = $this->getYouzan();
		$refurl = "https://open.youzan.com/oauth/token?grant_type=refresh_token&refresh_token=" . $refresh_token . "&client_id=" . $youzan['client_id'] . "&client_secret=" . $youzan['client_secret'];
		$result = ihttp_get($refurl);
		$auth = @json_decode($result['content'], true);
		return $auth;
	}
	private function getYouzan(){
		global $_W;
		$result = pdo_fetch("select * from " .tablename('n1ce_youzan_shopouth'));
		return $result;
	}
	/**
 * 导出CSV
 *
 * @param $filename
 * @param $data
 */
	function export_csv($filename, $data) {
		header( "Content-type:text/csv" );
		header( "Content-Disposition:attachment;filename=" . $filename );
		header( 'Cache-Control:must-revalidate,post-check=0,pre-check=0' );
		header( 'Expires:0' );
		header( 'Pragma:public' );
		echo $data;
	}
	function  encode($value)
	{
		return $value;
		return iconv("utf-8", "gb2312", $value);

	}
	private function sendRedPacket($openid,$money){
		global $_W,$_GPC;
		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
		load()->func('communication');
		$pars = array();
		$cfg = $this->module['config'];
		$pars['nonce_str'] = random(32);
		$pars['mch_billno'] = $cfg['pay_mchid'] . date('YmdHis') . rand( 100, 999 );
		$pars['mch_id'] = $cfg['pay_mchid'];
		$pars['wxappid'] = $cfg['appid'];
		//$pars['nick_name'] = $cfg['nick_name'];
		if(!empty($cfg['scene_id'])){
			$pars['scene_id'] = $cfg['scene_id'];
		}
		$pars['send_name'] = $cfg['send_name'];
		$pars['re_openid'] = $openid;
		$pars['total_amount'] = $money;
		$pars['total_num'] = 1;
		$pars['wishing'] = $cfg['wishing'];
		$pars['client_ip'] = $_W['clientip'];
		$pars['act_name'] = $cfg['act_name'];
		$pars['remark'] = $cfg['remark'];
		ksort($pars, SORT_STRING);
		$string1 = '';
		foreach($pars as $k => $v) {
			$string1 .= "{$k}={$v}&";
		}
		$string1 .= "key={$cfg['pay_signkey']}";
		$pars['sign'] = strtoupper(md5($string1));
		$xml = array2xml($pars);
		$extras = array();
		if($cfg['rootca']){
			$extras['CURLOPT_CAINFO'] = IA_ROOT .'/attachment/n1ce_mission/cert_2/' . $_W['uniacid'] . '/' . $cfg['rootca'];
		}
		
		$extras['CURLOPT_SSLCERT'] = IA_ROOT .'/attachment/n1ce_mission/cert_2/' . $_W['uniacid'] . '/' . $cfg['apiclient_cert'];
		$extras['CURLOPT_SSLKEY'] = IA_ROOT .'/attachment/n1ce_mission/cert_2/' . $_W['uniacid'] . '/' . $cfg['apiclient_key'];
		$procResult = false;
		$resp = ihttp_request($url, $xml, $extras);
		if(is_error($resp)) {
			$setting = $this->module['config'];
			$setting['api']['error'] = $resp['message'];
			$this->saveSettings($setting);
			$procResult = $resp['message'];
		} else {
			$xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
			$dom = new DOMDocument();
			if($dom->loadXML($xml)) {
				$xpath = new DOMXPath($dom);
				$code = $xpath->evaluate('string(//xml/return_code)');
				$ret = $xpath->evaluate('string(//xml/result_code)');
				if(strtolower($code) == 'success' && strtolower($ret) == 'success') {
					$procResult = true;
					$setting = $this->module['config'];
					$setting['api']['error'] = '';
					$this->saveSettings($setting);
				} else {
					$error = $xpath->evaluate('string(//xml/err_code_des)');
					$setting = $this->module['config'];
					$setting['api']['error'] = $error;
					$this->saveSettings($setting);
					$procResult = $error;
				}
			} else {
				$procResult = 'error response';
			}
		}
		return $procResult;
	}
	
	private function sendWxCard($from_user, $cardid,$code = '') {
		load()->classs('weixin.account');
		load()->func('communication');
		$access_token = WeAccount::token();
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
	
		$now = time();
		$nonce_str = $this->createNonceStr(8);
		$data = array(
				'api_ticket'=>$this->getApiTicket($access_token),
				'nonce_str'=>$nonce_str,
				'timestamp'=>$now,
				'code'=>$code,
				'card_id'=>$cardid,
				'openid'=>$from_user,
		);
		ksort($data);
		$buff = "";
		foreach ($data as $v) {
			$buff .= $v;
		}
		$sign = sha1($buff);
		$card_ext = array('code'=>$code,'openid'=>$from_user,'signature'=>$sign);
		$post = '{"touser":"' . $from_user . '","msgtype":"wxcard","wxcard":{"card_id":"' . $cardid . '","card_ext":"'.json_encode($card_ext).'"}}';
		load()->func('communication');
		$res = ihttp_post($url, $post);
		$res = json_decode($res['content'],true);
		if ($res['errcode'] == 0) return true;
		return $res['errmsg'];
	}
	private function createNonceStr($length = 16) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for ($i = 0; $i < $length; $i++) {
			$str.= substr($chars, mt_rand(0, strlen($chars) - 1) , 1);
		}
		return $str;
	}
	public function getCard($card_id,$openid){
        global $_W,$_GPC;
	    //获取access_token
	    load()->classs('weixin.account');
		load()->func('communication');
		$access_token = WeAccount::token();
	    $ticket = $this->getApiTicket($access_token);
	 
	    //获得ticket后将参数拼成字符串进行sha1加密
		$now = time();
		$timestamp = $now;
		$nonceStr = $this->createNonceStr();
		$card_id = $card_id;
		$openid = $openid;
		$arr = array($card_id,$ticket,$nonceStr,$openid,$timestamp);//组装参数
        asort($arr, SORT_STRING);
		$sortString = "";
		 foreach($arr as $temp){
			$sortString = $sortString.$temp;
		 }
		$signature = sha1($sortString);
		 $cardArry = array(
			'code' =>"",
			'openid' => $openid,
			'timestamp' => $now,
			'signature' => $signature,
			'cardId' => $card_id,
			'ticket' => $ticket,
			'nonceStr' => $nonceStr,
		 );
		return $cardArry;
  
  }
	private function getApiTicket($access_token){
		global $_W, $_GPC;
		$w = $_W['uniacid'];
		$cookiename = "wx{$w}a{$w}pi{$w}ti{$w}ck{$w}et";
		$apiticket = $_COOKIE[$cookiename];
		if (empty($apiticket)){
			$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$access_token}&type=wx_card";
			load()->func('communication');
			$res = ihttp_get($url);
			$res = json_decode($res['content'],true);
			if (!empty($res['ticket'])){
				setcookie($cookiename,$res['ticket'],time()+$res['expires_in']);
				$apiticket = $res['ticket'];
			}else{
				message('获取api_ticket失败：'.$res['errmsg']);
			}
		}
		return $apiticket;
	}
	//by 黄河 官方客服通知
	private function we7Custom($info,$openid){
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
	/**
	by 黄河 
	QQ：541535641
	**/
	public function getOtherSettings($name){
		global $_W;
		$sql = 'SELECT `settings` FROM ' . tablename('uni_account_modules') . ' WHERE `uniacid` = :uniacid AND `module` = :module';
		$settings = pdo_fetchcolumn($sql, array(':uniacid' => $_W['uniacid'], ':module' => $name));
		$settings = iunserializer($settings);
		return $settings;
	}
	/**
	* 服务商红包
	* by：黄河  QQ：541535641
	**/
	private function sendSubRedPacket($openid,$money){
		global $_W,$_GPC;
		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
		load()->func('communication');
		$pars = array();
		$cfg = $this->getOtherSettings('n1ce_redcode_plugin_affiliate');
		$pars['nonce_str'] = random(32);
		$pars['mch_billno'] = $cfg['mch_id'] . date('YmdHis') . rand( 100, 999 );
		$pars['mch_id'] = $cfg['mch_id'];
		$pars['sub_mch_id'] = $cfg['sub_mch_id'];
		$pars['wxappid'] = $cfg['wxappid'];
		$pars['msgappid'] = $cfg['msgappid'];
		if(!empty($cfg['scene_id'])){
	      $pars['scene_id'] = $cfg['scene_id'];
	    }
		$pars['send_name'] = $cfg['send_name'];
		$pars['re_openid'] = $openid;
		$pars['total_amount'] = $money;
		$pars['total_num'] = 1;
		$pars['wishing'] = $cfg['wishing'];
		$pars['client_ip'] = $_W['clientip'];
		$pars['act_name'] = $cfg['act_name'];
		$pars['remark'] = $cfg['remark'];
		if($cfg['consume_mch_id'] == 2){
			$pars['consume_mch_id'] = $cfg['mch_id'];
		}
		ksort($pars, SORT_STRING);
		$string1 = '';
		foreach($pars as $k => $v) {
			$string1 .= "{$k}={$v}&";
		}
		$string1 .= "key={$cfg['pay_signkey']}";
		$pars['sign'] = strtoupper(md5($string1));
		$xml = array2xml($pars);
		$extras = array();
		if($cfg['rootca']){
			$extras['CURLOPT_CAINFO'] = IA_ROOT .'/attachment/n1ce_affiliate/cert_2/' . $_W['uniacid'] . '/' . $cfg['rootca'];
		}
		$extras['CURLOPT_SSLCERT'] = IA_ROOT .'/attachment/n1ce_affiliate/cert_2/' . $_W['uniacid'] . '/' . $cfg['apiclient_cert'];
		$extras['CURLOPT_SSLKEY'] = IA_ROOT .'/attachment/n1ce_affiliate/cert_2/' . $_W['uniacid'] . '/' . $cfg['apiclient_key'];
		$procResult = false;
		$resp = ihttp_request($url, $xml, $extras);
		if(is_error($resp)) {
			$setting = $this->module['config'];
			$setting['api']['error'] = $resp['message'];
			$this->saveSettings($setting);
			$procResult = $resp['message'];
		} else {
			$xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
			$dom = new DOMDocument();
			if($dom->loadXML($xml)) {
				$xpath = new DOMXPath($dom);
				$code = $xpath->evaluate('string(//xml/return_code)');
				$ret = $xpath->evaluate('string(//xml/result_code)');
				if(strtolower($code) == 'success' && strtolower($ret) == 'success') {
					$procResult = true;
					$setting = $this->module['config'];
					$setting['api']['error'] = '';
					$this->saveSettings($setting);
				} else {
					$error = $xpath->evaluate('string(//xml/err_code_des)');
					$setting = $this->module['config'];
					$setting['api']['error'] = $error;
					$this->saveSettings($setting);
					$procResult = $error;
				}
			} else {
				$procResult = 'error response';
			}
		}
		return $procResult;
	}
	//动态菜单导航 感觉有傻狗会来偷学
	public function getMenus() {
        $menus = array(
			array(
				'title' => '活动列表',
				'url'   => $this->createWebUrl('manage'),
				'icon'  => 'fa fa-tasks',
			),
			array(
				'title' => '实物库',
				'url'   => $this->createWebUrl('goods'),
				'icon'  => 'fa fa-gift',
			),
			array(
				'title' => '取关提醒',
				'url'   => $this->createWebUrl('unsubscribe'),
				'icon'  => 'fa fa-comments',
			),
			array(
				'title' => '快递导入',
				'url'   => $this->createWebUrl('express'),
				'icon'  => 'fa fa-file-text-o',
			),
			array(
				'title' => '黑名单列表',
				'url'   => $this->createWebUrl('blacklist'),
				'icon'  => 'fa fa-bug',
			),
		);
		return $menus;
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
}