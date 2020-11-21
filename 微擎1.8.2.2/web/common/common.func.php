<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('module');


function url($segment, $params = array()) {
	return wurl($segment, $params);
}


function message($msg, $redirect = '', $type = '', $tips = false, $extend = array()) {
	global $_W, $_GPC;

	if($redirect == 'refresh') {
		$redirect = $_W['script_name'] . '?' . $_SERVER['QUERY_STRING'];
	}
	if($redirect == 'referer') {
		$redirect = referer();
	}
		$redirect = safe_gpc_url($redirect);

	if($redirect == '') {
		$type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'info';
	} else {
		$type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'success';
	}
	if ($_W['isajax'] || !empty($_GET['isajax']) || $type == 'ajax') {
		if($type != 'ajax' && !empty($_GPC['target'])) {
			exit("
<script type=\"text/javascript\">
	var url = ".(!empty($redirect) ? 'parent.location.href' : "''").";
	var modalobj = util.message('".$msg."', '', '".$type."');
	if (url) {
		modalobj.on('hide.bs.modal', function(){\$('.modal').each(function(){if(\$(this).attr('id') != 'modal-message') {\$(this).modal('hide');}});top.location.reload()});
	}
</script>");
		} else {
			$vars = array();
			$vars['message'] = $msg;
			$vars['redirect'] = $redirect;
			$vars['type'] = $type;
			exit(json_encode($vars));
		}
	}
	if (empty($msg) && !empty($redirect)) {
		header('Location: '.$redirect);
		exit;
	}
	$label = $type;
	if($type == 'error') {
		$label = 'danger';
	}
	if($type == 'ajax' || $type == 'sql') {
		$label = 'warning';
	}

	if ($tips) {
		if (is_array($msg)){
			$message_cookie['title'] = 'MYSQL 错误';
			$message_cookie['msg'] = 'php echo cutstr(' . $msg['sql'] . ', 300, 1);';
		} else{
			$message_cookie['title'] = $caption;
			$message_cookie['msg'] = $msg;
		}
		$message_cookie['type'] = $label;
		$message_cookie['redirect'] = $redirect ? $redirect : referer();
		$message_cookie['msg'] = rawurlencode($message_cookie['msg']);
		$extend_button = array();
		if (!empty($extend) && is_array($extend)) {
			foreach ($extend as $button) {
				if (!empty($button['title']) && !empty($button['url'])) {
					$button['url'] = safe_gpc_url($button['url']);
					$button['title'] = rawurlencode($button['title']);
					$extend_button[] = $button;
				}
			}
		}
		$message_cookie['extend'] = !empty($extend_button) ? $extend_button : '';

		isetcookie('message', stripslashes(json_encode($message_cookie, JSON_UNESCAPED_UNICODE)));
		header('Location: ' . $message_cookie['redirect']);
	} else {
		include template('common/message', TEMPLATE_INCLUDEPATH);
	}
	exit;
}

function iajax($code = 0, $message = '', $redirect = '') {
	message(error($code, $message), $redirect, 'ajax', false);
}

function itoast($message, $redirect = '', $type = '', $extend = array()) {
	message($message, $redirect, $type, true, $extend);
}


function checklogin() {
	global $_W;
	if (empty($_W['uid'])) {
		if (!empty($_W['setting']['copyright']['showhomepage'])) {
			itoast('', url('account/welcome'), 'warning');
		} else {
			itoast('', url('user/login'), 'warning');
		}
	}
	return true;
}

function buildframes($framename = ''){
	global $_W, $_GPC, $top_nav;

	if (!empty($GLOBALS['frames']) && !empty($_GPC['m'])) {
		$frames = array();
		$globals_frames = (array)$GLOBALS['frames'];
		foreach ($globals_frames as $key => $row) {
			if (empty($row)) continue;
			$row = (array)$row;
			$frames['section']['platform_module_menu'.$key]['title'] = $row['title'];
			if (!empty($row['items'])) {
				foreach ($row['items'] as $li) {
					$frames['section']['platform_module_menu'.$key]['menu']['platform_module_menu'.$li['id']] = array(
						'title' => "<i class='wi wi-appsetting'></i> {$li['title']}",
						'url' => $li['url'],
						'is_display' => 1,
					);
				}
			}
		}
		return $frames;
	}
	$frames = cache_load(cache_system_key('system_frame', array('uniacid' => $_W['uniacid'])));
	if(empty($frames)) {
		$frames = cache_build_frame_menu();
	}
			if (!empty($_W['role']) && empty($_W['isfounder'])) {
		$user_permission = permission_account_user('system');
	}
	if (empty($_W['role']) && empty($_W['uniacid'])) {
		$user_permission = permission_account_user('system');
	}
		if (!empty($user_permission)) {
		foreach ($frames as $nav_id => $section) {
			if (empty($section['section'])) {
				continue;
			}
			foreach ($section['section'] as $section_id => $secion) {
				if ($nav_id == 'account') {
					if ($status && !empty($module_permission) && in_array("account*", $user_permission) && $section_id != 'platform_module' && permission_account_user_role($_W['uid'], $_W['uniacid']) != ACCOUNT_MANAGE_NAME_OWNER) {
						$frames['account']['section'][$section_id]['is_display'] = false;
						continue;
					} else {
						if (in_array("account*", $user_permission)) {
							continue;
						}
					}
				}
				
				
					if ($nav_id != 'wxapp' && $nav_id != 'store') {
						$section_show = false;
						$secion['if_fold'] = !empty($_GPC['menu_fold_tag:'.$section_id]) ? 1 : 0;
						foreach ($secion['menu'] as $menu_id => $menu) {
							if (!in_array($menu['permission_name'], $user_permission) && $section_id != 'platform_module') {
								$frames[$nav_id]['section'][$section_id]['menu'][$menu_id]['is_display'] = false;
							} else {
								$section_show = true;
							}
						}
						if (!isset($frames[$nav_id]['section'][$section_id]['is_display'])) {
							$frames[$nav_id]['section'][$section_id]['is_display'] = $section_show;
						}
					}
				
			}

			if ($_W['role'] == ACCOUNT_MANAGE_NAME_EXPIRED && ($nav_id != 'store' || $nav_id != 'system')) {
				$menu['is_display'] = 0;
			}
		}
	} else {
		if (user_is_vice_founder()) {
			$frames['system']['section']['article']['is_display'] = false;
			$frames['system']['section']['welcome']['is_display'] = false;
			$frames['system']['section']['wxplatform']['menu']['system_platform']['is_display'] = false;
			$frames['system']['section']['user']['menu']['system_user_founder_group']['is_display'] = false;
		}
	}

		if (defined('FRAME') && (in_array(FRAME, array('site', 'system')))) {
		$frames = frames_top_menu($frames);
		return $frames[$framename];
	}

		$modules = uni_modules(false);
	if (defined('FRAME') && FRAME == 'account') {
		$sysmodules = system_modules();
		$status = permission_account_user_permission_exist($_W['uid'], $_W['uniacid']);
				if (!$_W['isfounder'] && $status && $_W['role'] != ACCOUNT_MANAGE_NAME_OWNER) {
			$module_permission = permission_account_user_menu($_W['uid'], $_W['uniacid'], 'modules');
			if (!is_error($module_permission) && !empty($module_permission)) {
				foreach ($module_permission as $module) {
					if (!in_array($module['type'], $sysmodules) && empty($modules[$module['type']]['main_module']) && $modules[$module['type']][MODULE_SUPPORT_ACCOUNT_NAME] == 2) {
						$module = $modules[$module['type']];
						if (!empty($module)) {
							$frames[FRAME]['section']['platform_module']['menu']['platform_' . $module['name']] = array(
								'title' => $module['title'],
								'icon' =>  $module['logo'],
								'url' => url('home/welcome/ext', array('m' => $module['name'])),
								'is_display' => 1,
							);
						}
					}
				}
			} else {
				$frames[FRAME]['section']['platform_module']['is_display'] = false;
			}
		} else {
						$account_module = pdo_getall('uni_account_modules', array('uniacid' => $_W['uniacid'], 'shortcut' => STATUS_ON), array('module'), '', 'displayorder DESC, id DESC');
			if (!empty($account_module)) {
				foreach ($account_module as $module) {
					if (!in_array($module['module'], $sysmodules)) {
						$module = module_fetch($module['module']);
						if (!empty($module) && !empty($modules[$module['name']]) && empty($module['main_module']) && ($module[MODULE_SUPPORT_ACCOUNT_NAME] == 2 || $module['webapp_support'] == 2)) {
							$frames[FRAME]['section']['platform_module']['menu']['platform_' . $module['name']] = array(
								'title' => $module['title'],
								'icon' =>  $module['logo'],
								'url' => url('home/welcome/ext', array('m' => $module['name'])),
								'is_display' => 1,
							);
						}
					}
				}
			} elseif (!empty($modules)) {
				$new_modules = array_reverse($modules);
				$i = 0;
				foreach ($new_modules as $module) {
					if (!empty($module['issystem'])) {
						continue;
					}
					if ($i == 5) {
						break;
					}
					$frames[FRAME]['section']['platform_module']['menu']['platform_' . $module['name']] = array(
						'title' => $module['title'],
						'icon' =>  $module['logo'],
						'url' => url('home/welcome/ext', array('m' => $module['name'])),
						'is_display' => 1,
					);
					$i++;
				}
			}
			if (array_diff(array_keys($modules), $sysmodules)) {
				$frames[FRAME]['section']['platform_module']['menu']['platform_module_more'] = array(
					'title' => '更多应用',
					'url' => url('module/manage-account'),
					'is_display' => 1,
				);
			} else {
				$frames[FRAME]['section']['platform_module']['is_display'] = false;
			}
		}
	}

		$modulename = trim($_GPC['m']);
	$eid = intval($_GPC['eid']);
	$version_id = intval($_GPC['version_id']);
	if ((!empty($modulename) || !empty($eid)) && !in_array($modulename, system_modules())) {
		if (!empty($eid)) {
			$entry = pdo_get('modules_bindings', array('eid' => $eid));
		}
		if(empty($modulename)) {
			$modulename = $entry['module'];
		}
		$module = module_fetch($modulename);
		if (defined('SYSTEM_WELCOME_MODULE')) {
			$entries = module_entries($modulename, array('system_welcome'));
		} else {
			$entries = module_entries($modulename);
		}
		if($status) {
			$permission = pdo_get('users_permission', array('uniacid' => $_W['uniacid'], 'uid' => $_W['uid'], 'type' => $modulename), array('permission'));
			if(!empty($permission)) {
				$permission = explode('|', $permission['permission']);
			} else {
				$permission = array('account*');
			}
			if($permission[0] != 'all') {
				if(!in_array($modulename.'_rule', $permission)) {
					unset($module['isrulefields']);
				}
				if(!in_array($modulename.'_settings', $permission)) {
					unset($module['settings']);
				}
				if(!in_array($modulename.'_permissions', $permission)) {
					unset($module['permissions']);
				}
				if(!in_array($modulename.'_home', $permission)) {
					unset($entries['home']);
				}
				if(!in_array($modulename.'_profile', $permission)) {
					unset($entries['profile']);
				}
				if(!in_array($modulename.'_shortcut', $permission)) {
					unset($entries['shortcut']);
				}
				if(!empty($entries['cover'])) {
					foreach($entries['cover'] as $k => $row) {
						if(!in_array($modulename.'_cover_'.$row['do'], $permission)) {
							unset($entries['cover'][$k]);
						}
					}
				}
				if(!empty($entries['menu'])) {
					foreach($entries['menu'] as $k => $row) {
						if(!in_array($modulename.'_menu_'.$row['do'], $permission)) {
							unset($entries['menu'][$k]);
						}
					}
				}
			}
		}

		$frames['account']['section'] = array();
		if($module['isrulefields'] || !empty($entries['cover']) || !empty($entries['mine'])) {
			if (!empty($module['isrulefields']) && !empty($_W['account']) && in_array($_W['account']['type'], array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH, ACCOUNT_TYPE_XZAPP_NORMAL, ACCOUNT_TYPE_XZAPP_AUTH))) {
				$url = url('platform/reply', array('m' => $modulename, 'version_id' => $version_id));
			}
			if (empty($url) && !empty($entries['cover'])) {
				$url = url('platform/cover', array('eid' => $entries['cover'][0]['eid'], 'version_id' => $version_id));
			}
			$frames['account']['section']['platform_module_common']['menu']['platform_module_entry'] = array(
				'title' => "<i class='wi wi-reply'></i> 应用入口",
				'url' => $url,
				'is_display' => 1,
			);
		}
		if($module['settings']) {
			$frames['account']['section']['platform_module_common']['menu']['platform_module_settings'] = array(
				'title' => "<i class='fa fa-cog'></i> 参数设置",
				'url' => url('module/manage-account/setting', array('m' => $modulename, 'version_id' => $version_id)),
				'is_display' => 1,
			);
		}
		if ($module['permissions'] && ($_W['isfounder'] || $_W['role'] == ACCOUNT_MANAGE_NAME_OWNER) && !defined('SYSTEM_WELCOME_MODULE')) {
			$frames['account']['section']['platform_module_common']['menu']['platform_module_permissions'] = array(
				'title' => "<i class='fa fa-cog'></i> 权限设置",
				'url' => url('module/permission', array('m' => $modulename, 'version_id' => $version_id)),
				'is_display' => 1,
			);
		}
		if (($_W['isfounder'] || $_W['role'] == ACCOUNT_MANAGE_NAME_OWNER) && !defined('SYSTEM_WELCOME_MODULE')) {
			$frames['account']['section']['platform_module_common']['menu']['platform_module_default_entry'] = array(
					'title' => "<i class='fa fa-cog'></i> 默认入口",
					'url' => url('module/default-entry', array('m' => $modulename, 'version_id' => $version_id)),
					'is_display' => 1,
			);
		}
		if($entries['home'] && !empty($_W['account']) && in_array($_W['account']['type'], array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH))) {
			$frames['account']['section']['platform_module_common']['menu']['platform_module_home'] = array(
				'title' => "<i class='fa fa-home'></i> 微站首页导航",
				'url' => url('site/nav/home', array('m' => $modulename, 'version_id' => $version_id)),
				'is_display' => 1,
			);
		}
		if($entries['profile'] && !empty($_W['account']) && in_array($_W['account']['type'], array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH))) {
			$frames['account']['section']['platform_module_common']['menu']['platform_module_profile'] = array(
				'title' => "<i class='fa fa-user'></i> 个人中心导航",
				'url' => url('site/nav/profile', array('m' => $modulename, 'version_id' => $version_id)),
				'is_display' => 1,
			);
		}
		if($entries['shortcut'] && !empty($_W['account']) && in_array($_W['account']['type'], array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH))) {
			$frames['account']['section']['platform_module_common']['menu']['platform_module_shortcut'] = array(
				'title' => "<i class='fa fa-plane'></i> 快捷菜单",
				'url' => url('site/nav/shortcut', array('m' => $modulename, 'version_id' => $version_id)),
				'is_display' => 1,
			);
		}
		if (!empty($entries['cover'])) {
			foreach ($entries['cover'] as $key => $menu) {
				$frames['account']['section']['platform_module_common']['menu']['platform_module_cover'][] = array(
					'title' => "{$menu['title']}",
					'url' => url('platform/cover', array('eid' => $menu['eid'], 'version_id' => $version_id)),
					'is_display' => 0,
				);
			}
		}
		if (!empty($entries['menu'])) {
			$frames['account']['section']['platform_module_menu']['title'] = '业务菜单';
			foreach($entries['menu'] as $key => $row) {
				if(empty($row)) continue;
				foreach($row as $li) {
					$frames['account']['section']['platform_module_menu']['menu']['platform_module_menu'.$row['eid']] = array(
						'title' => "<i class='wi wi-appsetting'></i> {$row['title']}",
						'url' => $row['url'] . '&version_id=' . $version_id,
						'is_display' => 1,
					);
				}
			}
		}
		if (!empty($module['plugin_list']) || !empty($module['main_module'])) {
			if (!empty($module['main_module'])) {
				$main_module = module_fetch($module['main_module']);
				$plugin_list = $main_module['plugin_list'];
			} else {
				$plugin_list = $module['plugin_list'];
			}
			$plugin_list = array_intersect($plugin_list, array_keys($modules));
			if (!empty($plugin_list)) {
				$frames['account']['section']['platform_module_menu']['plugin_menu'] = array(
					'main_module' => !empty($main_module) ? $main_module['name'] : $module['name'],
					'title' => !empty($main_module) ? $main_module['title'] : $module['title'],
					'icon' => !empty($main_module) ? $main_module['logo'] : $module['logo'],
					'menu' => array()
				);
				foreach ($plugin_list as $plugin) {
					$frames['account']['section']['platform_module_menu']['plugin_menu']['menu'][$modules[$plugin]['name']] = array(
						'title' => $modules[$plugin]['title'],
						'icon' => $modules[$plugin]['logo'],
						'url' => url('home/welcome/ext', array('m' => $plugin, 'version_id' => $version_id)),
					);
				}
			}
		}
		
			if (!empty($entries['system_welcome']) && $_W['isfounder']) {
				$frames['account']['section']['platform_module_welcome']['title'] = '';
				foreach ($entries['system_welcome'] as $key => $row) {
					if (empty($row)) continue;
					$frames['account']['section']['platform_module_welcome']['menu']['platform_module_welcome' . $row['eid']] = array (
						'title' => "<i class='wi wi-appsetting'></i> {$row['title']}",
						'url' => $row['url'],
						'is_display' => 1,
					);
				}
			}
		
	}

	if (defined('FRAME') && FRAME == 'account') {
		$system_menu = require IA_ROOT . '/web/common/frames.inc.php';
		foreach ($frames['account']['section'] as $section_key => &$section) {
			if ($section_key == 'platform_module') {
				continue;
			}
			foreach ($section['menu'] as $sub_key => &$sub_menu) {
				$sub_menu_frames = $system_menu['account']['section'][$section_key]['menu'][$sub_key];
				if (is_array($sub_menu_frames['is_display']) && !in_array($_W['account']['type'], $sub_menu_frames['is_display'])) {
					$sub_menu['is_display'] = 0;
				}
			}
		}
	}

		if (defined('FRAME') && FRAME == 'wxapp') {
		load()->model('miniapp');
		$version_id = intval($_GPC['version_id']);
		$wxapp_version = miniapp_version($version_id);
		if (!empty($wxapp_version['last_modules']) && is_array($wxapp_version['last_modules'])) {
			$last_modules = current($wxapp_version['last_modules']);
		}

		if (!empty($wxapp_version['modules'])) {
			foreach ($wxapp_version['modules'] as $module) {
				$wxapp_module_permission = permission_account_user_menu($_W['uid'], $_W['uniacid'], $module['name']);
				if (empty($wxapp_module_permission)) {
					$frames['wxapp']['section']['platform_module']['is_display'] = false;
					break;
				}
				$need_upload = !empty($last_modules) && ($module['version'] != $last_modules['version']);
				$frames['wxapp']['section']['platform_module']['menu']['module_menu'.$module['mid']] = array(
					'title' => "<img src='{$module['logo']}'> {$module['title']}",
					'url' => url('account/display/switch', array('module_name' => $module['name'], 'version_id' => $version_id, 'uniacid' => $_W['uniacid'])),
					'is_display' => 1,
				);
			}
		} else {
			$frames['wxapp']['section']['platform_module']['is_display'] = false;
		}
		if (!empty($frames['wxapp']['section']['wxapp_profile']['menu']['front_download'])) {
			$frames['wxapp']['section']['wxapp_profile']['menu']['front_download']['need_upload'] = empty($need_upload) ? 0 : 1;
		}

		if (!empty($frames['wxapp']['section'])) {
			$wxapp_permission = permission_account_user('wxapp');
			foreach ($frames['wxapp']['section'] as $wxapp_section_id => $wxapp_section) {
				if ($status && !empty($wxapp_permission) && in_array("wxapp*", $wxapp_permission) && $wxapp_section_id != 'platform_module' && $role != ACCOUNT_MANAGE_NAME_OWNER) {
					$frames['wxapp']['section'][$wxapp_section_id]['is_display'] = false;
					continue;
				}
				if (!empty($wxapp_section['menu']) && $wxapp_section_id != 'platform_module') {
					foreach ($wxapp_section['menu'] as $wxapp_menu_id => $wxapp_menu) {
						if (in_array($wxapp_section_id, array('wxapp_profile', 'wxapp_entrance', 'statistics', 'mc'))) {
							$frames['wxapp']['section'][$wxapp_section_id]['menu'][$wxapp_menu_id]['url'] .= 'version_id=' . $version_id;
						}
						if (!in_array('wxapp*', $wxapp_permission) && !in_array($wxapp_menu['permission_name'], $wxapp_permission)) {
							$frames['wxapp']['section'][$wxapp_section_id]['menu'][$wxapp_menu_id]['is_display'] = false;
						}
					}
				}
			}
		}
	}

	if (defined('FRAME') && FRAME == 'phoneapp') {
		load()->model('phoneapp');
		$version_id = intval($_GPC['version_id']);
		$phoneapp_version = phoneapp_version($version_id);
		if (!empty($phoneapp_version['modules'])) {
			foreach ($phoneapp_version['modules'] as $module) {
				$phoneapp_module_permission = permission_account_user_menu($_W['uid'], $_W['uniacid'], $module['name']);
				if (empty($phoneapp_module_permission)) {
					$frames['phoneapp']['section']['platform_module']['is_display'] = false;
					break;
				}
				$frames['phoneapp']['section']['platform_module']['menu']['module_menu'.$module['mid']] = array(
						'title' => "<img src='{$module['logo']}'> {$module['title']}",
						'url' => url('phoneapp/display/switch', array('module' => $module['name'], 'version_id' => $version_id)),
						'is_display' => 1,
				);
			}
		} else {
			$frames['phoneapp']['section']['platform_module']['menu']['platform_module_more'] = array(
				'title' => '更多应用',
				'url' => url('phoneapp/description'),
				'is_display' => 1,
			);
		}

		if (!empty($frames['phoneapp']['section'])) {
			$phoneapp_permission = permission_account_user('phoneapp');
			foreach ($frames['phoneapp']['section'] as $phoneapp_section_id => $phoneapp_section) {
				if ($status && !empty($phoneapp_permission) && in_array("phoneapp*", $phoneapp_permission) && $phoneapp_section_id != 'platform_module' && $role != ACCOUNT_MANAGE_NAME_OWNER) {
					$frames['phoneapp']['section'][$phoneapp_section_id]['is_display'] = false;
					continue;
				}
				if (!empty($phoneapp_section['menu']) && $phoneapp_section_id != 'platform_module') {
					foreach ($phoneapp_section['menu'] as $phoneapp_menu_id => $phoneapp_menu) {
						if ($phoneapp_section_id == 'phoneapp_profile' || $phoneapp_section_id == 'phoneapp_entrance') {
							$frames['phoneapp']['section'][$phoneapp_section_id]['menu'][$phoneapp_menu_id]['url'] .= 'version_id=' . $version_id;
						}
						if (!in_array('phoneapp*', $phoneapp_permission) && !in_array($phoneapp_menu['permission_name'], $phoneapp_permission)) {
							$frames['phoneapp']['section'][$phoneapp_section_id]['menu'][$phoneapp_menu_id]['is_display'] = false;
						}
					}
				}
			}
		}
	}
	$frames = frames_top_menu($frames);
	return !empty($framename) ? ($framename == 'system_welcome' ? $frames['account'] : $frames[$framename]) : $frames;
}

