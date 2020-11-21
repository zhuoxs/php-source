<?php

/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
function cache_build_template() {
	load()->func('file');
	rmdirs(IA_ROOT . '/data/tpl', true);
}


function cache_build_setting() {
	$sql = "SELECT * FROM " . tablename('core_settings');
	$setting = pdo_fetchall($sql, array(), 'key');
	if (is_array($setting)) {
		foreach ($setting as $k => $v) {
			$setting[$v['key']] = iunserializer($v['value']);
		}
		cache_write(cache_system_key('setting'), $setting);
	}
}


function cache_build_account_modules($uniacid = 0, $uid = 0) {
	$uniacid = intval($uniacid);
	if (empty($uniacid)) {
				cache_clean(cache_system_key('unimodules'));
		if (!empty($uid)) {
			cache_delete(cache_system_key('user_modules', array('uid' => $uid)));
		} else {
			cache_clean(cache_system_key('user_modules'));
		}
	} else {
		cache_delete(cache_system_key('unimodules', array('uniacid' => $uniacid, 'enabled' => 1)));
		cache_delete(cache_system_key('unimodules', array('uniacid' => $uniacid, 'enabled' => '')));
		if (empty($uid)) {
			$uid = table('account')->searchWithUniacid($uniacid)->searchWithRole('owner')->getOwnerUid();
		}
		cache_delete(cache_system_key('user_modules', array('uid' => $uid)));
	}
}


function cache_build_account($uniacid = 0) {
	global $_W;
	$uniacid = intval($uniacid);
	if (empty($uniacid)) {
		$uniacid_arr = pdo_fetchall("SELECT uniacid FROM " . tablename('uni_account'));
		foreach($uniacid_arr as $account){
			cache_delete(cache_system_key('uniaccount', array('uniacid' => $account['uniacid'])));
			cache_delete(cache_system_key('defaultgroupid', array('uniacid' => $account['uniacid'])));
		}
	} else {
		cache_delete(cache_system_key('uniaccount', array('uniacid' => $uniacid)));
		cache_delete(cache_system_key('defaultgroupid', array('uniacid' => $uniacid)));
	}

}


function cache_build_memberinfo($uid) {
	$uid = intval($uid);
	cache_delete(cache_system_key('memberinfo', array('uid' => $uid)));
	return true;
}


function cache_build_users_struct() {
	$base_fields = array(
		'uniacid' => '同一公众号id',
		'groupid' => '分组id',
		'credit1' => '积分',
		'credit2' => '余额',
		'credit3' => '预留积分类型3',
		'credit4' => '预留积分类型4',
		'credit5' => '预留积分类型5',
		'credit6' => '预留积分类型6',
		'createtime' => '加入时间',
		'mobile' => '手机号码',
		'email' => '电子邮箱',
		'realname' => '真实姓名',
		'nickname' => '昵称',
		'avatar' => '头像',
		'qq' => 'QQ号',
		'gender' => '性别',
		'birth' => '生日',
		'constellation' => '星座',
		'zodiac' => '生肖',
		'telephone' => '固定电话',
		'idcard' => '证件号码',
		'studentid' => '学号',
		'grade' => '班级',
		'address' => '地址',
		'zipcode' => '邮编',
		'nationality' => '国籍',
		'reside' => '居住地',
		'graduateschool' => '毕业学校',
		'company' => '公司',
		'education' => '学历',
		'occupation' => '职业',
		'position' => '职位',
		'revenue' => '年收入',
		'affectivestatus' => '情感状态',
		'lookingfor' => ' 交友目的',
		'bloodtype' => '血型',
		'height' => '身高',
		'weight' => '体重',
		'alipay' => '支付宝帐号',
		'msn' => 'MSN',
		'taobao' => '阿里旺旺',
		'site' => '主页',
		'bio' => '自我介绍',
		'interest' => '兴趣爱好',
		'password' => '密码',
		'pay_password' => '支付密码',
	);
	cache_write(cache_system_key('userbasefields'), $base_fields);
	$fields = table('core_profile_fields')->getProfileFields();
	if (!empty($fields)) {
		foreach ($fields as &$field) {
			$field = $field['title'];
		}
		$fields['uniacid'] = '同一公众号id';
		$fields['groupid'] = '分组id';
		$fields['credit1'] ='积分';
		$fields['credit2'] = '余额';
		$fields['credit3'] = '预留积分类型3';
		$fields['credit4'] = '预留积分类型4';
		$fields['credit5'] = '预留积分类型5';
		$fields['credit6'] = '预留积分类型6';
		$fields['createtime'] = '加入时间';
		$fields['password'] = '用户密码';
		$fields['pay_password'] = '支付密码';
		cache_write(cache_system_key('usersfields'), $fields);
	} else {
		cache_write(cache_system_key('usersfields'), $base_fields);
	}
}

