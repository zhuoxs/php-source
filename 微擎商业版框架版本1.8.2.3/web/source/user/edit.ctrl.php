<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('user');
load()->func('file');
load()->func('cache');
load()->model('visit');

$dos = array('edit_base', 'edit_modules_tpl', 'edit_account', 'edit_users_permission');
$do = in_array($do, $dos) ? $do: 'edit_base';

$_W['page']['title'] = '编辑用户 - 用户管理';

$uid = intval($_GPC['uid']);
$user = user_single($uid);
if (empty($user)) {
	itoast('访问错误, 未找到该操作员.', url('user/display'), 'error');
}

$founders = explode(',', $_W['config']['setting']['founder']);
$profile = pdo_get('users_profile', array('uid' => $uid));
if (!empty($profile)) $profile['avatar'] = tomedia($profile['avatar']);

if ($do == 'edit_base') {
	$account_num = permission_user_account_num($uid);
	$user['last_visit'] = date('Y-m-d H:i:s', $user['lastvisit']);
	$user['joindate'] = date('Y-m-d H:i:s', $user['joindate']);
	$user['end'] = $user['endtime'] == 0 ? '永久' : date('Y-m-d', $user['endtime']);
	$user['endtype'] = $user['endtime'] == 0 ? 1 : 2;
	$user['url'] = user_invite_register_url($uid);

	$profile = user_detail_formate($profile);
	
	$table = table('core_profile_fields');
	$extra_fields = $table->getExtraFields();
	template('user/edit-base');
}
if ($do == 'edit_modules_tpl') {
	if ($_W['isajax'] && $_W['ispost']) {
		if ($user['status'] == USER_STATUS_CHECK || $user['status'] == USER_STATUS_BAN) {
			iajax(-1, '访问错误，该用户未审核或者已被禁用，请先修改用户状态！', '');
		}
		if (intval($_GPC['groupid']) == $user['groupid']){
			iajax(2, '未做更改！');
		}
		if (!empty($_GPC['type']) && !empty($_GPC['groupid'])) {
			$data['uid'] = $uid;
			$data[$_GPC['type']] = intval($_GPC['groupid']);
			$group_info = user_group_detail_info($_GPC['groupid']);
			$timelimit = intval($group_info['timelimit']);
			if ($timelimit > 0) {
				$data['endtime'] = strtotime($timelimit . ' days');
			} else {
				$data['endtime'] = 0;
			}
			if (user_update($data)) {
				cache_delete(cache_system_key('user_modules', array('uid' => $uid)));
				visit_system_delete($uid);
				iajax(0, $group_info, '');
			} else {
				iajax(1, '更改失败！', '');
			}
		} else {
			iajax(-1, '参数错误！', '');
		}
	}

	$modules = user_modules($_W['uid']);
	$templates = pdo_getall('site_templates', array(), array('id', 'name', 'title'));

	$groups = user_group();
	$group_info = user_group_detail_info($user['groupid']);

	$extend_permission = pdo_get('uni_group', array('uid' => $uid, 'uniacid' => 0));
	$extend_permission['templates'] = (array)iunserializer($extend_permission['templates']);
	$extend_permission['modules'] = iunserializer($extend_permission['modules']);

	if (!empty($templates) && !empty($extend_permission['templates'])) {
		foreach ($templates as $k => $temp) {
			if (in_array($temp['id'], $extend_permission['templates'])) {
				$templates[$k]['checked'] = 1;
			}
		}
	}

	$extend = array();
	if (!empty($extend_permission['templates'])) {
		$extend['templates'] = pdo_getall('site_templates', array('id' => $extend_permission['templates']), array('id', 'name', 'title'));
	}
	if (!empty($extend_permission['modules'])) {
		foreach ($extend_permission['modules'] as $type => $modulenames) {
			foreach ($modulenames as $name) {
				$module = module_fetch($name);
				if (!empty($module)) {
					if ($type == 'modules' && $module[MODULE_SUPPORT_ACCOUNT_NAME] == MODULE_SUPPORT_ACCOUNT) {
						$extend[$type.'_modules'][$name] = $module;
					}
					if ($type == 'wxapp' && $module[MODULE_SUPPORT_WXAPP_NAME] == MODULE_SUPPORT_WXAPP) {
						$extend[$type.'_modules'][$name] = $module;
					}
					if ($type == 'webapp' && $module[MODULE_SUPPORT_WEBAPP_NAME] == MODULE_SUPPORT_WEBAPP) {
						$extend[$type.'_modules'][$name] = $module;
					}
					if ($type == 'phoneapp' && $module[MODULE_SUPPORT_PHONEAPP_NAME] == MODULE_SUPPORT_PHONEAPP) {
						$extend[$type.'_modules'][$name] = $module;
					}
					if ($type == 'xzapp' && $module[MODULE_SUPPORT_XZAPP_NAME] == MODULE_SUPPORT_XZAPP) {
						$extend[$type.'_modules'][$name] = $module;
					}
				}
			}
		}
	}
	$user_modules = array('account' => array(), 'wxapp' => array(), 'webapp' => array(), 'phoneapp' => array(), 'xzapp' => array());
	if (!empty($modules)) {
		foreach ($modules as $item) {
			if ($item['issystem'] == 0) {
				if ($item[MODULE_SUPPORT_ACCOUNT_NAME] == MODULE_SUPPORT_ACCOUNT) {
					if (!empty($extend_permission['modules']['modules']) && in_array($item['name'], $extend_permission['modules']['modules'])) {
						$item['checked'] = 1;
					}
					$user_modules['account'][] = $item;
					$item['checked'] = 0;
				}
				if ($item[MODULE_SUPPORT_WXAPP_NAME] == MODULE_SUPPORT_WXAPP) {
					if (!empty($extend_permission['modules']['wxapp']) && in_array($item['name'], $extend_permission['modules']['wxapp'])) {
						$item['checked'] = 1;
					}
					$user_modules['wxapp'][] = $item;
					$item['checked'] = 0;
				}
				if ($item[MODULE_SUPPORT_WEBAPP_NAME] == MODULE_SUPPORT_WEBAPP) {
					if (!empty($extend_permission['modules']['webapp']) && in_array($item['name'], $extend_permission['modules']['webapp'])) {
						$item['checked'] = 1;
					}
					$user_modules['webapp'][] = $item;
					$item['checked'] = 0;
				}
				if ($item[MODULE_SUPPORT_PHONEAPP_NAME] == MODULE_SUPPORT_PHONEAPP) {
					if (!empty($extend_permission['modules']['phoneapp']) && in_array($item['name'], $extend_permission['modules']['phoneapp'])) {
						$item['checked'] = 1;
					}
					$user_modules['phoneapp'][] = $item;
					$item['checked'] = 0;
				}
				if ($item[MODULE_SUPPORT_XZAPP_NAME] == MODULE_SUPPORT_XZAPP) {
					if (!empty($extend_permission['modules']['xzapp']) && in_array($item['name'], $extend_permission['modules']['xzapp'])) {
						$item['checked'] = 1;
					}
					$user_modules['xzapp'][] = $item;
					$item['checked'] = 0;
				}
			}
		}
	}

	template('user/edit-modules-tpl');
}

