<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');


function uni_owned($uid = 0, $is_uni_fetch = true) {
	global $_W;
	$uid = intval($uid) > 0 ? intval($uid) : $_W['uid'];
	$uniaccounts = array();

	$user_accounts = uni_user_accounts($uid);
	if (empty($user_accounts)) {
		return $uniaccounts;
	}

	if (!empty($user_accounts) && !empty($is_uni_fetch)) {
		foreach ($user_accounts as &$row) {
			$row = uni_fetch($row['uniacid']);
		}
	}
	return $user_accounts;
}


function uni_user_accounts($uid = 0, $type = 'app') {
	global $_W;
	$uid = intval($uid) > 0 ? intval($uid) : $_W['uid'];
	if (!in_array($type, array('app', 'wxapp', 'webapp', 'phoneapp'))) {
		$type = 'app';
	}
	$type = $type == 'app' ? 'wechats' : $type;
	$cachekey = cache_system_key('user_accounts', array('type' => $type, 'uid' => $uid));
	$cache = cache_load($cachekey);
	if (!empty($cache)) {
		return $cache;
	}
	$select_fields = 'w.acid, w.uniacid, w.name, a.type';
	if (in_array($type, array('wechats', 'wxapp', 'xzapp'))) {
		$select_fields .= ', w.level, w.key, w.secret, w.token';
	}
	$where = '';
	$params = array();
	$user_is_founder = user_is_founder($uid);
	if (empty($user_is_founder) || user_is_vice_founder($uid)) {
		$select_fields .= ', u.role';
		$where .= " LEFT JOIN " . tablename('uni_account_users') . " u ON u.uniacid = w.uniacid WHERE u.uid = :uid AND u.role IN(:role1, :role2) ";
		$params[':uid'] = $uid;
		$params[':role1'] = ACCOUNT_MANAGE_NAME_OWNER;
		$params[':role2'] = ACCOUNT_MANAGE_NAME_VICE_FOUNDER;
	}
	$where .= !empty($where) ? " AND a.isdeleted <> 1 AND u.role IS NOT NULL" : " WHERE a.isdeleted <> 1";

	$sql = "SELECT " . $select_fields . " FROM " . tablename('account_' . $type) . " w LEFT JOIN " . tablename('account') . " a ON a.acid = w.acid AND a.uniacid = w.uniacid" . $where;
	$result = pdo_fetchall($sql, $params, 'uniacid');
	cache_write($cachekey, $result);
	return $result;
}


function account_owner($uniacid = 0) {
	global $_W;
	load()->model('user');
	$uniacid = intval($uniacid);
	if (empty($uniacid)) {
		return array();
	}
	$ownerid = pdo_getcolumn('uni_account_users', array('uniacid' => $uniacid, 'role' => 'owner'), 'uid');
	if (empty($ownerid)) {
		$ownerid = pdo_getcolumn('uni_account_users', array('uniacid' => $uniacid, 'role' => 'vice_founder'), 'uid');
		if (empty($ownerid)) {
			$founders = explode(',', $_W['config']['setting']['founder']);
			$ownerid = $founders[0];
		}
	}
	$owner = user_single($ownerid);
	if (empty($owner)) {
		return array();
	}
	return $owner;
}

function uni_accounts($uniacid = 0) {
	global $_W;
	$uniacid = empty($uniacid) ? $_W['uniacid'] : intval($uniacid);
	$account_info = pdo_get('account', array('uniacid' => $uniacid));
	if (!empty($account_info)) {
		$accounts = pdo_fetchall("SELECT w.*, a.type, a.isconnect FROM " . tablename('account') . " a INNER JOIN " . tablename(uni_account_tablename($account_info['type'])) . " w USING(acid) WHERE a.uniacid = :uniacid AND a.isdeleted <> 1 ORDER BY a.acid ASC", array(':uniacid' => $uniacid), 'acid');
	}
	return !empty($accounts) ? $accounts : array();
}


function uni_fetch($uniacid = 0) {
	global $_W;
	load()->model('mc');

	$uniacid = empty($uniacid) ? $_W['uniacid'] : intval($uniacid);
	$cachekey = cache_system_key('uniaccount', array('uniacid' => $uniacid));
	$cache = cache_load($cachekey);
	if (!empty($cache)) {
		return $cache;
	}

	$acid = table('account')->getAccountByUniacid($uniacid);
	if (empty($acid)) {
		return false;
	}
	$account_api = WeAccount::create($acid['acid']);

	if (is_error($account_api)) {
		return $account_api;
	}
	$account = $account_api->account;
	if (empty($account) || $account['isdeleted'] == 1) {
		return array();
	}
			$owner = account_owner($uniacid);

	$account['type_sign'] = $account_api->typeSign;
	$account['uid'] = $owner['uid'];
	$account['starttime'] = $owner['starttime'];
	if (!empty($account['endtime'])) {
		$account['endtime'] = $account['endtime'] == '-1' ? 0 : $account['endtime'];
	} else {
		$account['endtime'] = $owner['endtime'];
	}

	$account['groups'] = mc_groups($uniacid);
	$account['setting'] = uni_setting($uniacid);
	$account['grouplevel'] = $account['setting']['grouplevel'];
	$account['logo'] = tomedia('headimg_'.$account['acid']. '.jpg').'?time='.time();
	$account['qrcode'] = tomedia('qrcode_'.$account['acid']. '.jpg').'?time='.time();
	$account['type_name'] = $account_api->typeName;

		$account['switchurl'] = wurl('account/display/switch', array('uniacid' => $account['uniacid']));
		if (!empty($account['settings']['notify'])) {
		$account['sms'] = $account['setting']['notify']['sms']['balance'];
	} else {
		$account['sms'] = 0;
	}
		$account['setmeal'] = uni_setmeal($account['uniacid']);

	cache_write($cachekey, $account);
	return $account;
}


function uni_site_store_buy_goods($uniacid, $type = STORE_TYPE_MODULE) {
	$cachekey = cache_system_key('site_store_buy', array('type' => $type, 'uniacid' => $uniacid));
	$site_store_buy_goods = cache_load($cachekey);
	if (!empty($site_store_buy_goods)) {
		return $site_store_buy_goods;
	}
	$store_table = table('store');
	if ($type != STORE_TYPE_API) {
		$store_table->searchWithEndtime();
		$site_store_buy_goods = $store_table->searchAccountBuyGoods($uniacid, $type);
		$site_store_buy_goods = array_keys($site_store_buy_goods);
	} else {
		$site_store_buy_goods = $store_table->searchAccountBuyGoods($uniacid, $type);
		$setting = uni_setting_load('statistics', $uniacid);
		$use_number = isset($setting['statistics']['use']) ? intval($setting['statistics']['use']) : 0;
		$site_store_buy_goods = $site_store_buy_goods - $use_number;
	}
	cache_write($cachekey, $site_store_buy_goods);
	return $site_store_buy_goods;
}



