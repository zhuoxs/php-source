<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('miniapp');
load()->classs('cloudapi');
load()->classs('uploadedfile');

$dos = array('front_download', 'domainset', 'code_uuid', 'code_gen', 'code_token', 'qrcode', 'checkscan',
	'commitcode', 'preview', 'getpackage', 'entrychoose', 'set_wxapp_entry',
	'custom', 'custom_save', 'custom_default', 'custom_convert_img', 'upgrade_module', 'tominiprogram', 'del_tominiprogram');
$do = in_array($do, $dos) ? $do : 'front_download';

$wxapp_info = miniapp_fetch($_W['uniacid']);

$is_module_wxapp = false;
if (!empty($version_id)) {
	$is_single_module_wxapp = $version_info['type'] == WXAPP_CREATE_MODULE; }


		if ($do == 'entrychoose') {
		$entrys = $version_info['cover_entrys'];
		template('wxapp/version-front-download');
	}
		if ($do == 'set_wxapp_entry') {
		$entry_id = intval($_GPC['entry_id']);
		$result = miniapp_update_entry($version_id, $entry_id);
		iajax(0, '设置入口成功');
	}


if ($do == 'custom') {
	$default_appjson = miniapp_code_current_appjson($version_id);

	$default_appjson = json_encode($default_appjson);
	template('wxapp/version-front-download');
}
if ($do == 'custom_default') {
	$result = miniapp_code_set_default_appjson($version_id);
	if ($result === false) {
		iajax(1, '操作失败，请重试！');
	} else {
		iajax(0, '设置成功！', url('wxapp/front-download/front_download', array('version_id' => $version_id)));
	}
}

if ($do == 'custom_save') {
	if (empty($version_info)) {
		iajax(1, '参数错误！');
	}
	$json = array();
	if (!empty($_GPC['json']['window'])) {
		$json['window'] = array(
			'navigationBarTitleText' => safe_gpc_string($_GPC['json']['window']['navigationBarTitleText']),
			'navigationBarTextStyle' => safe_gpc_string($_GPC['json']['window']['navigationBarTextStyle']),
			'navigationBarBackgroundColor' => safe_gpc_string($_GPC['json']['window']['navigationBarBackgroundColor']),
			'backgroundColor' => safe_gpc_string($_GPC['json']['window']['backgroundColor']),
		);
	}
	if (!empty($_GPC['json']['tabBar'])) {
		$json['tabBar'] = array(
			'color' => safe_gpc_string($_GPC['json']['tabBar']['color']),
			'selectedColor' => safe_gpc_string($_GPC['json']['tabBar']['selectedColor']),
			'backgroundColor' => safe_gpc_string($_GPC['json']['tabBar']['backgroundColor']),
			'borderStyle' => in_array($_GPC['json']['tabBar']['borderStyle'], array('black', 'white')) ? $_GPC['json']['tabBar']['borderStyle'] : '',
		);
	}
	$result = miniapp_code_save_appjson($version_id, $json);
	cache_delete(cache_system_key('miniapp_version', array('version_id' => $version_id)));
	iajax(0, '设置成功！', url('wxapp/front-download/front_download', array('version_id' => $version_id)));
}

if ($do == 'custom_convert_img') {
	$attchid = intval($_GPC['att_id']);
	$filename = miniapp_code_path_convert($attchid);
	iajax(0, $filename);
}

if ($do == 'front_download') {
	permission_check_account_user('wxapp_profile_front_download');
	$appurl = $_W['siteroot'].'/app/index.php';
	$uptype = $_GPC['uptype'];
	$wxapp_versions_info = miniapp_version($version_id);
	if (!in_array($uptype, array('auto', 'normal'))) {
		$uptype = 'auto';
	}
	if (!empty($wxapp_versions_info['last_modules'])) {
		$last_modules = current($wxapp_versions_info['last_modules']);
	}
	$need_upload = false;
	$module = array();
	if (!empty($wxapp_versions_info['modules'])) {
		foreach ($wxapp_versions_info['modules'] as $item) {
			$module = module_fetch($item['name']);
			$need_upload = !empty($last_modules) && ($module['version'] != $last_modules['version']);
		}
	}
	if (!empty($wxapp_versions_info['version'])) {
		$user_version = explode('.', $wxapp_versions_info['version']);
		$user_version[count($user_version) - 1] += 1;
		$user_version = join('.', $user_version);
	}
	template('wxapp/version-front-download');
}

if ($do == 'upgrade_module') {
	$modules = pdo_getcolumn('wxapp_versions', array('id' => $version_id), 'modules');
	$modules = iunserializer($modules);
	if (!empty($modules)) {
		foreach ($modules as $name => $module) {
			$module_info = module_fetch($name);
			if (!empty($module_info['version'])) {
				$modules[$name]['version'] = $module_info['version'];
			}
		}
		$modules = iserializer($modules);
		pdo_update('wxapp_versions', array(
			'modules' => $modules,
			'last_modules' => $modules,
			'version' => $_GPC['version'],
			'description' => trim($_GPC['description']),
			'upload_time' => TIMESTAMP,
		), array('id' => $version_id));
		cache_delete(cache_system_key('miniapp_version', array('version_id' => $version_id)));
	}
	exit;
}

