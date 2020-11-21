<?php
global $_GPC, $_W;
checklogin();
$uniacid = $_W["uniacid"];
load()->func("tpl");
$op = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
$shopid = intval($_GPC["shopid"]);
if ($op == "display") {
    $condition = '';
    $type = intval($_GPC["type"]);
    if (!empty($type)) {
        $condition = "AND type = '{$type}'";
    }
    $where = " WHERE uniacid = '{$uniacid}' AND shopid = '{$shopid}' " . $condition;
    $pindex = max(1, intval($_GPC["page"]));
    $psize = 10;
    $sum_money_all = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_FINANCE) . " WHERE uniacid = :uniacid AND shopid = :shopid AND type<2 AND status=1", array(":uniacid" => $uniacid, ":shopid" => $shopid));
    $sum_money = sprintf("%.2f", $sum_money_all["sum_money"]);
    $sum_money_freeze = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_FINANCE) . " WHERE uniacid = :uniacid AND shopid = :shopid AND type=2 AND status=1", array(":uniacid" => $uniacid, ":shopid" => $shopid));
    $freeze_money = sprintf("%.2f", $sum_money_freeze["sum_money"]);
    $sum_money_use = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_FINANCE) . " WHERE uniacid = :uniacid AND shopid = :shopid AND type=3 AND status=1", array(":uniacid" => $uniacid, ":shopid" => $shopid));
    $use_money = sprintf("%.2f", $sum_money_use["sum_money"]);
    $list = pdo_fetchall("SELECT * FROM " . tablename(TABLE_FINANCE) . " {$where}  ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . "," . $psize);
    foreach ($list as &$value) {
        if ($value["aid"]) {
            $activity_name = pdo_fetch("SELECT name FROM " . tablename(TABLE_ACTIVITY) . " WHERE uniacid = :uniacid  AND  id = :aid", array(":uniacid" => $uniacid, ":aid" => $value["aid"]));
            $value["activity_name"] = $activity_name["name"];
        }
    }
}
$shop_info = pdo_fetchall("select * from " . tablename(TABLE_SHOP) . " where uniacid='{$uniacid}'");
include $this->template("capital");