function uni_modules_by_uniacid($uniacid, $enabled = true) {
	global $_W;
	load()->model('user');
	load()->model('module');
	$account_info = uni_fetch($uniacid);
	$founders = explode(',', $_W['config']['setting']['founder']);
	$owner_uid = pdo_getall('uni_account_users',  array('uniacid' => $uniacid, 'role' => array('owner', 'vice_founder')), array('uid', 'role'), 'role');
	$owner_uid = !empty($owner_uid['owner']) ? $owner_uid['owner']['uid'] : (!empty($owner_uid['vice_founder']) ? $owner_uid['vice_founder']['uid'] : 0);

	$cachekey = cache_system_key('unimodules', array('uniacid' => $uniacid, 'enabled' => $enabled == true ? 1 : ''));
	$modules = cache_load($cachekey);
	if (empty($modules)) {
		$condition = "WHERE 1";

		if (!empty($owner_uid) && !in_array($owner_uid, $founders)) {
						$group_modules = table('account')->accountGroupModules($uniacid, $type);
						
				$goods_type = 0;
				switch ($account_info['type']) {
					case ACCOUNT_TYPE_OFFCIAL_NORMAL:
					case ACCOUNT_TYPE_OFFCIAL_AUTH:
						$goods_type = STORE_TYPE_MODULE;
						break;
					case ACCOUNT_TYPE_APP_NORMAL:
					case ACCOUNT_TYPE_APP_AUTH:
					case ACCOUNT_TYPE_WXAPP_WORK:
						$goods_type = STORE_TYPE_WXAPP_MODULE;
						break;
				}
				if ($goods_type) {
					$site_store_buy_goods = uni_site_store_buy_goods($uniacid, $goods_type);
					if (!empty($site_store_buy_goods)) {
						$group_modules = array_merge($group_modules, $site_store_buy_goods);
					}
				}
			
						$user_modules = user_modules($owner_uid);
			if (!empty($user_modules)) {
				$group_modules = array_merge($group_modules, array_keys($user_modules));
			}
			if (!empty($group_modules)) {
				foreach ($group_modules as $key => $val) {
					$params[':module_' . intval($key)] = safe_gpc_string($val);
				}
				$condition .= " AND a.name IN (" . implode(',', array_keys($params)) . ")";
			} else {
				$condition .= " AND a.name = ''";
			}
		}
		$condition .= $enabled ?  " AND (b.enabled = 1 OR b.enabled is NULL) OR a.issystem = 1" : " OR a.issystem = 1";
		$params[':uniacid'] = $uniacid;
		$sql = "SELECT a.name FROM " . tablename('modules') . " AS a LEFT JOIN " . tablename('uni_account_modules') . " AS b ON a.name = b.module AND b.uniacid = :uniacid " . $condition . " ORDER BY b.displayorder DESC, b.id DESC";
		$modules = pdo_fetchall($sql, $params, 'name');
		cache_write($cachekey, $modules);
	}

	$module_list = array();
	if (!empty($modules)) {
		foreach ($modules as $name => $module) {

			$module_info = module_fetch($name);

						if ($module_info[MODULE_SUPPORT_ACCOUNT_NAME] != MODULE_SUPPORT_ACCOUNT &&
				in_array($account_info['type'], array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH))) {
				continue;
			}
			if ($module_info[MODULE_SUPPORT_WEBAPP_NAME] != MODULE_SUPPORT_WEBAPP &&
				in_array($account_info['type'], array(ACCOUNT_TYPE_WEBAPP_NORMAL))) {
				continue;
			}
			if ($module_info[MODULE_SUPPORT_PHONEAPP_NAME] != MODULE_SUPPORT_PHONEAPP &&
				in_array($account_info['type'], array(ACCOUNT_TYPE_PHONEAPP_NORMAL))) {
				continue;
			}
			if ($module_info[MODULE_SUPPORT_XZAPP_NAME] != MODULE_SUPPORT_XZAPP &&
				in_array($account_info['type'], array(ACCOUNT_TYPE_XZAPP_NORMAL, ACCOUNT_TYPE_XZAPP_AUTH))) {
				continue;
			}
			if ($module_info[MODULE_SUPPORT_ALIAPP_NAME] != MODULE_SUPPORT_ALIAPP &&
				in_array($account_info['type'], array(ACCOUNT_TYPE_ALIAPP_NORMAL))) {
				continue;
			}
			if ($module_info[MODULE_SUPPORT_WXAPP_NAME] != MODULE_SUPPORT_WXAPP &&
				$module_info[MODULE_SUPPORT_ACCOUNT_NAME] != MODULE_SUPPORT_ACCOUNT &&
				in_array($account_info['type'], array(ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_APP_AUTH))) {
				continue;
			}
			if ($module_info[MODULE_SUPPORT_SYSTEMWELCOME_NAME] == MODULE_SUPPORT_SYSTEMWELCOME &&
				$module_info[MODULE_SUPPORT_ACCOUNT_NAME] != MODULE_SUPPORT_ACCOUNT &&
				$module_info[MODULE_SUPPORT_WEBAPP_NAME] != MODULE_SUPPORT_WEBAPP &&
				$module_info[MODULE_SUPPORT_PHONEAPP_NAME] != MODULE_SUPPORT_PHONEAPP &&
				$module_info[MODULE_SUPPORT_ALIAPP_NAME] != MODULE_SUPPORT_ALIAPP &&
				$module_info[MODULE_SUPPORT_WXAPP_NAME] != MODULE_SUPPORT_WXAPP) {
				continue;
			}
			if (!empty($module_info)) {
				$module_list[$name] = $module_info;
			}
		}
	}
	$module_list['core'] = array('title' => '系统事件处理模块', 'name' => 'core', 'issystem' => 1, 'enabled' => 1, 'isdisplay' => 0);
	return $module_list;
}


