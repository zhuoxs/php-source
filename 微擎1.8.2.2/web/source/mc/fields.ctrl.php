<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

permission_check_account_user('mc_member');

$dos = array('display', 'post');
$do = in_array($do, $dos) ? $do : 'display';
if($do == 'display') {
	$_W['page']['title'] = '字段管理 - 会员 - 会员字段管理';
	if (checksubmit('submit')) {
		if (!empty($_GPC['displayorder'])) {
			$field = array('uniacid' => $_W['uniacid']);
			foreach ($_GPC['displayorder'] as $id => $displayorder) {
				$field['id'] = intval($_GPC['id'][$id]);
				$field['fieldid'] = intval($_GPC['fieldid'][$id]);
				$field['displayorder'] = intval($displayorder);
				$field['available'] = intval($_GPC['available'][$id]);
				if (empty($field['id'])) {
					$field['title'] = $_GPC['title'][$id];
					pdo_insert('mc_member_fields', $field);
				} else {
					pdo_update('mc_member_fields', $field, array('id' => $field['id']));
				}
			}
		}
		message('会员字段更新成功！', referer(), 'success');
	}
	$account_member_fields = uni_account_member_fields($_W['uniacid']);
}
if ($do == 'post') {
	$_W['page']['title'] = '字段管理 - 会员 - 会员字段管理';
	$id = intval($_GPC['id']);
	if (checksubmit('submit')) {
		if (empty($_GPC['title'])) {
			message('抱歉，请填写资料名称！');
		}
		$field = array(
			'title' => $_GPC['title'],
			'displayorder' => intval($_GPC['displayorder']),
			'available' => intval($_GPC['available'])
		);
		pdo_update('mc_member_fields', $field, array('id' => $id));
		message('会员字段更新成功！', url('mc/fields'), 'success');
	}
	$field = pdo_get('mc_member_fields', array('id' => $id));
}
template('mc/fields');