<?php
defined("IN_IA") or exit("Access Denied");
global $_GPC, $_W;
checklogin();
$uniacid = $_W["uniacid"];
load()->func("tpl");
load()->func("file");
$op = $_GPC["op"] ? $_GPC["op"] : "display";
if (!($op == "deleteids")) {
    if ($op == "settlement_activity") {
        $shopid = intval($_GPC["shopid"]);
        $this->settlement_activity($shopid);
        exit;
    }
    $pindex = max(1, intval($_GPC["page"]));
    $psize = 10;
    $condition = "uniacid='{$uniacid}'";
    if (!empty($_GPC["keyword"])) {
        $condition .= " AND CONCAT(name,tel) LIKE '%{$_GPC["keyword"]}%'";
    }
    $pattern = intval($_GPC["pattern"]);
    if ($pattern) {
        $condition .= " AND pattern =" . $pattern;
    }
    $status = intval($_GPC["status"]);
    if ($status) {
        if ($status == 6) {
            $condition .= " AND endtime< {$_W["timestamp"]} AND endtime>0";
        } else {
            if ($status == 1) {
                $condition .= " AND status ='{$status}' AND (endtime=0 OR endtime>={$_W["timestamp"]}) AND {$_W["timestamp"]}>=begintime";
            } else {
                $condition .= " AND status ='{$status}' AND (endtime=0 OR endtime>={$_W["timestamp"]})";
            }
        }
    }
    $sid = intval($_GPC["sid"]);
    if ($sid) {
        $condition .= " AND sid ='{$sid}'";
    }
    $list = pdo_fetchall("select * from " . tablename(TABLE_ACTIVITY) . "  where {$condition}  ORDER BY createtime DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
    if (!empty($list)) {
        foreach ($list as &$task_row) {
            if ($task_row["qrcode_one"] == 1) {
                if ($task_row["url_key"]) {
                    $task_row["a_url"] = $_W["siteroot"] . "app/index.php?i=" . $uniacid . "&c=entry&m=crad_qrcode_red&do=index&aid=" . $task_row["id"] . "&k=" . $task_row["url_key"];
                } else {
                    $task_row["a_url"] = $_W["siteroot"] . "app/index.php?i=" . $uniacid . "&c=entry&m=crad_qrcode_red&do=index&aid=" . $task_row["id"];
                }
                if ($task_row["subscribe"] == 2) {
                    if (empty($task_row["qrcode_url"])) {
                        $res_get = $this->get_qrcode_url("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaared" . $task_row["id"], $task_row["qrcode_type"]);
                        if ($res_get["url"]) {
                            $task_row["qrcode_url"] = $res_get["url"];
                            pdo_update(TABLE_ACTIVITY, array("qrcode_url" => $res_get["url"]), array("id" => $task_row["id"]));
                        } else {
                            $task_row["qrcode_url"] = $task_row["a_url"];
                        }
                    }
                } else {
                    $task_row["qrcode_url"] = $task_row["a_url"];
                }
            }
            $shop_name = pdo_fetch("SELECT name FROM " . tablename(TABLE_SHOP) . " WHERE id = :sid", array(":sid" => $task_row["sid"]));
            $task_row["shop_name"] = $shop_name["name"];
            if ($task_row["sid"] && $task_row["use_balance"]) {
                $payment = pdo_fetch("SELECT * FROM " . tablename(TABLE_FINANCE) . " WHERE shopid = :shopid  AND aid = :aid AND uniacid = :uniacid", array(":uniacid" => $uniacid, ":shopid" => $task_row["sid"], ":aid" => $task_row["id"]));
                $task_row["payment_type"] = $payment["type"];
            }
            $task_row["qrcode_count"] = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " WHERE aid='{$task_row["id"]}' ");
            $task_row["qrcode_scan_count"] = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " WHERE status>0 AND aid='{$task_row["id"]}' ");
            $qrcode_code = pdo_fetch("select id from " . tablename(TABLE_QRCODE) . " where bid>0 AND aid='{$task_row["id"]}' AND status=0");
            if ($qrcode_code) {
                $task_row["unband"] = 1;
            }
            if ($task_row["pattern"] == 3) {
                $task_row["register_url"] = $_W["siteroot"] . "app/index.php?i=" . $uniacid . "&c=entry&m=crad_qrcode_red&do=index&op=register&aid=" . $task_row["id"];
            }
        }
    }
    $total = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_ACTIVITY) . " where {$condition}");
    $pager = pagination($total, $pindex, $psize);
    $shop_lists = pdo_fetchall("select id,name from " . tablename(TABLE_SHOP) . " where uniacid='{$uniacid}'");
    $beforehand_list = pdo_fetchall("select id,name from " . tablename(TABLE_BEFOREHAND) . " where uniacid='{$uniacid}'");
    include $this->template("activity");
}
$rowcount = 0;
$notrowcount = 0;
foreach ($_GPC["ids"] as $k => $id) {
    $id = intval($id);
    if (!empty($id)) {
        $item = pdo_fetch("SELECT id,sid,use_balance FROM " . tablename(TABLE_ACTIVITY) . " WHERE id = :id AND uniacid=:uniacid", array(":id" => $id, ":uniacid" => $uniacid));
        if (!empty($item)) {
            pdo_delete(TABLE_ACTIVITY, array("id" => $id));
            if ($item["sid"] && $item["use_balance"]) {
                $payment = pdo_fetch("SELECT * FROM " . tablename(TABLE_FINANCE) . " WHERE shopid = :shopid  AND aid = :aid", array(":uniacid" => $uniacid, ":shopid" => $item["sid"], ":aid" => $item["id"]));
                if ($payment && $payment["type"] == 2 && $payment["status"] == 1) {
                    $sum_money_activity = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_RED) . " WHERE aid='{$item["id"]}' AND shopid='{$item["sid"]}' AND status=1");
                    $data_pinance = array("type" => 3, "status" => 1, "money" => $sum_money_activity["sum_money"] ? $sum_money_activity["sum_money"] : "0.00", "paytime" => time());
                    pdo_update(TABLE_FINANCE, $data_pinance, array("id" => $payment["id"]));
                }
            }
            $rowcount++;
        } else {
            $notrowcount++;
        }
    }
}