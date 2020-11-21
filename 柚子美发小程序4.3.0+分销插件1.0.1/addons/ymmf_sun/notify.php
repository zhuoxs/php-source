<?php
/**
 * 柚子黑卡模块小程序接口定义
 *
 * @author 淡蓝海域
 * @url
 */

$xml = file_get_contents('php://input');

libxml_disable_entity_loader(true);
$result = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
if(!$result) die('FAIL');
//$result = 111;
// $results = print_r($result, true);
file_put_contents('notify.txt', print_r($result, true));

define('IN_MOBILE', true);
require '../../framework/bootstrap.inc.php';

$site = WeUtility::createModuleSite('ymmf_sun');
$_GPC['c']='site';
$_GPC['a']='entry';
$_GPC['m']='ymmf_sun';
$_GPC['do']='notify';

if(!is_error($site)) {
//	file_put_contents('notify.txt', print_r($site, true));
    $method = 'doWebNotify';
    $site->inMobile = true;
    if (method_exists($site, $method)) {
		//file_put_contents('notify.txt',"1111");
        $site->$method($result);
        exit;
    }
}
