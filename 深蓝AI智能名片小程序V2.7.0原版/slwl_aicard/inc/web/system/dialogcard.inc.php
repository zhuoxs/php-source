<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = $_GPC['op'] ? $_GPC['op'] : 'display';

if ($operation == 'display') {


// 卡片
} else if ($operation == 'search_card') {
	$keyword = trim($_GPC['keyword']);

	$condition = " AND uniacid=:uniacid AND `enabled`='1' ";
	$params = [':uniacid'=>$_W['uniacid']];
	if ($keyword) {
		$condition .= ' AND (CONCAT(`last_name`,`middle_name`,`first_name`) LIKE :theName OR mobile_show LIKE :mobile_show) ';
		$params[':theName'] = '%'.$keyword.'%';
		$params[':mobile_show'] = '%'.$keyword.'%';
	}

	$pindex = max(1, intval($_GPC['page']));
	$psize = 100;
	$sql = "SELECT * FROM " . sl_table_name('card',true) . ' WHERE 1 '
		. $condition . " ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;
	$list = pdo_fetchall($sql, $params);

	if ($list) {
		foreach ($list as $key => $value) {
			$list[$key]['thumb_url'] = tomedia($value['thumb']);
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

include $this->template('web/system/dialogcard');
