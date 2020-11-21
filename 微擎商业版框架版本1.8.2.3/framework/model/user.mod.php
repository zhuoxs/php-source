<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');


function user_register($user, $source) {
	load()->model('message');
	if (empty($user) || !is_array($user)) {
		return 0;
	}
	if (isset($user['uid'])) {
		unset($user['uid']);
	}

	$check_pass = safe_check_password(safe_gpc_string($user['password']));
	if (is_error($check_pass)) {
		return $check_pass;
	}

	$user['salt'] = random(8);
	$user['password'] = user_hash($user['password'], $user['salt']);
	$user['joinip'] = CLIENT_IP;
	$user['joindate'] = TIMESTAMP;
	$user['lastip'] = CLIENT_IP;
	$user['lastvisit'] = TIMESTAMP;
	if (!empty($user['owner_uid'])) {
		$vice_founder_info = user_single($user['owner_uid']);
		if (empty($vice_founder_info) || !user_is_vice_founder($vice_founder_info['uid'])) {
			$user['owner_uid'] = 0;
		}
	}
	if (empty($user['status'])) {
		$user['status'] = 2;
	}
	if (empty($user['type'])) {
		$user['type'] = USER_TYPE_COMMON;
	}

	$result = pdo_insert('users', $user);
	if (!empty($result)) {
		$user['uid'] = pdo_insertid();
	}
	$content = $user['username'] . ' ' .date("Y-m-d H:i:s") . '注册成功--' . $source;
	$message = array(
		'status' => $user['status']
	);
	message_notice_record($content, $user['uid'], $user['uid'], MESSAGE_REGISTER_TYPE, $message);

	return intval($user['uid']);
}