function frames_top_menu($frames) {
	global $_W, $top_nav;
	if (empty($frames)) {
		return array();
	}
	$is_vice_founder = user_is_vice_founder();
	foreach ($frames as $menuid => $menu) {
		
		
			if (!empty($menu['founder']) && empty($_W['isfounder']) ||
				is_array($_W['setting']['store']['blacklist']) && in_array($_W['username'], $_W['setting']['store']['blacklist'])&& !empty($_W['setting']['store']['permission_status']) && $_W['setting']['store']['permission_status']['blacklist'] && $menuid == 'store' ||
				is_array($_W['setting']['store']['whitelist']) && !in_array($_W['username'], $_W['setting']['store']['whitelist']) && !empty($_W['setting']['store']['permission_status']) && $_W['setting']['store']['permission_status']['whitelist'] && !($_W['isfounder'] && !$is_vice_founder) && $menuid == 'store' ||
				$is_vice_founder && in_array($menuid, array('site', 'advertisement', 'appmarket')) ||
				$_W['role'] == ACCOUNT_MANAGE_NAME_CLERK && in_array($menuid, array('account', 'wxapp', 'system', 'platform')) ||
				!$menu['is_display'] || $_W['setting']['store']['status'] == 1 && $menuid == 'store' && (!$_W['isfounder'] || $is_vice_founder)) {
				continue;
			}
		
		$top_nav[] = array(
			'title' => $menu['title'],
			'name' => $menuid,
			'url' => $menu['url'],
			'blank' => $menu['blank'],
			'icon' => $menu['icon'],
			'is_display' => $menu['is_display'],
		);
	}
	return $frames;
}

