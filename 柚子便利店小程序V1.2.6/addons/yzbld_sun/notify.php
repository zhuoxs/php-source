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
require '../../framework/bootstrap.inc.php';

$module = WeUtility::createModuleWxapp('yzbld_sun');
$_GPC['c']='entry';
$_GPC['a']='wxapp';
$_GPC['m']='yzbld_sun';

if(!is_error($module)) {
    $method = 'payNotify';
    if (method_exists($module, $method)) {
        $module->$method($result);
        exit;
    }
}
