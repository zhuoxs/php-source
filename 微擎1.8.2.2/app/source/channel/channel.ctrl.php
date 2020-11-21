<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');
if (!empty($_GPC['styleid'])) {
	$_W['account']['styleid'] = $_GPC['styleid'];
	$_W['account']['template'] = pdo_fetchcolumn("SELECT name FROM ".tablename('site_templates')." WHERE id = '{$_W['account']['styleid']}'");
}
load()->model('app');

$channel = array('index', 'mc', 'list', 'detail', 'album', 'photo','exchange');
$name = $_GPC['name'];
if ($name == 'home') {
	header("Location: ".url('mobile/mc', array('uniacid' => $_W['uniacid'])));
	exit;
}
$name = in_array($_GPC['name'], $channel) ? $name : 'index';

if ($name == 'index') {
	load()->model('site');
	$position = 1;
	$title = $_W['account']['name'];
	$navs = app_navs($position);
	$cover = pdo_fetch("SELECT description, title, thumb FROM ".tablename('cover_reply')." WHERE uniacid = :uniacid AND module = 'wesite'", array(':uniacid' => $_W['uniacid']));
	$_share_content = $cover['description'];
	$title = $cover['title'];
	$_share_img = $cover['thumb'];
} elseif ($name == 'mc') {
	$title = '个人中心';
	$position = 2;
	if (empty($_W['uid']) && empty($_W['openid'])) {
		message('非法访问，请重新点击链接进入个人中心！');
	}
	$navs = app_navs($position);
	if (!empty($navs)) {
		foreach ($navs as $row) {
			$menus[$row['module']][] = $row;
		}
		foreach ($menus as $module => $row) {
			if (count($row) <= 2) {
				$menus['other'][$module] = $row;
				unset($menus[$module]);
			}
		}
	}
} elseif ($name == 'list') {
	header("Location: ".url('mobile/module/list', array('name' => 'site', 'uniacid' => $_W['uniacid'], 'cid' => $_GPC['cid'])));
	exit;
} elseif ($name == 'detail') {
	header("Location: ".url('mobile/module/detail', array('name' => 'site', 'uniacid' => $_W['uniacid'], 'id' => $_GPC['id'])));
	exit;
} elseif ($name == 'album') {
	header("Location: ".url('mobile/module/list', array('name' => 'album', 'uniacid' => $_W['uniacid'])));
	exit;
} elseif ($name == 'photo') {
	header("Location: ".url('mobile/module/detail', array('name' => 'album', 'uniacid' => $_W['uniacid'], 'id' => $_GPC['id'])));
	exit;
}
template('channel/'.$name);