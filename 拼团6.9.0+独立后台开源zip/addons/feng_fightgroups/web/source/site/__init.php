<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
if(!empty($_GPC['f']) && $_GPC['f'] == 'multi') {
	define('ACTIVE_FRAME_URL', url('site/multi/display'));
}
$sysmodules = system_modules();
if(!empty($_GPC['styleid'])) {
	define('ACTIVE_FRAME_URL', url('site/style/styles'));
}

if($controller == 'site') {
	$m = $_GPC['m'];
	if(!empty($m)) {
		if(in_array($m, $sysmodules)) {
			define('FRAME', 'platform');
			define('CRUMBS_NAV', 2);
			define('ACTIVE_FRAME_URL', url('platform/reply/', array('m' => $m)));
		} else {
			if($action == 'nav' && $_COOKIE['ext_type'] == 1) {
				$do = trim($_GPC['do']);
				define('ACTIVE_FRAME_URL', url("site/nav/{$do}", array('m' => $m)));
			}
		}
	}
}
if($action != 'entry' && $action != 'nav') {
	define('FRAME', 'site');
}
if ($action == 'editor' && $_GPC['type'] == '4') {
	define('ACTIVE_FRAME_URL', url('site/editor/uc'));
}
if (!empty($_GPC['multiid'])) {
	define('ACTIVE_FRAME_URL', url('site/multi/display'));
}
//$frames = buildframes(array(FRAME));
//$frames = $frames[FRAME];