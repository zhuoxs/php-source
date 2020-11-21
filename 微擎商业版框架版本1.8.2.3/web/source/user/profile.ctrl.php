<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
load()->model('user');
load()->func('file');
load()->classs('oauth2/oauth2client');
load()->model('message');
load()->model('setting');

$dos = array('base', 'post', 'bind', 'validate_mobile', 'bind_mobile', 'unbind');
$do = in_array($do, $dos) ? $do : 'base';
$_W['page']['title'] = '账号信息 - 我的账户 - 用户管理';

if ($do == 'post' && $_W['isajax'] && $_W['ispost']) {
	$type = trim($_GPC['type']);

	if ($_W['isfounder']) {
		$uid = is_array($_GPC['uid']) ? 0 : intval($_GPC['uid']);
	} else {
		$uid = $_W['uid'];
	}
	if (empty($uid) || empty($type)) {
		iajax(40035, '参数错误，请刷新后重试！', '');
	}
	$user = user_single($uid);
	if (empty($user)) {
		iajax(-1, '用户不存在或已经被删除！', '');
	}

	if ($user['status'] == USER_STATUS_CHECK || $user['status'] == USER_STATUS_BAN) {
		iajax(-1, '访问错误，该用户未审核或者已被禁用，请先修改用户状态！', '');
	}

	$users_profile_exist = pdo_get('users_profile', array('uid' => $uid));

	if ($type == 'birth') {
		if ($users_profile_exist['year'] == $_GPC['year'] && $users_profile_exist['month'] == $_GPC['month'] && $users_profile_exist['day'] == $_GPC['day']) iajax(0, '未作修改！', '');
	} elseif ($type == 'reside') {
		if ($users_profile_exist['province'] == $_GPC['province'] && $users_profile_exist['city'] == $_GPC['city'] && $users_profile_exist['district'] == $_GPC['district']) iajax(0, '未作修改！', '');
	} else {
		if (in_array($type, array('username', 'password'))) {
			if ($user[$type] == $_GPC[$type] && $type != 'password') iajax(0, '未做修改！', '');
		} else {
			if ($users_profile_exist[$type] == $_GPC[$type]) iajax(0, '未作修改！', '');
		}
	}
	switch ($type) {
		case 'avatar':
		case 'realname':
		case 'address':
		case 'qq':
		case 'mobile':
			if ($type == 'mobile') {
				$match = preg_match(REGULAR_MOBILE, trim($_GPC[$type]));
				if (empty($match)) {
					iajax(-1, '手机号不正确', '');
				}
				$users_mobile = pdo_get('users_profile', array('mobile' => trim($_GPC[$type]), 'uid <>' => $uid));
				$bind_mobile = pdo_get('users_bind', array('bind_sign' => trim($_GPC[$type]), 'uid<>' => $uid));
				if (!empty($users_mobile) || !empty($bind_mobile)) {
					iajax(-1, '手机号已存在，请联系管理员', '');
				}
			}
			if ($users_profile_exist) {
				$result = pdo_update('users_profile', array($type => trim($_GPC[$type])), array('uid' => $uid));
			} else {
				$data = array(
					'uid' => $uid,
					'createtime' => TIMESTAMP,
					$type => trim($_GPC[$type])
				);
				$result = pdo_insert('users_profile', $data);
			}
			$data = array(
				'uid' => $uid,
				'bind_sign' => trim($_GPC[$type]),
				'third_nickname' => trim($_GPC[$type]),
				'third_type' => USER_REGISTER_TYPE_MOBILE,
			);
			$users_bind_exist = pdo_get('users_bind', array('uid' => $uid, 'third_type' => USER_REGISTER_TYPE_MOBILE));
			if ($users_bind_exist) {
				$result_bind = pdo_update('users_bind', $data);
			} else {
				$result_bind = pdo_insert('users_bind', $data);
			}
			if (!$result_bind) {
				iajax(-1, '绑定手机号失败，请联系管理员解决！', '');
			}
			break;
		case 'username':
			$founders = explode(',', $_W['config']['setting']['founder']);
			if (!in_array($_W['uid'], $founders) && $_W['uid'] != $user['owner_uid']) {
				iajax(1, '无权限修改，请联系网站创始人！');
			}
			$username = trim($_GPC['username']);
			$name_exist = pdo_get('users', array('username' => $username));
			if (!empty($name_exist)) {
				iajax(2, '用户名已存在，请更换其他用户名！', '');
			}
			$result = pdo_update('users', array('username' => $username), array('uid' => $uid));
			break;
		case 'vice_founder_name':
			$userinfo = user_single(array('username' => $_GPC['vice_founder_name']));
			if (empty($userinfo) || $userinfo['founder_groupid'] != ACCOUNT_MANAGE_GROUP_VICE_FOUNDER) {
				iajax(1, '用户不存在或该用户不是副创始人', '');
			}
			$result = pdo_update('users', array('owner_uid' => $userinfo['uid']), array('uid' => $uid));
			break;
		case 'remark':
			$result = pdo_update('users', array('remark' => trim($_GPC['remark'])), array('uid' => $uid));
			break;
		case 'welcome_link':

			$welcome_link = intval($_GPC['welcome_link']);
			$result = pdo_update('users', array('welcome_link' => $welcome_link), array('uid' => $uid));
			break;
		case 'password':
			if ($_GPC['newpwd'] !== $_GPC['renewpwd']) iajax(2, '两次密码不一致！', '');

			$check_safe = safe_check_password($_GPC['newpwd']);
			if (is_error($check_safe)) {
				iajax(4, $check_safe['message']);
			}

			if (!$_W['isfounder'] && empty($user['register_type'])) {
				$pwd = user_hash($_GPC['oldpwd'], $user['salt']);
				if ($pwd != $user['password']) iajax(3, '原密码不正确！', '');
			}
			$newpwd = user_hash($_GPC['newpwd'], $user['salt']);
			if ($newpwd == $user['password']) {
				iajax(0, '未作修改！', '');
			}
			$result = pdo_update('users', array('password' => $newpwd), array('uid' => $uid));
			break;
		case 'endtime' :
			if ($_GPC['endtype'] == 1) {
				$endtime = 0;
			} else {
				$endtime = strtotime($_GPC['endtime']);
			}
			
				if (user_is_vice_founder() && !empty($_W['user']['endtime']) && ($endtime > $_W['user']['endtime'] || empty($endtime))) {
					iajax(-1, '副创始人给用户设置的时间不能超过自己的到期时间');
				}
			
			$result = pdo_update('users', array('endtime' => $endtime), array('uid' => $uid));
			pdo_update('users_profile', array('send_expire_status' => 0), array('uid' => $uid));
			$uni_account_user = pdo_getall('uni_account_users', array('uid' => $uid, 'role' => 'owner'));
			if (!empty($uni_account_user)) {
				foreach ($uni_account_user as $account) {
					cache_delete(cache_system_key('uniaccount', array('uniacid' => $account['uniacid'])));
				}
			}
			break;
		case 'birth':
			if ($users_profile_exist) {
				$result = pdo_update('users_profile', array('birthyear' => intval($_GPC['year']), 'birthmonth' => intval($_GPC['month']), 'birthday' => intval($_GPC['day'])), array('uid' => $uid));
			} else {
				$data = array(
					'uid' => $uid,
					'createtime' => TIMESTAMP,
					'birthyear' => intval($_GPC['year']),
					'birthmonth' => intval($_GPC['month']),
					'birthday' => intval($_GPC['day'])
				);
				$result = pdo_insert('users_profile', $data);
			}
			break;
		case 'reside':
			if ($users_profile_exist) {
				$result = pdo_update('users_profile', array('resideprovince' => $_GPC['province'], 'residecity' => $_GPC['city'], 'residedist' => $_GPC['district']), array('uid' => $uid));
			} else {
				$data = array(
					'uid' => $uid,
					'createtime' => TIMESTAMP,
					'resideprovince' => $_GPC['province'],
					'residecity' => $_GPC['city'],
					'residedist' => $_GPC['district']
				);
				$result = pdo_insert('users_profile', $data);
			}
			break;
	}
	if ($result) {
		pdo_update('users_profile', array('edittime' => TIMESTAMP), array('uid' => $uid));
		iajax(0, '修改成功！', '');
	} else {
		iajax(1, '修改失败，请稍候重试！', '');
	}
}

