<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('module');
load()->model('miniapp');
load()->model('phoneapp');
load()->model('user');

$dos = array('display', 'save_account', 'check_params', 'get_user_info');
$do = in_array($do, $dos) ? $do : 'display';

if ($do == 'get_user_info') {
	$uid = intval($_GPC['uid'][0]);
	$sign = trim($_GPC['sign']);
	if (empty($account_all_type_sign[$sign])) {
		iajax(-1, '参数有误');
	}
	$user = user_single(array('uid' => $uid));
	if (empty($user)) {
		iajax(-1, '用户不存在或是已经被删除', '');
	}
	$info = array(
		'uid' => $user['uid'],
		'username' => $user['username'],
		'group' => user_group_detail_info($user['groupid']),
		'endtime' => user_end_time($user['uid']),
		'modules' => array(),
	);
	$info['endtime'] = empty($info['endtime']) ? 0 : date('Y-m-d', $info['endtime']);
	$info['package'] = empty($info['group']['package']) ? array() : iunserializer($info['group']['package']);

	$user_modules = user_modules($user['uid']);
	if (!empty($user_modules)) {
		foreach ($user_modules as $module) {
			if ($module['issystem'] != 1 && $module[$sign.'_support'] == MODULE_SUPPORT_ACCOUNT) {
				$info['modules'][] = $module;
			}
		}
	}
	iajax(0, $info);
}

$sign = safe_gpc_string($_GPC['sign']);
if (empty($account_all_type_sign[$sign])) {
	$error_msg = '所需创建的账号类型不存在, 请重试.';
	empty($_W['isajax']) ? message($error_msg, '', 'error') : iajax(-1, $error_msg);
}
$sign_title = $account_all_type_sign[$sign]['title'];
$create_account_type = $account_all_type_sign[$sign]['contain_type'][0];

$user_account_num = permission_user_account_num($_W['uid']);
if (empty($_W['isfounder']) && $user_account_num["{$sign}_limit"] <= 0) {
	$error_msg = $sign_title . '创建数量已达上限！';
	empty($_W['isajax']) ? message($error_msg, '', 'error') : iajax(-1, $error_msg);
}

if ($do == 'display') {
	$unigroups = uni_groups();
	foreach ($unigroups as $key => $group) {
		if (empty($group[$sign])) {
			unset($unigroups[$key]); 		}
	}
	$modules = user_modules($_W['uid']);
	foreach ($modules as $k => $module) {
		if ($module['issystem'] == 1 || $module[$sign.'_support'] != MODULE_SUPPORT_ACCOUNT) {
			unset($modules[$k]);		} else {
			$modules[$k]['support'] = $sign . '_support';
		}
	}
	if (in_array($sign, array(ACCOUNT_TYPE_SIGN, XZAPP_TYPE_SIGN))) {
		$templates = pdo_fetchall("SELECT * FROM ".tablename('site_templates'));
	}
}

if ($do == 'save_account' || $do == 'check_params') {
	$post = array();
	$post['step'] = safe_gpc_string(trim($_GPC['step']));
	$post['name'] = safe_gpc_string(trim($_GPC['name']));
	$post['description'] = safe_gpc_string($_GPC['description']);
	$post['owner_uid'] = intval($_GPC['owner_uid']);
	$post['version'] = safe_gpc_string(trim($_GPC['version']));

	if (empty($post['step']) || $post['step'] == 'base_info') {
		if (empty($post['name'])) {
			iajax(-1, $sign_title . '名称不能为空');
		}
		$account_table = table('account');
		$check_uniacname = $account_table->searchWithTitle($post['name'])->searchWithType($create_account_type)->searchAccountList();
		if (!empty($check_uniacname)) {
			iajax(-1, "该{$sign_title}名称已经存在");
		}
	}
	if (empty($post['step']) || $post['step'] == 'account_modules') {
		if (user_is_founder($_W['uid'])) {			if (!empty($post['owner_uid']) && !user_is_founder($post['owner_uid'], true)) {
				$create_account_info = permission_user_account_num($post['owner_uid']);
				if ($create_account_info[$sign . '_limit'] <= 0) {
					iajax(-1, "您所设置的主管理员所在的用户组可添加的公众号数量已达上限，请选择其他人做主管理员！");
				}
			}
		}
	}
	if (empty($post['step'])) {
		if (in_array($sign, array(PHONEAPP_TYPE_SIGN, WXAPP_TYPE_SIGN, ALIAPP_TYPE_SIGN, BAIDUAPP_TYPE_SIGN, TOUTIAOAPP_TYPE_SIGN))) {
			if (!preg_match('/^[0-9]{1,2}\.[0-9]{1,2}(\.[0-9]{1,2})?$/', $post['version'])) {
				iajax(-1, '版本号错误，只能是数字、点，数字最多2位，例如 1.1.1 或1.2');
			}
		}
	}
	if ($do == 'check_params') {
		iajax(0);
	}
}

