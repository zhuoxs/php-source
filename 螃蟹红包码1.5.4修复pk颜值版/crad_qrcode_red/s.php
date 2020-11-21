<?php
error_reporting(1);
define("IN_MOBILE", true);
global $_W;
$uuid = key($_GET);
require "../../framework/bootstrap.inc.php";
$tmpArr = explode("addons/crad_qrcode_red/", $_W["siteroot"]);
$_W["siteroot"] = $tmpArr[0] ? $tmpArr[0] : $_W["siteroot"];
if (empty($uuid) || !preg_match("/^[A-Za-z0-9]{32}\$/", $uuid)) {
    $type = "error";
    $msg = "参数错误";
    include "template/mobile/message.html";
    exit;
}
$qrcode = pdo_fetch("SELECT uniacid,aid FROM " . tablename("crad_qrcode_red_qrcode") . " WHERE uuid = :uuid", array(":uuid" => $uuid));
if ($qrcode["aid"] && $qrcode["uniacid"]) {
    $jump_url = $_W["siteroot"] . "app/index.php?i=" . $qrcode["uniacid"] . "&c=entry&m=crad_qrcode_red&do=index&aid=" . $qrcode["aid"] . "&uuid=" . $uuid;
    header("Location:{$jump_url}");
    exit;
}
$type = "error";
$msg = "无效二维码";
include "template/mobile/message.html";
exit;