if ($do == 'base') {
	$account_num = permission_user_account_num($_W['uid']);
	$message_id = intval($_GPC['message_id']);
	message_notice_read($message_id);

	$user_type = !empty($_GPC['user_type']) ? trim($_GPC['user_type']) : PERSONAL_BASE_TYPE;
		$user = user_single($_W['uid']);
	if (empty($user)) {
		itoast('抱歉，用户不存在或是已经被删除！', url('user/profile'), 'error');
	}
	$user['last_visit'] = date('Y-m-d H:i:s', $user['lastvisit']);
	$user['joindate'] = date('Y-m-d H:i:s', $user['joindate']);
	$user['url'] = user_invite_register_url($_W['uid']);

	$profile = pdo_get('users_profile', array('uid' => $_W['uid']));

	$profile = user_detail_formate($profile);

	
		if (!$_W['isfounder'] || user_is_vice_founder()) {
						if ($_W['user']['founder_groupid'] == ACCOUNT_MANAGE_GROUP_VICE_FOUNDER) {
				$groups = user_founder_group();
				$group_info = user_founder_group_detail_info($user['groupid']);
			} else {
				$groups = user_group();
				$group_info = user_group_detail_info($user['groupid']);
			}

						$account_detail = user_account_detail_info($_W['uid']);
		}
	
	
	$table = table('core_profile_fields');
	$extra_fields = $table->getExtraFields();
	template('user/profile');
}

