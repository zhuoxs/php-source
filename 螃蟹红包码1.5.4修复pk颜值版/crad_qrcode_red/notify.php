<?php
error_reporting(1);
define("IN_MOBILE", true);
require "../../framework/bootstrap.inc.php";
require_once "../../addons/crad_qrcode_red/libs/WxPayPubHelper/WxPayPubHelper.php";
$input = file_get_contents("php://input");
WeUtility::logging("info", "异步通知数据" . $input);
global $_W;
$notify = new Notify_pub();
$notify->saveData($input);
$data = $notify->getData();
if (empty($data)) {
    $notify->setReturnParameter("return_code", "FAIL");
    $notify->setReturnParameter("return_msg", "参数格式校验错误");
    WeUtility::logging("info", "参数格式校验错误");
    exit($notify->createXml());
}
if ($data["result_code"] != "SUCCESS" || $data["return_code"] != "SUCCESS") {
    $notify->setReturnParameter("return_code", "FAIL");
    $notify->setReturnParameter("return_msg", "参数格式校验错误");
    WeUtility::logging("info", "校验错误");
    exit($notify->createXml());
}
$finance_info = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_finance") . " WHERE order_no = :order_no", array(":order_no" => $data["out_trade_no"]));
if (!empty($finance_info)) {
    pdo_update("crad_qrcode_red_finance", array("status" => "1", "paytime" => time()), array("order_no" => $data["out_trade_no"]));
}
$notify->setReturnParameter("return_code", "SUCCESS");
$notify->setReturnParameter("return_msg", "OK");
exit($notify->createXml());