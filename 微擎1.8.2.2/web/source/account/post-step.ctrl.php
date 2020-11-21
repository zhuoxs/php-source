<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->func('file');
load()->model('module');
load()->model('user');
load()->model('account');
load()->classs('weixin.platform');

$_W['page']['title'] = '添加/编辑公众号 - 公众号管理';
$uniacid = intval($_GPC['uniacid']);
$step = intval($_GPC['step']) ? intval($_GPC['step']) : 1;
$user_create_account_info = permission_user_account_num();

if($step == 1) {
	if ($user_create_account_info['uniacid_limit'] <= 0 && !$_W['isfounder']) {
		$authurl = "javascript:alert('创建公众号已达上限！');";
	}

	if (empty($authurl) && !empty($_W['setting']['platform']['authstate'])) {
		$account_platform = new WeixinPlatform();
		$authurl = $account_platform->getAuthLoginUrl();
	}
} elseif ($step == 2) {
	if (!empty($uniacid)) {
		$state = permission_account_user_role($uid, $uniacid);
		if ($state != ACCOUNT_MANAGE_NAME_FOUNDER && $state != ACCOUNT_MANAGE_NAME_OWNER) {
			itoast('没有该公众号操作权限！', '', '');
		}
		if (is_error($permission = permission_create_account($_W['uid'], 2))) {
			itoast($permission['message'], '' , 'error');
		}
	} else {
		if (empty($_W['isfounder']) && is_error($permission = permission_create_account($_W['uid'], 1))) {
			if (is_error($permission = permission_create_account($_W['uid'], 2))) {
				itoast($permission['message'], '' , 'error');
			}
		}
	}
		if (checksubmit('submit')) {
		if ($user_create_account_info['uniacid_limit'] <= 0 && !$_W['isfounder']) {
			itoast('创建公众号已达上限！');
		}
		$update = array();
		$update['name'] = trim($_GPC['cname']);

		if(empty($update['name'])) {
			itoast('公众号名称必须填写', '', '');
		}
				if (empty($uniacid)) {
			$name = trim($_GPC['cname']);
			$description = trim($_GPC['description']);
			$data = array(
				'name' => $name,
				'description' => $description,
				'title_initial' => get_first_pinyin($name),
				'groupid' => 0,
			);
						$account_table = table('account');
			$account_table->searchWithTitle($name);
			$account_table->searchWithType(ACCOUNT_TYPE_OFFCIAL_NORMAL);
			$check_uniacname = $account_table->searchAccountList();
			if (!empty($check_uniacname)) {
				itoast('该公众号名称已经存在', '', '');
			}
			if (!pdo_insert('uni_account', $data)) {
				itoast('添加公众号失败', '', '');
			}
			$uniacid = pdo_insertid();

						$template = pdo_fetch('SELECT id,title FROM ' . tablename('site_templates') . " WHERE name = 'default'");
			$styles['uniacid'] = $uniacid;
			$styles['templateid'] = $template['id'];
			$styles['name'] = $template['title'] . '_' . random(4);
			pdo_insert('site_styles', $styles);
			$styleid = pdo_insertid();
						$multi['uniacid'] = $uniacid;
			$multi['title'] = $data['name'];
			$multi['styleid'] = $styleid;
			pdo_insert('site_multi', $multi);
			$multi_id = pdo_insertid();

			$unisettings['creditnames'] = array('credit1' => array('title' => '积分', 'enabled' => 1), 'credit2' => array('title' => '余额', 'enabled' => 1));
			$unisettings['creditnames'] = iserializer($unisettings['creditnames']);
			$unisettings['creditbehaviors'] = array('activity' => 'credit1', 'currency' => 'credit2');
			$unisettings['creditbehaviors'] = iserializer($unisettings['creditbehaviors']);
			$unisettings['uniacid'] = $uniacid;
			$unisettings['default_site'] = $multi_id;
			$unisettings['sync'] = iserializer(array('switch' => 0, 'acid' => ''));
			pdo_insert('uni_settings', $unisettings);

			pdo_insert('mc_groups', array('uniacid' => $uniacid, 'title' => '默认会员组', 'isdefault' => 1));
			$fields = pdo_getall('profile_fields');
			foreach($fields as $field) {
				$data = array(
					'uniacid' => $uniacid,
					'fieldid' => $field['id'],
					'title' => $field['title'],
					'available' => $field['available'],
					'displayorder' => $field['displayorder'],
				);
				pdo_insert('mc_member_fields', $data);
			}

		}
		$update['account'] = trim($_GPC['account']);
		$update['original'] = trim($_GPC['original']);
		$update['level'] = intval($_GPC['level']);
		$update['key'] = trim($_GPC['key']);
		$update['secret'] = trim($_GPC['secret']);
		$update['type'] = ACCOUNT_TYPE_OFFCIAL_NORMAL;
		$update['encodingaeskey'] = trim($_GPC['encodingaeskey']);
		
			if (user_is_vice_founder()) {
				uni_user_account_role($uniacid, $_W['uid'], ACCOUNT_MANAGE_NAME_VICE_FOUNDER);
			}
		

		if (empty($acid)) {
			$acid = account_create($uniacid, $update);
			if(is_error($acid)) {
				itoast('添加公众号信息失败', url('account/post-step/', array('uniacid' => $uniacid, 'step' => 2)), 'error');
			}
			pdo_update('uni_account', array('default_acid' => $acid), array('uniacid' => $uniacid));
			if (empty($_W['isfounder'])) {
				uni_user_account_role($uniacid, $_W['uid'], ACCOUNT_MANAGE_NAME_OWNER);
			}
			
				if (!empty($_W['user']['owner_uid'])) {
					uni_user_account_role($uniacid, $_W['user']['owner_uid'], ACCOUNT_MANAGE_NAME_VICE_FOUNDER);
				}
			
		} else {
			pdo_update('account', array('type' => ACCOUNT_TYPE_OFFCIAL_NORMAL, 'hash' => ''), array('acid' => $acid, 'uniacid' => $uniacid));
			unset($update['type']);
			pdo_update('account_wechats', $update, array('acid' => $acid, 'uniacid' => $uniacid));
		}
		if(parse_path($_GPC['qrcode']) && in_array(pathinfo($_GPC['qrcode'], PATHINFO_EXTENSION), $_W['config']['upload']['image']['extentions'])) {
			copy($_GPC['qrcode'], IA_ROOT . '/attachment/qrcode_'.$acid.'.jpg');
		}
		if(parse_path($_GPC['headimg']) && in_array(pathinfo($_GPC['qrcode'], PATHINFO_EXTENSION), $_W['config']['upload']['image']['extentions'])) {
			copy($_GPC['headimg'], IA_ROOT . '/attachment/headimg_'.$acid.'.jpg');
		}
				$oauth = uni_setting($uniacid, array('oauth'));
		if ($acid && !empty($update['key']) && !empty($update['secret']) && empty($oauth['oauth']['account']) && $update['level'] == ACCOUNT_SERVICE_VERIFY) {
			pdo_update('uni_settings', array('oauth' => iserializer(array('account' => $acid, 'host' => $oauth['oauth']['host']))), array('uniacid' => $uniacid));
		}
		cache_delete(cache_system_key('unisetting', array('uniacid' => $uniacid)));
		if (!empty($_GPC['uniacid']) || empty($_W['isfounder'])) {
			header("Location: ".url('account/post-step/', array('uniacid' => $uniacid, 'acid' => $acid, 'step' => 4)));
		} else {
			header("Location: ".url('account/post-step/', array('uniacid' => $uniacid, 'acid' => $acid, 'step' => 3)));
		}
		exit;
	}
}elseif ($step == 3) {
	$acid = intval($_GPC['acid']);
	$uniacid = intval($_GPC['uniacid']);
	if (empty($_W['isfounder'])) {
		itoast('您无权进行该操作！', '', '');
	}
	if ($_GPC['get_type'] == 'userinfo' && $_W['ispost']) {
		$result = array();
		$uid = intval($_GPC['uid'][0]);
		$user = user_single(array('uid' => $uid));
		if (empty($user)) {
			iajax(-1, '用户不存在或是已经被删除', '');
		}
		$result['username'] = $user['username'];
		$result['uid'] = $user['uid'];
		$result['group'] = user_group_detail_info($user['groupid']);
		$result['package'] = iunserializer($result['group']['package']);
		iajax(0, $result, '');
		exit;
	}
	if (checksubmit('submit')) {
				$uid = intval($_GPC['uid']);
		$groupid = intval($_GPC['groupid']);
		if (!empty($uid)) {
						$create_account_info = permission_user_account_num($uid);
			if ($create_account_info['uniacid_limit'] <= 0 && (!user_is_founder($_W['uid']) || user_is_vice_founder())) {
				itoast("您所设置的主管理员所在的用户组可添加的公众号数量已达上限，请选择其他人做主管理员！", referer(), 'error');
			}
			pdo_delete('uni_account_users', array('uniacid' => $uniacid, 'uid' => $uid));
			$owner = pdo_get('uni_account_users', array('uniacid' => $uniacid, 'role' => 'owner'));
			if (!empty($owner)) {
				pdo_update('uni_account_users', array('uid' => $uid), array('uniacid' => $uniacid, 'role' => 'owner'));
			} else {
				uni_user_account_role($uniacid, $uid, ACCOUNT_MANAGE_NAME_OWNER);
			}
			$user_vice_id = pdo_getcolumn('users', array('uid' => $uid), 'owner_uid');
			
				if ($_W['user']['founder_groupid'] != ACCOUNT_MANAGE_GROUP_VICE_FOUNDER && !empty($user_vice_id)) {
					uni_user_account_role($uniacid, $user_vice_id, ACCOUNT_MANAGE_NAME_VICE_FOUNDER);
				}
			
		}
		if (!empty($_GPC['signature'])) {
			$signature = trim($_GPC['signature']);
			$setting = pdo_get('uni_settings', array('uniacid' => $_W['uniacid']));
			$notify = iunserializer($setting['notify']);
			$notify['sms']['signature'] = $signature;

			uni_setting_save('notify', $notify);
			$notify = serialize($notify);
			pdo_update('uni_settings', array('notify' => $notify), array('uniacid' => $uniacid));
		}
		$user = array(
			'uid' => $uid,
			'groupid' => $groupid,
		);
		if ($_GPC['is-set-endtime'] == 1 && !empty($_GPC['endtime'])) {
			$user['endtime'] = strtotime($_GPC['endtime']);
		} else {
			$user['endtime'] = 0;
		}
		if (!empty($user)) {
			user_update($user);
		}
				pdo_delete('uni_account_group', array('uniacid' => $uniacid));
		if (!empty($_GPC['package'])) {
			$group = pdo_get('users_group', array('id' => $groupid));
			$group['package'] = iunserializer($group['package']);
			if (!is_array($group['package']) || !in_array('-1', $group['package'])) {
				foreach ($_GPC['package'] as $packageid) {
					if (!empty($packageid)) {
						pdo_insert('uni_account_group', array(
							'uniacid' => $uniacid,
							'groupid' => $packageid,
						));
					}
				}
			}
		}
				if (!empty($_GPC['extra']['modules']) || !empty($_GPC['extra']['templates'])) {
			$data = array(
				'modules' => array('modules' => array(), 'wxapp' => array(), 'webapp' => array(), 'xzapp' => array(), 'phoneapp' => array()),
				'templates' => iserializer($_GPC['extra']['templates']),
				'uniacid' => $uniacid,
				'name' => '',
			);
			$account = pdo_get('account', array('uniacid' => $uniacid));
			if (empty($account)) {
				itoast('无效的 uniacid', '', '');
			}
			switch ($account['type']) {
				case ACCOUNT_TYPE_OFFCIAL_NORMAL:
				case ACCOUNT_TYPE_OFFCIAL_AUTH:
					$data['modules']['modules'] = $_GPC['extra']['modules'];
					break;
				case ACCOUNT_TYPE_APP_NORMAL:
				case ACCOUNT_TYPE_APP_AUTH:
				case ACCOUNT_TYPE_WXAPP_WORK:
					$data['modules']['wxapp'] = $_GPC['extra']['modules'];
					break;
				case ACCOUNT_TYPE_WEBAPP_NORMAL:
					$data['modules']['webapp'] = $_GPC['extra']['modules'];
					break;
				case ACCOUNT_TYPE_XZAPP_NORMAL:
				case ACCOUNT_TYPE_XZAPP_AUTH:
					$data['modules']['xzapp'] = $_GPC['extra']['modules'];
					break;
				case ACCOUNT_TYPE_PHONEAPP_NORMAL:
					$data['modules']['phoneapp'] = $_GPC['extra']['modules'];
					break;
			}
			$data['modules'] = iserializer($data['modules']);
			$id = pdo_fetchcolumn("SELECT id FROM ".tablename('uni_group')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
			if (empty($id)) {
				pdo_insert('uni_group', $data);
			} else {
				pdo_update('uni_group', $data, array('id' => $id));
			}
		} else {
			pdo_delete('uni_group', array('uniacid' => $uniacid));
		}

		cache_delete(cache_system_key('uniaccount', array('uniacid' => $uniacid)));

		cache_delete(cache_system_key('unimodules', array('uniacid' => $uniacid, 'enabled' => 1)));
		cache_delete(cache_system_key('unimodules', array('uniacid' => $uniacid, 'enabled' => '')));

		cache_delete(cache_system_key('accesstoken', array('acid' => $acid)));

		cache_delete(cache_system_key('proxy_wechatpay_account'));

		cache_clean(cache_system_key('user_accounts'));

		if (!empty($_GPC['from'])) {
			itoast('公众号权限修改成功', url('account/post-step/', array('uniacid' => $uniacid, 'step' => 3, 'from' => 'list')), 'success');
		} else {
			header("Location: ".url('account/post-step/', array('uniacid' => $uniacid, 'acid' => $acid, 'step' => 4)));
			exit;
		}
	}

	$unigroups = uni_groups();

	if(!empty($unigroups['modules'])) {
		foreach ($unigroups['modules'] as $module_key => $module_val) {
			if(file_exists(IA_ROOT.'/addons/'.$module_val['name'].'/icon-custom.jpg')) {
				$unigroups['modules'][$module_key]['logo'] = tomedia(IA_ROOT.'/addons/'.$module_val['name'].'/icon-custom.jpg');
			}else {
				$unigroups['modules'][$module_key]['logo'] = tomedia(IA_ROOT.'/addons/'.$module_val['name'].'/icon.jpg');
			}
		}
	}

	$settings = uni_setting($uniacid, array('notify'));
	$notify = $settings['notify'] ? $settings['notify'] : array();

	$ownerid = pdo_fetchcolumn("SELECT uid FROM ".tablename('uni_account_users')." WHERE uniacid = :uniacid AND role = 'owner'", array(':uniacid' => $uniacid));
	if (!empty($ownerid)) {
		$owner = user_single(array('uid' => $ownerid));
		$owner['group'] = pdo_fetch("SELECT id, name, package FROM ".tablename('users_group')." WHERE id = :id", array(':id' => $owner['groupid']));
		$owner['group']['package'] = iunserializer($owner['group']['package']);
	}

	$extend = pdo_fetch("SELECT * FROM ".tablename('uni_group')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
	$extend['templates'] = iunserializer($extend['templates']);
	$extend['modules'] = iunserializer($extend['modules']);
	if (!empty($extend['modules'])) {
		$extend_modules = $extend['modules'];
		$extend['modules'] = array();
		foreach ($extend_modules as $modulenames) {
			if (!empty($modulenames)) {
				$extend['modules'] = array_merge($extend['modules'], $modulenames);
			}
		}
		$owner['extend']['modules'] = pdo_getall('modules', array('name' => $extend['modules']));
		if (!empty($owner['extend']['modules'])) {
			foreach ($owner['extend']['modules'] as &$extend_module) {
				if (file_exists(IA_ROOT.'/addons/'.$extend_module['name'].'/icon-custom.jpg')) {
					$extend_module['logo'] = tomedia(IA_ROOT.'/addons/'.$extend_module['name'].'/icon-custom.jpg');
				} else {
					$extend_module['logo'] = tomedia(IA_ROOT.'/addons/'.$extend_module['name'].'/icon.jpg');
				}
			}
			unset($extend_module);
		}
	}
	if (!empty($extend['templates'])) {
		$owner['extend']['templates'] = pdo_getall('site_templates', array('id' => $extend['templates']));
	}
	$extend['package'] = pdo_getall('uni_account_group', array('uniacid' => $uniacid), array(), 'groupid');
	$groups = user_group();
	$modules = user_modules($_W['uid']);
	$modules = array_filter($modules, function($module) {
		return empty($module['issystem']);
	});
	$templates  = pdo_fetchall("SELECT * FROM ".tablename('site_templates'));
} elseif($step == 4) {
	$uniacid = intval($_GPC['uniacid']);
	$acid = intval($_GPC['acid']);
	$uni_account = pdo_get('uni_account', array('uniacid' => $uniacid));
	if (empty($uni_account)) {
		itoast('非法访问', '', '');
	}
	$account = account_fetch($uni_account['default_acid']);
}
template('account/post-step' . $template_show);