if ($do == 'bind') {
	$setting_sms_sign = setting_load('site_sms_sign');
	$bind_sign = !empty($setting_sms_sign['site_sms_sign']['register']) ? $setting_sms_sign['site_sms_sign']['register'] : '';

	$user_table = table('users');
	$user = $user_table->usersInfo($_W['uid']);
	$user_profile = $user_table->userProfile($_W['uid']);

	$user_table->bindSearchWithUser($_W['uid']);
	$bind_info = $user_table->userBind();

	$signs = array_keys($bind_info);

	if (!empty($user['openid']) && !in_array($user['openid'], $signs)) {
		pdo_insert('users_bind', array('uid' => $user['uid'], 'bind_sign' => $user['openid'], 'third_type' => $user['register_type'], 'third_nickname' => $user_profile['nickname']));
	}

	if (!empty($user_profile['mobile']) && !in_array($user_profile['mobile'], $signs)) {
		pdo_insert('users_bind', array('uid' => $user_profile['uid'], 'bind_sign' => $user_profile['mobile'], 'third_type' => USER_REGISTER_TYPE_MOBILE, 'third_nickname' => $user_profile['mobile']));
	}

	$user_table->bindSearchWithUser($_W['uid']);
	$lists = $user_table->userBind();

	$bind_qq = array();
	$bind_wechat = array();
	$bind_mobile = array();

	if (!empty($lists)) {
		foreach($lists as $list) {
			switch($list['third_type']){
				case USER_REGISTER_TYPE_QQ:
					$bind_qq = $list;
					break;
				case USER_REGISTER_TYPE_WECHAT:
					$bind_wechat = $list;
					break;
				case USER_REGISTER_TYPE_MOBILE:
					$bind_mobile = $list;
					break;
			}
		}
	}

	$support_login_urls = user_support_urls();

	template('user/bind');
}

if (in_array($do, array('validate_mobile', 'bind_mobile')) || $_GPC['bind_type'] == USER_REGISTER_TYPE_MOBILE && $do == 'unbind') {
	$user_table = table('users');
	$user_profile = $user_table->userProfile($_W['uid']);

	$mobile = trim($_GPC['mobile']);
	$type = trim($_GPC['type']);
	$user_table = table('users');

	$mobile_exists = $user_table->userProfileMobile($mobile);
	if (empty($mobile)) {
		iajax(-1, '手机号不能为空');
	}
	if (!preg_match(REGULAR_MOBILE, $mobile)) {
		iajax(-1, '手机号格式不正确');
	}

	if (!empty($type) && $mobile != $user_profile['mobile']) {
		iajax(-1, '请输入已绑定的手机号');
	}

	if (empty($type) && !empty($mobile_exists)) {
		iajax(-1, '手机号已存在');
	}
}
if ($do == 'validate_mobile') {
	$user = array('username' => trim($_GPC['mobile']));
	$mobile_exists = user_check($user);
	if ($mobile_exists) {
		iajax(-1, '手机号已经存在');
	}
	iajax(0, '本地校验成功');
}

if ($do == 'bind_mobile') {
	if ($_W['isajax'] && $_W['ispost']) {
		$bind_info = OAuth2Client::create('mobile')->bind();

		$user = array('username' => trim($_GPC['mobile']));
		$mobile_exists = user_check($user);
		if ($mobile_exists) {
			iajax(-1, '手机号已经存在');
		}

		if (is_error($bind_info)) {
			iajax(-1, $bind_info['message']);
		}
		iajax(0, '绑定成功', url('user/profile/bind'));
	} else {
		iajax(-1, '非法请求');
	}
}

if ($do == 'unbind') {
	$types = array(1 => 'qq', 2 => 'wechat', 3 => 'mobile');
	if (!in_array($_GPC['bind_type'], array(USER_REGISTER_TYPE_QQ, USER_REGISTER_TYPE_WECHAT, USER_REGISTER_TYPE_MOBILE))) {
		iajax(-1, '类型错误');
	}
	$bind_type = $types[$_GPC['bind_type']];
	if ($_W['isajax'] && $_W['ispost']) {
		$unbind_info = OAuth2Client::create($bind_type, $_W['setting']['thirdlogin'][$bind_type]['appid'], $_W['setting']['thirdlogin'][$bind_type]['appsecret'])->unbind();

		if (is_error($unbind_info)) {
			iajax(-1, $unbind_info['message']);
		}
		iajax(0, '解绑成功', url('user/profile/bind'));
	}
	iajax(-1, '非法请求');
}
