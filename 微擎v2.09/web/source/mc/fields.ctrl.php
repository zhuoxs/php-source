<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

permission_check_account_user('mc_member_fields');

$dos = array('list', 'post', 'change_available');
$do = in_array($do, $dos) ? $do : 'list';
if($do == 'list') {
	$account_member_fields = uni_account_member_fields($_W['uniacid']);
}

if ($do == 'change_available') {
	$id = intval($_GPC['id']);
	$available = intval($_GPC['available']);
	$res = pdo_update('mc_member_fields', array('available' => $available = empty($available) ? 1 : 0), array('id' => $id));
	if ($res) {
		iajax(0, '会员字段更新成功！');
	} else {
		iajax(0, '会员字段更新失败！');
	}
}

if ($do == 'post') {
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
		pdo_update('mc_member_fields', $field, array('id' => $id, 'uniacid' => $_W['uniacid']));
		message('会员字段更新成功！', url('mc/fields'), 'success');
	}
	$field = pdo_get('mc_member_fields', array('id' => $id));
}
template('mc/fields');