<?php
defined("IN_IA") or exit("Access Denied");
global $_W, $_GPC;
defined("IN_IA") or exit("Access Denied");
global $_GPC, $_W;
checklogin();
$uniacid = $_W["uniacid"];
load()->func("tpl");
$op = $_GPC["op"] ? $_GPC["op"] : "display";
$id = intval($_GPC["id"]);
$aid = intval($_GPC["aid"]);
$cfg = $this->module["config"]["api"];
if ($aid) {
    $activity_name = pdo_fetch("SELECT name,pattern FROM " . tablename(TABLE_ACTIVITY) . " WHERE uniacid = :uniacid AND id = :id", array(":uniacid" => $uniacid, ":id" => $aid));
    if (empty($activity_name) || $activity_name["pattern"] != 11) {
        message("参数错误", referer(), "error");
    }
    $pattern = $activity_name["pattern"] ? $activity_name["pattern"] : 11;
    $activity_name = $activity_name["name"];
}
if ($op == "del") {
    $item = pdo_fetch("SELECT * FROM " . tablename(TABLE_ORDER) . " WHERE id = :id", array(":id" => $id));
    if (empty($item)) {
        message("抱歉，数据不存在或是已经删除！", referer(), "error");
    }
    if ($item["uniacid"] != $uniacid || $item["aid"] != $aid) {
        message("您没有权限操作");
    }
    if (pdo_delete(TABLE_ORDER, array("id" => $id)) === false) {
        message("删除失败！", referer(), "error");
    } else {
        message("删除成功！", referer());
    }
} else {
    if ($op == "deleteids") {
        $rowcount = 0;
        $notrowcount = 0;
        foreach ($_GPC["ids"] as $k => $id) {
            $id = intval($id);
            if (!empty($id)) {
                $item_task = pdo_fetch("SELECT * FROM " . tablename(TABLE_ORDER) . " WHERE id = :id AND uniacid=:uniacid", array(":id" => $id, ":uniacid" => $uniacid));
                if (!empty($item_task)) {
                    pdo_delete(TABLE_ORDER, array("id" => $id, "uniacid" => $uniacid));
                    $rowcount++;
                } else {
                    $notrowcount++;
                }
            }
        }
    } else {
        if ($op == "deleteall") {
            $search = array("uniacid" => $uniacid, "aid" => $aid);
            $status = intval($_GPC["status"]);
            if ($status) {
                $search["status"] = intval($status);
            }
            pdo_delete(TABLE_ORDER, $search);
            message("删除成功", referer(), "success");
        } else {
            if ($op == "is_pay") {
                $where = "id ='{$id}'";
                $item = pdo_fetch("SELECT * FROM " . tablename(TABLE_ORDER) . " WHERE {$where}");
                if (empty($item)) {
                    message("抱歉，数据不存在或是已经删除！", referer(), "error");
                }
                if ($item["uniacid"] != $uniacid) {
                    message("您没有权限操作");
                }
                if ($item["status"] == 1) {
                    message("该订单已支付过了");
                }
                $update = array("status" => 1, "paytime" => time());
                if (pdo_update(TABLE_ORDER, $update, array("id" => $id)) === false) {
                    message("操作失败！", referer(), "error");
                } else {
                    message("操作成功！", referer());
                }
            } else {
                $activity_info = pdo_fetchall("select * from " . tablename(TABLE_ACTIVITY) . " where uniacid='{$uniacid}' AND pattern='{$pattern}'");
                $pindex = max(1, intval($_GPC["page"]));
                $psize = 10;
                $where = " WHERE a.uniacid=:uniacid";
                $params = array(":uniacid" => $_W["uniacid"]);
                if (!empty($_GPC["order_no"])) {
                    $where .= " AND a.order_no like :order_no";
                    $params[":order_no"] = "%{$_GPC["order_no"]}%";
                }
                if (!empty($_GPC["keyword"])) {
                    $where .= " AND CONCAT(u.nickname,u.tel,u.openid) LIKE like :keyword";
                    $params[":keyword"] = "%{$_GPC["keyword"]}%";
                }
                $status = intval($_GPC["status"]);
                if (in_array($status, array(1, 2))) {
                    $where .= " AND (a.status = :status)";
                    $params[":status"] = $status == 2 ? 0 : 1;
                }
                $createtime = $_GPC["createtime"];
                if (empty($createtime)) {
                    $createtime["start"] = date("Y-m-d", TIMESTAMP - 86400);
                    $createtime["end"] = date("Y-m-d");
                }
                $where .= " AND (a.createtime >= :start) AND (a.createtime < :end) ";
                $params[":start"] = strtotime($createtime["start"]);
                $params[":end"] = strtotime($createtime["end"]) + 86399;
                $list = pdo_fetchall("select a.*,u.nickname,u.tel,u.headimgurl from " . tablename(TABLE_ORDER) . " a left join " . tablename(TABLE_USER) . " u on a.openid=u.openid  AND a.aid = u.aid  {$where}  ORDER BY a.id DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}", $params);
                $total = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_ORDER) . " a left join " . tablename(TABLE_USER) . " u on a.openid=u.openid AND a.aid = u.aid  {$where}", $params);
                $pager = pagination($total, $pindex, $psize);
                $freeze_money = pdo_fetchcolumn("SELECT SUM(money) from " . tablename(TABLE_ORDER) . " a left join " . tablename(TABLE_USER) . " u on a.openid=u.openid  AND a.aid = u.aid  {$where} AND a.status=1", $params);
                $use_money = pdo_fetchcolumn("SELECT SUM(money) from " . tablename(TABLE_ORDER) . " a left join " . tablename(TABLE_USER) . " u on a.openid=u.openid  AND a.aid = u.aid   {$where} AND a.status=0", $params);
                $sum_money = pdo_fetchcolumn("SELECT SUM(money) from " . tablename(TABLE_ORDER) . " a left join " . tablename(TABLE_USER) . " u on a.openid=u.openid  AND a.aid = u.aid  {$where}", $params);
                include $this->template("order");
            }
        }
    }
}