function uni_modules_list($uniacid, $enabled = true, $type = '') {
	global $_W;
	load()->model('user');
	load()->model('module');
	if ($type == '') {
		$account_info = uni_fetch($uniacid);
		$type = $account_info['type'];
	}

	$founders = explode(',', $_W['config']['setting']['founder']);
	$owner_uid = pdo_getcolumn('uni_account_users',  array('uniacid' => $uniacid, 'role' => 'owner'), 'uid');

	$condition = "WHERE 1";
	if (!empty($owner_uid) && !in_array($owner_uid, $founders)) {
				$group_modules = table('account')->accountGroupModules($uniacid);
				
			$goods_type = 0;
			switch ($type) {
				case ACCOUNT_TYPE_OFFCIAL_NORMAL:
				case ACCOUNT_TYPE_OFFCIAL_AUTH:
					$goods_type = STORE_TYPE_MODULE;
					break;
				case ACCOUNT_TYPE_APP_NORMAL:
				case ACCOUNT_TYPE_APP_AUTH:
				case ACCOUNT_TYPE_WXAPP_WORK:
					$goods_type = STORE_TYPE_WXAPP_MODULE;
					break;
			}
			if ($goods_type) {
				$site_store_buy_goods = uni_site_store_buy_goods($uniacid, $goods_type);
				if (!empty($site_store_buy_goods)) {
					$group_modules = array_merge($group_modules, $site_store_buy_goods);
				}
			}
		
				$user_modules = user_modules($owner_uid);
		if (!empty($user_modules)) {
			$group_modules = array_merge($group_modules, array_keys($user_modules));
		}
		if (!empty($group_modules)) {
			foreach ($group_modules as $key => $val) {
				$params[':module_' . intval($key)] = safe_gpc_string($val);
			}
			$condition .= " AND a.name IN (" . implode(',', array_keys($params)) . ")";
		} else {
			$condition .= " AND a.name = ''";
		}
	}
	$condition .= $enabled ?  " AND (b.enabled = 1 OR b.enabled is NULL) OR a.issystem = 1" : " OR a.issystem = 1";
	$params[':uniacid'] = $uniacid;
	$sql = "SELECT a.name, a.wxapp_support, a.account_support, a.webapp_support, a.phoneapp_support, a.welcome_support, a.xzapp_support, a.mid, a.name, a.type, a.title, a.issystem, a.title_initial, b.enabled FROM " . tablename('modules') . " AS a LEFT JOIN " . tablename('uni_account_modules') . " AS b ON a.name = b.module AND b.uniacid = :uniacid " . $condition . " ORDER BY b.displayorder DESC, b.id DESC";
	$modules = pdo_fetchall($sql, $params, 'name');

	$module_list = array();
	if (!empty($modules)) {
		foreach ($modules as $name => $module) {
			$module_info = $module;
			if (file_exists (IA_ROOT . '/addons/' . $module_info['name'] . '/icon-custom.jpg')) {
				$module_info['logo'] = tomedia (IA_ROOT . '/addons/' . $module_info['name'] . '/icon-custom.jpg') . "?v=" . time ();
			} else {
				$module_info['logo'] = tomedia (IA_ROOT . '/addons/' . $module_info['name'] . '/icon.jpg') . "?v=" . time ();
			}
						if ($module_info[MODULE_SUPPORT_ACCOUNT_NAME] != MODULE_SUPPORT_ACCOUNT &&
				in_array($type, array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH))) {
				continue;
			}

			if ($module_info[MODULE_SUPPORT_WEBAPP_NAME] != MODULE_SUPPORT_WEBAPP &&
				in_array($type, array(ACCOUNT_TYPE_WEBAPP_NORMAL))) {
				continue;
			}

			if ($module_info[MODULE_SUPPORT_PHONEAPP_NAME] != MODULE_SUPPORT_PHONEAPP &&
				in_array($type, array(ACCOUNT_TYPE_PHONEAPP_NORMAL))) {
				continue;
			}

			if ($module_info[MODULE_SUPPORT_XZAPP_NAME] != MODULE_SUPPORT_XZAPP &&
				in_array($type, array(ACCOUNT_TYPE_XZAPP_NORMAL, ACCOUNT_TYPE_XZAPP_AUTH))) {
				continue;
			}

			if ($module_info[MODULE_SUPPORT_ALIAPP_NAME] != MODULE_SUPPORT_ALIAPP &&
				in_array($type, array(ACCOUNT_TYPE_ALIAPP_NORMAL))) {
				continue;
			}

			if ($module_info[MODULE_SUPPORT_WXAPP_NAME] != MODULE_SUPPORT_WXAPP &&
				$module_info[MODULE_SUPPORT_ACCOUNT_NAME] != MODULE_SUPPORT_ACCOUNT &&
				in_array($type, array(ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_APP_AUTH))) {
				continue;
			}

			if ($module_info[MODULE_SUPPORT_SYSTEMWELCOME_NAME] == MODULE_SUPPORT_SYSTEMWELCOME &&
				$module_info[MODULE_SUPPORT_ACCOUNT_NAME] != MODULE_SUPPORT_ACCOUNT &&
				$module_info[MODULE_SUPPORT_WEBAPP_NAME] != MODULE_SUPPORT_WEBAPP &&
				$module_info[MODULE_SUPPORT_PHONEAPP_NAME] != MODULE_SUPPORT_PHONEAPP &&
				$module_info[MODULE_SUPPORT_WXAPP_NAME] != MODULE_SUPPORT_WXAPP) {
				continue;
			}
			if (!empty($module_info)) {
				$module_list[$name] = $module_info;
			}
		}
	}
	$module_list['core'] = array('title' => '系统事件处理模块', 'name' => 'core', 'issystem' => 1, 'enabled' => 1, 'isdisplay' => 0);
	return $module_list;
}



function uni_modules($enabled = true) {
	global $_W;
	return uni_modules_by_uniacid($_W['uniacid'], $enabled);
}

function uni_modules_app_binding() {
	global $_W;
	$cachekey = cache_system_key('unimodules_binding', array('uniacid' => $_W['uniacid']));
	$cache = cache_load($cachekey);
	if (!empty($cache)) {
		return $cache;
	}
	load()->model('module');
	$result = array();
	$modules = uni_modules();
	if(!empty($modules)) {
		foreach($modules as $module) {
			if($module['type'] == 'system') {
				continue;
			}
			$entries = module_app_entries($module['name'], array('home', 'profile', 'shortcut', 'function', 'cover'));
			if(empty($entries)) {
				continue;
			}
			if($module['type'] == '') {
				$module['type'] = 'other';
			}
			$result[$module['name']] = array(
				'name' => $module['name'],
				'type' => $module['type'],
				'title' => $module['title'],
				'entries' => array(
					'cover' => $entries['cover'],
					'home' => $entries['home'],
					'profile' => $entries['profile'],
					'shortcut' => $entries['shortcut'],
					'function' => $entries['function']
				)
			);
			unset($module);
		}
	}
	cache_write($cachekey, $result);
	return $result;
}