if ($do == 'edit_account') {
	$account_detail = user_account_detail_info($uid);
	template('user/edit-account');
}

if ($do == 'edit_users_permission') {
	if ($_W['isajax'] && $_W['ispost']) {
		$module = $_GPC['module'];
		$tpl = $_GPC['tpl'];

		if (!empty($module) || !empty($tpl)) {
			$data = array(
				'modules' => iserializer(array(
					'modules' => empty($module['modules']) ? array() : $module['modules'],
					'wxapp' => empty($module['wxapp']) ? array() : $module['wxapp'],
					'webapp' => empty($module['webapp']) ? array(): $module['webapp'],
					'xzapp' => empty($module['xzapp']) ? array() : $module['xzapp'],
					'phoneapp' => empty($module['phoneapp']) ? array() : $module['phoneapp']
				)),
				'templates' => empty($tpl) ? '' : iserializer($tpl),
				'uid' => $uid,
				'uniacid' => 0,
				'owner_uid' => 0,
				'name' => '',
			);
			$id = pdo_fetchcolumn("SELECT id FROM " . tablename('uni_group') . " WHERE uid=:uid and uniacid=:uniacid", array(":uniacid" => 0, ":uid" => $uid));
			if (empty($id)) {
				$res = pdo_insert('uni_group', $data);
			} else {
				$res = pdo_update('uni_group', $data, array('id' => $id));
			}
		} else {
			$res = pdo_delete('uni_group', array('uid' => $uid, 'uniacid' => 0));
		}
		if ($res === false) {
			iajax(-1, '修改失败', '');
		} else {
			iajax(0, '修改成功', '');
		}
	}
}
