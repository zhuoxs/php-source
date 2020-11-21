<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
load()->model('reply');
load()->model('module');

$dos = array('display', 'post', 'delete', 'change_status', 'change_keyword_status');
$do = in_array($do, $dos) ? $do : 'display';

$m = empty($_GPC['m']) ? 'keyword' : trim($_GPC['m']);
if (in_array($m, array('keyword', 'special', 'welcome', 'default', 'apply', 'service', 'userapi'))) {
	permission_check_account_user('platform_reply');
} else {
	permission_check_account_user('', true, 'reply');
	$modules = uni_modules();
	$_W['current_module'] = $modules[$m];
	define('IN_MODULE', $m);
}
$_W['page']['title'] = '自动回复';
if (empty($m)) {
	itoast('错误访问.', '', '');
}
if ($m == 'special') {
	$mtypes = array(
		'image' => '图片消息',
		'voice' => '语音消息',
		'video' => '视频消息',
		'shortvideo' => '小视频消息',
		'location' => '位置消息',
		'trace' => '上报地理位置',
		'link' => '链接消息',
		'merchant_order' => '微小店消息',
		'ShakearoundUserShake' => '摇一摇:开始摇一摇消息',
		'ShakearoundLotteryBind' => '摇一摇:摇到了红包消息',
		'WifiConnected' => 'Wifi连接成功消息',
		'qr' => '二维码',
	);

	if (in_array($_W['account']['type'], array(ACCOUNT_TYPE_XZAPP_NORMAL, ACCOUNT_TYPE_XZAPP_AUTH))) {
		$mtypes = array(
			'image' => '图片消息',
			'voice' => '语音消息',
			'video' => '视频消息',
		);
	}
}