function uni_groups($groupids = array(), $show_all = false) {
	load()->model('module');
	global $_W;
	$cachekey = cache_system_key('uni_groups');
	$list = cache_load($cachekey);
	if (empty($list)) {
		$condition = ' WHERE uniacid = 0';
		$list = pdo_fetchall("SELECT * FROM " . tablename('uni_group') . $condition . " ORDER BY id DESC", array(), 'id');
		if (!empty($groupids)) {
			if (in_array('-1', $groupids)) {
				$list[-1] = array('id' => -1, 'name' => '所有服务', 'modules' => array('title' => '系统所有模块'), 'templates' => array('title' => '系统所有模板'));
			}
			if (in_array('0', $groupids)) {
				$list[0] = array('id' => 0, 'name' => '基础服务', 'modules' => array('title' => '系统模块'), 'templates' => array('title' => '系统模板'));
			}
		}

		if (!empty($list)) {
			foreach ($list as $k => &$row) {
				$modules = (array)iunserializer($row['modules']);
				$row['modules'] = $row['wxapp'] = $row['webapp'] = $row['phoneapp'] = $row['xzapp'] = $row['aliapp'] = array();
				if (!empty($modules)) {
					foreach ($modules as $type => $modulenames) {
						if (empty($modulenames) || !is_array($modulenames)) {
							continue;
						}
						foreach ($modulenames as $name) {
							$module = module_fetch($name);
							if (empty($module)) {
								continue;
							}
							switch ($type) {
								case 'modules':
									if ($module[MODULE_SUPPORT_ACCOUNT_NAME] == MODULE_SUPPORT_ACCOUNT) {
										$row['modules'][] = $name;
									}
									break;
								case 'wxapp':
									if ($module[MODULE_SUPPORT_WXAPP_NAME] == MODULE_SUPPORT_WXAPP) {
										$row['wxapp'][] = $name;
									}
									break;
								case 'webapp':
									if ($module[MODULE_SUPPORT_WEBAPP_NAME] == MODULE_SUPPORT_WEBAPP) {
										$row['webapp'][] = $name;
									}
									break;
								case 'xzapp':
									if ($module[MODULE_SUPPORT_XZAPP_NAME] == MODULE_SUPPORT_XZAPP) {
										$row['xzapp'][] = $name;
									}
									break;
								case 'phoneapp':
									if ($module[MODULE_SUPPORT_PHONEAPP_NAME] == MODULE_SUPPORT_PHONEAPP) {
										$row['phoneapp'][] = $name;
									}
									break;
								case 'aliapp':
									if ($module[MODULE_SUPPORT_ALIAPP_NAME] == MODULE_SUPPORT_ALIAPP) {
										$row['aliapp'][] = $name;
									}
									break;
							}
						}
					}
				}

				if (!empty($row['templates'])) {
					$row['templates'] = (array)iunserializer($row['templates']);
					if (!empty($row['templates'])) {
						$row['templates'] = pdo_getall('site_templates', array('id' => $row['templates']), array('id', 'name', 'title'), 'name');
					}
				}
			}
		}

		cache_write($cachekey, $list);
	}
	$group_list = array();
	if (!empty($groupids)) {
		foreach ($groupids as $id) {
			$group_list[$id] = $list[$id];
		}
	} else {
		if (user_is_vice_founder() && empty($show_all)) {
			foreach ($list as $group_key => $group) {
				if ($group['owner_uid'] != $_W['uid']) {
					unset($list[$group_key]);
					continue;
				}
			}
		}
		$group_list = $list;
	}

	$module_section = array('modules', 'phoneapp', 'wxapp', 'webapp', 'xzapp', 'aliapp');
	if (!empty($group_list)) {
		foreach ($group_list as $id => $group) {
			foreach ($module_section as $section) {
				if (!empty($group_list[$id][$section])) {
					$modules = $group_list[$id][$section];
					$group_list[$id][$section] = array();

					foreach ($modules as $modulename) {
						if (is_string($modulename)) {
							$group_list[$id][$section][$modulename] = module_fetch($modulename);
						}
					}
				}
			}
		}
	}
	return $group_list;
}


function uni_templates() {
	global $_W;
	$owneruid = pdo_fetchcolumn("SELECT uid FROM ".tablename('uni_account_users')." WHERE uniacid = :uniacid AND role = 'owner'", array(':uniacid' => $_W['uniacid']));
	load()->model('user');
		$owner = user_single(array('uid' => $owneruid));
	if (empty($owner) || user_is_founder($owner['uid'])) {
		$groupid = '-1';
	} else {
		$groupid = $owner['groupid'];
	}
	$extend = pdo_getall('uni_account_group', array('uniacid' => $_W['uniacid']), array(), 'groupid');
	if (!empty($extend) && $groupid != '-1') {
		$groupid = '-2';
	}
	if (empty($groupid)) {
		$templates = pdo_fetchall("SELECT * FROM " . tablename('site_templates') . " WHERE name = 'default'", array(), 'id');
	} elseif ($groupid == '-1') {
		$templates = pdo_fetchall("SELECT * FROM " . tablename('site_templates') . " ORDER BY id ASC", array(), 'id');
	} else {
		$group = pdo_fetch("SELECT id, name, package FROM ".tablename('users_group')." WHERE id = :id", array(':id' => $groupid));
		$packageids = iunserializer($group['package']);
		if (!empty($extend)) {
			foreach ($extend as $extend_packageid => $row) {
				$packageids[] = $extend_packageid;
			}
		}
		if(is_array($packageids)) {
			if (in_array('-1', $packageids)) {
				$templates = pdo_fetchall("SELECT * FROM " . tablename('site_templates') . " ORDER BY id ASC", array(), 'id');
			} else {
				$wechatgroup = pdo_fetchall("SELECT `templates` FROM " . tablename('uni_group') . " WHERE id IN ('".implode("','", $packageids)."') OR uniacid = '{$_W['uniacid']}'");
				$ms = array();
				$mssql = '';
				if (!empty($wechatgroup)) {
					foreach ($wechatgroup as $row) {
						$row['templates'] = iunserializer($row['templates']);
						if (!empty($row['templates'])) {
							foreach ($row['templates'] as $templateid) {
								$ms[$templateid] = $templateid;
							}
						}
					}
					$ms[] = 1;
					$mssql = " `id` IN ('".implode("','", $ms)."')";
				}
				$templates = pdo_fetchall("SELECT * FROM " . tablename('site_templates') .(!empty($mssql) ? " WHERE $mssql" : '')." ORDER BY id DESC", array(), 'id');
			}
		}
	}
	if (empty($templates)) {
		$templates = pdo_fetchall("SELECT * FROM " . tablename('site_templates') . " WHERE id = 1 ORDER BY id DESC", array(), 'id');
	}
	return $templates;
}


function uni_setting_save($name, $value) {
	global $_W;
	if (empty($name)) {
		return false;
	}
	if (is_array($value)) {
		$value = serialize($value);
	}
	$unisetting = pdo_get('uni_settings', array('uniacid' => $_W['uniacid']), array('uniacid'));
	if (!empty($unisetting)) {
		pdo_update('uni_settings', array($name => $value), array('uniacid' => $_W['uniacid']));
	} else {
		pdo_insert('uni_settings', array($name => $value, 'uniacid' => $_W['uniacid']));
	}
	cache_delete(cache_system_key('uniaccount', array('uniacid' => $_W['uniacid'])));
	return true;
}


function uni_setting_load($name = '', $uniacid = 0) {
	global $_W;
	$uniacid = empty($uniacid) ? $_W['uniacid'] : $uniacid;
	$cachekey = cache_system_key('unisetting', array('uniacid' => $uniacid));
	$unisetting = cache_load($cachekey);
	if (empty($unisetting)) {
		$unisetting = pdo_get('uni_settings', array('uniacid' => $uniacid));
		if (!empty($unisetting)) {
			$serialize = array('site_info', 'stat', 'oauth', 'passport', 'uc', 'notify',
				'creditnames', 'default_message', 'creditbehaviors', 'payment',
				'recharge', 'tplnotice', 'mcplugin', 'statistics', 'bind_domain');
			foreach ($unisetting as $key => &$row) {
				if (in_array($key, $serialize) && !empty($row)) {
					$row = (array)iunserializer($row);
				}
			}
		} else {
			$unisetting = array();
		}
		cache_write($cachekey, $unisetting);
	}
	if (empty($unisetting)) {
		return array();
	}
	if (empty($name)) {
		return $unisetting;
	}
	if (!is_array($name)) {
		$name = array($name);
	}
	return array_elements($name, $unisetting);
}

if (!function_exists('uni_setting')) {
	function uni_setting($uniacid = 0, $fields = '*', $force_update = false) {
		global $_W;
		load()->model('account');
		if ($fields == '*') {
			$fields = '';
		}
		return uni_setting_load($fields, $uniacid);
	}
}


