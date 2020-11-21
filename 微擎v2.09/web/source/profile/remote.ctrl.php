<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
load()->func('communication');
load()->model('attachment');
load()->model('miniapp');

$dos = array('display', 'save', 'test_setting', 'upload_remote');
$do = in_array($do, $dos) ? $do : 'display';

permission_check_account_user('profile_setting_remote');

if (!empty($_GPC['version_id'])) {
	$version_id = intval($_GPC['version_id']);
	$version_info = miniapp_version($version_id);
}

$remote = $_W['setting']['remote_complete_info'][$_W['uniacid']];
if ($do == 'upload_remote') {
	if (!empty($_W['setting']['remote_complete_info'][$_W['uniacid']]['type'])) {
		if (empty($_W['setting']['remote']['type'])) {
			iajax(3, '未开启全局远程附件');
		}
		$result = file_dir_remote_upload(ATTACHMENT_ROOT . 'images/' . $_W['uniacid']);
		if (is_error($result)) {
			iajax(1, $result['message']);
		} else {
			iajax(0, '上传成功!');
		}
	} else {
		iajax(1, '请先填写并开启远程附件设置。');
	}
}
if ($do == 'display') {
	$safe_path = safe_gpc_path(IA_ROOT . '/attachment/images/' . $_W['uniacid']);
	if (!empty($safe_path)) {
		$local_attachment = file_dir_exist_image($safe_path);
	} else {
		$local_attachment = array();
	}
}

if ($do == 'save') {
	$remote_data = array(
		'type' => $_GPC['type'],
		'qiniu' => array(
			'accesskey' => $_GPC['qiniu']['accesskey'],
			'secretkey' => strexists($_GPC['qiniu']['secretkey'], '*') ? $remote['qiniu']['secretkey'] : trim($_GPC['qiniu']['secretkey']),
			'bucket' => $_GPC['qiniu']['bucket'],
			'url' => $_GPC['qiniu']['url'],
		)
	);
	if ($remote_data['type'] == ATTACH_QINIU) {
		if (empty($remote_data['qiniu']['accesskey'])) {
			iajax(1, '请填写Accesskey');
		}
		if (empty($remote_data['qiniu']['secretkey'])) {
			iajx(1, '请填写secretkey');
		}
		if (empty($remote_data['qiniu']['bucket'])) {
			iajx(1, '请填写bucket');
		}
		if (empty($remote_data['qiniu']['url'])) {
			iajx(1, '请填写url');
		} else {
			$remote_data['qiniu']['url'] = strexists ($remote_data['qiniu']['url'], 'http') ? trim ($remote_data['qiniu']['url'], '/') : 'http://' . trim ($remote_data['qiniu']['url'], '/');
		}
		$auth = attachment_qiniu_auth ($remote_data['qiniu']['accesskey'], $remote_data['qiniu']['secretkey'], $remote_data['qiniu']['bucket']);
		if (is_error ($auth)) {
			$message = $auth['message']['error'] == 'bad token' ? 'Accesskey或Secretkey填写错误， 请检查后重新提交' : 'bucket填写错误或是bucket所对应的存储区域选择错误，请检查后重新提交';
			iajx(1, $message);
		}
	}
	$_W['setting']['remote_complete_info'][$_W['uniacid']] = $remote_data;
	setting_save($_W['setting']['remote_complete_info'], 'remote');
	iajax(0, '保存成功', url('profile/remote'));
}

if ($do == 'test_setting') {
	$type = $_GPC['type'];
	if ($type == ATTACH_QINIU) {
		$_GPC['qiniu']['secretkey'] = strexists($_GPC['qiniu']['secretkey'], '*') ? $remote['qiniu']['secretkey'] : $_GPC['qiniu']['secretkey'];
		$auth = attachment_qiniu_auth(trim($_GPC['qiniu']['accesskey']), trim($_GPC['qiniu']['secretkey']), trim($_GPC['qiniu']['bucket']));
		if (is_error($auth)) {
			iajax(-1, '配置失败，请检查配置。注：请检查存储区域是否选择的是和bucket对应<br/>的区域', '');
		}
		$url = trim(safe_gpc_string($_GPC['qiniu']['url']), '/');
		$url = strexists($url, 'http') ? $url : 'http://'. $url;
		$filename = 'MicroEngine.ico';
		$response = ihttp_request($url. '/'.$filename, array(), array('CURLOPT_REFERER' => $_SERVER['SERVER_NAME']));
		if (is_error($response)) {
			iajax(-1, '配置失败，七牛访问url错误');
		}
		if (intval($response['code']) != 200) {
			iajax(-1, '配置失败，七牛访问url错误,请保证bucket为公共读取的');
		}
		$image = getimagesizefromstring($response['content']);
		if (!empty($image) && strexists($image['mime'], 'image')) {
			iajax(0,'配置成功');
		} else {
			iajax(-1, '配置失败，七牛访问url错误');
		}
	}
}

template('profile/remote');