function user_check($user) {
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
	$sql = 'SELECT `password`,`salt` FROM ' . tablename('users') . "$where LIMIT 1";
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


function user_is_founder($uid, $only_main_founder = false) {
	global $_W;
	$founders = explode(',', $_W['config']['setting']['founder']);
	if (in_array($uid, $founders)) {
		return true;
	}

	if (empty($only_main_founder)) {
		$founder_groupid = pdo_getcolumn('users', array('uid' => $uid), 'founder_groupid');
		if ($founder_groupid == ACCOUNT_MANAGE_GROUP_VICE_FOUNDER) {
			return true;
		}
	}

	return false;
}


function user_is_vice_founder($uid = 0) {
	global $_W;
	$uid = intval($uid);
	if (empty($uid)) {
		$user_info = $_W['user'];
	} else {
		$user_info = user_single($uid);
	}
	if ($user_info['founder_groupid'] == ACCOUNT_MANAGE_GROUP_VICE_FOUNDER) {
		return true;
	}
	return false;
}


function user_delete($uid, $is_recycle = false) {
	load()->model('cache');
	$user_table = table('users');
	if (empty($is_recycle)) {
		$user_table->userAccountRole(ACCOUNT_MANAGE_NAME_OWNER);
		$user_accounts = $user_table->userOwnedAccount($uid);
		if (!empty($user_accounts)) {
			foreach ($user_accounts as $uniacid) {
				cache_build_account_modules($uniacid);
			}
		}
	}
	$user_table->userAccountDelete($uid, $is_recycle);
	return true;
}


function user_single($user_or_uid) {
	$user = $user_or_uid;
	if (empty($user)) {
		return false;
	}
	if (is_numeric($user)) {
		$user = array('uid' => $user);
	}
	if (!is_array($user)) {
		return false;
	}
	$where = ' WHERE 1 ';
	$params = array();
	if (!empty($user['uid'])) {
		$where .= ' AND u.`uid`=:uid';
		$params[':uid'] = intval($user['uid']);
	}
	if (!empty($user['username'])) {
		$where .= ' AND u.`username`=:username';
		$params[':username'] = $user['username'];

		$user_exists = user_check($user);
		$is_mobile = preg_match(REGULAR_MOBILE, $user['username']);
		if (!$user_exists && !empty($user['username']) && $is_mobile) {
			$sql = "select b.uid, u.username FROM " . tablename('users_bind') . " AS b LEFT JOIN " . tablename('users') . " AS u ON b.uid = u.uid WHERE b.bind_sign = :bind_sign";
			$bind_info = pdo_fetch($sql, array('bind_sign' => $user['username']));
			if (!is_array($bind_info) || empty($bind_info) || empty($bind_info['username'])) {
				return false;
			}
			$params[':username'] = $bind_info['username'];
		}
	}
	if (!empty($user['email'])) {
		$where .= ' AND u.`email`=:email';
		$params[':email'] = $user['email'];
	}
	if (!empty($user['status'])) {
		$where .= " AND u.`status`=:status";
		$params[':status'] = intval($user['status']);
	}
	if (empty($params)) {
		return false;
	}
	$sql = 'SELECT u.*, p.avatar FROM ' . tablename('users') . ' AS u LEFT JOIN '. tablename('users_profile') . ' AS p ON u.uid = p.uid '. $where. ' LIMIT 1';

	$record = pdo_fetch($sql, $params);
	if (empty($record)) {
		return false;
	}
	if (!empty($user['password'])) {
		$password = user_hash($user['password'], $record['salt']);
		if ($password != $record['password']) {
			return false;
		}
	}

	$record['hash'] = md5($record['password'] . $record['salt']);
		
	if (!empty($record['owner_uid'])) {
		$record['vice_founder_name'] = pdo_getcolumn('users', array('uid' => $record['owner_uid']), 'username');
	}
	if($record['type'] == ACCOUNT_OPERATE_CLERK) {
		$clerk = pdo_get('activity_clerks', array('uid' => $record['uid']));
		if(!empty($clerk)) {
			$record['name'] = $clerk['name'];
			$record['clerk_id'] = $clerk['id'];
			$record['store_id'] = $clerk['storeid'];
			$record['store_name'] = pdo_fetchcolumn('SELECT business_name FROM ' . tablename('activity_stores') . ' WHERE id = :id', array(':id' => $clerk['storeid']));
			$record['clerk_type'] = '3';
			$record['uniacid'] = $clerk['uniacid'];
		}
	} else {
				$record['name'] = $record['username'];
		$record['clerk_id'] = $user['uid'];
		$record['store_id'] = 0;
		$record['clerk_type'] = '2';
	}
	$third_info = pdo_getall('users_bind', array('uid' => $record['uid']), array(), 'third_type');
	if (!empty($third_info) && is_array($third_info)) {
		$record['qq_openid'] = $third_info[USER_REGISTER_TYPE_QQ]['bind_sign'];
		$record['wechat_openid'] = $third_info[USER_REGISTER_TYPE_WECHAT]['bind_sign'];
		$record['mobile'] = $third_info[USER_REGISTER_TYPE_MOBILE]['bind_sign'];
	}
	return $record;
}


function user_update($user) {
	if (empty($user['uid']) || !is_array($user)) {
		return false;
	}
	$record = array();
	if (!empty($user['username'])) {
		$record['username'] = $user['username'];
	}
	if (!empty($user['password'])) {
		$record['password'] = user_hash($user['password'], $user['salt']);
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
	if(isset($user['lastuniacid'])) {
		$record['lastuniacid'] = intval($user['lastuniacid']);
	}
	if (empty($record)) {
		return false;
	}
	return pdo_update('users', $record, array('uid' => intval($user['uid'])));
}


function user_hash($passwordinput, $salt) {
	global $_W;
	$passwordinput = "{$passwordinput}-{$salt}-{$_W['config']['setting']['authkey']}";
	return sha1($passwordinput);
}


function user_level() {
	static $level = array(
		'-3' => '锁定用户',
		'-2' => '禁止访问',
		'-1' => '禁止发言',
		'0' => '普通会员',
		'1' => '管理员',
	);
	return $level;
}


function user_group() {
	global $_W;
	if (user_is_vice_founder()) {
		$condition = array(
			'owner_uid' => $_W['uid'],
		);
	}
	$groups = pdo_getall('users_group', $condition, array('id', 'name', 'package'), 'id', 'id ASC');
	return $groups;
}


function user_founder_group() {
	$groups = pdo_getall('users_founder_group', array(), array('id', 'name', 'package'), 'id', 'id ASC');
	return $groups;
}


function user_group_detail_info($groupid = 0) {
	$group_info = array();

	$groupid = is_array($groupid) ? 0 : intval($groupid);
	if(empty($groupid)) {
		return $group_info;
	}
	$group_info = pdo_get('users_group', array('id' => $groupid));
	if (empty($group_info)) {
		return $group_info;
	}

	$group_info['package'] = (array)iunserializer($group_info['package']);
	if (!empty($group_info['package'])) {
		$group_info['package_detail'] = uni_groups($group_info['package']);
	}
	return $group_info;
}


function user_founder_group_detail_info($groupid = 0) {
	$group_info = array();

	$groupid = is_array($groupid) ? 0 : intval($groupid);
	if(empty($groupid)) {
		return $group_info;
	}
	$group_info = pdo_get('users_founder_group', array('id' => $groupid));
	if (empty($group_info)) {
		return $group_info;
	}

	$group_info['package'] = (array)iunserializer($group_info['package']);
	if (!empty($group_info['package'])) {
		$group_info['package_detail'] = uni_groups($group_info['package']);
	}
	return $group_info;
}


function user_account_detail_info($uid) {
	$account_lists = $app_user_info = $wxapp_user_info = $webapp_user_info = $xzapp_user_info = array();
	$uid = intval($uid);
	if (empty($uid)) {
		return $account_lists;
	}

	$account_users_info = table('account')->userOwnedAccount($uid);

	if (!empty($account_users_info)) {
		foreach ($account_users_info as $uniacid => $account) {
			if ($account['type'] == ACCOUNT_TYPE_OFFCIAL_NORMAL || $account['type'] == ACCOUNT_TYPE_OFFCIAL_AUTH) {
				$app_user_info[$uniacid] = $account;
			} elseif ($account['type'] == ACCOUNT_TYPE_APP_NORMAL) {
				$wxapp_user_info[$uniacid] = $account;
			} elseif ($account['type'] == ACCOUNT_TYPE_WEBAPP_NORMAL) {
				$webapp_user_info[$uniacid] = $account;
			} elseif ($account['type'] == ACCOUNT_TYPE_PHONEAPP_NORMAL) {
				$phoneapp_user_info[$uniacid] = $account;
			} elseif ($account['type'] == ACCOUNT_TYPE_XZAPP_NORMAL) {
				$xzapp_user_info[$uniacid] = $account;
			}
		}
	}

	$wxapps = $wechats = $webapps = $pohoneapp = $xzapp = array();
	if (!empty($wxapp_user_info)) {
		$wxapps = table('account')->accountWxappInfo(array_keys($wxapp_user_info), $uid);
	}
	if (!empty($app_user_info)) {
		$wechats = table('account')->accountWechatsInfo(array_keys($app_user_info), $uid);
	}
	if (!empty($webapp_user_info)) {
		$webapps = table('account')->accountWebappInfo(array_keys($webapp_user_info), $uid);
	}
	if (!empty($webapp_user_info)) {
		$pohoneapp = table('account')->accountPhoneappInfo(array_keys($webapp_user_info), $uid);
	}
	if (!empty($xzapp_user_info)) {
		$xzapp = table('account')->accountXzappInfo(array_keys($xzapp_user_info), $uid);
	}

	$accounts = array_merge($wxapps, $wechats, $webapps, $pohoneapp, $xzapp);
	if (!empty($accounts)) {
		foreach ($accounts as &$account_val) {
			$account_val['thumb'] = tomedia('headimg_'.$account_val['default_acid']. '.jpg');
			foreach ($account_users_info as $uniacid => $user_info) {
				if ($account_val['uniacid'] == $uniacid) {
					$account_val['type'] = $user_info['type'];
					if ($user_info['type'] == ACCOUNT_TYPE_APP_NORMAL || $user_info['type'] == ACCOUNT_TYPE_APP_AUTH) {
						$account_lists['wxapp'][$uniacid] = $account_val;
					} elseif ($user_info['type'] == ACCOUNT_TYPE_OFFCIAL_NORMAL || $user_info['type'] == ACCOUNT_TYPE_OFFCIAL_AUTH) {
						$account_lists['wechat'][$uniacid] = $account_val;
					} elseif ($user_info['type'] == ACCOUNT_TYPE_WEBAPP_NORMAL) {
						$account_lists['webapp'][$uniacid] = $account_val;
					} elseif ($user_info['type'] == ACCOUNT_TYPE_PHONEAPP_NORMAL) {
						$account_lists['phoneapp'][$uniacid] = $account_val;
					} elseif ($user_info['type'] == ACCOUNT_TYPE_XZAPP_NORMAL) {
						$account_lists['xzapp'][$uniacid] = $account_val;
					}
				}
			}
		}
		unset($account_val);
	}
	return $account_lists;
}


function user_modules($uid = 0) {
	global $_W;
	if (empty($uid)) {
		$uid = $_W['uid'];
	}
	$modules = cache_load(cache_system_key('user_modules', array('uid' => $uid)));
	if (empty($modules)) {
		$user_info = user_single(array ('uid' => $uid));

		if (empty($uid) || user_is_founder($uid, true)) {
			$module_list = table('modules')->searchWithRecycle();
			$module_list = modules_support_all(array_keys($module_list));

		} elseif (!empty($user_info) && $user_info['type'] == ACCOUNT_OPERATE_CLERK) {
			$clerk_module = pdo_fetch("SELECT p.type FROM " . tablename('users_permission') . " p LEFT JOIN " . tablename('uni_account_users') . " u ON p.uid = u.uid AND p.uniacid = u.uniacid WHERE u.role = :role AND p.uid = :uid", array(':role' => ACCOUNT_MANAGE_NAME_CLERK, ':uid' => $uid));
			if (empty($clerk_module)) {
				return array();
			}
			$module_list = array($clerk_module['type'] => $clerk_module['type']);
			$module_list = modules_support_all(array_keys($module_list));

		} elseif (!empty($user_info) && empty($user_info['groupid'])) {
			$module_list = pdo_getall('modules', array('issystem' => 1), array('name'), 'name');;
			$module_list = modules_support_all(array_keys($module_list));

		} else {
			if ($user_info['founder_groupid'] == ACCOUNT_MANAGE_GROUP_VICE_FOUNDER) {
				$user_group_info = user_founder_group_detail_info($user_info['groupid']);
			} else {
				$user_group_info = user_group_detail_info($user_info['groupid']);
			}
			$packageids = $user_group_info['package'];
			if (!empty($packageids) && in_array('-1', $packageids)) {
				$module_list = table('modules')->searchWithRecycle();
				$module_list = modules_support_all(array_keys($module_list));

			} else {
				$module_list = array();
				$package_group = (array) pdo_getall('uni_group', array('id' => $packageids));
				$package_group[] = pdo_get('uni_group', array('uid' => $uid)); 				if (!empty($package_group)) {
					foreach ($package_group as $row) {
						if (empty($row)) {
							continue;
						}
						$row['modules'] = iunserializer($row['modules']);
						if (!empty($row['modules'])) {
							foreach ($row['modules'] as $type => $modulenames) {
								foreach ($modulenames as $name) {
									switch ($type) {
										case 'modules':
											$module_list[$name][] = MODULE_SUPPORT_ACCOUNT_NAME;
											break;
										case 'wxapp':
											$module_list[$name][] = MODULE_SUPPORT_WXAPP_NAME;
											break;
										case 'webapp':
											$module_list[$name][] = MODULE_SUPPORT_WEBAPP_NAME;
											break;
										case 'xzapp':
											$module_list[$name][] = MODULE_SUPPORT_XZAPP_NAME;
											break;
										case 'phoneapp':
											$module_list[$name][] = MODULE_SUPPORT_PHONEAPP_NAME;
											break;
									}
								}
							}
						}
					}
				}
			}
		}

		$modules = array();
		if (!empty($module_list)) {
			$have_plugin_module = array();
			if (pdo_tableexists('modules_plugin')) {
				$plugin_list = pdo_getall('modules_plugin', array('name' => array_keys($module_list)), array());
				if (!empty($plugin_list)) {
					foreach ($plugin_list as $plugin) {
						$have_plugin_module[$plugin['main_module']][$plugin['name']] = $module_list[$plugin['name']];
						unset($module_list[$plugin['name']]);
					}
				}
			}
			if (!empty($module_list)) {
				foreach ($module_list as $module => $support) {
					$modules[$module] = $support;
					if (!empty($have_plugin_module[$module])) {
						foreach ($have_plugin_module[$module] as $plugin => $plugin_support) {
							$modules[$plugin] = $plugin_support;
						}
					}
				}
			}
		}

		cache_write(cache_system_key('user_modules', array('uid' => $uid)), $modules);
	}

	$module_list = array();
	if (!empty($modules)) {
		foreach ($modules as $module => $support) {
			$module_info = module_fetch($module);
						if (!user_is_founder($_W['uid'], true) &&
				$module_info[MODULE_SUPPORT_SYSTEMWELCOME_NAME] == MODULE_SUPPORT_SYSTEMWELCOME &&
				$module_info[MODULE_SUPPORT_ACCOUNT_NAME] != MODULE_SUPPORT_ACCOUNT &&
				$module_info[MODULE_SUPPORT_WXAPP_NAME] != MODULE_SUPPORT_WXAPP &&
				$module_info[MODULE_SUPPORT_WEBAPP_NAME] != MODULE_SUPPORT_WEBAPP &&
				$module_info[MODULE_SUPPORT_PHONEAPP_NAME] != MODULE_SUPPORT_PHONEAPP) {
				continue;
			}
						if ($support !== 'all') {
				if ($module_info[MODULE_SUPPORT_ACCOUNT_NAME] == MODULE_SUPPORT_ACCOUNT && !in_array(MODULE_SUPPORT_ACCOUNT_NAME, $support)) {
					$module_info[MODULE_SUPPORT_ACCOUNT_NAME] = MODULE_NONSUPPORT_ACCOUNT;
				}
				if ($module_info[MODULE_SUPPORT_WXAPP_NAME] == MODULE_SUPPORT_WXAPP && !in_array(MODULE_SUPPORT_WXAPP_NAME, $support)) {
					$module_info[MODULE_SUPPORT_WXAPP_NAME] = MODULE_NONSUPPORT_WXAPP;
				}
				if ($module_info[MODULE_SUPPORT_WEBAPP_NAME] == MODULE_SUPPORT_WEBAPP && !in_array(MODULE_SUPPORT_WEBAPP_NAME, $support)) {
					$module_info[MODULE_SUPPORT_WEBAPP_NAME] = MODULE_NOSUPPORT_WEBAPP;
				}
				if ($module_info[MODULE_SUPPORT_XZAPP_NAME] == MODULE_SUPPORT_XZAPP && !in_array(MODULE_SUPPORT_XZAPP_NAME, $support)) {
					$module_info[MODULE_SUPPORT_XZAPP_NAME] = MODULE_NOSUPPORT_XZAPP;
				}
				if ($module_info[MODULE_SUPPORT_PHONEAPP_NAME] == MODULE_SUPPORT_PHONEAPP && !in_array(MODULE_SUPPORT_PHONEAPP_NAME, $support)) {
					$module_info[MODULE_SUPPORT_PHONEAPP_NAME] = MODULE_NOSUPPORT_PHONEAPP;
				}
			}
			$module_list[$module] = $module_info;
		}
	}
	return $module_list;
}

function modules_support_all($modulenames) {
	if (empty($modulenames)) {
		return array();
	}
	$data = array();
	foreach ($modulenames as $name) {
		$data[$name] = 'all';
	}
	return $data;
}


function user_login_forward($forward = '') {
	global $_W, $_GPC;
	$login_forward = trim($forward);

	$login_location = array(
		'account' => url('home/welcome'),
		'wxapp' => url('wxapp/version/home'),
		'module' => url('module/display'),
		'webapp' => url('webapp/home'),
		'phoneapp' => url('phoneapp/display/home'),
	);
	if (!empty($forward)) {
		return $login_forward;
	}

	if (empty($_W['isfounder']) || user_is_vice_founder()) {
		if (!empty($_W['user']['endtime']) && $_W['user']['endtime'] < TIMESTAMP) {
			return url('user/profile');
		}
	}

	if (user_is_founder($_W['uid']) && !user_is_vice_founder($_W['uid'])) {
		return url('home/welcome/system');
	}
	if (user_is_vice_founder()) {
		return url('account/manage', array('account_type' => 1));
	}
	if ($_W['user']['type'] == ACCOUNT_OPERATE_CLERK) {
		return url('module/display');
	}

	$url = user_after_login_link();
	if (!empty($url)) {
		return $url;
	}

	$login_forward = url('account/display');
	$visit_key = '__lastvisit_' . $_W['uid'];
	if (!empty($_GPC[$visit_key])) {
		$last_visit = explode(',', $_GPC[$visit_key]);
		$last_visit_uniacid = intval($last_visit[0]);
		$last_visit_url = url_params($last_visit[1]);
		if ($last_visit_url['c'] == 'site' && in_array($last_visit_url['a'], array('entry', 'nav')) ||
			$last_visit_url['c'] == 'platform' && in_array($last_visit_url['a'], array('cover', 'reply')) && !in_array($last_visit_url['m'], system_modules()) ||
			$last_visit_url['c'] == 'module' && in_array($last_visit_url['a'], array('manage-account', 'permission', 'display'))) {
			return $login_location['module'];
		} else {
			if ($last_visit_url['c'] == 'wxapp') {
				return $last_visit_url['a'] == 'display' ? url('account/display', array('type' => WXAPP_TYPE_SIGN)) : $login_location['wxapp'];
			}
			$account_info = uni_fetch($last_visit_uniacid);
			if (empty($account_info) || $last_visit_url['c'] == 'account' && $last_visit_url['a'] == 'display') {
				return $login_forward;
			}
			if (in_array($account_info['type'], array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH))) {
				return $login_location['account'];
			}
			if ($account_info['type'] == ACCOUNT_TYPE_APP_NORMAL) {
				return $login_location['wxapp'];
			}
			if ($account_info['type'] == ACCOUNT_TYPE_WEBAPP_NORMAL) {
				return $login_location['webapp'];
			}
			if ($account_info['type'] == ACCOUNT_TYPE_PHONEAPP_NORMAL) {
				return $login_location['phoneapp'];
			}
		}
	}

	if (!empty($_W['uniacid']) && !empty($_W['account'])) {
		$permission = permission_account_user_role($_W['uid'], $_W['uniacid']);
		if (empty($permission)) {
			return $login_forward;
		}
		if ($_W['account']['type'] == ACCOUNT_TYPE_OFFCIAL_NORMAL || $_W['account']['type'] == ACCOUNT_TYPE_OFFCIAL_AUTH) {
			$login_forward = url('home/welcome');
		} elseif ($_W['account']['type'] == ACCOUNT_TYPE_APP_NORMAL) {
			$login_forward = url('wxapp/display/home');
		} elseif ($_W['account']['type'] == ACCOUNT_TYPE_WEBAPP_NORMAL) {
			$login_forward = url('webapp/home/display');
		} elseif ($_W['account']['type'] == ACCOUNT_TYPE_PHONEAPP_NORMAL) {
			$login_forward = url('phoneapp/display/home');
		}
	}

	return $login_forward;
}

function user_invite_register_url($uid = 0) {
	global $_W;
	if (empty($uid)) {
		$uid = $_W['uid'];
	}
	return $_W['siteroot'] . 'web/index.php?c=user&a=register&owner_uid=' . $uid;
}


function user_save_group($group_info) {
	global $_W;
	$group_table = table('group');
	$name = trim($group_info['name']);
	if (empty($name)) {
		return error(-1, '用户权限组名不能为空');
	}

	$group_table->searchWithName($name);
	if (!empty($group_info['id'])) {
		$group_table->searchWithNoId($group_info['id']);
	}
	$name_exist = $group_table->searchGroup();
	if (!empty($name_exist)) {
		return error(-1, '用户权限组名已存在！');
	}

	if (user_is_vice_founder()) {
		$group_table->searchWithId($_W['user']['groupid']);
		$founder_info = $group_table->searchGroup(true);
		if ($group_info['maxaccount'] > $founder_info['maxaccount']) {
			return error(-1, '当前用户组的公众号个数不能超过' . $founder_info['maxaccount'] . '个！');
		}
		if ($group_info['maxwxapp'] > $founder_info['maxwxapp']) {
			return error(-1, '当前用户组的公众号个数不能超过' . $founder_info['maxwxapp'] . '个！');
		}
		if ($group_info['maxwebapp'] > $founder_info['maxwebapp']) {
			return error(-1, '当前用户组的公众号个数不能超过' . $founder_info['maxwebapp'] . '个！');
		}
		if ($group_info['maxaliapp'] > $founder_info['maxaliapp']) {
			return error(-1, '当前用户组的支付宝小程序个数不能超过' . $founder_info['maxaliapp'] . '个！');
		}
	}

	if (!empty($group_info['package'])) {
		foreach ($group_info['package'] as $value) {
			$package[] = intval($value);
		}
	}
	$group_info['package'] = iserializer($package);
	if (user_is_vice_founder()) {
		$group_info['owner_uid'] = $_W['uid'];
	}

	if (empty($group_info['id'])) {
		pdo_insert('users_group', $group_info);
	} else {
		pdo_update('users_group', $group_info, array('id' => $group_info['id']));
	}

	return error(0, '添加成功');
}


function user_save_founder_group($group_info) {
	$name = trim($group_info['name']);
	if (empty($name)) {
		return error(-1, '用户权限组名不能为空');
	}

	if (!empty($group_info['id'])) {
		$name_exist = pdo_get('users_founder_group', array('id <>' => $group_info['id'], 'name' => $name));
	} else {
		$name_exist = pdo_get('users_founder_group', array('name' => $name));
	}

	if (!empty($name_exist)) {
		return error(-1, '用户权限组名已存在！');
	}

	if (!empty($group_info['package'])) {
		foreach ($group_info['package'] as $value) {
			$package[] = intval($value);
		}
	}
	$group_info['package'] = iserializer($package);

	if (empty($group_info['id'])) {
		pdo_insert('users_founder_group', $group_info);
	} else {
		pdo_update('users_founder_group', $group_info, array('id' => $group_info['id']));
	}

	return error(0, '添加成功');
}


function user_group_format($lists) {
	if (empty($lists)) {
		return $lists;
	}
	$all_package = array();
	foreach ($lists as $key => $group) {
		if (empty($group['package'])) {
			continue;
		}
		$package = iunserializer($group['package']);
		if (!is_array($package)) {
			continue;
		}
		$all_package = array_merge($all_package, $package);
	}
	$group_package = uni_groups($all_package);

	foreach ($lists as $key => $group) {
		$package = iunserializer($group['package']);
		$group['package'] = array();
		if (is_array($package)) {
			foreach ($package as $packageid) {
				$group['package'][$packageid] = $group_package[$packageid];
			}
		}
		if (empty($package)) {
			$lists[$key]['module_nums'] = 0;
			$lists[$key]['wxapp_nums'] = 0;
			$lists[$key]['webapp_nums'] = 0;
			$lists[$key]['phoneapp_nums'] = 0;
			$lists[$key]['xzapp_nums'] = 0;
			continue;
		}
		if (is_array($package) && in_array(-1, $package)) {
			$lists[$key]['module_nums'] = -1;
			$lists[$key]['wxapp_nums'] = -1;
			$lists[$key]['webapp_nums'] = -1;
			$lists[$key]['phoneapp_nums'] = -1;
			$lists[$key]['xzapp_nums'] = -1;
			continue;
		}
		$names = array();
		$modules = array(
			'modules' => array(),
			'wxapp' => array(),
			'webapp' => array(),
			'phoneapp' => array(),
			'xzapp' => array()
		);
		if (!empty($group['package'])) {
			foreach ($group['package'] as $package) {
				$names[] = $package['name'];
				$package['modules'] = !empty($package['modules']) && is_array($package['modules']) ? array_keys($package['modules']) : array();
				$package['wxapp'] = !empty($package['wxapp']) && is_array($package['wxapp']) ? array_keys($package['wxapp']) : array();
				$package['webapp'] = !empty($package['webapp']) && is_array($package['webapp']) ? array_keys($package['webapp']) : array();
				$package['phoneapp'] = !empty($package['phoneapp']) && is_array($package['phoneapp']) ? array_keys($package['phoneapp']) : array();
				$package['xzapp'] = !empty($package['xzapp']) && is_array($package['xzapp']) ? array_keys($package['xzapp']) : array();
				$modules['modules'] = array_unique(array_merge($modules['modules'], $package['modules']));
				$modules['wxapp'] = array_unique(array_merge($modules['wxapp'], $package['wxapp']));
				$modules['webapp'] = array_unique(array_merge($modules['webapp'], $package['webapp']));
				$modules['phoneapp'] = array_unique(array_merge($modules['phoneapp'], $package['phoneapp']));
				$modules['xzapp'] = array_unique(array_merge($modules['xzapp'], $package['xzapp']));
			}
			$lists[$key]['module_nums'] = count($modules['modules']);
			$lists[$key]['wxapp_nums'] = count($modules['wxapp']);
			$lists[$key]['webapp_nums'] = count($modules['webapp']);
			$lists[$key]['phoneapp_nums'] = count($modules['phoneapp']);
			$lists[$key]['xzapp_nums'] = count($modules['xzapp']);
		}
		$lists[$key]['packages'] = implode(',', $names);
	}
	return $lists;
}


function user_list_format($users) {
	if (empty($users)) {
		return array();
	}
	$users_table = table('users');
	$groups = $users_table->usersGroup();
	$founder_groups = $users_table->usersFounderGroup();

	foreach ($users as &$user) {
		$user['avatar'] = !empty($user['avatar']) ? $user['avatar'] : './resource/images/nopic-user.png';
		$user['joindate'] = date('Y-m-d', $user['joindate']);
		if (empty($user['endtime'])) {
			$user['endtime'] = '永久有效';
		} else {
			$user['endtime'] = $user['endtime'] <= TIMESTAMP ? '服务已到期' : date('Y-m-d', $user['endtime']);
		}

		$user['module_num'] =array();
		if ($user['founder_groupid'] == ACCOUNT_MANAGE_GROUP_VICE_FOUNDER) {
			$group = $founder_groups[$user['groupid']];
		} else {
			$group = $groups[$user['groupid']];
		}

		$user['maxaccount'] = $user['founder_groupid'] == 1 ? '不限' : (empty($group) ? 0 : $group['maxaccount']);
		$user['maxwxapp'] = $user['founder_groupid'] == 1 ? '不限' : (empty($group) ? 0 : $group['maxwxapp']);
		$user['maxwebapp'] = $user['founder_groupid'] == 1 ? '不限' : (empty($group) ? 0 : $group['maxwebapp']);
		$user['maxphoneapp'] = $user['founder_groupid'] == 1 ? '不限' : (empty($group) ? 0 : $group['maxphoneapp']);
		$user['maxxzapp'] = $user['founder_groupid'] == 1 ? '不限' : (empty($group) ? 0 : $group['maxxzapp']);
		$user['groupname'] = $group['name'];
		unset($user);
	}
	return $users;
}


function user_info_save($user, $is_founder_group = false) {
	global $_W;
	if (!preg_match(REGULAR_USERNAME, $user['username'])) {
		return error(-1, '必须输入用户名，格式为 3-15 位字符，可以包括汉字、字母（不区分大小写）、数字、下划线和句点。');
	}
	if (user_check(array('username' => $user['username']))) {
		return error(-1, '非常抱歉，此用户名已经被注册，你需要更换注册名称！');
	}
	if (istrlen($user['password']) < 8) {
		return error(-1, '必须输入密码，且密码长度不得低于8位。');
	} else {
		$check_pass = safe_check_password(safe_gpc_string($user['password']));
		if (is_error($check_pass)) {
			return $check_pass;
		}
	}

	if (trim($user['password']) !== trim($user['repassword'])) {
		return error(-1, '两次密码不一致！');
	}
	if (intval($user['groupid'])) {
		if ($is_founder_group) {
			$group = user_founder_group_detail_info($user['groupid']);
		} else {
			$group = user_group_detail_info($user['groupid']);
		}
		if (empty($group)) {
			return error(-1, '会员组不存在');
		}
		$timelimit = intval($group['timelimit']);
	} else {
		$timelimit = 0;
	}

	$timeadd = 0;
	if ($timelimit > 0) {
		$timeadd = strtotime($timelimit . ' days');
	}
	if (user_is_vice_founder() && !empty($_W['user']['endtime'])) {
		$timeadd = !empty($timeadd) ? min($timeadd, $_W['user']['endtime']) : $_W['user']['endtime'];
	}
	if (empty($timeadd)) {
		$user['endtime'] = max(0, $user['endtime']);
	} else {
		$user['endtime'] =  empty($user['endtime']) ? $timeadd : min($timeadd, $user['endtime']);
	}
	if (user_is_vice_founder()) {
		$user['owner_uid'] = $_W['uid'];
	}
	unset($user['vice_founder_name']);
	unset($user['repassword']);
	$user_add_id = user_register($user, 'admin');
	if (empty($user_add_id)) {
		return error(-1, '增加失败，请稍候重试或联系网站管理员解决！');
	}
	return array('uid' => $user_add_id);
}


function user_detail_formate($profile) {
	if (!empty($profile)) {
		$profile['reside'] = array(
			'province' => $profile['resideprovince'],
			'city' => $profile['residecity'],
			'district' => $profile['residedist']
		);
		$profile['birth'] = array(
			'year' => $profile['birthyear'],
			'month' => $profile['birthmonth'],
			'day' => $profile['birthday'],
		);
		$profile['avatar'] = tomedia($profile['avatar']);
		$profile['resides'] = $profile['resideprovince'] . $profile['residecity'] . $profile['residedist'] ;
		$profile['births'] =($profile['birthyear'] ? $profile['birthyear'] : '--') . '年' . ($profile['birthmonth'] ? $profile['birthmonth'] : '--') . '月' . ($profile['birthday'] ? $profile['birthday'] : '--') .'日';
	}
	return $profile;
}


function user_support_urls() {
	global $_W;
	load()->classs('oauth2/oauth2client');
	$types = OAuth2Client::supportLoginType();
	$login_urls = array();
	foreach ($types as $type) {
		if (!empty($_W['setting']['thirdlogin'][$type]['authstate'])) {
			$login_urls[$type] = OAuth2Client::create($type, $_W['setting']['thirdlogin'][$type]['appid'], $_W['setting']['thirdlogin'][$type]['appsecret'])->showLoginUrl();
		}
	}
	if (empty($login_urls)) {
		$login_urls['system'] = true;
	}
	return $login_urls;
}


function user_borrow_oauth_account_list() {
	global $_W;
	$user_have_accounts = uni_user_accounts($_W['uid']);
	$oauth_accounts = array();
	$jsoauth_accounts = array();
	if(!empty($user_have_accounts)) {
		foreach($user_have_accounts as $account) {
			if(!empty($account['key']) && !empty($account['secret'])) {
				if (in_array($account['level'], array(ACCOUNT_SERVICE_VERIFY))) {
					$oauth_accounts[$account['acid']] = $account['name'];
				}
				if (in_array($account['level'], array(ACCOUNT_SUBSCRIPTION_VERIFY, ACCOUNT_SERVICE_VERIFY))) {
					$jsoauth_accounts[$account['acid']] = $account['name'];
				}
			}
		}
	}
	return array(
		'oauth_accounts' => $oauth_accounts,
		'jsoauth_accounts' => $jsoauth_accounts
	);
}


function user_founder_templates($founder_groupid) {
	$group_detail_info = user_founder_group_detail_info($founder_groupid);

	if (empty($group_detail_info) || empty($group_detail_info['package'])) {
		return array();
	}

	if (in_array(-1, $group_detail_info['package'])) {
		$template_list = table('sitetemplates')->getAllTemplates();
		return $template_list;
	}

	$template_list = array();
	foreach ($group_detail_info['package'] as $uni_group) {
		if (!empty($group_detail_info['package_detail'][$uni_group]['templates'])) {
			$template_list = array_merge($template_list, $group_detail_info['package_detail'][$uni_group]['templates']);
		}
	}
	return $template_list;
}


function user_is_bind() {
	global $_W;
	if (!empty($_W['setting']['copyright']['bind'])) {
		$complete_info = false;
		switch($_W['setting']['copyright']['bind']) {
			case 'qq' :
				if (!empty($_W['user']['qq_openid'])) {
					$complete_info = true;
				}
				break;
			case 'mobile' :
				if (!empty($_W['user']['mobile'])) {
					$complete_info = true;
				}
				break;
			case 'wechat' :
				if (!empty($_W['user']['wechat_openid'])) {
					$complete_info = true;
				}
				break;
		}
		if (empty($_W['isfounder']) && !$complete_info) {
			return false;
		}
	}
	return true;
}


function user_change_welcome_status($uid, $welcome_status) {
	if (empty($uid)) {
		return true;
	}
	$user_table = table('users');
	$user_table->fillWelcomeStatus($welcome_status)->whereUid($uid)->save();
	return true;
}


function user_after_login_link() {
	global $_W;

	if (!empty($_W['user']['welcome_link'])) {
		$type = $_W['user']['welcome_link'];
	} else {
		if (!empty($_W['setting']['copyright']['welcome_link'])) {
			$type = $_W['setting']['copyright']['welcome_link'];
		} else {
			$type = WELCOME_DISPLAY_TYPE;
		}
	}

	switch ($type) {
		case WELCOME_DISPLAY_TYPE:
			$url = url('home/welcome/system_home');
			break;
		case PLATFORM_DISPLAY_TYPE:
			$url = url('account/display/platform');
			break;
		default:
			$url = '';
			break;
	}

	return $url;
}