function uni_account_default($uniacid = 0) {
	global $_W;
	$uniacid = empty($uniacid) ? $_W['uniacid'] : intval($uniacid);
	$uni_account = pdo_fetch("SELECT * FROM ".tablename('uni_account')." a LEFT JOIN ".tablename('account')." w ON a.uniacid = w.uniacid AND a.default_acid = w.acid WHERE a.uniacid = :uniacid", array(':uniacid' => $uniacid));
		if (empty($uni_account)) {
		$uni_account = pdo_fetch("SELECT * FROM ".tablename('uni_account')." a LEFT JOIN ".tablename('account')." w ON a.uniacid = w.uniacid WHERE a.uniacid = :uniacid ORDER BY w.acid DESC", array(':uniacid' => $uniacid));
	}
	if (!empty($uni_account)) {
		$account = pdo_get(uni_account_tablename($uni_account['type']), array('acid' => $uni_account['acid']));
		if (empty($account)) {
			$account['uniacid'] = $uni_account['uniacid'];
			$account['acid'] = $uni_account['default_acid'];
		}
		$account['type'] = $uni_account['type'];
		$account['isconnect'] = $uni_account['isconnect'];
		$account['isdeleted'] = $uni_account['isdeleted'];
		$account['endtime'] = $uni_account['endtime'];
		return $account;
	}
}

function uni_account_tablename($type) {
	switch ($type) {
		case ACCOUNT_TYPE_OFFCIAL_NORMAL:
		case ACCOUNT_TYPE_OFFCIAL_AUTH:
			return 'account_wechats';
		case ACCOUNT_TYPE_APP_NORMAL:
		case ACCOUNT_TYPE_APP_AUTH:
			return 'account_wxapp';
		case ACCOUNT_TYPE_WEBAPP_NORMAL:
			return 'account_webapp';
		case ACCOUNT_TYPE_PHONEAPP_NORMAL:
			return 'account_phoneapp';
		case ACCOUNT_TYPE_XZAPP_NORMAL:
			return 'account_xzapp';
		case ACCOUNT_TYPE_ALIAPP_NORMAL:
			return 'account_aliapp';
	}
}

function uni_user_account_role($uniacid, $uid, $role) {
	$vice_account = array(
		'uniacid' => intval($uniacid),
		'uid' => intval($uid),
		'role' => trim($role)
	);
	$account_user = pdo_get('uni_account_users', $vice_account, array('id'));
	if (!empty($account_user)) {
		return false;
	}
	return pdo_insert('uni_account_users', $vice_account);
}


function uni_user_see_more_info($user_type, $see_more = false) {
	global $_W;
	if (empty($user_type)) {
		return false;
	}
	if ($user_type == ACCOUNT_MANAGE_NAME_VICE_FOUNDER && !empty($see_more) || $_W['role'] != $user_type) {
		return true;
	}

	return false;
}


function uni_owner_account_nums($uid, $role) {
	$account_num = $wxapp_num = $webapp_num = $phoneapp_num = $xzapp_num = $aliapp_num = 0;
	$condition = array('uid' => $uid, 'role' => $role);
	$uniacocunts = pdo_getall('uni_account_users', $condition, array(), 'uniacid');

	if (!empty($uniacocunts)) {
		$all_account = pdo_fetchall('SELECT * FROM (SELECT u.uniacid, a.default_acid FROM ' . tablename('uni_account_users') . ' as u RIGHT JOIN '. tablename('uni_account').' as a  ON a.uniacid = u.uniacid  WHERE u.uid = :uid AND u.role = :role ) AS c LEFT JOIN '.tablename('account').' as d ON c.default_acid = d.acid WHERE d.isdeleted = 0', array(':uid' => $uid, ':role' => $role));
		foreach ($all_account as $account) {
			if ($account['type'] == ACCOUNT_TYPE_OFFCIAL_NORMAL || $account['type'] == ACCOUNT_TYPE_OFFCIAL_AUTH) {
				$account_num++;
			}
			if ($account['type'] == ACCOUNT_TYPE_APP_NORMAL || $account['type'] == ACCOUNT_TYPE_APP_AUTH) {
				$wxapp_num++;
			}
			if ($account['type'] == ACCOUNT_TYPE_WEBAPP_NORMAL) {
				$webapp_num++;
			}
			if ($account['type'] == ACCOUNT_TYPE_PHONEAPP_NORMAL) {
				$phoneapp_num++;
			}
			if ($account['type'] == ACCOUNT_TYPE_XZAPP_NORMAL) {
				$xzapp_num++;
			}
			if ($account['type'] == ACCOUNT_TYPE_ALIAPP_NORMAL) {
				$aliapp_num++;
			}
		}
	}
	$num = array(
		'account_num' => $account_num,
		'wxapp_num' => $wxapp_num,
		'webapp_num' => $webapp_num,
		'phoneapp_num' => $phoneapp_num,
		'xzapp_num' => $xzapp_num,
		'aliapp_num' => $aliapp_num,
	);
	return $num;
}
function uni_update_week_stat() {
	global $_W;
	$cachekey = cache_system_key('stat_todaylock', array('uniacid' => $_W['uniacid']));
	$cache = cache_load($cachekey);
	if(!empty($cache) && $cache['expire'] > TIMESTAMP) {
		return true;
	}
	$seven_days = array(
		date('Ymd', strtotime('-1 days')),
		date('Ymd', strtotime('-2 days')),
		date('Ymd', strtotime('-3 days')),
		date('Ymd', strtotime('-4 days')),
		date('Ymd', strtotime('-5 days')),
		date('Ymd', strtotime('-6 days')),
		date('Ymd', strtotime('-7 days')),
	);
	$week_stat_fans = pdo_getall('stat_fans', array('date' => $seven_days, 'uniacid' => $_W['uniacid']), '', 'date');
	$stat_update_yes = false;
	foreach ($seven_days as $sevens) {
		if (empty($week_stat_fans[$sevens]) || $week_stat_fans[$sevens]['cumulate'] <=0) {
			$stat_update_yes = true;
			break;
		}
	}
	if (empty($stat_update_yes)) {
		return true;
	}
	foreach($seven_days as $sevens) {
		if($_W['account']['level'] == ACCOUNT_SUBSCRIPTION_VERIFY || $_W['account']['level'] == ACCOUNT_SERVICE_VERIFY) {
			$account_obj = WeAccount::create();
			$weixin_stat = $account_obj->getFansStat();
			if(is_error($weixin_stat) || empty($weixin_stat)) {
				return error(-1, '调用微信接口错误');
			} else {
				$update_stat = array();
				$update_stat = array(
					'uniacid' => $_W['uniacid'],
					'new' => $weixin_stat[$sevens]['new'],
					'cancel' => $weixin_stat[$sevens]['cancel'],
					'cumulate' => $weixin_stat[$sevens]['cumulate'],
					'date' => $sevens,
				);
			}
		} else {
			$update_stat = array();
			$update_stat['cumulate'] = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('mc_mapping_fans') . " WHERE acid = :acid AND uniacid = :uniacid AND follow = :follow AND followtime < :endtime", array(':acid' => $_W['acid'], ':uniacid' => $_W['uniacid'], ':endtime' => strtotime($sevens)+86400, ':follow' => 1));
			$update_stat['date'] = $sevens;
			$update_stat['new'] = $week_stat_fans[$sevens]['new'];
			$update_stat['cancel'] = $week_stat_fans[$sevens]['cancel'];
			$update_stat['uniacid'] = $_W['uniacid'];
		}
		if(empty($week_stat_fans[$sevens])) {
			pdo_insert('stat_fans', $update_stat);
		} elseif (empty($week_stat_fans[$sevens]['cumulate']) || $week_stat_fans[$sevens]['cumulate'] < 0) {
			pdo_update('stat_fans', $update_stat, array('id' => $week_stat_fans[$sevens]['id']));
		}
	}
	cache_write($cachekey, array('expire' => TIMESTAMP + 7200));
	return true;
}


