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
$order_info = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_order") . " WHERE order_no = :order_no", array(":order_no" => $data["out_trade_no"]));
if ($order_info) {
    pdo_update("crad_qrcode_red_order", array("status" => "1", "paytime" => time()), array("id" => $order_info["id"]));
    if (empty($order_info["status"]) && $order_info["sid"]) {
        $income_charge = pdo_fetch("SELECT income_charge FROM " . tablename("crad_qrcode_red_shop") . " WHERE id = :id", array(":id" => $order_info["sid"]));
        if ($income_charge) {
            $money = round(($order_info["money"] * 1000 - $order_info["money"] * $income_charge["income_charge"]) / 10);
        } else {
            $money = round($order_info["money"] * 100);
        }
        $finance_balance = pdo_fetch("SELECT id FROM " . tablename("crad_qrcode_red_finance") . " WHERE tid = :tid AND order_no = :order_no", array(":tid" => $order_info["tid"], ":order_no" => $order_info["order_no"]));
        if ($money > 1 && empty($finance_balance)) {
            $data_finance = array("uniacid" => $order_info["uniacid"], "openid" => $order_info["openid"], "shopid" => $order_info["sid"], "tid" => $order_info["tid"], "type" => 1, "status" => 1, "money" => $money / 100, "money_all" => $money / 100, "money_fee" => "0.00", "order_no" => $order_info["order_no"], "createtime" => time(), "paytime" => time());
            pdo_insert("crad_qrcode_red_finance", $data_finance);
            pdo_update("crad_qrcode_red_order", array("is_balance" => "1"), array("id" => $order_info["id"]));
        }
    }
}
$notify->setReturnParameter("return_code", "SUCCESS");
$notify->setReturnParameter("return_msg", "OK");
exit($notify->createXml());