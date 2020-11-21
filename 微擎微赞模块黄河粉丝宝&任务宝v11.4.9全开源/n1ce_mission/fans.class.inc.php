<?php

/*
* refresh fansinfo
*/
class Fans
{
	private static $t_member = 'n1ce_mission_member';

	// 获取用户基本信息，如果没有获取到昵称和头像，则通过微信API刷新
	public function refresh($from_user){
		global $_W;
		load()->model('mc');
		$userInfo = mc_fetch($from_user);
		WeUtility::logging('old member',$userInfo);
		if(empty($userInfo['nickname']) or empty($userInfo['avatar'])){
			$info = $this->getUserInfo($from_user);
			WeUtility::logging('empty fans',$info);
			mc_update($from_user,array('nickname' => $info['nickname'] , 'avatar' => $info['headimgurl'] , 'resideprovince' => $info['resideprovince'], 'residecity' => $info['residecity'], 'gender' => $info['gender']));
			$userInfo['avatar'] = $info['headimgurl'];
			$userInfo['nickname'] = $info['nickname'];
			WeUtility::logging('empty fans2',$userInfo);
		}
		$userInfo['openid'] = $from_user;
		return $userInfo;
	}
	public function getUniodid($from_user){
		$info = $this->getUserInfo($from_user);
		return $info['unionid'];
	}
	//获取用户真实openid
	public function getRealOpenid($openid,$oauth_openid,$rid,$brrow,$unionid){
		global $_W;
		if($brrow == 2){
			$member = pdo_get(self::$t_member,array('uniacid'=>$_W['uniacid'],'rid'=>$rid,'brrow_openid'=>$oauth_openid),array('from_user'));
			if(empty($member['from_user'])){
				$member = pdo_get(self::$t_member,array('uniacid'=>$_W['uniacid'],'rid'=>$rid,'unionid'=>$unionid),array('from_user'));
			}
			$realOpenid = $member['from_user'];
		}else{
			$realOpenid = $openid;
		}
		return $realOpenid;
	}
	// 通过微信api获取粉丝信息
	private function getUserInfo($from_user){
		global $_W;
		load()->classs( 'account' );
		load()->func( 'communication' );
		$accToken = WeAccount::token();
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$accToken}&openid={$from_user}&lang=zh_CN";
		$json = ihttp_get($url);
		$userinfo = @json_decode($json['content'],true);
		return $userinfo;
	}
}