function uni_account_rank_top($uniacid) {
	global $_W;
	if (!empty($_W['isfounder'])) {
		$max_rank = pdo_getcolumn('uni_account', array(), 'max(rank)');
		pdo_update('uni_account', array('rank' => ($max_rank + 1)), array('uniacid' => $uniacid));
	}else {
		$max_rank = pdo_getcolumn('uni_account_users', array('uid' => $_W['uid']), 'max(rank)');
		pdo_update('uni_account_users', array('rank' => ($max_rank['maxrank'] + 1)), array('uniacid' => $uniacid, 'uid' => $_W['uid']));
	}
	return true;
}


function uni_account_last_switch() {
	global $_W, $_GPC;
	$cache_key = cache_system_key('last_account', array('switch' => $_GPC['__switch']));
	$cache_lastaccount = (int)cache_load($cache_key);
	return $cache_lastaccount;
}

function uni_account_switch($uniacid, $redirect = '', $type = ACCOUNT_TYPE_SIGN) {
	global $_W;
	if (!in_array($type, array(ACCOUNT_TYPE_SIGN, WXAPP_TYPE_SIGN, WEBAPP_TYPE_SIGN, PHONEAPP_TYPE_SIGN, XZAPP_TYPE_SIGN, ALIAPP_TYPE_SIGN))) {
		return error(-1, '账号类型不合法');
	}
	uni_account_save_switch($uniacid, $type);
	isetcookie('__uid', $_W['uid'], 7 * 86400);
	if (!empty($redirect)) {
		header('Location: ' . $redirect);
		exit;
	}
	return true;
}




function uni_account_save_switch($uniacid, $type = ACCOUNT_TYPE_SIGN) {
	global $_W, $_GPC;
	load()->model('visit');
	if (!in_array($type, array(ACCOUNT_TYPE_SIGN, WXAPP_TYPE_SIGN, WEBAPP_TYPE_SIGN, PHONEAPP_TYPE_SIGN, XZAPP_TYPE_SIGN, ALIAPP_TYPE_SIGN))) {
		return error(-1, '账号类型不合法');
	}
	if (empty($_GPC['__switch'])) {
		$_GPC['__switch'] = random(5);
	}
	$cache_key = cache_system_key('last_account', array('switch' => $_GPC['__switch']));
	$cache_lastaccount = $uniacid;
	visit_system_update(array('uniacid' => $uniacid, 'uid' => $_W['uid']));
	cache_write($cache_key, $cache_lastaccount);
	cache_write(cache_system_key('last_account_type'), $type);
	isetcookie('__uniacid', $uniacid, 7 * 86400);
	isetcookie('__switch', $_GPC['__switch'], 7 * 86400);
	return true;
}


function account_create($uniacid, $account) {
	global $_W;
	$accountdata = array('uniacid' => $uniacid, 'type' => $account['type'], 'hash' => random(8));
	$user_create_account_info = permission_user_account_num();
	if (empty($_W['isfounder']) && empty($user_create_account_info['usergroup_account_limit'])) {
		$accountdata['endtime'] = strtotime('+1 month', time());
		pdo_insert('site_store_create_account', array('endtime' => strtotime('+1 month', time()), 'uid' => $_W['uid'], 'uniacid' => $uniacid, 'type' => $account['type']));
	}
	pdo_insert('account', $accountdata);
	$acid = pdo_insertid();
	$account['acid'] = $acid;
	$account['token'] = random(32);
	$account['encodingaeskey'] = random(43);
	$account['uniacid'] = $uniacid;
	$table = $account['type'] == ACCOUNT_TYPE_OFFCIAL_NORMAL ? 'account_wechats' : 'account_xzapp';
	unset($account['type']);
	pdo_insert($table, $account);
	return $acid;
}


function account_fetch($acid) {
	$account_info = pdo_get('account', array('acid' => $acid));
	if (empty($account_info)) {
		return error(-1, '公众号不存在');
	}
	return uni_fetch($account_info['uniacid']);
}


function uni_setmeal($uniacid = 0) {
	global $_W;
	if(!$uniacid) {
		$uniacid = $_W['uniacid'];
	}
	$owneruid = pdo_fetchcolumn("SELECT uid FROM ".tablename('uni_account_users')." WHERE uniacid = :uniacid AND role = 'owner'", array(':uniacid' => $uniacid));
	if(empty($owneruid)) {
		$user = array(
			'uid' => -1,
			'username' => '创始人',
			'timelimit' => '未设置',
			'groupid' => '-1',
			'groupname' => '所有服务'
		);
		return $user;
	}
	load()->model('user');
	$groups = pdo_getall('users_group', array(), array('id', 'name'), 'id');
	$owner = user_single(array('uid' => $owneruid));
	$user = array(
		'uid' => $owner['uid'],
		'username' => $owner['username'],
		'groupid' => $owner['groupid'],
		'groupname' => $groups[$owner['groupid']]['name']
	);
	if(empty($owner['endtime'])) {
		$user['timelimit'] = date('Y-m-d', $owner['starttime']) . ' ~ 无限制' ;
	} else {
		if($owner['endtime'] <= TIMESTAMP) {
			$user['timelimit'] = '已到期';
		} else {
			$year = 0;
			$month = 0;
			$day = 0;
			$endtime = $owner['endtime'];
			$time = strtotime('+1 year');
			while ($endtime > $time)
			{
				$year = $year + 1;
				$time = strtotime("+1 year", $time);
			};
			$time = strtotime("-1 year", $time);
			$time = strtotime("+1 month", $time);
			while($endtime > $time)
			{
				$month = $month + 1;
				$time = strtotime("+1 month", $time);
			} ;
			$time = strtotime("-1 month", $time);
			$time = strtotime("+1 day", $time);
			while($endtime > $time)
			{
				$day = $day + 1;
				$time = strtotime("+1 day", $time);
			} ;
			if (empty($year)) {
				$timelimit = empty($month)? $day.'天' : date('Y-m-d', $owner['starttime']) . '~'. date('Y-m-d', $owner['endtime']);
			}else {
				$timelimit = date('Y-m-d', $owner['starttime']) . '~'. date('Y-m-d', $owner['endtime']);
			}
			$user['timelimit'] = $timelimit;
		}
	}
	return $user;
}


function uni_is_multi_acid($uniacid = 0) {
	global $_W;
	if(!$uniacid) {
		$uniacid = $_W['uniacid'];
	}
	$cachekey = cache_system_key('unicount', array('uniacid' => $uniacid));
	$nums = cache_load($cachekey);
	$nums = intval($nums);

	if(!$nums) {
		$nums = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('account_wechats') . ' WHERE uniacid = :uniacid', array(':uniacid' => $_W['uniacid']));
		cache_write($cachekey, $nums);
	}
	if($nums <= 1) {
		return false;
	}
	return true;
}

