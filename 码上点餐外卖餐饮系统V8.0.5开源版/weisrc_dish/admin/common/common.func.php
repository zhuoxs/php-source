<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');


function url($segment, $params = array()) {

	list($controller, $action, $do) = explode('/', $segment);
	$url = './store.php?';
	if(!empty($controller)) {
		$url .= "c={$controller}&";
	}
	if(!empty($action)) {
		$url .= "a={$action}&";
	}
	if(!empty($do)) {
		$url .= "do={$do}&";
	}
	if(!empty($params)) {
		$queryString = http_build_query($params, '', '&');
		$url .= $queryString;
	}
	return $url;

//	return wurl($segment, $params);
}

function message($msg, $redirect = '', $type = '') {
	global $_W, $_GPC;
	if($redirect == 'refresh') {
		$redirect = $_W['script_name'] . '?' . $_SERVER['QUERY_STRING'];
	}
	if($redirect == 'referer') {
		$redirect = referer();
	}
	if($redirect == '') {
		$type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'info';
	} else {
		$type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'success';
	}
	if ($_W['isajax'] || !empty($_GET['isajax']) || $type == 'ajax') {


		if($type != 'ajax' && !empty($_GPC['target'])) {
			exit("
<script type=\"text/javascript\">
parent.require(['jquery', 'util'], function($, util){
	var url = ".(!empty($redirect) ? 'parent.location.href' : "''").";
	var modalobj = util.message('".$msg."', '', '".$type."');
	if (url) {
		modalobj.on('hide.bs.modal', function(){\$('.modal').each(function(){if(\$(this).attr('id') != 'modal-message') {\$(this).modal('hide');}});top.location.reload()});
	}
});
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
		header('location: '.$redirect);
	}
	$label = $type;
	if($type == 'error') {
		$label = 'danger';
	}
	if($type == 'ajax' || $type == 'sql') {
		$label = 'warning';
	}
	include template('common/message', TEMPLATE_INCLUDEPATH);
	exit();
}


function checklogin() {
	global $_W;
	if (empty($_W['uid'])) {
		$url = url('user/login');
		header('location:' . $url);
	} else {
		$account = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_account") . " WHERE status=2 AND uid=:uid ORDER BY id DESC LIMIT 1", array(':uid' => $_W['uid']));
		if (empty($account)) {
			$url = url('user/login');
			header('location:' . $url);
//			$storeid = $account['storeid'];
//			$url = url('site/entry/stores', array('m' => 'weisrc_dish', 'storeid' => $storeid, 'do' => 'start'));
//			header('location:' . $url);
		}
	}
	return true;
}


function checkaccount() {
	global $_W;
	if (empty($_W['uniacid'])) {
		message('这项功能需要你选择特定公众号才能使用！', url('account/display'), 'info');
	}
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

function buildframes($frame = array('platform')){
	global $_W, $_GPC;
	if($_W['role'] == 'clerk') {
		return false;
	}
	$GLOBALS['top_nav'] = pdo_fetchall('SELECT name, title, append_title FROM ' . tablename('core_menu') . ' WHERE pid = 0 AND is_display = 1 ORDER BY displayorder DESC');
	$ms = cache_load('system_frame');
	if(empty($ms)) {
		cache_build_frame_menu();
		$ms = cache_load('system_frame');
	}
	load()->model('module');
	$frames = array();
	$modules = uni_modules(false);
	$modules_temp = array_keys($modules);
	$status = uni_user_permission_exist();
	if(is_error($status)) {
		$modules_temp = pdo_fetchall('SELECT type FROM ' . tablename('users_permission') . ' WHERE uniacid = :uniacid AND uid = :uid AND type != :type', array(':uniacid' => $_W['uniacid'], ':uid' => $_W['uid'], ':type' => 'system'), 'type');
		if(!empty($modules_temp)) {
			$modules_temp = array_keys($modules_temp);
		} else {
			$modules = array();
		}
	}
	if(!empty($modules)) {
		$sysmods = system_modules();
		foreach($modules as $m) {
			if (empty($m['isdisplay'])) {
				continue;
			}
			if(in_array($m['name'], $sysmods)) {
				$_W['setting']['permurls']['modules'][] = $m['name'];
				continue;
			}
			if(in_array($m['name'], $modules_temp)) {
				if($m['enabled']) {
					$frames[$m['type']][] = $m;
				}
				$_W['setting']['permurls']['modules'][] = $m['name'];
			}
		}
	}
	if(is_error($status)) {
		$system = array();
		$system = uni_user_permission('system');
		if (!empty($system) || !empty($modules_temp)) {
						foreach ($ms as $name => $section) {
				$hassection = false;
				foreach ($section as $i => $menus) {
					$hasitems = false;
					if(empty($menus['items'])) continue;
					foreach ($menus['items'] as $j => $menu) {
						if (!in_array($menu['permission_name'], $system)) {
							unset($ms[$name][$i]['items'][$j]);
						} else {
							$hasitems = true;
							$hassection = true;
						}
					}
					if (!$hasitems) {
						unset($ms[$name][$i]);
					}
				}
				if (!$hassection) {
					unset($ms[$name]);
				} else {
					$_W['setting']['permurls']['sections'][] = $name;
				}
			}
		}
	}
	$types = module_types();
	if(!empty($frames)) {
		foreach($frames as $type => $fs) {
			$items = array();
			if(!empty($fs)) {
				foreach($fs as $m) {
					$items[] = array(
						'title' => $m['title'],
						'url' => url('home/welcome/ext', array('m' => $m['name']))
					);
				}
			}
			$ms['ext'][] = array(
				'title' => $types[$type]['title'],
				'items' => $items
			);
		}
		if(is_error($status)) {
			$_W['setting']['permurls']['sections'][] = 'ext';
		}
	}
	$GLOBALS['ext_type'] = 0;
	$m = trim($_GPC['m']);
	$eid = intval($_GPC['eid']);
	if(FRAME == 'ext' && (!empty($m) || !empty($eid)) && $GLOBALS['ext_type'] != 2) {
		if(empty($_COOKIE['ext_type'])) {
			setcookie('ext_type', 1, TIMESTAMP + 8640000, "/");
			$_COOKIE['ext_type'] = 1;
		}
		$GLOBALS['ext_type'] = $_COOKIE['ext_type'];
		if(empty($m)) {
			$m = pdo_fetchcolumn('SELECT module FROM ' . tablename('modules_bindings') . ' WHERE eid = :eid', array(':eid' => $eid));
		}
		$module = module_fetch($m);
		$entries = module_entries($m);
		if(is_error($status)) {
			$permission = uni_user_permission($m);
			if($permission[0] != 'all') {
				if(!in_array($m.'_rule', $permission)) {
					unset($module['isrulefields']);
				}
				if(!in_array($m.'_settings', $permission)) {
					unset($module['settings']);
				}
				if(!in_array($m.'_home', $permission)) {
					unset($entries['home']);
				}
				if(!in_array($m.'_profile', $permission)) {
					unset($entries['profile']);
				}
				if(!in_array($m.'_shortcut', $permission)) {
					unset($entries['shortcut']);
				}
				if(!empty($entries['cover'])) {
					foreach($entries['cover'] as $k => $row) {
						if(!in_array($m.'_cover_'.$row['do'], $permission)) {
							unset($entries['cover'][$k]);
						}
					}
				}
				if(!empty($entries['menu'])) {
					foreach($entries['menu'] as $k => $row) {
						if(!in_array($m.'_menu_'.$row['do'], $permission)) {
							unset($entries['menu'][$k]);
						}
					}
				}
			}
		}
		$entries_filter = array_elements(array('cover', 'menu', 'mine'), $entries);
		$navs = array(
			array(
				'title' => "模块列表",
				'items' => array(
					array(
						'title' => "<i class='fa fa-reply-all'></i> &nbsp;&nbsp;返回模块列表",
						'url' => url('home/welcome/ext', array('a' => 0)),
					),
					array(
						'title' => "<i class='fa fa-reply-all'></i> &nbsp;&nbsp;返回{$module['title']}",
						'url' => url('home/welcome/ext', array('m' => $m, 't' => 1)),
					),
				),
			),
		);
		if($module['isrulefields'] || $module['settings']) {
			$navs['rule'] = array(
				'title' => "回复规则",
			);
			if($module['isrulefields']) {
				$navs['rule']['items'][] = array(
					'title' => "<i class='fa fa-comments'></i> &nbsp;&nbsp;回复规则列表",
					'url' => url('platform/reply', array('m' => $m)),
				);
			}
			if($module['settings']) {
				$navs['rule']['items'][] = array(
					'title' => "<i class='fa fa-cog'></i> &nbsp;&nbsp;参数设置",
					'url' => url('profile/module/setting', array('m' => $m)),
				);
			}
		}
		if($entries['home'] || $entries['profile'] || $entries['shortcut']) {
			$navs['nav'] = array(
				'title' => "导航菜单",
			);
			if($entries['home']) {
				$navs['nav']['items'][] = array(
					'title' => "<i class='fa fa-home'></i> &nbsp;&nbsp;微站首页导航",
					'url' => url('site/nav/home', array('m' => $m)),
				);
			}
			if($entries['profile']) {
				$navs['nav']['items'][] = array(
					'title' => "<i class='fa fa-user'></i> &nbsp;&nbsp;个人中心导航",
					'url' => url('site/nav/profile', array('m' => $m)),
				);
			}
			if($entries['shortcut']) {
				$navs['nav']['items'][] = array(
					'title' => "<i class='fa fa-plane'></i> &nbsp;&nbsp;快捷菜单",
					'url' => url('site/nav/shortcut', array('m' => $m)),
				);
			}
		}
		$menus = array(
			'menu' => "业务菜单",
			'cover' => "封面入口",
			'mine' => "自定义菜单",
		);

		foreach($entries_filter as $key => $row) {
			if(empty($row)) continue;
			if(!isset($navs[$key])) {

				$navs[$key] = array(
					'title' => $menus[$key],
				);
			}
			foreach($row as $li) {
				$navs[$key]['items'][] = array(
					'title' => "<i class='{$li["icon"]}'></i> &nbsp;&nbsp;{$li['title']}",
					'url' => $li['url']
				);
			}
		}
	}
	if($GLOBALS['ext_type'] == 1) {
		$ms['ext'] = $navs;
	} elseif($GLOBALS['ext_type'] == 3) {
		$ms['ext'] = array_merge($navs, $ms['ext']);
	}
	return $ms;
}

function system_modules() {
	return array(
		'basic', 'news', 'music', 'userapi', 'recharge', 
		'custom', 'images', 'video', 'voice', 'chats', 'wxcard', 'paycenter'
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


function site_profile_perfect_tips(){
	global $_W;
	
	if ($_W['isfounder'] && (empty($_W['setting']['site']) || empty($_W['setting']['site']['profile_perfect']))) {
		if (!defined('SITE_PROFILE_PERFECT_TIPS')) {
			$url = url('cloud/profile');
			return <<<EOF
$(function() {
	var html = 
		'<div id="siteinfo-tips" class="upgrade-tips">'+
			'<a href="{$url}" target="_blank">请尽快完善您在微擎云服务平台的站点注册信息。</a>'+
		'</div>';
	$('body').prepend(html);
});
EOF;
			define('SITE_PROFILE_PERFECT_TIPS', true);
		}
	}
	return '';
}
