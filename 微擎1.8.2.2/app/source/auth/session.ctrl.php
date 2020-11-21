<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

load()->model('mc');

$dos = array('openid', 'userinfo', 'check');
$do = in_array($do, $dos) ? $do : 'openid';

$account_api = WeAccount::create();
if ($do == 'openid') {
	
	$code = $_GPC['code'];
	$openid = $_GPC['openid'];
	
	if (empty($openid) && !empty($_W['openid'])) {
		$openid = $_W['openid'];
	}
	
	if (empty($_W['account']['oauth']) || (empty($code) && empty($openid))) {
		exit('通信错误，请在微信中重新发起请求');
	}
	
	if (!empty($openid)) {
		$_SESSION['openid'] = $oauth['openid'];
		$fans = mc_fansinfo($openid);
		if (!empty($fans)) {
			$account_api->result(0, '', array('sessionid' => $_W['session_id'], 'userinfo' => $fans));
		} else {
			$account_api->result(1, 'openid不存在');
		}
	}
	$oauth = $account_api->getOauthInfo($code);
	if (!empty($oauth) && !is_error($oauth)) {
		$_SESSION['openid'] = $oauth['openid'];
		$_SESSION['session_key'] = $oauth['session_key'];
				$fans = mc_fansinfo($oauth['openid']);
		if (empty($fans)) {
			$record = array(
				'openid' => $oauth['openid'],
				'unionid' => $oauth['unionid'],
				'uid' => 0,
				'acid' => $_W['acid'],
				'uniacid' => $_W['uniacid'],
				'salt' => random(8),
				'updatetime' => TIMESTAMP,
				'nickname' => '',
				'follow' => '1',
				'followtime' => TIMESTAMP,
				'unfollowtime' => 0,
				'tag' => '',
			);
			$email = md5($oauth['openid']).'@we7.cc';
			$email_exists_member = pdo_getcolumn('mc_members', array('email' => $email), 'uid');
			if (!empty($email_exists_member)) {
				$uid = $email_exists_member;
			} else {
				$default_groupid = pdo_fetchcolumn('SELECT groupid FROM ' .tablename('mc_groups') . ' WHERE uniacid = :uniacid AND isdefault = 1', array(':uniacid' => $_W['uniacid']));
				$data = array(
					'uniacid' => $_W['uniacid'],
					'email' => $email,
					'salt' => random(8),
					'groupid' => $default_groupid,
					'createtime' => TIMESTAMP,
					'password' => md5($message['from'] . $data['salt'] . $_W['config']['setting']['authkey']),
					'nickname' => '',
					'avatar' => '',
					'gender' => '',
					'nationality' => '',
					'resideprovince' => '',
					'residecity' => '',
				);
				pdo_insert('mc_members', $data);
				$uid = pdo_insertid();
			}
			$record['uid'] = $uid;
			$_SESSION['uid'] = $uid;
			pdo_insert('mc_mapping_fans', $record);
		} else {
			$userinfo = $fans['tag'];
			$uid = $fans['uid'];
		}
		if (empty($userinfo)) {
			$userinfo = array(
				'openid' => $oauth['openid'],
			);
		}
		$_SESSION['userinfo'] = base64_encode(iserializer($userinfo));
		$account_api->result(0, '', array('sessionid' => $_W['session_id'], 'userinfo' => $fans, 'openid' => $oauth['openid']));
	} else {
		$account_api->result(1, $oauth['message']);
	}
} elseif ($do == 'userinfo') {
	$encrypt_data = $_GPC['encryptedData'];
	$iv = $_GPC['iv'];
	if (empty($_SESSION['session_key']) || empty($encrypt_data) || empty($iv)) {
		$account_api->result(1, '请先登录');
	}
	$sign = sha1($_POST['rawData'].$_SESSION['session_key']);
	if ($sign !== $_GPC['signature']) {
		$account_api->result(1, '签名错误');
	}

	$userinfo = $account_api->pkcs7Encode($encrypt_data, $iv);
	$userinfo['nickname'] = $userinfo['nickName'];
	$_SESSION['userinfo'] = base64_encode(iserializer($userinfo));

	$fans = mc_fansinfo($userinfo['openId']);
	$fans_update = array(
		'nickname' => $userinfo['nickName'],
		'unionid' => $userinfo['unionId'],
		'tag' => base64_encode(iserializer(array(
			'subscribe' => 1,
			'openid' => $userinfo['openId'],
			'nickname' => $userinfo['nickName'],
			'sex' => $userinfo['gender'],
			'language' => $userinfo['language'],
			'city' => $userinfo['city'],
			'province' => $userinfo['province'],
			'country' => $userinfo['country'],
			'headimgurl' => $userinfo['avatarUrl'],
		))),
	);
			if (!empty($userinfo['unionId'])) {
		$union_fans = pdo_get('mc_mapping_fans', array('unionid' => $userinfo['unionId'], 'openid !=' => $userinfo['openId']));
		if (!empty($union_fans['uid'])) {
			if (!empty($fans['uid'])) {
				
			}
			$fans_update['uid'] = $union_fans['uid'];
			$_SESSION['uid'] = $union_fans['uid'];
		}
	}
	pdo_update('mc_mapping_fans', $fans_update, array('fanid' => $fans['fanid']));
	pdo_update('mc_members', array('nickname' => $userinfo['nickName'], 'avatar' => $userinfo['avatarUrl'], 'gender' => $userinfo['gender']), array('uid' => $fans['uid']));
	$member = mc_fetch($fans['uid']);
	unset($member['password']);
	unset($member['salt']);
	$account_api->result(0, '', $member);
} elseif ($do == 'check') {
	if (!empty($_W['openid'])) {
		$account_api->result(0);
	} else {
		$account_api->result(1, 'session失效，请重新发起登录请求');
	}
}