function account_delete($acid) {
	global $_W;
	load()->func('file');
	load()->model('module');
	load()->model('job');
	$jobid  = 0;
		$account = pdo_get('uni_account', array('default_acid' => $acid));
	if ($account) {
		$uniacid = $account['uniacid'];
		$state = permission_account_user_role($_W['uid'], $uniacid);
		if (!in_array($state, array(ACCOUNT_MANAGE_NAME_OWNER, ACCOUNT_MANAGE_NAME_FOUNDER, ACCOUNT_MANAGE_NAME_VICE_FOUNDER))) {
			itoast('没有该公众号操作权限！', url('account/recycle'), 'error');
		}
		if($uniacid == $_W['uniacid']) {
			isetcookie('__uniacid', '');
		}
		cache_delete(cache_system_key('uniaccount', array('uniacid' => $uniacid)));
		$modules = array();
				$rules = pdo_fetchall("SELECT id, module FROM ".tablename('rule')." WHERE uniacid = '{$uniacid}'");
		if (!empty($rules)) {
			foreach ($rules as $index => $rule) {
				$deleteid[] = $rule['id'];
			}
			pdo_delete('rule', "id IN ('".implode("','", $deleteid)."')");
		}

		$subaccount = pdo_fetchall("SELECT acid FROM ".tablename('account')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
		if (!empty($subaccount)) {
			foreach ($subaccount as $childaccount) {
				@unlink(IA_ROOT . '/attachment/qrcode_'.$childaccount['acid'].'.jpg');
				@unlink(IA_ROOT . '/attachment/headimg_'.$childaccount['acid'].'.jpg');
				file_remote_delete('qrcode_'.$childaccount['acid'].'.jpg');
				file_remote_delete('headimg_'.$childaccount['acid'].'.jpg');
			}
			if (!empty($acid)) {
				$jobid = job_create_delete_account($uniacid, $account['name'], $_W['uid']);
			}
		}

				$tables = array(
			'account','account_wechats', 'account_wxapp', 'wxapp_versions', 'account_webapp', 'account_phoneapp',
			'phoneapp_versions','core_paylog','core_queue','core_resource',
			 'cover_reply', 'mc_chats_record','mc_credits_recharge','mc_credits_record',
			'mc_fans_groups','mc_groups','mc_handsel','mc_mapping_fans','mc_mapping_ucenter','mc_mass_record',
			'mc_member_address','mc_member_fields','mc_members','menu_event',
			'qrcode','qrcode_stat', 'rule','rule_keyword','site_article','site_category','site_multi','site_nav','site_slide',
			'site_styles','site_styles_vars','stat_keyword', 'stat_rule','uni_account','uni_account_modules','uni_account_users','uni_settings', 'uni_group', 'uni_verifycode','users_permission',
			'mc_member_fields', 'wechat_news',
		);
		if (!empty($tables)) {
			foreach ($tables as $table) {
				$tablename = str_replace($GLOBALS['_W']['config']['db']['tablepre'], '', $table);
				pdo_delete($tablename, array( 'uniacid'=> $uniacid));
			}
		}
	} else {
		$account = account_fetch($acid);
		if (empty($account)) {
			itoast('子公众号不存在或是已经被删除', '', '');
		}
		$uniacid = $account['uniacid'];
		$state = permission_account_user_role($_W['uid'], $uniacid);
		if($state != ACCOUNT_MANAGE_NAME_FOUNDER && $state != ACCOUNT_MANAGE_NAME_OWNER) {
			itoast('没有该公众号操作权限！', url('account/recycle'), 'error');
		}
		$uniaccount = uni_fetch($account['uniacid']);
		if ($uniaccount['default_acid'] == $acid) {
			itoast('默认子公众号不能删除', '', '');
		}
		pdo_delete('account', array('acid' => $acid));
		pdo_delete('account_wechats', array('acid' => $acid, 'uniacid' => $uniacid));
		cache_delete(cache_system_key('uniaccount', array('uniacid' => $uniacid)));
		cache_delete(cache_system_key('account_auth_refreshtoken', array('acid' => $acid)));
		$oauth = uni_setting($uniacid, array('oauth'));
		if($oauth['oauth']['account'] == $acid) {
			$acid = pdo_fetchcolumn('SELECT acid FROM ' . tablename('account_wechats') . " WHERE uniacid = :id AND level = 4 AND secret != '' AND `key` != ''", array(':id' => $uniacid));
			pdo_update('uni_settings', array('oauth' => iserializer(array('account' => $acid, 'host' => $oauth['oauth']['host']))), array('uniacid' => $uniacid));
		}
		@unlink(IA_ROOT . '/attachment/qrcode_'.$acid.'.jpg');
		@unlink(IA_ROOT . '/attachment/headimg_'.$acid.'.jpg');
		file_remote_delete('qrcode_'.$acid.'.jpg');
		file_remote_delete('headimg_'.$acid.'.jpg');
	}
	return $jobid;
}


function account_wechatpay_proxy () {
	global $_W;
	$proxy_account = cache_load(cache_system_key('proxy_wechatpay_account'));
	if (empty($proxy_account)) {
		$proxy_account = cache_build_proxy_wechatpay_account();
	}
	unset($proxy_account['borrow'][$_W['uniacid']]);
	unset($proxy_account['service'][$_W['uniacid']]);
	return $proxy_account;
}


function uni_account_module_shortcut_enabled($modulename, $status = STATUS_ON) {
	global $_W;
	$module = module_fetch($modulename);
	if(empty($module)) {
		return error(1, '抱歉，你操作的模块不能被访问！');
	}

	$module_status = pdo_get('uni_account_modules', array('module' => $modulename, 'uniacid' => $_W['uniacid']), array('id', 'shortcut'));
	if (empty($module_status)) {
		$data = array(
			'uniacid' => $_W['uniacid'],
			'module' => $modulename,
			'enabled' => STATUS_ON,
			'shortcut' => $status ? STATUS_ON : STATUS_OFF,
			'settings' => '',
		);
		pdo_insert('uni_account_modules', $data);
	} else {
		$data = array(
			'shortcut' => $status ? STATUS_ON : STATUS_OFF,
		);
		pdo_update('uni_account_modules', $data, array('id' => $module_status['id']));
	}
	cache_build_module_info($modulename);
	return true;
}


function uni_account_member_fields($uniacid) {
	if (empty($uniacid)) {
		return array();
	}
	$account_member_fields = pdo_getall('mc_member_fields', array('uniacid' => $uniacid), array(), 'fieldid');
	$system_member_fields = pdo_getall('profile_fields', array(), array(), 'id');
	$less_field_indexes = array_diff(array_keys($system_member_fields), array_keys($account_member_fields));
	if (empty($less_field_indexes)) {
		foreach ($account_member_fields as &$field) {
			$field['field'] = $system_member_fields[$field['fieldid']]['field'];
		}
		unset($field);
		return $account_member_fields;
	}

	$account_member_add_fields = array('uniacid' => $uniacid);
	foreach ($less_field_indexes as $field_index) {
		$account_member_add_fields['fieldid'] = $system_member_fields[$field_index]['id'];
		$account_member_add_fields['title'] = $system_member_fields[$field_index]['title'];
		$account_member_add_fields['available'] = $system_member_fields[$field_index]['available'];
		$account_member_add_fields['displayorder'] = $system_member_fields[$field_index]['displayorder'];
		pdo_insert('mc_member_fields', $account_member_add_fields);
		$insert_id = pdo_insertid();
		$account_member_fields[$insert_id]['id'] = $insert_id;
		$account_member_fields[$insert_id]['field'] = $system_member_fields[$field_index]['field'];
		$account_member_fields[$insert_id]['fid'] = $system_member_fields[$field_index]['id'];
		$account_member_fields[$insert_id] = array_merge($account_member_fields[$insert_id], $account_member_add_fields);
	}
	return $account_member_fields;
}



function uni_account_global_oauth() {
	load()->model('setting');
	$oauth = setting_load('global_oauth');
	$oauth = !empty($oauth['global_oauth']) ? $oauth['global_oauth'] : array();
	return $oauth;
}

function uni_search_link_account($module_name, $account_type) {
	global $_W;
	load()->model('miniapp');
	$module_name = trim($module_name);
	if (empty($module_name) || empty($account_type) || !in_array($account_type, array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH, ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_APP_AUTH, ACCOUNT_TYPE_WEBAPP_NORMAL))) {
		return array();
	}
	if (in_array($account_type, array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH))) {
		$owned_account = uni_user_accounts($_W['uid'], 'app');
	} elseif (in_array($account_type, array(ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_APP_AUTH))) {
		$owned_account = uni_user_accounts($_W['uid'], 'wxapp');
	} elseif ($account_type == ACCOUNT_TYPE_WEBAPP_NORMAL) {
		$owned_account = uni_user_accounts($_W['uid'], 'webapp');
	} else {
		$owned_account = array();
	}
	if (!empty($owned_account)) {
		foreach ($owned_account as $key => $account) {
			if ($account['type'] != $account_type || $account['uniacid'] == $_W['uniacid']) {
				unset($owned_account[$key]);
				continue;
			}
			$account['role'] = permission_account_user_role($_W['uid'], $account['uniacid']);
			if (!in_array($account['role'], array(ACCOUNT_MANAGE_NAME_OWNER, ACCOUNT_MANAGE_NAME_VICE_FOUNDER, ACCOUNT_MANAGE_NAME_FOUNDER))) {
				unset($owned_account[$key]);
			}
		}
		foreach ($owned_account as $key => $account) {
			$account_modules = uni_modules_by_uniacid($account['uniacid']);
			if (empty($account_modules[$module_name])) {
				unset($owned_account[$key]);
				continue;
			}
			if (in_array($account_type, array(ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_APP_AUTH))) {
				$last_version = (array)miniapp_fetch($account['uniacid']);
				if (empty($last_version['version']) || empty($last_version['version']['modules']) || current((array)array_keys($last_version['version']['modules'])) != $module_name) {
					unset($owned_account[$key]);
					continue;
				}
				$current_module = current($last_version['version']['modules']);
				if (!empty($current_module['account'])) {
					unset($owned_account[$key]);
					continue;
				}
			}
			if (in_array($account_type, array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH)) && $account_modules[$module_name][MODULE_SUPPORT_ACCOUNT_NAME] != MODULE_SUPPORT_ACCOUNT) {
				unset($owned_account[$key]);
			} elseif (in_array($account_type, array(ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_APP_AUTH)) && $account_modules[$module_name]['wxapp_support'] != MODULE_SUPPORT_WXAPP) {
				unset($owned_account[$key]);
			} elseif ($account_type == ACCOUNT_TYPE_WEBAPP_NORMAL && $account_modules[$module_name]['webapp_support'] != MODULE_SUPPORT_WEBAPP) {
				unset($owned_account[$key]);
			}
		}
	}
	return $owned_account;
}


