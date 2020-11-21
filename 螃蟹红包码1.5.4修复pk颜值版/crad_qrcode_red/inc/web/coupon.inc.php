<?php
global $_GPC, $_W;
checklogin();
$uniacid = $_W["uniacid"];
load()->func("tpl");
$op = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
$aid = intval($_GPC["aid"]);
$cid = intval($_GPC["cid"]);
load()->classs("coupon");
$coupon_api = new coupon();
if ($op == "display") {
    $condition = '';
    $coupon_type = intval($_GPC["coupon_type"]);
    if (!empty($coupon_type)) {
        $condition = "AND a.coupon_type = '{$coupon_type}'";
    }
    $where = " WHERE a.uniacid = '{$uniacid}' " . $condition;
    $params = array();
    if (!empty($_GPC["nickname"])) {
        $where .= " AND a.nickname LIKE :nickname";
        $params[":nickname"] = trim($_GPC["nickname"]);
    }
    if ($aid) {
        $where .= " AND a.aid = :aid";
        $params[":aid"] = $aid;
    }
    if ($cid) {
        $where .= " AND a.cid = :cid";
        $params[":cid"] = $cid;
    }
    $shopid = $_GPC["shopid"];
    if ($shopid) {
        $where .= " AND a.shopid = :shopid";
        $params[":shopid"] = $shopid;
    }
    $status = intval($_GPC["status"]);
    if (!empty($status)) {
        $where .= " AND a.status = :status";
        $params[":status"] = $status;
    } else {
        $where .= " AND a.status != :status";
        $params[":status"] = 2;
    }
    $pindex = max(1, intval($_GPC["page"]));
    $psize = 10;
    $list = pdo_fetchall("SELECT a.*, b.name as activity_name   FROM " . tablename(TABLE_COUPON) . " AS a LEFT JOIN " . tablename(TABLE_ACTIVITY) . " AS b ON a.aid = b.id  AND a.uniacid = b.uniacid" . " {$where}  ORDER BY a.id DESC LIMIT " . ($pindex - 1) * $psize . "," . $psize, $params);
    $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename(TABLE_COUPON) . " AS a LEFT JOIN " . tablename(TABLE_ACTIVITY) . " AS b ON a.aid = b.id  AND a.uniacid = b.uniacid " . $where, $params);
    if (!empty($list)) {
        $uids = array();
        foreach ($list as &$coupon_row) {
            if ($coupon_row["coupon_validity"]) {
                $coupon_validity = json_decode($coupon_row["coupon_validity"], true);
                if ($coupon_validity["time_type"] == 1) {
                    if ($coupon_validity["start"] || $coupon_validity["end"]) {
                        $coupon_row["coupon_validity"] = $coupon_validity["start"] . "至" . $coupon_validity["end"] . "时间内使用";
                    } else {
                        $coupon_row["coupon_validity"] = "无时间限制";
                    }
                } else {
                    if ($coupon_validity["time_type"] == 2) {
                        if (empty($coupon_validity["deadline"])) {
                            $deadline_str = "当";
                        } else {
                            $deadline_str = $coupon_validity["deadline"];
                        }
                        $coupon_row["coupon_validity"] = "领取后" . $deadline_str . "天有效，有效期" . $coupon_validity["limit"] . "天";
                    }
                }
            }
            if ($coupon_row["coupon_content"]) {
                $coupon_content = json_decode($coupon_row["coupon_content"], true);
                if ($coupon_row["coupon_type"] == 1) {
                    $coupon_row["coupon_content"] = "折扣券：" . $coupon_content["discount"] / 10 . "折";
                } else {
                    if ($coupon_row["coupon_type"] == 2) {
                        $coupon_row["coupon_content"] = "现金券：" . $coupon_content["reduce_cost"] . "元";
                    } else {
                        if ($coupon_row["coupon_type"] == 3) {
                            $coupon_row["coupon_content"] = "礼品券：" . $coupon_content["gift"];
                        }
                    }
                }
            }
        }
    }
    $pager = pagination($total, $pindex, $psize);
} else {
    if ($op == "consume") {
        $recid = intval($_GPC["id"]);
        $record = pdo_get(TABLE_COUPON, array("id" => $recid));
        if (empty($record)) {
            message("抱歉，数据不存在或是已经删除！", referer(), "error");
        }
        if ($record["uniacid"] != $uniacid) {
            message("您没有权限操作");
        }
        if ($record["status"] != 1) {
            message("卡券状态错误");
        }
        if ($record["wechat_coupon"] == "1" && $record["code"]) {
            $status = $coupon_api->ConsumeCode(array("code" => $record["code"]));
            if (is_error($status)) {
                if (strexists($status["message"], "40127")) {
                    $status["message"] = "卡券已失效";
                    pdo_update("coupon_record", array("status" => "2"), array("uniacid" => $_W["uniacid"], "id" => $recid));
                }
                if (strexists($status["message"], "40099")) {
                    $status["message"] = "卡券已被核销";
                    pdo_update("coupon_record", array("status" => "3"), array("uniacid" => $_W["uniacid"], "id" => $recid));
                }
                message($status["message"]);
            }
        }
        $update = array("status" => 3, "usetime" => time());
        $status = pdo_update(TABLE_COUPON, $update, array("uniacid" => $uniacid, "id" => $recid));
        if ($status === false) {
            message("核销失败！", referer(), "error");
        } else {
            message("核销成功！", referer());
        }
    } else {
        if ($op == "del") {
            $recid = intval($_GPC["id"]);
            $record = pdo_get(TABLE_COUPON, array("uniacid" => $uniacid, "id" => $recid));
            if (empty($record)) {
                message("抱歉，数据不存在或是已经删除！", referer(), "error");
            }
            if ($record["uniacid"] != $uniacid) {
                message("您没有权限操作");
            }
            if ($record["wechat_coupon"] == "1" && $record["code"]) {
                $status = $coupon_api->UnavailableCode(array("code" => $record["code"]));
                if (is_error($status)) {
                    message($status["message"]);
                }
            }
            $status = pdo_delete(TABLE_COUPON, array("uniacid" => $uniacid, "id" => $recid));
            if ($status === false) {
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
                        $item_task = pdo_fetch("SELECT * FROM " . tablename(TABLE_COUPON) . " WHERE id = :id AND uniacid=:uniacid", array(":id" => $id, ":uniacid" => $uniacid));
                        if (!empty($item_task)) {
                            if (!($item_task["wechat_coupon"] == "1" && $item_task["code"])) {
                                pdo_delete(TABLE_COUPON, array("id" => $id, "uniacid" => $uniacid));
                                $rowcount++;
                            } else {
                                $status = $coupon_api->UnavailableCode(array("code" => $item_task["code"]));
                                if (is_error($status)) {
                                }
                            }
                        } else {
                            $notrowcount++;
                        }
                    }
                }
            } else {
                if ($op == "deleteall") {
                    $search = array("uniacid" => $uniacid);
                    $shopid = $_GPC["shopid"];
                    if ($shopid) {
                        $search["shopid"] = intval($shopid);
                    }
                    if ($aid) {
                        $search["aid"] = $aid;
                    }
                    if ($cid) {
                        $search["cid"] = $cid;
                    }
                    $coupon_type = intval($_GPC["coupon_type"]);
                    if ($coupon_type) {
                        $search["coupon_type"] = intval($coupon_type);
                    }
                    $status = intval($_GPC["status"]);
                    if ($status) {
                        $search["status"] = intval($status);
                    }
                    pdo_delete(TABLE_COUPON, $search);
                    message("删除成功", referer(), "success");
                }
            }
        }
    }
}
$activity_info = pdo_fetchall("select id,name from " . tablename(TABLE_ACTIVITY) . " where uniacid='{$uniacid}'");
include $this->template("coupon");