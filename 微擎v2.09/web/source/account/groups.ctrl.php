<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
$do = !empty($_GPC['do']) ? $_GPC['do'] : 'display';

if ($do == 'display') {
	$_W['page']['title'] = '服务套餐列表 - 服务套餐管理 - 公众号';
	if (checksubmit('submit')) {
		if (!empty($_GPC['delete'])) {
			pdo_query("DELETE FROM ".tablename('uni_group')." WHERE id IN ('".implode("','", $_GPC['delete'])."')");
			cache_build_account_modules();
		}
		message('用户组更新成功！', referer(), 'success');
	}
	$list = pdo_fetchall("SELECT * FROM ".tablename('uni_group') . ' WHERE uniacid = 0');
	if (!empty($list)) {
		foreach ($list as &$row) {
			if (!empty($row['modules'])) {
				$modules = iunserializer($row['modules']);
				if (is_array($modules)) {
					$row['modules'] = pdo_fetchall("SELECT name, title FROM ".tablename('modules')." WHERE `name` IN ('".implode("','", $modules)."')");
				}
			}
			if (!empty($row['templates'])) {
				$templates = iunserializer($row['templates']);
				if (is_array($templates)) {
					$row['templates'] = pdo_fetchall("SELECT name, title FROM ".tablename('site_templates')." WHERE id IN ('".implode("','", $templates)."')");
				}
			}
		}
	}
}

if ($do == 'post') {
	$id = intval($_GPC['id']);
	$_W['page']['title'] = $id ? '编辑服务套餐 - 服务套餐管理 - 公众号' : '添加服务套餐 - 服务套餐管理 - 公众号';
	$sql = "SELECT * FROM " . tablename('modules') . ' WHERE 1';
	$modules = pdo_fetchall($sql, array(), 'name');
	if (!empty($id)) {
		$item = pdo_fetch("SELECT * FROM ".tablename('uni_group') . " WHERE id = :id", array(':id' => $id));
		$item['modules'] = iunserializer($item['modules']);
		$item['templates'] = iunserializer($item['templates']);
	}
	$templates  = pdo_fetchall("SELECT * FROM ".tablename('site_templates'));
	if (checksubmit('submit')) {
		if (empty($_GPC['name'])) {
			message('请输入公众号组名称！');
		}
		$data = array(
			'name' => $_GPC['name'],
			'modules' => iserializer($_GPC['modules']),
			'templates' => iserializer($_GPC['templates'])
		);
		if (empty($id)) {
			pdo_insert('uni_group', $data);
		} else {
			pdo_update('uni_group', $data, array('id' => $id));
			cache_build_account_modules();
		}
		load()->model('module');
		module_build_privileges();
		message('公众号组更新成功！', url('account/groups/display'), 'success');
	}
}

template('account/groups');