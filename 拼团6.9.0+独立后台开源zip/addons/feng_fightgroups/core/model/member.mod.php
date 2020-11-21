<?php
	
/**
 * [weliam] Copyright (c) 2016/3/23 
 * 会员model
 */


function member_get_by_params($params = ''){
	if(!empty($params)){
		$params = ' where '. $params;
	}
	$sql = "SELECT * FROM " . tablename('tg_member') . $params;
	$member = pdo_fetch($sql);
	return $member;
}

function getMember($openid = '') {
	global $_W;
	load()->model('mc');
	if (empty($openid)) {
		return;
	} 
	$info = pdo_fetch('select * from ' . tablename('tg_member') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
	if($_W['tgsetting']['member']['credit_type'] == 1){
		$uid = mc_openidTouid($openid);
		$mc = mc_fetch($uid, array('credit1', 'credit2'));
		$info['credit1'] = $mc['credit1'];
		$info['credit2'] = $mc['credit2'];
	}
	return $info;
}
function getUnionidMember($unionid) {
	global $_W;
	if (empty($unionid)) return;
	$info = pdo_fetch('select * from ' . tablename('tg_member') . ' where unionid=:unionid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':unionid' => $unionid));
	return $info;
}
function checkAppMember($userinfo) {
	global $_W,$_GPC;
	$member = getUnionidMember($userinfo['unionid']);
	if (empty($member)) {
		$wqMember = array(
			'uniacid'=>$_W['uniacid'],
			'nickname' => $userinfo['nickname'],
			'avatar'=>$userinfo['headimgurl'],
		);
		pdo_insert('mc_members', $wqMember);
		$wqMemberId = pdo_insertid();
		
		$wqFans = array(
			'uid'=>$wqMemberId,
			'unionid' => $userinfo['unionid'],
			'uniacid'=>$_W['uniacid'],
			'nickname' => $userinfo['nickname'],
			'openid'=>$userinfo['openid'],
			'updatetime'=>time()
		);
		pdo_insert('mc_mapping_fans', $wqFans);
		$tgMember = array(
			'uid'=>$wqMemberId,
			'uniacid'=>$_W['uniacid'],
			'nickname' => $userinfo['nickname'],
			'avatar'=>$userinfo['headimgurl'],
			'unionid' => $userinfo['unionid'],
			'openid'=>$userinfo['openid'],
			'appopenid'=>$userinfo['openid']
		);
		pdo_insert('tg_member', $tgMember);
		
	} else {
		$upgrade = array();
		if ($userinfo['nickname'] != $member['nickname']) $upgrade['nickname'] = $userinfo['nickname'];
		if ($userinfo['headimgurl'] != $member['avatar']) $upgrade['avatar'] = $userinfo['headimgurl'];
		if ($userinfo['openid'] != $member['appopenid']) $upgrade['appopenid'] = $userinfo['openid'];
		if (!empty($upgrade)) pdo_update('tg_member', $upgrade, array('id' => $member['id']));
	} 
} 
function checkMember($openid = '') {
	global $_W;
	load()->func('communication');
	if (empty($openid)) {
		$openid = getOpenid();
	} 
	if (empty($openid)) {
		return;
	} 
	$member = getMember($openid);
	$userinfo = getInfo();
	$userinfoUnionid=getUnionidMember($userinfo['unionid']);
	$fans = pdo_fetch("select uid from".tablename('mc_mapping_fans')."where uniacid={$_W['uniacid']} and openid='{$openid}'");
	$uid = $fans['uid'];
	if (empty($member)) {
		$member = array(
			'uid'=>$uid,
			'uniacid' => $_W['uniacid'], 
			'openid' => $openid, 
			'nickname' => $userinfo['nickname'], 
			'avatar' => $userinfo['avatar'],
			'unionid' => $userinfo['unionid'],
		);
		
		//同步会员信息到芸众商城
		$yunapi = IA_ROOT . '/addons/yun_shop/api.php';
		if (is_file($yunapi)) {
			$i = $_W['uniacid'];
	        $url = $_W['siteroot'] . 'addons/yun_shop/api.php?i='.$i.'&type=1&route=member.member.memberFromHXQModule';
	
	        if ($_GPC['mid']) {
	            if ($_GPC['mid'] == $uid) {
	                $mid = 0;
	            } else {
	                $mid = (int)$_GPC['mid'];
	            }
	        } else {
	            $mid = 0;
	        }
			ihttp_request($url, array('uid' => $uid,'mid' => $mid), array('Content-Type' => 'application/x-www-form-urlencoded'), 1);
		}
		
		pdo_insert('tg_member', $member);
		
		if(!empty($userinfoUnionid)){ //微信端首次进入，此时app端已有数据
			if(WL_USER_AGENT == 'yunapp') appDataToWeixinData($userinfo['unionid'],$openid); // 更新app数据到微信端数据
		}
	} else {
		if (!empty($member['id'])) {
			$fans = pdo_fetch("select uid from".tablename('mc_mapping_fans')."where uniacid={$_W['uniacid']} and openid='{$openid}'");
			$uid = $fans['uid'];
			
			//微信端进入且有微信端openid的数据
			
			$address = pdo_fetch("SELECT * FROM " . tablename('tg_address') . " where openid=:openid and uniacid=:uniacid and status=1", array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
			$mem_addr = $address['peovince'].",".$address['city'].",".$address['country'].",".$address['detailed_address'];
			
			$upgrade = array();
			$userinfo['avatar'] = !empty($userinfo['avatar']) ?$userinfo['avatar']:$userinfo['headimgurl'];
			if ($userinfo['nickname'] != $member['nickname']) {
				$upgrade['nickname'] = $userinfo['nickname'];
			} 
			if ($userinfo['avatar'] != $member['avatar']) {
				$upgrade['avatar'] = $userinfo['avatar'];
			}
			if ($member['uid'] != $uid) {
				$upgrade['uid'] = $uid;
			}
			if ($member['unionid'] != $userinfo['unionid']) {
				$upgrade['unionid'] = $userinfo['unionid'];
			}
			if (!empty($upgrade)) {
				pdo_update('tg_member', $upgrade, array('id' => $member['id']));
			} 
		} 
		
	} 
} 

function getOpenid($openid='') {
	if($openid) return $openid;
	$userinfo = getInfo();
	return $userinfo['openid'];
} 

function getInfo() {
	global $_W, $_GPC;
	$userinfo = array();
	$debug = TRUE;
	load() -> model('mc');
	$userinfo = mc_oauth_userinfo();
	if($debug == FALSE){
		if (empty($userinfo['openid'])) {
			die("<!DOCTYPE html>
            <html>
                <head>
                    <meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'>
                    <title>抱歉，出错了</title><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'><link rel='stylesheet' type='text/css' href='https://res.wx.qq.com/connect/zh_CN/htmledition/style/wap_err1a9853.css'>
                </head>
                <body>
                <div class='page_msg'><div class='inner'><span class='msg_icon_wrp'><i class='icon80_smile'></i></span><div class='msg_content'><h4>请在微信客户端打开链接</h4></div></div></div>
                </body>
            </html>");
		}
	}
	return $userinfo;
} 
/** 
* 将app用户数据转换为微信端用户数据 
* 
* @access public
* @name appDataToWeixinData 
* @param $openid  openid 
* @return array 
*/  
function appDataToWeixinData($unionid,$openid){}
