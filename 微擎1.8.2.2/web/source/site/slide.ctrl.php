<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

$do = !empty($do) ? $do : 'display';
$do = in_array($do, array('display', 'post', 'delete')) ? $do : 'display';
permission_check_account_user('platform_site');

if ($do == 'display' && $_W['isajax'] && $_W['ispost']) {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$condition = '';
	$params = array();
	$multiid = intval($_GPC['multiid']);
	if ($multiid > 0) {
		$condition .= " AND multiid = {$multiid}";
	}
	if (!empty($_GPC['keyword'])) {
		$condition .= " AND title LIKE '%{$_GPC['keyword']}%'";
	}
	$list = pdo_fetchall("SELECT * FROM ".tablename('site_slide')." WHERE uniacid = '{$_W['uniacid']}' $condition ORDER BY displayorder DESC, uniacid DESC LIMIT ".($pindex - 1) * $psize.','.$psize, $params);
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('site_slide') . " WHERE uniacid = '{$_W['uniacid']}' $condition");
	$pager = pagination($total, $pindex, $psize);
	iajax(0, $list, '');
}

if ($do == 'post' && $_W['isajax'] && $_W['ispost']) {
	$multiid = intval($_GPC['multiid']);
	
	if (empty($_GPC['slide'])) {
		pdo_delete('site_slide', array('uniacid' => $_W['uniacid'], 'multiid' => $multiid));
	} else {
		foreach ($_GPC['slide'] as $key => $val) {
			if (empty($val['thumb'])){
				iajax(-1, '幻灯图片不可为空', '');
			}
		}
		pdo_delete('site_slide', array('uniacid' => $_W['uniacid'], 'multiid' => $multiid));
		foreach ($_GPC['slide'] as  $value) {
			$data = array(
				'uniacid' => $_W['uniacid'],
				'multiid' => $multiid,
				'title' => $value['title'],
				'url' => $value['url'],
				'thumb' => $value['thumb'],
				'displayorder' => intval($value['displayorder']),
			);
			pdo_insert('site_slide', $data);
		}
	}
	iajax(0, '幻灯片保存成功！', '');
}