function uni_account_oauth_host() {
	global $_W;
	$oauth_url = $_W['siteroot'];
	$unisetting = uni_setting_load();
	if (!empty($unisetting['bind_domain']) && !empty($unisetting['bind_domain']['domain'])) {
		$oauth_url = $unisetting['bind_domain']['domain'] . '/';
	} else {
		if (!empty($unisetting['oauth']['host'])) {
			$oauth_url = $unisetting['oauth']['host'] . '/';
		} else {
			$global_unisetting = uni_account_global_oauth();
			$oauth_url = !empty($global_unisetting['oauth']['host']) ? $global_unisetting['oauth']['host'] . '/' : $oauth_url;
		}
	}
	return $oauth_url;
}


function uni_passive_link_uniacid($uniacid, $module_name) {
	global $_W;
	$uniacid = intval($uniacid);
	$module_name = trim($module_name);
	if (empty($uniacid) || empty($module_name)) {
		return false;
	}
		$passive_link_module = pdo_get('uni_account_modules', array('module' => $module_name, 'uniacid' => $uniacid), array('id', 'settings'));
	if (!empty($passive_link_module)) {
		$passive_settings = (array)iunserializer($passive_link_module['settings']);
		if (!is_array($passive_settings['passive_link_uniacid']) && !empty($passive_settings['passive_link_uniacid'])) {
			$passive_settings = array($passive_settings['passive_link_uniacid']);
		}
		if (empty($passive_settings)) {
			$passive_settings = array('passive_link_uniacid' => array($_W['uniacid']));
		} elseif (empty($passive_settings['passive_link_uniacid'])) {
			$passive_settings['passive_link_uniacid'] = array($_W['uniacid']);
		} elseif (!empty($passive_settings['passive_link_uniacid']) && !in_array($_W['uniacid'], $passive_settings['passive_link_uniacid'])) {

			array_push($passive_settings['passive_link_uniacid'], array($_W['uniacid']));
		}
		pdo_update('uni_account_modules', array('settings' => iserializer($passive_settings)), array('id' => $passive_link_module['id']));
	} else {
		$passive_settings = array('passive_link_uniacid' => array($_W['uniacid']));
		$passive_data = array(
			'settings' => iserializer($passive_settings),
			'uniacid' => $uniacid,
			'module' => $module_name,
			'enabled' => STATUS_ON,
		);
		pdo_insert('uni_account_modules', $passive_data);
	}
		cache_clean(cache_system_key('module_setting'));
	return true;
}

function uni_unpassive_link_uniacid($uniacid, $module_name) {
	global $_W;
	if (empty($uniacid) || empty($module_name)) {
		return false;
	}
	$passive_info = table('uni_account_modules')->getByUniacidAndModule($module_name, $uniacid);
	if (!empty($passive_info['settings']) && is_array($passive_info['settings']['passive_link_uniacid'])) {
		foreach ($passive_info['settings']['passive_link_uniacid'] as $key => $value) {
			if ($_W['uniacid'] == $value) {
				unset($passive_info['settings']['passive_link_uniacid'][$key]);
				break;
			}
		}
		table('uni_account_modules')->fill(array('settings' => iserializer($passive_info['settings'])))->where('module', $module_name)->where('uniacid', $uniacid)->save();
		cache_delete(cache_system_key('module_setting', array('module_name' => $module_name, 'uniacid' => $uniacid)));
	}
}
