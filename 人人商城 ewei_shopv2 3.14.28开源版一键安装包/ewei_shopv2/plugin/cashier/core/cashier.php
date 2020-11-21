<?php
//QQ63779278
define('IN_SYS', true);
require '../framework/bootstrap.inc.php';
load()->web('common');
load()->web('template');
$_W['attachurl'] = $_W['attachurl_local'] = $_W['siteroot'] . $_W['config']['upload']['attachdir'] . '/';

if (!empty($_W['setting']['remote'][$_W['uniacid']]['type'])) {
	$_W['setting']['remote'] = $_W['setting']['remote'][$_W['uniacid']];
}

if (!empty($_W['setting']['remote']['type'])) {
	if ($_W['setting']['remote']['type'] == ATTACH_FTP) {
		$_W['attachurl'] = $_W['attachurl_remote'] = $_W['setting']['remote']['ftp']['url'] . '/';
	}
	else if ($_W['setting']['remote']['type'] == ATTACH_OSS) {
		$_W['attachurl'] = $_W['attachurl_remote'] = $_W['setting']['remote']['alioss']['url'] . '/';
	}
	else if ($_W['setting']['remote']['type'] == ATTACH_QINIU) {
		$_W['attachurl'] = $_W['attachurl_remote'] = $_W['setting']['remote']['qiniu']['url'] . '/';
	}
	else {
		if ($_W['setting']['remote']['type'] == ATTACH_COS) {
			$_W['attachurl'] = $_W['attachurl_remote'] = $_W['setting']['remote']['cos']['url'] . '/';
		}
	}
}

header('Content-Type: text/html; charset=UTF-8');
$uniacid = intval($_GPC['i']);

if (empty($uniacid)) {
	exit('Access Denied.');
}

$site = WeUtility::createModuleSite('ewei_shopv2');
$_GPC['c'] = 'site';
$_GPC['a'] = 'entry';
$_GPC['m'] = 'ewei_shopv2';
$_GPC['do'] = 'web';

if (!isset($_GPC['r'])) {
	$_GPC['r'] = 'cashier.manage.index';
}
else {
	$_GPC['r'] = 'cashier.manage.' . $_GPC['r'];
}

$_W['uniacid'] = (int) $_GPC['i'];
$_W['acid'] = (int) $_GPC['i'];
@session_start();

if (!empty($uniacid)) {
	isetcookie('__uniacid', $uniacid, 7 * 86400);
}

if (!is_error($site)) {
	$method = 'doWebWeb';
	$site->uniacid = $uniacid;
	$site->inMobile = false;

	if (method_exists($site, $method)) {
		$site->{$method}();
		exit();
	}
}

?>
