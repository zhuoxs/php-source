<?php
//QQ63779278
define('IN_SYS', true);
require '../framework/bootstrap.inc.php';
load()->web('common');
load()->web('template');
$uniacid = intval($_GPC['i']);

if (empty($uniacid)) {
	$uniacid = intval($_GPC['__uniacid']);

	if (empty($uniacid)) {
		$uniacid = $_COOKIE[$_W['config']['cookie']['pre'] . '__uniacid'];
	}
}

$_W['uniacid'] = $uniacid;
$_W['attachurl'] = $_W['attachurl_local'] = $_W['siteroot'] . $_W['config']['upload']['attachdir'] . '/';

if (!empty($_W['setting']['remote'][$_W['uniacid']]['type'])) {
	$_W['setting']['remote'] = $_W['setting']['remote'][$_W['uniacid']];
}

$info = uni_setting_load('remote', $_W['uniacid']);

if (!empty($info['remote'])) {
	if ($info['remote']['type'] != 0) {
		$_W['setting']['remote'] = $info['remote'];
	}
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
$cookie = $_GPC['__uniacid'];
if (empty($uniacid) && empty($cookie)) {
	exit('Access Denied.');
}

@session_start();

if (!empty($uniacid)) {
	$_SESSION['__merch_uniacid'] = $uniacid;
	$acid = (int) pdo_fetchcolumn('SELECT acid FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid LIMIT 1', array(':uniacid' => $uniacid));
	isetcookie('__uniacid', $uniacid, 7 * 86400);
	isetcookie('__uid', $acid, 7 * 86400);
}

$site = WeUtility::createModuleSite('ewei_shopv2');

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
