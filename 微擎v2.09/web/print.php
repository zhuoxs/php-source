<?php
/**
 * 打印机配置
 */
define('IN_SYS', true);
require '../framework/bootstrap.inc.php';
header('Content-Type: text/html; charset=GBK');

$site = WeUtility::createModuleSite('weisrc_dish');
if(!is_error($site)) {
 	$method = 'dowebprint';
	$site->uniacid = $_W['uniacid'];
	$site->inMobile = false;

	if (method_exists($site, $method)) {
		exit($site->$method());
	}
} else {
    echo 'page is error';
}

exit("访问的方法 {$method} 不存在.");