function cache_build_frame_menu() {
	global $_W;
	$system_menu_db = pdo_getall('core_menu', array('permission_name !=' => ''), array(), 'permission_name');
	$account = pdo_get('account', array('uniacid' => $_W['uniacid']));
	$system_menu = require IA_ROOT . '/web/common/frames.inc.php';
	if (!empty($system_menu) && is_array($system_menu)) {
		$system_displayoder = 1;
		foreach ($system_menu as $menu_name => $menu) {
			$system_menu[$menu_name]['is_system'] = true;
			$system_menu[$menu_name]['is_display'] = !empty($system_menu_db[$menu_name]['is_display']) ? true : ((isset($system_menu[$menu_name]['is_display']) && empty($system_menu[$menu_name]['is_display']) || !empty($system_menu_db[$menu_name])) ? false : true);
			$system_menu[$menu_name]['displayorder'] = !empty($system_menu_db[$menu_name]) ? intval($system_menu_db[$menu_name]['displayorder']) : ++$system_displayoder;
			if ($_W['role'] == ACCOUNT_MANAGE_NAME_EXPIRED && $menu_name != 'store' && $menu_name != 'system') {
				$system_menu[$menu_name]['is_display'] = false;
			}
			if ($menu_name == 'appmarket') {
				$system_menu[$menu_name]['is_display'] = true;
			}
			foreach ($menu['section'] as $section_name => $section) {
				$displayorder = max(count($section['menu']), 1);

								if (empty($section['menu'])) {
					$section['menu'] = array();
				}
				$add_menu = pdo_getall('core_menu', array('group_name' => $section_name), array(
					'id', 'title', 'url', 'is_display', 'is_system', 'permission_name', 'displayorder', 'icon',
				), 'permission_name', 'displayorder DESC');
				if (!empty($add_menu)) {
					foreach ($add_menu as $permission_name => $menu) {
						$menu['icon'] = !empty($menu['icon']) ? $menu['icon'] : 'wi wi-appsetting';
						$section['menu'][$permission_name] = $menu;
					}
				}
				$section_hidden_menu_count = 0;
				foreach ($section['menu']  as $permission_name => $sub_menu) {
					$sub_menu_db = $system_menu_db[$sub_menu['permission_name']];
					$system_menu[$menu_name]['section'][$section_name]['menu'][$permission_name] = array(
						'is_system' => isset($sub_menu['is_system']) ? $sub_menu['is_system'] : 1,
						'is_display' => isset($sub_menu_db['is_display']) ? $sub_menu_db['is_display'] : ((isset($sub_menu['is_display']) && (empty($sub_menu['is_display']) || (is_array($sub_menu['is_display']) && !in_array($account['type'], $sub_menu['is_display'])))) ? 0 : 1),
						'title' => !empty($sub_menu_db['title']) ? $sub_menu_db['title'] : $sub_menu['title'],
						'url' => $sub_menu['url'],
						'permission_name' => $sub_menu['permission_name'],
						'icon' => $sub_menu['icon'],
						'displayorder' => !empty($sub_menu_db['displayorder']) ? $sub_menu_db['displayorder'] : $displayorder,
						'id' => $sub_menu['id'],
						'sub_permission' => $sub_menu['sub_permission'],
					);
					$displayorder--;
					$displayorder = max($displayorder, 0);
					if (empty($system_menu[$menu_name]['section'][$section_name]['menu'][$permission_name]['is_display'])) {
						$section_hidden_menu_count++;
					}
				}
				if (empty($section['is_display']) && $section_hidden_menu_count == count($section['menu']) && $section_name != 'platform_module') {
					$system_menu[$menu_name]['section'][$section_name]['is_display'] = 0;
				}
				$system_menu[$menu_name]['section'][$section_name]['menu'] = iarray_sort($system_menu[$menu_name]['section'][$section_name]['menu'], 'displayorder', 'desc');
			}
		}
		$add_top_nav = pdo_getall('core_menu', array('group_name' => 'frame', 'is_system <>' => 1), array('title', 'url', 'permission_name', 'displayorder', 'icon', 'is_display'));
		if (!empty($add_top_nav)) {
			foreach ($add_top_nav as $menu) {
				$menu['url'] = strexists($menu['url'], 'http') ?  $menu['url'] : $_W['siteroot'] . $menu['url'];
				$menu['blank'] = true;
				$menu['is_display'] = $menu['is_display'] == 0 ? false : true;;
				$system_menu[$menu['permission_name']] = $menu;
			}
		}
		$system_menu = iarray_sort($system_menu, 'displayorder', 'asc');
		cache_delete(cache_system_key('system_frame', array('uniacid' => $_W['uniacid'])));
		cache_write(cache_system_key('system_frame', array('uniacid' => $_W['uniacid'])), $system_menu);
		return $system_menu;
	}
}