$sysmods = system_modules();
if (in_array($m, array('custom'))) {
	$site = WeUtility::createModuleSite('reply');
	$site_urls = $site->getTabUrls();
}
if ($do == 'display') {
	if ($m == 'keyword' || !in_array($m, $sysmods)) {
		$pindex = max(1, intval($_GPC['page']));
		$psize = 8;
		$cids = $parentcates = $list =  array();
		$condition = "uniacid = :uniacid AND module != 'cover' AND module != 'userapi'";
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		if (isset($_GPC['type']) && !empty($_GPC['type'])) {
			$type = trim($_GPC['type']);
			if ($type == 'apply') {
				$condition .= " AND module NOT IN ('basic', 'news', 'images', 'voice', 'video', 'music', 'wxcard', 'reply')";
			} else {
				if (!in_array($type, array('basic', 'news', 'images', 'voice', 'video', 'music', 'wxcard'))) {
					itoast('非法语句！', referer(), 'error');
				}
				$condition .= " AND (FIND_IN_SET('" . $type . "', `containtype`) OR module = :type)";
				$params[':type'] = $type;
			}
		}
		if (!in_array($m, $sysmods)) {
			$condition .= " AND `module` = :type";
			$params[':type'] = $m;
		}
		if (!empty($_GPC['keyword'])) {
			if ($_GPC['search_type'] == 'keyword') {
				$rule_keyword_rid_list = pdo_getall('rule_keyword',array('content LIKE' => "%{$_GPC['keyword']}%"),array('rid'),'rid',array('id DESC'));
				if (!empty($rule_keyword_rid_list)) {
					$condition .= " AND id IN (" . implode(",", array_keys($rule_keyword_rid_list)) . ")";
				}
			} else {
				$condition .= " AND `name` LIKE :keyword";
				$params[':keyword'] = "%{$_GPC['keyword']}%";
			}
		}
		if (!empty($_GPC['keyword']) && $_GPC['search_type'] == 'keyword' && empty($rule_keyword_rid_list)) {
			$replies = array();
			$pager = '';
		} else {
			$replies = reply_search($condition, $params, $pindex, $psize, $total);
			$pager = pagination($total, $pindex, $psize);
			if (!empty($replies)) {
				foreach ($replies as &$item) {
					$condition = '`rid`=:rid';
					$params = array();
					$params[':rid'] = $item['id'];
					$item['keywords'] = reply_keywords_search($condition, $params);
					$item['allreply'] = reply_contnet_search($item['id']);
					$entries = module_entries($item['module'], array('rule'),$item['id']);
					if (!empty($entries)) {
						$item['options'] = $entries['rule'];
					}
										if (!in_array($item['module'], array("basic", "news", "images", "voice", "video", "music", "wxcard", "reply"))) {
						$item['module_info'] = module_fetch($item['module']);
					}
				}
				unset($item);
			}
		}
		$entries = module_entries($m, array('rule'));
	}
	if ($m == 'special') {
		$setting = uni_setting_load('default_message', $_W['uniacid']);
		$setting = $setting['default_message'] ? $setting['default_message'] : array();
		$module = uni_modules();
	}
	if ($m == 'default' || $m == 'welcome') {
		$setting = uni_setting($_W['uniacid'], array($m));
		if (!empty($setting[$m])) {
			$rule_keyword_id = pdo_getcolumn('rule_keyword', array('uniacid' => $_W['uniacid'], 'content' => $setting[$m]), 'rid');
						$setting_keyword = $setting[$m];
		}
	}
	if ($m == 'service') {
		$service_list = reply_getall_common_service();
	}
	if ($m == 'userapi') {
		$pindex = max(1, intval($_GPC['page']));
		$psize = 8;

		$condition = "uniacid = :uniacid AND `module`=:module";
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$params[':module'] = 'userapi';
		if (!empty($_GPC['keyword'])) {
			if ($_GPC['search_type'] == 'keyword') {
				$rule_keyword_rid_list = pdo_getall('rule_keyword',array('content LIKE' => "%{$_GPC['keyword']}%"),array('rid'),'rid',array('id DESC'));
				if (!empty($rule_keyword_rid_list)) {
					$condition .= " AND id IN (" . implode(",", array_keys($rule_keyword_rid_list)) . ")";
				}
			} else {
				$condition .= " AND `name` LIKE :keyword" ;
				$params[':keyword'] = "%{$_GPC['keyword']}%";
			}
		}
		if (!empty($_GPC['keyword']) && $_GPC['search_type'] == 'keyword' && empty($rule_keyword_rid_list)) {
			$replies = array();
			$pager = '';
		} else {
			$replies = reply_search($condition, $params, $pindex, $psize, $total);
			$pager = pagination($total, $pindex, $psize);
			if (!empty($replies)) {
				foreach ($replies as &$item) {
					$condition = '`rid`=:rid';
					$params = array();
					$params[':rid'] = $item['id'];
					$item['keywords'] = reply_keywords_search($condition, $params);
				}
				unset($item);
			}
		}
	}
	template('platform/reply');
}
if ($do == 'post') {
	if ($m == 'keyword' || $m == 'userapi' || !in_array($m, $sysmods)) {
		$module['title'] = '关键字自动回复';
		if ($_W['isajax'] && $_W['ispost']) {
			$keyword = safe_gpc_string($_GPC['keyword']);
			$sensitive_word = detect_sensitive_word($keyword);
			if (!empty($sensitive_word)) {
				iajax(-2, '含有敏感词:' . $sensitive_word);
			}
			$keyword = preg_replace('/，/', ',', $keyword);
			$keyword_arr = explode(',', $keyword);
			$result = pdo_getall('rule_keyword', array('uniacid' => $_W['uniacid'], 'content IN' => $keyword_arr, 'status !=' => 1), array('rid'));
			if (!empty($result)) {
				$keywords = array();
				foreach ($result as $reply) {
					$keywords[] = $reply['rid'];
				}
				$rids = implode($keywords, ',');
				$sql = "SELECT `id`, `name` FROM " . tablename('rule') . " WHERE `id` IN ($rids)";
				$rules = pdo_fetchall($sql);
				iajax(-1, $rules, '');
			}
			iajax(0, '');
		}
		$rid = intval($_GPC['rid']);
		if (!empty($rid)) {
			$reply = reply_single($rid);
			if (empty($reply) || $reply['uniacid'] != $_W['uniacid']) {
				itoast('抱歉，您操作的规则不在存或是已经被删除！', url('platform/reply', array('m' => $m)), 'error');
			}
			if (!empty($reply['keywords'])) {
				foreach ($reply['keywords'] as &$keyword) {
					$keyword = array_elements(array('type', 'content'), $keyword);
				}
				unset($keyword);
			}
		}
		if (checksubmit('submit')) {

			$keywords = @json_decode(htmlspecialchars_decode($_GPC['keywords']), true);

			if (empty($keywords)) {
				itoast('必须填写有效的触发关键字.');
			}

			$rulename = trim($_GPC['rulename']);
			$containtype = '';
			$_GPC['reply'] = (array)$_GPC['reply'];

			foreach ($_GPC['reply'] as $replykey => $replyval) {
				if (!empty($replyval)) {
					$type = substr($replykey, 6);
					$containtype .= $type == 'image' ? 'images' : $type .',';
				}
			}
			if (empty($containtype) && in_array($m, $sysmods) && $m != 'userapi') {
				itoast('必须填写有效的回复内容！');
			}
			$rule = array(
				'uniacid' => $_W['uniacid'],
				'name' => $rulename,
				'module' => $m == 'keyword' ? 'reply' : $m,
				'containtype' => $containtype,
				'status' => $_GPC['status'] == 'true' ? 1 : 0,
				'displayorder' => intval($_GPC['displayorder_rule']),
			);
			if ($_GPC['istop'] == 1) {
				$rule['displayorder'] = 255;
			} else {
				$rule['displayorder'] = range_limit($rule['displayorder'], 0, 254);
			}

			if ($m == 'userapi') {
				$module = WeUtility::createModule('userapi');
			} else {
				$module = WeUtility::createModule('core');
			}
			$msg = $module->fieldsFormValidate();

			$module_info = module_fetch($m);
			if (!empty($module_info) && empty($module_info['issystem'])) {
				$user_module = WeUtility::createModule($m);
				if (empty($user_module)) {
					itoast('抱歉，模块不存在请重新选择其它模块！', '', '');
				}
				$user_module_error_msg = $user_module->fieldsFormValidate();
			}
			if ((is_string($msg) && trim($msg) != '') || (is_string($user_module_error_msg) && trim($user_module_error_msg) != '')) {
				itoast($msg.$user_module_error_msg, '', '');
			}
			if (!empty($rid)) {
				$result = pdo_update('rule', $rule, array('id' => $rid));
			} else {
				$result = pdo_insert('rule', $rule);
				$rid = pdo_insertid();
			}

			if (!empty($rid)) {
				pdo_delete('rule_keyword', array('rid' => $rid, 'uniacid' => $_W['uniacid']));

				$rowtpl = array(
					'rid' => $rid,
					'uniacid' => $_W['uniacid'],
					'module' => $m == 'keyword' ? 'reply' : $m,
					'status' => $rule['status'],
					'displayorder' => $rule['displayorder'],
				);
				foreach ($keywords as $kw) {
					$krow = $rowtpl;
					$krow['type'] = range_limit($kw['type'], 1, 4);
					$krow['content'] = htmlspecialchars($kw['content']);
					pdo_insert('rule_keyword', $krow);
				}
				$kid = pdo_insertid();
				$module->fieldsFormSubmit($rid);
				if (!empty($module_info) && empty($module_info['issystem'])) {
					$user_module->fieldsFormSubmit($rid);
				}
				itoast('回复规则保存成功！', url('platform/reply', array('m' => $m)), 'success');
			} else {
				itoast('回复规则保存失败, 请联系网站管理员！', url('platform/reply', array('m' => $m)), 'error');
			}
		}
		template('platform/reply-post');
	}
	if ($m == 'special') {
		$type = trim($_GPC['type']);
		$setting = uni_setting_load('default_message', $_W['uniacid']);
		$setting = $setting['default_message'] ? $setting['default_message'] : array();
		if (checksubmit('submit')) {
			$rule_id = intval(trim(htmlspecialchars_decode($_GPC['reply']['reply_keyword']), "\""));
			$module = trim(htmlspecialchars_decode($_GPC['reply']['reply_module']), "\"");
			if ((empty($rule_id) && empty($module)) || $_GPC['status'] === '0') {
				$setting[$type] = array('type' => '', 'module' => $module, 'keyword' => $rule_id);
				uni_setting_save('default_message', $setting);
				itoast('关闭成功', url('platform/reply', array('m' => 'special')), 'success');
			}
			$reply_type = empty($rule_id) ? 'module' : 'keyword';
			$reply_module = WeUtility::createModule('core');
			$result = $reply_module->fieldsFormValidate();
			if (is_error($result)) {
				itoast($result['message'], '', 'info');
			}

			if ($reply_type == 'module') {
				$setting[$type] = array('type' => 'module', 'module' => $module);
			} else {
				$rule = pdo_get('rule_keyword', array('id' => $rule_id, 'uniacid' => $_W['uniacid']));
				$setting[$type] = array('type' => 'keyword', 'keyword' => $rule['content']);
			}
			uni_setting_save('default_message', $setting);
			itoast('发布成功', url('platform/reply', array('m' => 'special')), 'success');
		}
		if ($setting[$type]['type'] == 'module') {
			$rule_id = $setting[$type]['module'];
		} else {
			$rule_id = pdo_getcolumn('rule_keyword', array('uniacid' => $_W['uniacid'], 'content' => $setting[$type]['keyword']), 'rid');
						$setting_keyword = $setting[$type]['keyword'];
		}
		template('platform/specialreply-post');
	}
	if ($m == 'default' || $m == 'welcome') {
		if (checksubmit('submit')) {
			$rule_keyword_id = intval(trim(htmlspecialchars_decode($_GPC['reply']['reply_keyword']), "\""));
			if (!empty($rule_keyword_id)) {
				$rule = pdo_get('rule_keyword', array('id' => $rule_keyword_id, 'uniacid' => $_W['uniacid']));
				$settings = array(
					$m => $rule['content']
				);
			} else {
				$settings = array($m => '');
			}
			$item = pdo_fetch("SELECT uniacid FROM " . tablename('uni_settings') . " WHERE uniacid=:uniacid", array(':uniacid' => $_W['uniacid']));
			if (!empty($item)){
				pdo_update('uni_settings', $settings, array('uniacid' => $_W['uniacid']));
			} else {
				$settings['uniacid'] = $_W['uniacid'];
				pdo_insert('uni_settings', $settings);
			}
			cache_delete(cache_system_key('unisetting', array('uniacid' => $_W['uniacid'])));
			cache_delete(cache_system_key('keyword', array('content' => md5($rule['content']), 'uniacid' => $_W['uniacid'])));
			itoast('系统回复更新成功！', url('platform/reply', array('m' => $m)), 'success');
		}
	}
	if ($m == 'apply') {
		$module['title'] = '应用关键字';
		$installedmodulelist = uni_modules();
		foreach ($installedmodulelist as $key => &$value) {
			if ($value['type'] == 'system' || in_array($value['name'], $sysmods)) {
				unset($installedmodulelist[$key]);
				continue;
			}
			$value['official'] = empty($value['issystem']) && (strexists($value['author'], 'WeEngine Team') || strexists($value['author'], ''));
		}
		unset($value);
		foreach ($installedmodulelist as $name => $module) {
			if (empty($module['isrulefields']) && $name != "core") {
				continue;
			}
			$module['title_first_pinyin'] = get_first_pinyin($module['title']);
			if ($module['issystem']) {
				$path = '../framework/builtin/' . $module['name'];
			} else {
				$path = '../addons/' . $module['name'];
			}
			$cion = $path . '/icon-custom.jpg';
			if (!file_exists($cion)) {
				$cion = $path . '/icon.jpg';
				if (!file_exists($cion)) {
					$cion = './resource/images/nopic-small.jpg';
				}
			}
			$module['icon'] = $cion;

			if ($module['enabled'] == 1) {
				$enable_modules[$name] = $module;
			} else {
				$unenable_modules[$name] = $module;
			}
		}
		$current_user_permissions = pdo_getall('users_permission', array('uid' => $_W['user']['uid'], 'uniacid' => $_W['uniacid']), array(), 'type');
		if (!empty($current_user_permissions)) {
			$current_user_permission_types = array_keys($current_user_permissions);
		}
		$moudles = true;
		template('platform/reply-post');
	}
}

