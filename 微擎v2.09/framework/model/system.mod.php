<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

function system_menu() {
	global $we7_system_menu;
	require_once IA_ROOT . '/web/common/frames.inc.php';
	return $we7_system_menu;
}

function system_shortcut_menu() {
	global $_W;
	static $shortcut_menu;
	load()->model('user');

	if (empty($shortcut_menu)) {
		$shortcut_menu = array();
		$system_menu = system_menu();
		$is_main_founder = user_is_founder($_W['uid'], true);
		$is_vice_founder = user_is_vice_founder();
		$hidden_menu = array_keys((array) pdo_getall('core_menu', array('is_display' => 0), array('id', 'permission_name'), 'permission_name'));

		foreach (array('system', 'site') as $top_menu) {
			if (!empty($system_menu[$top_menu]['founder']) && !$is_main_founder) {
				continue;
			}
			$shortcut_menu[$top_menu] = $system_menu[$top_menu];
			foreach ($shortcut_menu[$top_menu]['section'] as $section_key => &$section) {
				if (!empty($section['founder']) && !$is_main_founder) {
					unset($shortcut_menu[$top_menu]['section'][$section_key]);
				}
				foreach ($section['menu'] as $i => $menu) {
					if (!isset($menu['is_display'])) {
						$section['menu'][$i]['is_display'] = 1;
					}
					if (in_array($menu['permission_name'], $hidden_menu)) {
						$section['menu'][$i]['is_display'] = 0;
					}
				}
			}
		}

		$store_setting = $_W['setting']['store'];
		if ($is_main_founder || empty($store_setting['status'])) {
						if (!$is_main_founder && !empty($_W['username']) && !empty($store_setting['permission_status']) && empty($store_setting['permission_status']['close'])) {
				if (!in_array($_W['username'], (array)$store_setting['whitelist']) && !empty($store_setting['permission_status']['whitelist'])
					|| in_array($_W['username'], (array)$store_setting['blacklist']) && !empty($store_setting['permission_status']['blacklist'])
				) {
					$system_menu['store'] = array();
				}
			}
			if (!empty($system_menu['store']['section'])) {
				$shortcut_menu['store'] = $system_menu['store'];
				foreach ($shortcut_menu['store']['section'] as $key => &$section) {
					if (in_array($key, array('store_manage', 'store_payments', 'store_cash_manage')) && !$is_main_founder) {
						$section['is_display'] = 0;
						continue;
					}
					if ($key == 'store_cash' && (!$is_vice_founder || empty($store_setting['cash_status']))) {
						$section['is_display'] = 0;
						continue;
					}
					foreach ($section['menu'] as $menu_key => &$menu) {
						$menu['is_display'] = 1;
						if ($key == 'store_goods' && !empty($store_setting[$menu_key])) {
							$menu['is_display'] = 0;
						}
						if ($menu_key == 'store_goods_users_package' && $is_vice_founder) {
							$menu['is_display'] = 0;
						}
						if ($menu_key == 'store_cash_orders' && (!$is_vice_founder || empty($store_setting['cash_status']))) {
							$menu['is_display'] = 0;
						}
						if ($menu_key == 'store_check_cash' && empty($store_setting['cash_status'])) {
							$menu['is_display'] = 0;
						}
					}
				}
			}
		}
	}
	return $shortcut_menu;
}


function system_menu_permission_list($role = '') {
	global $_W;
	$system_menu = cache_load(cache_system_key('system_frame', array('uniacid' => $_W['uniacid'])));
	if(empty($system_menu)) {
		cache_build_frame_menu();
		$system_menu = cache_load(cache_system_key('system_frame', array('uniacid' => $_W['uniacid'])));
	}
		if ($role == ACCOUNT_MANAGE_NAME_OPERATOR) {
		unset($system_menu['appmarket']);
		unset($system_menu['advertisement']);
		unset($system_menu['system']);
	}
	return $system_menu;
}

function system_database_backup() {
	$path = IA_ROOT . '/data/backup/';
	load()->func('file');
	$reduction = array();
	if (!is_dir($path)) {
		return array();
	}
	if ($handle = opendir($path)) {
		while (false !== ($bakdir = readdir($handle))) {
			if ($bakdir == '.' || $bakdir == '..') {
				continue;
			}
			$times[] = date("Y-m-d H:i:s", filemtime($path.$bakdir));
			if (preg_match('/^(?P<time>\d{10})_[a-z\d]{8}$/i', $bakdir, $match)) {
				$time = $match['time'];
				if ($handle1= opendir($path . $bakdir)) {
					while (false !== ($filename = readdir($handle1))) {
						if ($filename == '.' || $filename == '..') {
							continue;
						}
						if (preg_match('/^volume-(?P<prefix>[a-z\d]{10})-\d{1,}\.sql$/i', $filename, $match1)) {
							$volume_prefix = $match1['prefix'];
							if (!empty($volume_prefix)) {
								break;
							}
						}
					}
				}
				$volume_list = array();
				for ($i = 1;;) {
					$last = $path . $bakdir . "/volume-{$volume_prefix}-{$i}.sql";
					array_push($volume_list, $last);
					$i++;
					$next = $path . $bakdir . "/volume-{$volume_prefix}-{$i}.sql";
					if (!is_file($next)) {
						break;
					}
				}
				if (is_file($last)) {
					$fp = fopen($last, 'r');
					fseek($fp, -27, SEEK_END);
					$end = fgets($fp);
					fclose($fp);
					if ($end == '----WeEngine MySQL Dump End') {
						$row = array(
							'bakdir' => $bakdir,
							'time' => $time,
							'volume' => $i - 1,
							'volume_list' => $volume_list,
						);
						$reduction[$bakdir] = $row;
						continue;
					}
				}
			}
			rmdirs($path . $bakdir);
		}
		closedir($handle);
	}
	if (!empty($times)) {
		array_multisort($times, SORT_DESC, SORT_STRING, $reduction);
	}
	return $reduction;
}

