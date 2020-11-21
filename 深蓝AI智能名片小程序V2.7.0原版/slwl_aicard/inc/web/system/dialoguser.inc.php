<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = $_GPC['op'] ? $_GPC['op'] : 'display';

if ($operation == 'display') {


// 系统用户
} else if ($operation == 'search_user') {
	$keyword = trim($_GPC['keyword']);

	$where = [
		'uniacid' => $_W['uniacid'],
		'delete' => 0,
	];
	$condition = " AND uniacid=:uniacid ";
	$params = [':uniacid'=>$_W['uniacid']];
	if ($keyword) {
		$condition .= " AND (nicename LIKE :keyword OR real_name LIKE :keyword OR tel LIKE :keyword) ";
		$params[':keyword'] = $keyword;
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = 100;
	$sql = "SELECT * FROM " . sl_table_name('users',TRUE) . ' WHERE 1 '
		. $condition . " ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;
	$list = pdo_fetchall($sql, $params);

	if ($list) {
		foreach ($list as $key => $value) {
			$list[$key]['nicename'] = sl_nickname($value['nicename']);
		}
	}

	if ($list) {
		sl_ajax(0, $list);
	} else {
		sl_ajax(2, '没有查到数据！');
	}


} else {
	message('请求方式不存在');
}

include $this->template('web/system/dialoguser');