if ($do == 'delete') {
	$rids = $_GPC['rid'];
	if (!is_array($rids)) {
		$rids = array($rids);
	}
	if (empty($rids)) {
		itoast('非法访问.', '', '');
	}
	foreach ($rids as $rid) {
		$rid = intval($rid);
		$reply = reply_single($rid);
		if (empty($reply) || $reply['uniacid'] != $_W['uniacid']) {
			itoast('抱歉，您操作的规则不在存或是已经被删除！', url('platform/reply', array('m' => $m)), 'error');
		}
				if (pdo_delete('rule', array('id' => $rid))) {
			pdo_delete('rule_keyword', array('rid' => $rid));
						if (!in_array($m, $sysmods)) {
				$reply_module = $m;
			} else {
				if ($m == 'userapi') {
					$reply_module = 'userapi';
				} else {
					$reply_module = 'reply';
				}
			}
			$module = WeUtility::createModule($reply_module);
			if (method_exists($module, 'ruleDeleted')) {
				$module->ruleDeleted($rid);
			}
		}
	}
	itoast('规则操作成功！', referer(), 'success');
}

if ($do == 'change_status') {
	$m = $_GPC['m'];
	if ($m == 'service') {
		$rid = intval($_GPC['rid']);
		$file = trim($_GPC['file']);
		if ($rid == 0) {
			$rid = reply_insert_without_service($file);
			if (empty($rid)) {
				iajax(1, '参数错误');
			}
		}
		$userapi_module = module_fetch('userapi');
		$config = $userapi_module['config'];
		$config[$rid] = isset($config[$rid]) && $config[$rid] ? false : true;
		$module_api = WeUtility::createModule('userapi');
		$module_api->saveSettings($config);
		iajax(0, '');
	} else {
		$type = trim($_GPC['type']);
		$setting = uni_setting_load('default_message', $_W['uniacid']);
		$setting = $setting['default_message'] ? $setting['default_message'] : array();
		if (empty($setting[$type]['type'])) {
			if (!empty($setting[$type]['keyword'])) {
				$setting[$type]['type'] = 'keyword';
			}
			if (!empty($setting[$type]['module'])) {
				$setting[$type]['type'] = 'module';
			}
			if (empty($setting[$type]['type'])) {
				iajax(1, '请先设置回复内容', '');
			}
		} else {
			$setting[$type]['type'] = '';
		}
		$result = uni_setting_save('default_message', $setting);
		if ($result) {
			iajax(0, '更新成功！');
		}
	}
}

if ($do == 'change_keyword_status') {
	
	$id = intval($_GPC['id']);
	$result = pdo_get('rule', array('id' => $id), array('status'));
	if (!empty($result)) {
		$rule = $rule_keyword = false;
		if ($result['status'] == 1) {
			$rule = pdo_update('rule', array('status' => 0), array('id' => $id));
			$rule_keyword = pdo_update('rule_keyword', array('status' => 0), array('uniacid' => $_W['uniacid'], 'rid' => $id));
		} else {
			$rule = pdo_update('rule', array('status' => 1), array('id' => $id));
			$rule_keyword = pdo_update('rule_keyword', array('status' => 1), array('uniacid' => $_W['uniacid'], 'rid' => $id));
		}
		if ($rule && $rule_keyword) {
			iajax(0, '更新成功！', '');
		} else {
			iajax(-1, '更新失败！', '');
		}
	}
	iajax(-1, '更新失败！', '');
}