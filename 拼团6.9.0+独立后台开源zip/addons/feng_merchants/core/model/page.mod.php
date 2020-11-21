<?php
/**
 * [weliam] Copyright (c) 2016/3/26
 * 商城首页自定义mod
 */
defined('IN_IA') or exit('Access Denied');
function wl_page($page_id){
	return pdo_fetch_one('tg_page', array('id' => $page_id));
}
function wl_page_home() {
//	$cache_key = 'page_home';
//	$page = cache_load($cache_key);
//	if ($page) {
//		return $page;
//	}
	$page = pdo_fetch_one('tg_page', array('type' => 1));
//	cache_write($cache_key, $page);
	return $page;
}