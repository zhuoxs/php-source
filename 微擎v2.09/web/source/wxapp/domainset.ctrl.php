<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('miniapp');
load()->classs('cloudapi');
load()->classs('uploadedfile');
load()->func('file');

$dos = array('display');
$do = in_array($do, $dos) ? $do : 'display';

$wxapp_info = miniapp_fetch($_W['uniacid']);

$is_module_wxapp = false;
if (!empty($version_id)) {
	$is_single_module_wxapp = $version_info['type'] == WXAPP_CREATE_MODULE; }

if ($do == 'display') {
	$appurl = $_W['siteroot'].'app/index.php';
	$uniacid = 0;
	if ($version_info) {
		$wxapp = pdo_get('account_wxapp', array('uniacid' => $version_info['uniacid']));
		if ($wxapp && !empty($wxapp['appdomain'])) {
			$appurl = $wxapp['appdomain'];
		}
		if (!starts_with($appurl, 'https')) { 			$appurl = str_replace('http', 'https', $appurl);
		}
		$uniacid = $version_info['uniacid'];
	}
	if ($_W['ispost']) {
		$appurl = safe_gpc_url($_GPC['appurl'], false);

		if (!starts_with($appurl, 'https')) {
			itoast('域名必须以https开头');
			return;
		}

		$file = $_FILES['file'];
		if (!empty($file['name']) && $file['error'] == 0) {
			$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
			if (strtolower($ext) == 'txt') {
				$file['name'] = parse_path($file['name']);
				file_move($file['tmp_name'], IA_ROOT . '/' . $file['name']);
			}
		}
		if ($version_info) {
			$update = pdo_update('account_wxapp', array('appdomain' => $appurl), array('uniacid' => $uniacid));
			itoast('更新成功'); 		}
	}

	template('wxapp/domainset');
}