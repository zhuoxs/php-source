<?php
/*
* 活动借权and地区限制
*/
 class Area
 {
 	static $t_member = 'n1ce_mission_member';

 	private function getUserStatus($from_user,$rid){
 		global $_W;
 		$status = pdo_fetch("select * from ".tablename(self::$t_member)." where uniacid = :uniacid and rid = :rid and from_user = :from_user",array(':uniacid'=>$_W['uniacid'],':from_user'=>$from_user,':rid'=>$rid));
 		return $status;
 	}
 	private function getUserStatus2($unionid,$rid){
 		global $_W;
 		$status = pdo_fetch("select * from ".tablename(self::$t_member)." where uniacid = :uniacid and rid = :rid and unionid = :unionid",array(':uniacid'=>$_W['uniacid'],':unionid'=>$unionid,':rid'=>$rid));
 		return $status;
 	}
 	//借权情况下
 	public function borrow($settings,$reply,$from_user,$unionid,$rule){
 		if($reply['isred'] == 1){
 			$status = $this->getUserStatus($from_user,$reply['rid']);
 		}else{
 			$status2 = $this->getUserStatus2($unionid,$reply['rid']);
 		}
 		yload()->classs('n1ce_mission','wechatutil');
 		if(empty($status2['unionid']) && $reply['isred'] == 2){
 			$data = array(
 				'uniacid' => $reply['uniacid'],
 				'rid' => $reply['rid'],
 				'from_user' => $from_user,
 				'status' => 2,
 				'unionid' => $unionid,
 				'createtime' => TIMESTAMP,
 			);
 			pdo_insert(self::$t_member,$data);
 		}
 		if(empty($status['brrow_openid']) && $reply['isred'] == 1){
 			//先获取借权信息
			$limit_info = str_replace('#获取信息#', WechatUtil::createMobileUrl('bropenid', 'n1ce_mission',array('rid' => $reply['rid'],'from_user' => $from_user,'rule'=>$rule)), $reply['get_fans']);
			if(!empty($reply['area'])){
				$limit_info = str_replace('#获取信息#', WechatUtil::createMobileUrl('bropenid', 'n1ce_mission',array('rid' => $reply['rid'],'from_user' => $from_user,'open'=>'yes','rule'=>$rule)), $reply['get_fans']);
			}
			$this->sendText($from_user,$limit_info);exit();
 		}
 		if(!empty($reply['area']) && $status['status'] == 2 ){
			$limit_info = str_replace('#验证地址#', WechatUtil::createMobileUrl('bropenid', 'n1ce_mission',array('rid' => $reply['rid'],'from_user' => $from_user,'open'=>'yes','rule'=>$rule)), $reply['limit_join']);
			$this->sendText($from_user,$limit_info);
			exit();
 		}
 		if(!empty($reply['area']) && $status2['status'] == 2 ){
			$limit_info = str_replace('#验证地址#', WechatUtil::createMobileUrl('bropenid', 'n1ce_mission',array('rid' => $reply['rid'],'from_user' => $from_user,'open'=>'yes','rule'=>$rule)), $reply['limit_join']);
			$this->sendText($from_user,$limit_info);
			exit();
 		}
 		if(!empty($reply['area']) && empty($status2['unionid']) && $reply['isred'] == 2){
			$limit_info = str_replace('#验证地址#', WechatUtil::createMobileUrl('bropenid', 'n1ce_mission',array('rid' => $reply['rid'],'from_user' => $from_user,'open'=>'yes','rule'=>$rule)), $reply['limit_join']);
			$this->sendText($from_user,$limit_info);
			exit();
 		}
 	}
 	public function borrow2($settings,$reply,$from_user,$rule){
 		$status = $this->getUserStatus($from_user,$reply['rid']);
 		yload()->classs('n1ce_mission','wechatutil');
 		if(empty($status['brrow_openid'])){
 			//先获取借权信息
			$limit_info = str_replace('#获取信息#', WechatUtil::createMobileUrl('bropenid', 'n1ce_mission',array('rid' => $reply['rid'],'from_user' => $from_user,'rule'=>$rule)), $reply['get_fans']);
			if(!empty($reply['area'])){
				$limit_info = str_replace('#获取信息#', WechatUtil::createMobileUrl('bropenid', 'n1ce_mission',array('rid' => $reply['rid'],'from_user' => $from_user,'open'=>'yes','rule'=>$rule)), $reply['get_fans']);
			}
			$this->sendText($from_user,$limit_info);exit();
 		}
 		if(!empty($reply['area']) && $status['status'] == 2){
 			
			$limit_info = str_replace('#验证地址#', WechatUtil::createMobileUrl('bropenid', 'n1ce_mission',array('rid' => $reply['rid'],'from_user' => $from_user,'open'=>'yes','rule'=>$rule)), $reply['limit_join']);
			$this->sendText($from_user,$limit_info);exit();
 		}
 	}
 	//不借权
 	public function onlyArea($settings,$reply,$from_user,$rule){
 		$status = $this->getUserStatus($from_user,$reply['rid']);
 		yload()->classs('n1ce_mission','wechatutil');
 		if(empty($status['status']) || $status['status'] == 2){
			$limit_info = str_replace('#验证地址#', WechatUtil::createMobileUrl('bropenid', 'n1ce_mission',array('rid' => $reply['rid'],'from_user' => $from_user,'open'=>'yes','rule'=>$rule)), $reply['limit_join']);
			$this->sendText($from_user,$limit_info);
			exit();
 		}
 	}
 	
 	private function sendNews($news,$from_user){
 		global $_W;
 		$account_api = WeAccount::create();
 		$message = array(
			'touser' => $from_user,
			'msgtype' => 'news',
			'news' => array('articles' => $news),
		);
		$status = $account_api->sendCustomNotice($message);
		return $status;
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