function system_database_volume_next($volume_name) {
	$next_volume_name = '';
	if (!empty($volume_name) && preg_match('/^([^\s]*volume-(?P<prefix>[a-z\d]{10})-)(\d{1,})\.sql$/i', $volume_name, $match)) {
		$next_volume_name = $match[1] . ($match[3] + 1) . ".sql";
	}
	return $next_volume_name;
}

function system_database_volume_restore($volume_name) {
	if (empty($volume_name) || !is_file($volume_name)) {
		return false;
	}
	$sql = file_get_contents($volume_name);
	pdo_run($sql);
	return true;
}

function system_database_backup_delete($delete_dirname) {
	$path = IA_ROOT . '/data/backup/';
	$dir = $path . $delete_dirname;
	if (empty($delete_dirname) || !is_dir($dir)) {
		return false;
	}
	return rmdirs($dir);
}


function system_template_ch_name() {
	$result = array(
		'default' => '白色',
		'black' => '黑色',
		'classical' => '经典',
		'2.0' => '2.0',
	);
	return $result;
}


function system_site_info() {
	load()->classs('cloudapi');

	$api = new CloudApi();
	$site_info = $api->get('site', 'info');
	return $site_info;
}


function system_check_statcode($statcode) {
	$allowed_stats = array(
		'baidu' => array(
			'enabled' => true,
			'reg' => '/(http[s]?\:)?\/\/hm\.baidu\.com\/hm\.js\?/'
		),

		'qq' => array(
			'enabled' => true,
			'reg' => '/(http[s]?\:)?\/\/tajs\.qq\.com/'
		),
	);
	foreach($allowed_stats as $key => $item) {
		$preg = preg_match($item['reg'], $statcode);
		if ($preg && $item['enabled']) {
			return htmlspecialchars_decode($statcode);
		} else {
			return safe_gpc_html(htmlspecialchars_decode($statcode));
		}
	}
}


function system_check_items() {
	return array(
		'mbstring' => array(
			'operate' => 'system_check_php_ext',
			'description' => 'mbstring 扩展',
			'error_message' => '不支持库',
			'solution' => '安装 mbstring 扩展',
			'handle' => 'https://bbs.w7.cc/thread-33156-1-1.html'
		),
		'mcrypt' => array(
			'operate' => 'system_check_php_ext',
			'description' => 'mcrypt 扩展',
			'error_message' => '不支持库',
			'solution' => '安装 mcrypt 扩展',
			'handle' => 'https://bbs.w7.cc/thread-33159-1-1.html'
		),
		'openssl' => array(
			'operate' => 'system_check_php_ext',
			'description' => 'openssl 扩展',
			'error_message' => '不支持库',
			'solution' => '安装 openssl 扩展',
			'handle' => 'https://bbs.w7.cc/thread-33160-1-1.html'
		),
		'system_template' => array(
			'operate' => 'system_check_template',
			'description' => '是否系统皮肤',
			'error_message' => '不是系统皮肤',
			'solution' => '更换系统默认皮肤',
			'handle' => 'https://bbs.w7.cc/thread-33162-1-1.html'
		),
		'max_allowed_packet' => array(
			'operate' => 'system_check_mysql_params',
			'description' => 'mysql max_allowed_packet 值',
			'error_message' => 'max_allowed_packet 小于 20M',
			'solution' => '修改 mysql max_allowed_packet 值',
			'handle' => 'https://bbs.w7.cc/thread-33415-1-1.html'
		)
	);
}


function system_check_php_ext($extension) {
	return extension_loaded($extension) ? true : false;
}

function system_check_mysql_params($param) {
	$check_result = pdo_fetchall("SHOW GLOBAL VARIABLES LIKE '{$param}'");
	return $check_result[0]['Value'] < 1024*1024*20 ? false : true;
}


function system_check_template() {
	global $_W;
	$current_template = $_W['template'];
	$template_ch_name = system_template_ch_name();
	return in_array($current_template, array_keys($template_ch_name)) ? true : false;
}


function system_setting_items() {
	$items = array(
		'bind',
		'develop_status',
		'icp',
		'login_type',
		'log_status',
		'mobile_status',
		'reason',
		'status',
		'welcome_link',
	);

	
		$more_items = array(
			'address',
			'blogo',
			'baidumap',
			'background_img',
			'company',
			'companyprofile',
			'description',
			'email',
			'footerleft',
			'footerright',
			'flogo',
			'icon',
			'keywords',
			'leftmenufixed',
			'notice',
			'oauth_bind',
			'phone',
			'person',
			'qq',
			'statcode',
			'slides',
			'showhomepage',
			'sitename',
			'template',
			'url',
			'verifycode',
		);
		$items = array_merge($items, $more_items);
	

	return $items;
}