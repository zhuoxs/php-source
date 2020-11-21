<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

$dos = array('display', 'post');
$do = in_array($do, $dos) ? $do : 'display';

if ($do == 'display') {

	$table = table('core_profile_fields');

	$keyword = safe_gpc_string($_GPC['keyword']);
	if (!empty($keyword)) {
		$table->searchWithKeyword($keyword);
	}

	if ($_W['isajax'] && $_W['ispost']) {
		$res = pdo_update('profile_fields', array(safe_gpc_string($_GPC['key']) => intval($_GPC['val'])), array('id' => intval($_GPC['id'])));
		if ($res) {
			iajax(0, '修改成功!', referer());
		} else {
			iajax(0, '修改失败!', referer());
		}
	}

	$fields = $table->getFieldsList();
	template('user/fields-display');
}

if ($do == 'post') {
	$field = $_GPC['field'];
	$id = intval($field['id']);
	if ($_W['isajax'] && $_W['ispost']) {
		if (empty($field['title'])) {
			iajax(-1, '抱歉，请填写资料名称！', referer());
		}
		if (empty($field['field'])) {
			iajax(-1, '抱歉，请填写字段名！', referer());
		}
		if (!preg_match('/^[A-Za-z0-9_]*$/', $field['field'])) {
			iajax(-1, '请使用字母或数字或下划线组合字段名！', referer());
		}
		$data = array(
			'title' => safe_gpc_string($field['title']),
			'description' => safe_gpc_string($field['description']),
			'displayorder' => intval($field['displayorder']),
			'unchangeable' => intval($field['unchangeable']),
			'field' => safe_gpc_string($field['field']),
			'field_length' => intval($field['field_length'])
		);
		$length = intval($field['field_length']);
		if (empty($id)) {
			pdo_insert('profile_fields', $data);
			if (!pdo_fieldexists('users_profile', $data['field'])) {
				pdo_query("ALTER TABLE ". tablename('users_profile'). " ADD `". $data['field']."` varchar({$length}) NOT NULL default '';");
			}
			if (!pdo_fieldexists('mc_members', $data['field'])) {
				pdo_query("ALTER TABLE ". tablename('mc_members'). " ADD `". $data['field']."` varchar({$length}) NOT NULL default '';");
			}
		} else {
			if (!pdo_fieldexists('users_profile', $data['field'])) {
				pdo_query("ALTER TABLE ". tablename('users_profile'). " ADD `". $data['field']."` varchar({$length}) NOT NULL default '';");
			} else {
				pdo_query("ALTER TABLE ". tablename('users_profile'). " CHANGE `". $data['field']. "` `". $data['field']."` varchar({$length}) NOT NULL default ''");
			}
			if (!pdo_fieldexists('mc_members', $data['field'])) {
				pdo_query("ALTER TABLE ". tablename('mc_members'). " ADD `". $data['field']."` varchar({$length}) NOT NULL default '';");
			} else {
				pdo_query("ALTER TABLE ". tablename('mc_members'). " CHANGE `". $data['field']. "` `". $data['field']."` varchar({$length}) NOT NULL default ''");
			}
			pdo_update('profile_fields', $data, array('id' => $id));
		}
		iajax(0, '更新字段成功！', url('user/fields'));
	}

	if (!empty($id)) {
		$item = pdo_get('profile_fields', array('id' => $id));
	}
	template('user/fields-post');
}