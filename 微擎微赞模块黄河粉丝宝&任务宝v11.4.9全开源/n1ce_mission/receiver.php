<?php
/**
 * 黄河·任务宝模块订阅器
 *
 * @author 
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

require IA_ROOT . '/addons/n1ce_mission/loader.php';
//你这傻逼，你爸爸的代码好看吗，日你妈，MMB
class N1ce_missionModuleReceiver extends WeModuleReceiver {
	public function receive() {
		global $_W;
		yload()->classs('n1ce_mission','wechatapi');
		$type = $this->message['type'];
		$from_user = $this->message['from'];
		$unInfo = $this->refreshUserInfo($from_user);
		//这里定义此模块进行消息订阅时的, 消息到达以后的具体处理过程, 请查看微擎文档来编写你的代码
		if($this->message['event'] == 'unsubscribe'){
			$unsub = pdo_fetch("select * from " .tablename('n1ce_mission_unsub'). " where uniacid = :uniacid",array(':uniacid'=>$_W['uniacid']));
			if($unsub['id']){
				
				$upLevel = $this->getUpLevel($_W['uniacid'],$from_user);
				if(empty($upLevel['id'])){
					//普通取消关注
				}else{
					$upInfo = $this->refreshUserInfo($upLevel['leader']);
					$this->disappear($_W['uniacid'],$upLevel['rid'],$upLevel['leader'],$upLevel['id']);
					$up_num = pdo_get('n1ce_mission_allnumber',array('uniacid'=>$_W['uniacid'],'rid'=>$upLevel['rid'],'from_user'=>$upLevel['leader']),array('allnumber'));
					$un_tips = str_replace('#下级昵称#', $unInfo['nickname'], $unsub['un_tips']);
					$un_tips = str_replace('#上级昵称#', $upInfo['nickname'], $un_tips);
					$un_tips = str_replace('#上级总人气#', $up_num['allnumber'], $un_tips);
					WechatAPI::sendText($upLevel['leader'],$un_tips);
					exit(0);
				}
			}
		}
	}
	public function getUpLevel($uniacid,$follower){
		$ret = pdo_fetch("SELECT * FROM " . tablename('n1ce_mission_follow') . " WHERE follower=:follower AND uniacid=:uniacid AND status = 1",
	      array(":follower"=>$follower, ":uniacid"=>$uniacid));
	    return $ret;
	}
	public function disappear($uniacid,$rid,$leader,$id){
		pdo_update('n1ce_mission_follow',array('status'=>2),array('id'=>$id));
		pdo_update('n1ce_mission_allnumber',array('allnumber -='=>1),array('uniacid'=>$uniacid,'rid'=>$rid,'from_user'=>$leader));
	}
	private function refreshUserInfo($from_user) {
	    global $_W;
	    yload()->classs('n1ce_mission', 'fans');
	    $_fans = new Fans();
	    $userInfo = $_fans->refresh($from_user);
	    WeUtility::logging('refresh', $userInfo);
	    return $userInfo;
	}
}