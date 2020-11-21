<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('module');
load()->model('miniapp');

$dos = array('post', 'get_wxapp_modules', 'module_binding');
$do = in_array($do, $dos) ? $do : 'post';
$_W['page']['title'] = '小程序 - 新建版本';
$account_info = permission_user_account_num($_W['uid']);
$type = intval($_GPC['type']);

if ($do == 'post') {
	$uniacid = intval($_GPC['uniacid']);

	if (checksubmit('submit')) {
		if ($account_info['aliapp_limit'] <= 0 && empty($uniacid) && !$_W['isfounder']) {
			iajax(-1, '创建的支付宝小程序已达上限！');
		}
		if (!preg_match('/^[0-9]{1,2}\.[0-9]{1,2}(\.[0-9]{1,2})?$/', trim($_GPC['version']))) {
			iajax(-1, '版本号错误，只能是数字、点，数字最多2位，例如 1.1.1 或1.2');
		}
				if (empty($uniacid)) {
			if (empty($_GPC['name'])) {
				iajax(-1, '请填写支付宝小程序名称');
			}
			$data = array(
				'name' => trim($_GPC['name']),
				'description' => safe_gpc_string($_GPC['description']),
				'headimg' => safe_gpc_path($_GPC['headimg']),
				'qrcode' => safe_gpc_path($_GPC['qrcode']),
				'level' => 1,
				'appid' => trim($_GPC['appid']),
				'type' => $type,
			);
			$uniacid = miniapp_create($data, ACCOUNT_TYPE_ALIAPP_NORMAL);
			if (is_error($uniacid)) {
				iajax(-1, '添加失败');
			}
		}

				$version = array(
			'uniacid' => $uniacid,
			'multiid' => '0',
			'description' => safe_gpc_string($_GPC['description']),
			'version' => safe_gpc_string($_GPC['version']),
			'modules' => '',
			'createtime' => TIMESTAMP,
		);

				if (!empty($_GPC['choose_module'])) {
			$module = module_fetch($_GPC['choose_module']['name']);
			if (!empty($module)) {
				$select_modules[$module['name']] = array(
					'name' => $module['name'],
					'version' => $module['version']
				);
				$version['modules'] = serialize($select_modules);
			}
		}
		$result = pdo_insert('wxapp_versions', $version);
		$msg = $result ? '创建成功' : '创建失败';
		iajax(0, $msg, url('account/display/switch', array('uniacid' => $uniacid, 'type' => $type)));
	}
	if (!empty($uniacid)) {
		$miniapp_info = miniapp_fetch($uniacid);
	}
	template('miniapp/post');
}