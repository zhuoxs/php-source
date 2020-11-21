<?php
/**
 * 小程序接口定义
 *
 * @author alluu
 * @url
 */

$xml = file_get_contents('php://input');

libxml_disable_entity_loader(true);
$result = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
if(!$result) die('FAIL');

// $results = print_r($result, true);
// file_put_contents('notify.txt', print_r($results, true));

define('IN_MOBILE', true);
require '../../framework/bootstrap.inc.php';

$site = WeUtility::createModuleSite('yzzc_sun');
$_GPC['c']='site';
$_GPC['a']='entry';
$_GPC['m']='yzzc_sun';
$_GPC['do']='notify';

if(!is_error($site)) {
    $method = 'doWebNotify';
    $site->inMobile = true;
    if (method_exists($site, $method)) {
        $site->$method($result);
        exit;
    }
}