if ($do == 'code_uuid') {
	$user_version = $_GPC['user_version'];
	$data = miniapp_code_generate($version_id, $user_version);
	echo json_encode($data);
}

if ($do == 'code_gen') {
	$code_uuid = $_GPC['code_uuid'];
	$data = miniapp_check_code_isgen($code_uuid);
	echo json_encode($data);
}

if ($do == 'code_token') {
	$tokendata = miniapp_code_token();
	echo json_encode($tokendata);
}

if ($do == 'qrcode') {
	$code_token = $_GPC['code_token'];
	header('Content-type: image/jpg'); 	echo miniapp_code_qrcode($code_token);
	exit;
}

if ($do == 'checkscan') {
	$code_token = $_GPC['code_token'];
	$last = $_GPC['last'];
	$data = miniapp_code_check_scan($code_token, $last);
	echo json_encode($data);
}

if ($do == 'preview') {
	$code_token = $_GPC['code_token'];
	$code_uuid = $_GPC['code_uuid'];
	$data = miniapp_code_preview_qrcode($code_uuid, $code_token);
	echo json_encode($data);
}

if ($do == 'commitcode') {
	$user_version = $_GPC['user_version'];
	$user_desc = $_GPC['user_desc'];
	$code_token = $_GPC['code_token'];
	$code_uuid = $_GPC['code_uuid'];
	$data = miniapp_code_commit($code_uuid, $code_token, $user_version, $user_desc);
	echo json_encode($data);
}

if ($do == 'tominiprogram') {
	$tomini_lists = iunserializer($version_info['tominiprogram']);

	if (!is_array($tomini_lists)) {
		$data = array('tominiprogram' => iserializer(array()));
		miniapp_version_update($version_id, $data);
	}

	if (checksubmit()) {
		$tominiprogram_data = array();
		$appid = safe_gpc_string(trim($_GPC['appid']));
		$app_name = safe_gpc_string(trim($_GPC['app_name']));
		$tominiprogram_data[$appid] = array('appid' => $appid, 'app_name' => $app_name);
		if (empty($appid)) {
			itoast('appid不可为空！', referer(), 'error');
		}
		if (empty($app_name)) {
			itoast('app_name不可为空！', referer(), 'error');
		}
		if (in_array($appid, array_keys($tomini_lists))) {
			itoast('该appid值已存在！', referer(), 'error');
		}
		if (count($tomini_lists) == 10) {
			itoast('要跳转的小程序不可超过10个！', referer(), 'error');
		}
		if (empty($tomini_lists)) {
			$data = array('tominiprogram' => iserializer($tominiprogram_data));
		} else {
			$tomini_lists[$appid] = array('appid' => $appid, 'app_name' => $app_name);
			$data = array('tominiprogram' => iserializer($tomini_lists));
		}
		miniapp_version_update($version_id, $data);
		itoast('保存成功！', referer(), 'success');
	}

	template('wxapp/version-front-download');
}

if ($do == 'del_tominiprogram') {
	$tomini_lists = iunserializer($version_info['tominiprogram']);
	$appid = safe_gpc_string(trim($_GPC['appid']));
	$app_name = safe_gpc_string(trim($_GPC['app_name']));

	if (!in_array($appid, array_keys($tomini_lists))) {
		itoast('不存在该appid', referer(), 'error');
	}
	$tomini_lists = array_diff($tomini_lists, array($appid));
	unset($tomini_lists[$appid]);
	$data = array('tominiprogram' => iserializer($tomini_lists));
	miniapp_version_update($version_id, $data);
	itoast('删除成功！', referer(), 'success');
}
if ($do == 'getpackage') {
	if (empty($version_id)) {
		itoast('参数错误！', '', '');
	}
	$account_wxapp_info = miniapp_fetch($version_info['uniacid'], $version_id);
	if (empty($account_wxapp_info)) {
		itoast('版本不存在！', referer(), 'error');
	}

	$siteurl = $_W['siteroot'].'app/index.php';
	if (!empty($account_wxapp_info['appdomain'])) {
		$siteurl = $account_wxapp_info['appdomain'];
	}

	$request_cloud_data = array(
		'name' => $account_wxapp_info['name'],
		'modules' => $account_wxapp_info['version']['modules'],
		'support' => $_W['account']['type_sign'], 		'siteInfo' => array(
			'name' => $account_wxapp_info['name'],
			'uniacid' => $account_wxapp_info['uniacid'],
			'acid' => $account_wxapp_info['acid'],
			'multiid' => $account_wxapp_info['version']['multiid'],
			'version' => $account_wxapp_info['version']['version'],
			'siteroot' => $siteurl,
			'design_method' => $account_wxapp_info['version']['design_method'],
		),
			);
	$result = miniapp_getpackage($request_cloud_data);

	if (is_error($result)) {
		itoast($result['message'], '', '');
	} else {
		header('content-type: application/zip');
		header('content-disposition: attachment; filename="'.$request_cloud_data['name'].'.zip"');
		echo $result;
	}
	exit;
}
