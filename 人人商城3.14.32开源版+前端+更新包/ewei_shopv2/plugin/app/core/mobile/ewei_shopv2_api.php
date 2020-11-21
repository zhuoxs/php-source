<?php

define("IN_SYS", true);
require __DIR__ . "/../framework/bootstrap.inc.php";
load()->web("common");
$_W["uniacid"] = intval($_GPC["i"]);
$uniacid = $_W["uniacid"];
$_W["attachurl_local"] = $_W["siteroot"] . $_W["config"]["upload"]["attachdir"] . "/";
$_W["attachurl"] = $_W["attachurl_local"];
if (!empty($_W["setting"]["remote"][$_W["uniacid"]]["type"])) {
    $_W["setting"]["remote"] = $_W["setting"]["remote"][$_W["uniacid"]];
}
$info = uni_setting_load("remote", $uniacid);
if (!empty($info["remote"]) && $info["remote"]["type"] != 0) {
    $_W["setting"]["remote"] = $info["remote"];
}
if (!empty($_W["setting"]["remote"]["type"])) {
    if ($_W["setting"]["remote"]["type"] == ATTACH_FTP) {
        $_W["attachurl_remote"] = $_W["setting"]["remote"]["ftp"]["url"] . "/";
        $_W["attachurl"] = $_W["attachurl_remote"];
    } else {
        if ($_W["setting"]["remote"]["type"] == ATTACH_OSS) {
            $_W["attachurl_remote"] = $_W["setting"]["remote"]["alioss"]["url"] . "/";
            $_W["attachurl"] = $_W["attachurl_remote"];
        } else {
            if ($_W["setting"]["remote"]["type"] == ATTACH_QINIU) {
                $_W["attachurl_remote"] = $_W["setting"]["remote"]["qiniu"]["url"] . "/";
                $_W["attachurl"] = $_W["attachurl_remote"];
            } else {
                if ($_W["setting"]["remote"]["type"] == ATTACH_COS) {
                    $_W["attachurl_remote"] = $_W["setting"]["remote"]["cos"]["url"] . "/";
                    $_W["attachurl"] = $_W["attachurl_remote"];
                }
            }
        }
    }
}
if (!empty($_GPC["formwe7"])) {
    $bind = pdo_fetch("SELECT * FROM " . tablename("ewei_shop_wxapp_bind") . " WHERE wxapp=:wxapp LIMIT 1", array(":wxapp" => $uniacid));
    if (!empty($bind) && !empty($bind["uniacid"])) {
        $_GPC["i"] = $bind["uniacid"];
        $uniacid = $_GPC["i"];
    }
}
header("ACCESS-CONTROL-ALLOW-ORIGIN:*");
if (empty($uniacid)) {
    exit("Access Denied.");
}
$site = WeUtility::createModuleSite("ewei_shopv2");
$_GPC["c"] = "site";
$_GPC["a"] = "entry";
$_GPC["m"] = "ewei_shopv2";
$_GPC["do"] = "mobile";
$_W["uniacid"] = (int) $_GPC["i"];
$_W["account"] = uni_fetch($_W["uniacid"]);
$_W["acid"] = (int) $_W["account"]["acid"];
if (!isset($_GPC["r"])) {
    $_GPC["r"] = "app";
} else {
    $_GPC["r"] = "app." . $_GPC["r"];
}
if (!is_error($site)) {
    $method = "doMobileMobile";
    $site->uniacid = $uniacid;
    $site->inMobile = true;
    if (method_exists($site, $method)) {
        $r = $site->{$method}();
        if (!empty($r)) {
            echo $r;
            exit;
        }
        exit;
    }
}

?>