<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = $_GPC['op'] ? $_GPC['op'] : 'display';

if ($operation == 'display') {
	$condition = ' AND uniacid=:uniacid ';
	$params = array(':uniacid' => $_W['uniacid']);
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$sql = "SELECT * FROM " . tablename('slwl_aicard_oplogs'). ' WHERE 1 ' . $condition . " ORDER BY addtime DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

	$list = pdo_fetchall($sql, $params);
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_oplogs') . ' WHERE 1 ' . $condition, $params);
	$pager = pagination($total, $pindex, $psize);

	foreach ($list as $k => $v) {
		$tmp_str = json_encode(json_decode($v['op_txt']), JSON_UNESCAPED_UNICODE);
		$list[$k]['op_txt_cn'] = $v['op_type'].'=-+++-='.$tmp_str;
	}

} else if ($operation == 'delete') {
	$id = intval($_GPC['id']);

	$rst = pdo_delete('slwl_aicard_oplogs', array('id' => $id));
	if ($rst !== false) {
		sl_ajax(0, '成功');
	} else {
		sl_ajax(1, '不存在或已删除');
	}


} else {
	message('请求方式不存在');
}

include $this->template('web/other/oplog');