function cache_build_module_subscribe_type() {
	global $_W;
	$modules = table('modules')->getByHasSubscribes();
	if (empty($modules)) {
		return array();
	}
	$subscribe = array();
	foreach ($modules as $module) {
		$module['subscribes'] = iunserializer($module['subscribes']);
		if (!empty($module['subscribes'])) {
			foreach ($module['subscribes'] as $event) {
				if ($event == 'text') {
					continue;
				}
				$subscribe[$event][] = $module['name'];
			}
		}
	}

	$module_ban = $_W['setting']['module_receive_ban'];
	foreach ($subscribe as $event => $module_group) {
		if (!empty($module_group)) {
			foreach ($module_group as $index => $module) {
				if (!empty($module_ban[$module])) {
					unset($subscribe[$event][$index]);
				}
			}
		}
	}
	cache_write(cache_system_key('module_receive_enable'), $subscribe);
	return $subscribe;
}



function cache_build_cloud_ad() {
	global $_W;
	$uniacid_arr = pdo_fetchall("SELECT uniacid FROM " . tablename('uni_account'));
	foreach($uniacid_arr as $account){
		cache_delete(cache_system_key('stat_todaylock', array('uniacid' => $account['uniacid'])));
		cache_delete(cache_system_key('cloud_ad_uniaccount', array('uniacid' => $account['uniacid'])));
		cache_delete(cache_system_key('cloud_ad_app_list', array('uniacid' => $account['uniacid'])));
	}
	cache_delete(cache_system_key('cloud_flow_master'));
	cache_delete(cache_system_key('cloud_ad_uniaccount_list'));
	cache_delete(cache_system_key('cloud_ad_tags'));
	cache_delete(cache_system_key('cloud_ad_type_list'));
	cache_delete(cache_system_key('cloud_ad_app_support_list'));
	cache_delete(cache_system_key('cloud_ad_site_finance'));
}


