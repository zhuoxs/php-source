<?php
error_reporting(0);
define('IN_MOBILE', true);
if (empty($_GET['outtradeno'])){
    exit('订单不存在');
}
require '../../../../framework/bootstrap.inc.php';
global $_W,$_GPC;
$pdoname =  'wlmerchant_';
$orderon = $_GPC['outtradeno'];

$_W['uniacid'] = $_W['weid'] = intval($_GPC['attach']);
$_W['uniaccount'] = $_W['account'] = uni_fetch($_W['uniacid']);
$_W['acid'] = $_W['uniaccount']['acid'];
$_W['siteroot'] = str_replace(array('/addons/weliam_merchant/payment/wechat','/addons/weliam_merchant'), '', $_W['siteroot']);
$log = pdo_get("core_paylog",array('uniontid'=>$orderon));
if (!(empty($log))) {
    $site = WeUtility::createModuleSite($log['module']);
    $method = 'payResult';
    if (!(is_error($site))) {
        $ret['uniacid'] = $log['uniacid'];
        $ret['tid'] = $log['tid'];
        $ret['result'] = 'success';
        $ret['from'] = 'return';
        $ret['type'] = $log['type'];
        $site->$method($ret);
        exit();
    }
}

