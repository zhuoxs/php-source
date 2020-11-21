<?php 
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

$dos = array('wechat', 'system', 'database','sms');
$do = in_array($do, $dos) ? $do : 'wechat';

$params = array();
$where  = '';
$order = ' ORDER BY `id` DESC';
if ($_GPC['time']) {
		$starttime = strtotime($_GPC['time']['start']);
	$endtime = strtotime($_GPC['time']['end']);
	$timewhere = ' AND `createtime` >= :starttime AND `createtime` < :endtime';
	$params[':starttime'] = $starttime;
	$params[':endtime'] = $endtime + 86400;
}

if ($do == 'wechat') {
	$path = IA_ROOT . '/data/logs/';
	$files = glob($path . '*');
	if (!empty($_GPC['searchtime'])) {
		$searchtime = $_GPC['searchtime'] . '.php';
	} else {
		$searchtime = date('Ymd', time()) . '.php';
	}
	$tree = array();
	foreach ($files as $key => $file) {
		if (!preg_match('/\/[0-9]+\.php/', $file)) {
			continue;
		}
		$pathinfo = pathinfo($file);
		array_unshift($tree, $pathinfo['filename']);
		if (strexists($file, $searchtime)) {
			$contents = file_get_contents($file);
		}
	}
}

if ($do == 'system') {
	$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
	$where .= " WHERE `type` = '1'";
	$sql = 'SELECT * FROM ' . tablename('core_performance') . " $where $timewhere $order LIMIT " . ($pindex - 1) * $psize .','. $psize;
	$list = pdo_fetchall($sql, $params);
	foreach ($list as $key => $value) {
		$list[$key]['type'] = '系统日志';
		$list[$key]['createtime'] = date('Y-m-d H:i:s', $value['createtime']);
	}
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('core_performance'). $where . $timewhere , $params);
	$pager = pagination($total, $pindex, $psize);
}

if ($do == 'database') {
	$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
	$where .= " WHERE `type` = '2'";
	$sql = 'SELECT * FROM ' . tablename('core_performance') . " $where $timewhere $order LIMIT " . ($pindex - 1) * $psize .','. $psize;
	$list = pdo_fetchall($sql, $params);
	foreach ($list as $key => $value) {
		$list[$key]['type'] = '数据库日志';
		$list[$key]['createtime'] = date('Y-m-d H:i:s', $value['createtime']);
	}
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('core_performance'). $where . $timewhere , $params);
	$pager = pagination($total, $pindex, $psize);
}

if ($do == 'sms') {
	if (!empty($_GPC['mobile'])) {
		$timewhere .= ' AND `mobile` LIKE :mobile ';
		$params[':mobile'] = "%{$_GPC['mobile']}%";
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = 40;
	$params[':uniacid'] = $_W['uniacid'];
	$sql = "SELECT * FROM". tablename('core_sendsms_log'). " WHERE uniacid = :uniacid ". $timewhere. " ORDER BY id DESC LIMIT ". ($pindex-1)*$psize . ','. $psize;
	$list = pdo_fetchall($sql, $params);
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM". tablename('core_sendsms_log'). " WHERE uniacid = :uniacid". $timewhere, $params);
	$pager = pagination($total, $pindex, $psize);
}
 
template('system/logs');