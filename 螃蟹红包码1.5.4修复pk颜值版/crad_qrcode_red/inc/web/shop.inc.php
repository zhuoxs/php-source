<?php
defined("IN_IA") or exit("Access Denied");
global $_GPC, $_W;
checklogin();
$uniacid = $_W["uniacid"];
load()->func("tpl");
$op = $_GPC["op"] ? $_GPC["op"] : "display";
$pindex = max(1, intval($_GPC["page"]));
$psize = 10;
$condition = '';
$circle = pdo_fetchall("select * from " . tablename(TABLE_CIRCLE) . " where uniacid='{$uniacid}' AND status = 1");
if (!empty($_GPC["keyword"])) {
    $condition .= " AND CONCAT(name,tel) LIKE '%{$_GPC["keyword"]}%'";
}
$circleid = $_GPC["circleid"];
if ($circleid !== '' && $circleid !== null) {
    $condition .= " AND circleid='{$circleid}'";
}
if ($op == "get_shops") {
    $list_shops = pdo_fetchall("SELECT * FROM " . tablename(TABLE_SHOP) . " WHERE uniacid='{$uniacid}' {$condition} ORDER BY id DESC");
    exit(json_encode($list_shops));
}
$list = pdo_fetchall("select * from " . tablename(TABLE_SHOP) . " where uniacid='{$uniacid}' {$condition}   LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
if (!empty($list)) {
    foreach ($list as &$shop_row) {
        $shop_row["token"] = $this->get_shoptoken($uniacid, $shop_row["id"]);
        $shop_row["a_url"] = $_W["siteroot"] . "app/index.php?i=" . $uniacid . "&c=entry&m=crad_qrcode_red&do=shop_info&shopid=" . $shop_row["id"] . "&token=" . $shop_row["token"];
        $shop_row["my_url"] = $_W["siteroot"] . "app/index.php?i=" . $uniacid . "&c=entry&m=crad_qrcode_red&do=my&shopid=" . $shop_row["id"];
        if ($shop_row["circleid"]) {
            $circle_name = pdo_fetch("SELECT name FROM " . tablename(TABLE_CIRCLE) . " WHERE uniacid = :uniacid AND id = :id", array(":uniacid" => $uniacid, ":id" => $shop_row["circleid"]));
            $shop_row["circle_name"] = $circle_name["name"];
        }
        $sum_money_all = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_FINANCE) . " WHERE uniacid = :uniacid AND shopid = :shopid AND type<2 AND status=1", array(":uniacid" => $uniacid, ":shopid" => $shop_row["id"]));
        $shop_row["sum_money"] = $sum_money_all["sum_money"] ? $sum_money_all["sum_money"] : "0.00";
        $sum_money_freeze = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_FINANCE) . " WHERE uniacid = :uniacid AND shopid = :shopid AND type=2 AND status=1", array(":uniacid" => $uniacid, ":shopid" => $shop_row["id"]));
        $shop_row["freeze_money"] = $sum_money_freeze["sum_money"] ? $sum_money_freeze["sum_money"] : "0.00";
        $sum_money_use = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_FINANCE) . " WHERE uniacid = :uniacid AND shopid = :shopid AND type=3 AND status=1", array(":uniacid" => $uniacid, ":shopid" => $shop_row["id"]));
        $shop_row["use_money"] = $sum_money_use["sum_money"] ? $sum_money_use["sum_money"] : "0.00";
        $qrcode_band_count = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename(TABLE_QRCODE) . " where sid='{$shop_row["id"]}'");
        $shop_row["unband"] = 0;
        $shop_row["qrcode_band_count"] = 0;
        if ($qrcode_band_count) {
            $shop_row["unband"] = 1;
            $shop_row["qrcode_band_count"] = $qrcode_band_count;
        }
    }
}
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename(TABLE_SHOP) . " WHERE uniacid='{$_W["uniacid"]}' {$condition} ");
$xx = $this->createWebUrl("shop");
$url = str_replace("./index.php?", '', $xx) . "&page=*&keyword={$keyword}&circleid={$circleid}";
$beforehand_list = pdo_fetchall("select id,name from " . tablename(TABLE_BEFOREHAND) . " where uniacid='{$uniacid}'");
$pager = pagination($total, $pindex, $psize, $url);
include $this->template("shop");