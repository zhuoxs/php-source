<?php
defined('IN_IA') or exit('Access Denied');

function checkMember($openid = '') {
	global $_W,$_GPC;
	if (empty($openid)) {
		$openid = $_W['openid'];
	} 
	if (empty($openid)) {
		if (!DEVELOPMENT && ($_GPC['do'] == 'home' || $_GPC['do'] == 'member' || $_GPC['do'] == 'user')) {
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
		return;
	} 
	load()->model('mc');
	$member = wl_mem_single(array('openid'=>$openid));
	$userinfo = mc_oauth_userinfo();
	$uid = 0;
	if($_W['fans']['follow'] == 1){
		$uid = mc_openid2uid($openid);
	}
	if (empty($member)) {
		$member = array(
			'uid'=>$uid,
			'uniacid' => $_W['uniacid'], 
			'openid' => $userinfo['openid'], 
			'nickname' => $userinfo['nickname'], 
			'avatar' => $userinfo['avatar'], 
			'gender' => $userinfo['sex'], 
			'unionid' => $userinfo['unionid'], 
			'province' => $userinfo['province'], 
			'city' => $userinfo['city'],
			'status' => 1,
			'mstatus' => 1,
			'userstatus' => 1,
			'createtime' => time()
		);
		pdo_insert('weliam_shiftcar_member', $member);
	} else {
		if (!empty($member['id'])) {
			$upgrade = array();
			if ($userinfo['nickname'] != $member['nickname']) {
				$upgrade['nickname'] = $userinfo['nickname'];
			} 
			if ($userinfo['avatar'] != $member['avatar']) {
				$upgrade['avatar'] = $userinfo['avatar'];
			}
			if ($userinfo['sex'] != $member['gender']) {
				$upgrade['gender'] = $userinfo['sex'];
			}
			if ($userinfo['unionid'] != $member['unionid']) {
				$upgrade['unionid'] = $userinfo['unionid'];
			}
			if ($userinfo['province'] != $member['province']) {
				$upgrade['province'] = $userinfo['province'];
			}
			if ($userinfo['city'] != $member['city']) {
				$upgrade['city'] = $userinfo['city'];
			}
			if (empty($member['uid'])) {
				$upgrade['uid'] = $uid;
			}
			if (!empty($upgrade)) {
				pdo_update('weliam_shiftcar_member', $upgrade, array('id' => $member['id']));
			} 
		} 
	} 
	unset($member,$userinfo,$upgrade,$uid);
	$member = wl_mem_single(array('openid'=>$openid));
	if($member['userstatus'] == -1){
		wl_message('您已被禁止访问，请联系管理员进行处理！','close');
	}
	return $member;
}

function wl_mem_register($user) {
	global $_W;
	if (empty($user) || !is_array($user)) {
		return 0;
	}
	if (isset($user['id'])) {
		unset($user['id']);
	}
	$user['salt'] = random(8);
	$user['uniacid'] = $_W['uniacid'];
	$user['password'] = wl_mem_hash($user['password'], $user['salt']);
	$user['createtime'] = time();
	$result = pdo_insert('weliam_shiftcar_member', $user);
	if (!empty($result)) {
		$user['id'] = pdo_insertid();
	}
	return intval($user['id']);
}


function wl_mem_check($user) {
	if (empty($user) || !is_array($user)) {
		return false;
	}
	$where = ' WHERE 1 ';
	$params = array();
	if (!empty($user['uid'])) {
		$where .= ' AND `uid`=:uid';
		$params[':uid'] = intval($user['uid']);
	}
	if (!empty($user['username'])) {
		$where .= ' AND `username`=:username';
		$params[':username'] = $user['username'];
	}
	if (!empty($user['status'])) {
		$where .= " AND `status`=:status";
		$params[':status'] = intval($user['status']);
	}
	if (empty($params)) {
		return false;
	}
	$sql = 'SELECT `password`,`salt` FROM ' . tablename('weliam_shiftcar_member') . "$where LIMIT 1";
	$record = pdo_fetch($sql, $params);
	if (empty($record) || empty($record['password']) || empty($record['salt'])) {
		return false;
	}
	if (!empty($user['password'])) {
		$password = user_hash($user['password'], $record['salt']);
		return $password == $record['password'];
	}
	return true;
}


function wl_mem_single($user_or_uid) {
	global $_W;
	$user = $user_or_uid;
	if (empty($user)) {
		return false;
	}
	if (is_numeric($user)) {
		$user = array('id' => $user);
	}
	if (!is_array($user)) {
		return false;
	}
	$where = " WHERE 1 ";
	$params = array();
	if (!empty($user['id'])) {
		$where .= ' AND `id`=:id';
		$params[':id'] = intval($user['id']);
	}
	if (!empty($user['uid'])) {
		$where .= ' AND `uid`=:uid';
		$params[':uid'] = intval($user['uid']);
	}
	if (!empty($user['openid'])) {
		$where .= ' AND `openid`=:openid';
		$params[':openid'] = $user['openid'];
	}
	if (!empty($user['mobile'])) {
		$where .= ' AND `mobile`=:mobile';
		$params[':mobile'] = $user['mobile'];
	}
	if (!empty($user['uniacid'])) {
		$where .= " AND `uniacid`=:uniacid";
		$params[':uniacid'] = $user['uniacid'];
	}
	if (!empty($user['ncnumber'])) {
		$where .= " AND `ncnumber`=:ncnumber";
		$params[':ncnumber'] = $user['ncnumber'];
	}
	if (empty($params)) {
		return false;
	}
	$sql = 'SELECT * FROM ' . tablename('weliam_shiftcar_member') . " $where LIMIT 1";
	$record = pdo_fetch($sql, $params);
	if (empty($record)) {
		return false;
	}
	if (!empty($user['password'])) {
		$password = wl_mem_hash($user['password'], $record['salt']);
		if ($password != $record['password']) {
			return false;
		}
	}
	if($_W['fans']['follow'] == 1 && $_W['tgsetting']['member']['credit_type'] == 1){
		$uid = mc_openid2uid($openid);
		$mc = mc_fetch($uid, array('credit1', 'credit2'));
		$info['credit1'] = $mc['credit1'];
		$info['credit2'] = $mc['credit2'];
	}
	return $record;
}


function wl_mem_update($user) {
	if (empty($user['uid']) || !is_array($user)) {
		return false;
	}
	$record = array();
	if (!empty($user['username'])) {
		$record['username'] = $user['username'];
	}
	if (!empty($user['password'])) {
		$record['password'] = wl_mem_hash($user['password'], $user['salt']);
	}
	if (!empty($user['lastvisit'])) {
		$record['lastvisit'] = (strlen($user['lastvisit']) == 10) ? $user['lastvisit'] : strtotime($user['lastvisit']);
	}
	if (!empty($user['lastip'])) {
		$record['lastip'] = $user['lastip'];
	}
	if (isset($user['joinip'])) {
		$record['joinip'] = $user['joinip'];
	}
	if (isset($user['remark'])) {
		$record['remark'] = $user['remark'];
	}
	if (isset($user['type'])) {
		$record['type'] = $user['type'];
	}
	if (isset($user['status'])) {
		$status = intval($user['status']);
		if (!in_array($status, array(1, 2))) {
			$status = 2;
		}
		$record['status'] = $status;
	}
	if (isset($user['groupid'])) {
		$record['groupid'] = $user['groupid'];
	}
	if (isset($user['starttime'])) {
		$record['starttime'] = $user['starttime'];
	}
	if (isset($user['endtime'])) {
		$record['endtime'] = $user['endtime'];
	}
	if (empty($record)) {
		return false;
	}
	return pdo_update('weliam_shiftcar_member', $record, array('uid' => intval($user['uid'])));
}


function wl_mem_hash($passwordinput, $salt) {
	global $_W;
	$passwordinput = "{$passwordinput}-{$salt}-{$_W['config']['setting']['authkey']}";
	return sha1($passwordinput);
}

function wl_merge_member($data = array()){
	global $_W;
	$member = array(
		'uid'        => $_W['wlmember']['uid'],
		'uniacid'    => $_W['uniacid'], 
		'openid'     => $_W['openid'], 
		'nickname'   => $_W['wlmember']['nickname'], 
		'avatar'     => $_W['wlmember']['avatar'], 
		'gender'     => $_W['wlmember']['sex'], 
		'unionid'    => $_W['wlmember']['unionid'], 
		'mobile'     => $data['mobile'], 
		'createtime' => time()
	);
	pdo_insert('wlmerchant_member', $member);
}
