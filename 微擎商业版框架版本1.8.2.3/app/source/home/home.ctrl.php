<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
load()->model('app');
$multiid = intval($_GPC['t']);
if(empty($multiid)) {
	load()->model('account');
	$setting = uni_setting($_W['uniacid'], array('default_site'));
	$multiid = $setting['default_site'];
}
$title = $_W['page']['title'];
$navs = app_navs('home', $multiid);
$share_tmp = pdo_fetch('SELECT title,description,thumb FROM ' . tablename('cover_reply') . ' WHERE uniacid = :aid AND multiid = :id AND module = :m', array(':aid' => $_W['uniacid'], ':id' => $multiid, ':m' => 'site'));
$_share['imgUrl'] = tomedia($share_tmp['thumb']);
$_share['desc'] = $share_tmp['description'];
$_share['title'] = $share_tmp['title'];
$category_list = pdo_getall('site_category', array('uniacid' => $_W['uniacid'], 'multiid' => $multiid), array(), 'id');
if (!empty($multiid)) {
	isetcookie('__multiid', $multiid);
}
template('home/home');