function system_modules() {
	return array(
		'basic', 'news', 'music', 'service', 'userapi', 'recharge', 'images', 'video', 'voice', 'wxcard',
		'custom', 'chats', 'paycenter', 'keyword', 'special', 'welcome', 'default', 'apply', 'reply', 'core'
	);
}


function filter_url($params) {
	global $_W;
	if(empty($params)) {
		return '';
	}
	$query_arr = array();
	$parse = parse_url($_W['siteurl']);
	if(!empty($parse['query'])) {
		$query = $parse['query'];
		parse_str($query, $query_arr);
	}
	$params = explode(',', $params);
	foreach($params as $val) {
		if(!empty($val)) {
			$data = explode(':', $val);
			$query_arr[$data[0]] = trim($data[1]);
		}
	}
	$query_arr['page'] = 1;
	$query = http_build_query($query_arr);
	return './index.php?' . $query;
}

function url_params($url) {
	$result = array();
	if (empty($url)) {
		return $result;
	}
	$components = parse_url($url);
	$params = explode('&',$components['query']);
	foreach ($params as $param) {
		if (!empty($param)) {
			$param_array = explode('=',$param);
			$result[$param_array[0]] = $param_array[1];
		}
	}
	return $result;
}

function frames_menu_append() {
	$system_menu_default_permission = array(
		'founder' => array(),
		'owner' => array(
			'system_account',
			'system_module',
			'system_wxapp',
			'system_module_wxapp',
			'system_webapp',
			'system_module_webapp',
			'system_phoneapp',
			'system_module_phoneapp',
			'system_xzapp',
			'system_module_xzapp',
			'system_my',
			'system_setting_updatecache',
			'system_message_notice',
		),
		'manager' => array(
			'system_account',
			'system_module',
			'system_wxapp',
			'system_module_wxapp',
			'system_my',
			'system_setting_updatecache',
			'system_message_notice',
		),
		'operator' => array(
			'system_account',
			'system_wxapp',
			'system_my',
			'system_setting_updatecache',
			'system_message_notice',
		),
		'clerk' => array(
			'system_my',
		),
		'expired' => array(
			'system_my',
			'system_setting_updatecache',
		)
	);
	return $system_menu_default_permission;
}


function site_profile_perfect_tips(){
	global $_W;

	if ($_W['isfounder'] && (empty($_W['setting']['site']) || empty($_W['setting']['site']['profile_perfect']))) {
		if (!defined('SITE_PROFILE_PERFECT_TIPS')) {
			$url = url('cloud/profile');
			return <<<EOF
$(function() {
	var html =
		'<div class="we7-body-alert">'+
			'<div class="container">'+
				'<div class="alert alert-info">'+
					'<i class="wi wi-info-sign"></i>'+
					'<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true" class="wi wi-error-sign"></span><span class="sr-only">Close</span></button>'+
//					'<a href="{$url}" target="_blank">请尽快完善您在微擎云服务平台的站点注册信息。</a>'+
				'</div>'+
			'</div>'+
		'</div>';
	$('body').prepend(html);
});
EOF;
			define('SITE_PROFILE_PERFECT_TIPS', true);
		}
	}
	return '';
}