if ($do == 'save_account') {
		if (in_array($sign, array(ACCOUNT_TYPE_SIGN, XZAPP_TYPE_SIGN, WEBAPP_TYPE_SIGN, PHONEAPP_TYPE_SIGN))) {
		pdo_insert('uni_account', array(
			'groupid' => 0,
			'default_acid' => 0,
			'name' => $post['name'],
			'description' => $post['description'],
			'title_initial' => get_first_pinyin($post['name']),
		));
		$uniacid = pdo_insertid();
		if (empty($uniacid)) {
			iajax(-1, "添加{$sign_title}失败, 请重试");
		}
		$account_data = array('name' => $post['name'], 'type' => $create_account_type);
		if ($sign == ACCOUNT_TYPE_SIGN) {
			$account_data['account'] = safe_gpc_string(trim($_GPC['account']));
		}
		if ($sign == ACCOUNT_TYPE_SIGN || $sign == XZAPP_TYPE_SIGN) {
			$account_data['original'] = safe_gpc_string(trim($_GPC['original']));
			$account_data['level'] = intval($_GPC['level']);
			$account_data['key'] = safe_gpc_string(trim($_GPC['key']));
			$account_data['secret'] = safe_gpc_string(trim($_GPC['secret']));
		}
		$acid = account_create($uniacid, $account_data);
		if(empty($acid)) {
			iajax(-1, "添加{$sign_title}信息失败");
		}
		pdo_update('uni_account', array('default_acid' => $acid), array('uniacid' => $uniacid));

				if (!empty($_GPC['headimg'])) {
			$headimg = safe_gpc_path($_GPC['headimg']);
			if (file_is_image($headimg)) {
				copy($headimg, IA_ROOT . '/attachment/headimg_'.$acid.'.jpg');
			}
		}
		if (!empty($_GPC['qrcode'])) {
			$qrcode = safe_gpc_path($_GPC['qrcode']);
			if (file_is_image($qrcode)) {
				copy($qrcode, IA_ROOT . '/attachment/qrcode_'.$acid.'.jpg');
			}
		}
				if (empty($_W['isfounder'])) {
			uni_user_account_role($uniacid, $_W['uid'], ACCOUNT_MANAGE_NAME_OWNER);
			cache_build_account_modules($uniacid);
		}
		
			if (user_is_vice_founder()) {
				uni_user_account_role($uniacid, $_W['uid'], ACCOUNT_MANAGE_NAME_VICE_FOUNDER);
			}
			if (!empty($_W['user']['owner_uid'])) {
				uni_user_account_role($uniacid, $_W['user']['owner_uid'], ACCOUNT_MANAGE_NAME_VICE_FOUNDER);
			}
		

				if (in_array($sign, array(ACCOUNT_TYPE_SIGN, XZAPP_TYPE_SIGN))) {
			pdo_insert('mc_groups', array('uniacid' => $uniacid, 'title' => '默认会员组', 'isdefault' => 1));
			$fields = pdo_getall('profile_fields');
			if (is_array($fields)) {
				foreach($fields as $field) {
					pdo_insert('mc_member_fields', array(
						'uniacid' => $uniacid,
						'fieldid' => $field['id'],
						'title' => $field['title'],
						'available' => $field['available'],
						'displayorder' => $field['displayorder'],
					));
				}
			}
		}
				if ($sign == ACCOUNT_TYPE_SIGN) {
						$oauth = uni_setting($uniacid, array('oauth'));
			if ($acid && empty($oauth['oauth']['account']) && !empty($account_data['key']) && !empty($account_data['secret'])  && $account_data['level'] == ACCOUNT_SERVICE_VERIFY) {
				pdo_update('uni_settings',
					array('oauth' => iserializer(array('account' => $acid, 'host' => $oauth['oauth']['host']))),
					array('uniacid' => $uniacid)
				);
			}
						$template = pdo_fetch('SELECT id,title FROM ' . tablename('site_templates') . " WHERE name = 'default'");
			pdo_insert('site_styles', array(
				'uniacid' => $uniacid,
				'templateid' => $template['id'],
				'name' => $template['title'] . '_' . random(4),
			));
			$styleid = pdo_insertid();
						pdo_insert('site_multi', array(
				'uniacid' => $uniacid,
				'title' => $post['name'],
				'styleid' => $styleid,
			));
			$multi_id = pdo_insertid();
		}
		pdo_insert('uni_settings', array(
			'creditnames' => iserializer(array('credit1' => array('title' => '积分', 'enabled' => 1), 'credit2' => array('title' => '余额', 'enabled' => 1))),
			'creditbehaviors' => iserializer(array('activity' => 'credit1', 'currency' => 'credit2')),
			'uniacid' => $uniacid,
			'default_site' => empty($multi_id) ? 0 : $multi_id,
			'sync' => iserializer(array('switch' => 0, 'acid' => '')),
		));
	}
	if (in_array($sign, array(WXAPP_TYPE_SIGN, ALIAPP_TYPE_SIGN, BAIDUAPP_TYPE_SIGN, TOUTIAOAPP_TYPE_SIGN))) {
		$miniapp_data = array(
			'name' => $post['name'],
			'type' => $create_account_type,
			'description' => $post['description'],
			'headimg' => !empty($_GPC['headimg']) && file_is_image($_GPC['headimg']) ?  $_GPC['headimg'] : '',
			'qrcode' => !empty($_GPC['qrcode']) && file_is_image($_GPC['qrcode']) ?  $_GPC['qrcode'] : '',
		);
		if ($sign == WXAPP_TYPE_SIGN) {
			$miniapp_data['original'] = safe_gpc_string($_GPC['original']);
			$miniapp_data['level'] = 1;
		}
				if (isset($_GPC['key']) && !empty($_GPC['key'])) {
			$miniapp_data['key'] = safe_gpc_string($_GPC['key']);
		}
		if (isset($_GPC['appid']) && !empty($_GPC['appid'])) {
			if ($sign == WXAPP_TYPE_SIGN || $sign == ALIAPP_TYPE_SIGN) {
				$miniapp_data['key'] = safe_gpc_string($_GPC['appid']);
			} else {
				$miniapp_data['appid'] = safe_gpc_string($_GPC['appid']);
			}
		}
		if (isset($_GPC['secret']) && !empty($_GPC['secret'])) {
			$miniapp_data['secret'] = safe_gpc_string($_GPC['secret']);
		}

		$uniacid = miniapp_create($miniapp_data);
		if (is_error($uniacid) || empty($uniacid)) {
			iajax(-1, empty($uniacid) ? '添加失败' : $uniacid['message']);
		}
		$acid = pdo_getcolumn('account', array('uniacid' => $uniacid, 'type' => $create_account_type), 'acid');
	}

		if (user_is_founder($_W['uid'])) {
		if (!empty($post['owner_uid'])) {
			$owner = pdo_get('uni_account_users', array('uniacid' => $uniacid, 'role' => 'owner'));
			if (!empty($owner)) {
				pdo_update('uni_account_users', array('uid' => $post['owner_uid']), array('uniacid' => $uniacid, 'role' => 'owner'));
			} else {
				uni_user_account_role($uniacid, $post['owner_uid'], ACCOUNT_MANAGE_NAME_OWNER);
			}
			
				$user_vice_id = pdo_getcolumn('users', array('uid' => $post['owner_uid']), 'owner_uid');
				if ($_W['user']['founder_groupid'] != ACCOUNT_MANAGE_GROUP_VICE_FOUNDER && !empty($user_vice_id)) {
					uni_user_account_role($uniacid, $user_vice_id, ACCOUNT_MANAGE_NAME_VICE_FOUNDER);
				}
			
		}

		if (!empty($_GPC['endtime'])) {
			$account_end_time = strtotime($_GPC['endtime']);
			if (!empty($post['owner_uid'])) {
				$user_end_time = user_end_time($post['owner_uid']);
				if ($user_end_time > 0 && $account_end_time > $user_end_time) {
					$account_end_time = $user_end_time;
				}
			}
		} else {
			$account_end_time = 0;
		}
		pdo_update('account', array('endtime' => $account_end_time), array('uniacid' => $uniacid));

				if (!empty($_GPC['groups'])) {
			foreach ($_GPC['groups'] as $group_id) {
				$group_id = intval($group_id);
				if (!empty($group_id)) {
					pdo_insert('uni_account_group', array('uniacid' => $uniacid, 'groupid' => $group_id));
				}
			}
		}
				if (!empty($_GPC['modules']) || !empty($_GPC['templates'])) {
			$templates = safe_gpc_array($_GPC['templates']);
			$modules = safe_gpc_array($_GPC['modules']);
			$data = array(
				'modules' => array('modules' => array(), 'wxapp' => array(), 'webapp' => array(), 'xzapp' => array(), 'phoneapp' => array()),
				'templates' => iserializer($templates),
				'uniacid' => $uniacid,
				'name' => '',
			);
			$group_sign = $sign == 'account' ? 'modules' : $sign;
			$data['modules'][$group_sign] = $modules;
			$data['modules'] = iserializer($data['modules']);
			pdo_insert('uni_group', $data);
		}
		cache_delete(cache_system_key('uniaccount', array('uniacid' => $uniacid)));
		cache_delete(cache_system_key('unimodules', array('uniacid' => $uniacid, 'enabled' => 1)));
		cache_delete(cache_system_key('unimodules', array('uniacid' => $uniacid, 'enabled' => '')));
		cache_delete(cache_system_key('proxy_wechatpay_account'));
		$cash_index = $sign == 'account' ? 'app' : $sign;
		cache_delete(cache_system_key('user_accounts', array('type' => $cash_index, 'uid' => $_W['uid'])));
		if (!empty($post['owner_uid'])) {
			cache_delete(cache_system_key('user_accounts', array('type' => $cash_index, 'uid' => $post['owner_uid'])));
			cache_build_account_modules($uniacid, $post['owner_uid']);
		}
	}

		$next_url = '';
	if ($sign == ACCOUNT_TYPE_SIGN) {
		$next_url = url('account/post-step', array('uniacid' => $uniacid, 'acid' => $acid, 'step' => 4));
	} elseif ($sign == XZAPP_TYPE_SIGN) {
		$next_url = url('xzapp/post-step', array('uniacid' => $uniacid, 'acid' => $acid, 'step' => 4));
	} elseif (in_array($sign, array(PHONEAPP_TYPE_SIGN, WXAPP_TYPE_SIGN, ALIAPP_TYPE_SIGN, BAIDUAPP_TYPE_SIGN, TOUTIAOAPP_TYPE_SIGN))) {
		$next_url = '';
	} else {
		$next_url = url('account/display/switch', array('uniacid' => $uniacid, 'acid' => $acid, 'type' => $create_account_type));
		iajax(0, '创建成功', $next_url);
	}
	if (!empty($next_url)) {
		iajax(0, '', $next_url);
	}

		if (in_array($sign, array(PHONEAPP_TYPE_SIGN, WXAPP_TYPE_SIGN, ALIAPP_TYPE_SIGN, BAIDUAPP_TYPE_SIGN, TOUTIAOAPP_TYPE_SIGN))) {
				$version = array(
			'uniacid' => $uniacid,
			'description' => safe_gpc_string($_GPC['version_description']),
			'version' => $post['version'],
			'modules' => '',
			'createtime' => TIMESTAMP,
		);
				$module = module_fetch(safe_gpc_string($_GPC['version_module']));
		if (!empty($module)) {
			$version['modules'] = serialize(array($module['name'] => array(
				'name' => $module['name'],
				'version' => $module['version'],
			)));
		}
		if ($sign == WXAPP_TYPE_SIGN) {
			$version['design_method'] = WXAPP_MODULE;
			$version['quickmenu'] = '';
			$version['createtime'] = TIMESTAMP;
			$version['template'] = 0;
			$version['type'] = 0; 			$version['multiid'] = 0;
		}

		pdo_insert('wxapp_versions', $version);
		$version_id = pdo_insertid();

		if (empty($version_id)) {
			iajax(-1, '版本创建失败');
		} else {
			cache_delete(cache_system_key('user_accounts', array('type' => $sign, 'uid' => $_W['uid'])));
			iajax(0, '创建成功', url('account/display/switch', array('uniacid' => $uniacid, 'version_id' => $version_id, 'type' => $create_account_type)));
		}
	}
}

template('account/create');