function cache_build_uninstalled_module() {
	$modulelist = table('modules')->getall('name');

	$module_root = IA_ROOT . '/addons/';
	$module_path_list = glob($module_root . '/*');
	if (empty($module_path_list)) {
		return true;
	}
	foreach ($module_path_list as $path) {
		$modulename = pathinfo($path, PATHINFO_BASENAME);
		if (!empty($modulelist[$modulename])) {
						$module_cloud_upgrade = table('modules_cloud')->getByName($modulename);
			if (!empty($module_cloud_upgrade)) {
				table('modules_cloud')->deleteByName($modulename);
			}
			continue;
		}

		if (!is_dir($path) || !file_exists($path . '/manifest.xml')) {
			continue;
		}

		$manifest = ext_module_manifest($modulename);
		$module_upgrade_data = array(
			'name' => $modulename,
			'has_new_version' => 0,
			'has_new_branch' => 0,
			'install_status' => MODULE_LOCAL_UNINSTALL,
			'logo' => $manifest['application']['logo'],
			'version' => $manifest['application']['version'],
			'title' => $manifest['application']['name'],
			'title_initial' => get_first_pinyin($manifest['application']['name']),
		);

		if (!empty($manifest['platform']['supports'])) {
			foreach (array('app', 'wxapp', 'webapp', 'phoneapp', 'system_welcome', 'xzapp', 'aliapp') as $support) {
				if (in_array($support, $manifest['platform']['supports'])) {
										if ($support == 'app') {
						$support = 'account';
					}
					$module_upgrade_data["{$support}_support"] = MODULE_SUPPORT_ACCOUNT;
				}
			}
		}
		$module_cloud_upgrade = table('modules_cloud')->getByName($modulename);

		if (empty($module_cloud_upgrade)) {
			table('modules_cloud')->fill($module_upgrade_data)->save();
		} else {
			table('modules_cloud')->fill($module_upgrade_data)->where('name', $modulename)->save();
		}
	}
	return true;
}


function cache_build_proxy_wechatpay_account() {
	global $_W;
	load()->model('account');
	if(empty($_W['isfounder'])) {
		$where = " WHERE `uniacid` IN (SELECT `uniacid` FROM " . tablename('uni_account_users') . " WHERE `uid`=:uid)";
		$params[':uid'] = $_W['uid'];
	}
	$sql = "SELECT * FROM " . tablename('uni_account') . $where;
	$uniaccounts = pdo_fetchall($sql, $params);
	$service = array();
	$borrow = array();
	if (!empty($uniaccounts)) {
		foreach ($uniaccounts as $uniaccount) {
			$account = account_fetch($uniaccount['default_acid']);
			$account_setting = pdo_get('uni_settings', array ('uniacid' => $account['uniacid']));
			$payment = iunserializer($account_setting['payment']);
			if (is_array($account) && !empty($account['key']) && !empty($account['secret']) && in_array($account['level'], array (4)) &&
				is_array($payment) && !empty($payment) && intval($payment['wechat']['switch']) == 1) {

				if ((!is_bool ($payment['wechat']['switch']) && $payment['wechat']['switch'] != 4) || (is_bool ($payment['wechat']['switch']) && !empty($payment['wechat']['switch']))) {
					$borrow[$account['uniacid']] = $account['name'];
				}
			}
			if (!empty($payment['wechat_facilitator']['switch'])) {
				$service[$account['uniacid']] = $account['name'];
			}
		}
	}
	$cache = array(
		'service' => $service,
		'borrow' => $borrow
	);
	cache_write(cache_system_key('proxy_wechatpay_account'), $cache);
	return $cache;
}


function cache_build_module_info($module_name) {
	global $_W;
		table('modules_cloud')->deleteByName($module_name);
	cache_delete(cache_system_key('module_info', array('module_name' => $module_name)));
}


function cache_build_uni_group() {
	cache_delete(cache_system_key('uni_groups'));
}
