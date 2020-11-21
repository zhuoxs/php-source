<?php
defined("IN_IA") or exit("Access Denied");
global $_GPC, $_W;
checklogin();
$uniacid = $_W["uniacid"];
$op = $_GPC["op"];
$id = intval($_GPC["id"]);
$aid = intval($_GPC["aid"]);
if ($aid) {
    $activity_name = pdo_fetch("SELECT name,pattern FROM " . tablename(TABLE_ACTIVITY) . " WHERE uniacid = :uniacid AND id = :id", array(":uniacid" => $uniacid, ":id" => $aid));
    if (empty($activity_name) || $activity_name["pattern"] != 1) {
        message("参数错误", referer(), "error");
    }
    $activity_name = $activity_name["name"];
}
load()->func("file");
if ($op == "del") {
    $item = pdo_fetch("SELECT * FROM " . tablename(TABLE_SHOP_TASK) . " WHERE id = :id", array(":id" => $id));
    if (empty($item)) {
        message("抱歉，数据不存在或是已经删除！", referer(), "error");
    }
    if ($item["uniacid"] != $uniacid) {
        message("您没有权限操作");
    }
    if (pdo_delete(TABLE_SHOP_TASK, array("id" => $id)) === false) {
        message("删除失败！", referer(), "error");
    } else {
        if ($item["image"]) {
            if (!empty($cfg["isremote"])) {
                $this->file_picremote_delete($cfg, $item["image"]);
            } else {
                if (!empty($_W["setting"]["remote"]["type"])) {
                    file_remote_delete($item["image"]);
                } else {
                    file_delete(ATTACHMENT_ROOT . $item["image"]);
                }
            }
        }
        message("删除成功！", referer());
    }
} else {
    if ($op == "deleteids") {
        $rowcount = 0;
        $notrowcount = 0;
        foreach ($_GPC["ids"] as $k => $id) {
            $id = intval($id);
            if (!empty($id)) {
                $item_task = pdo_fetch("SELECT * FROM " . tablename(TABLE_SHOP_TASK) . " WHERE id = :id AND uniacid=:uniacid", array(":id" => $id, ":uniacid" => $uniacid));
                if (!empty($item_task)) {
                    pdo_delete(TABLE_SHOP_TASK, array("id" => $id, "uniacid" => $uniacid));
                    if ($item_task["image"]) {
                        if (!empty($cfg["isremote"])) {
                            $this->file_picremote_delete($cfg, $item_task["image"]);
                        } else {
                            if (!empty($_W["setting"]["remote"]["type"])) {
                                file_remote_delete($item_task["image"]);
                            } else {
                                file_delete(ATTACHMENT_ROOT . $item_task["image"]);
                            }
                        }
                    }
                    $rowcount++;
                } else {
                    $notrowcount++;
                }
            }
        }
    } else {
        if ($op == "deleteall") {
            $search = "uniacid='{$uniacid}'";
            $aid = intval($_GPC["aid"]);
            if ($aid) {
                $search .= " AND aid='{$aid}'";
            }
            $status = intval($_GPC["status"]);
            if ($status) {
                $search .= " AND status='" . ($status == 3 ? 0 : $status) . "'";
            }
            $task_list = pdo_fetchall("select * from " . tablename(TABLE_SHOP_TASK) . " where {$search}");
            if (pdo_delete(TABLE_SHOP_TASK, $search) === false) {
                message("全清失败！", referer(), "error");
            } else {
                foreach ($task_list as $val) {
                    if ($val["image"]) {
                        if (!empty($cfg["isremote"])) {
                            $this->file_picremote_delete($cfg, $val["image"]);
                        } else {
                            if (!empty($_W["setting"]["remote"]["type"])) {
                                file_remote_delete($val["image"]);
                            } else {
                                file_delete(ATTACHMENT_ROOT . $val["image"]);
                            }
                        }
                    }
                }
            }
        }
    }
}
$activity_info = pdo_fetchall("select * from " . tablename(TABLE_ACTIVITY) . " where uniacid='{$uniacid}' and pattern=1");
if ($op == "check") {
    $status = intval($_GPC["status"]);
    $recid = intval($_GPC["id"]);
    $record = pdo_get(TABLE_SHOP_TASK, array("uniacid" => $_W["uniacid"], "id" => $recid));
    if (empty($record)) {
        message("任务信息不存在！", referer());
    }
    if ($record["aid"] != $aid) {
        message("数据错误", referer());
    }
    if ($record["status"] > 0) {
        message("该任务已经审核了，无需重复审核！", referer());
    }
    $activity = pdo_fetch("select * from " . tablename(TABLE_ACTIVITY) . " where uniacid='{$uniacid}' and pattern=1 and id='{$aid}' ");
    $qrcode = pdo_fetch("SELECT id,aid,uuid FROM " . tablename(TABLE_QRCODE) . " WHERE uniacid = :uniacid AND aid = :aid AND id = :id", array(":uniacid" => $uniacid, ":aid" => $record["aid"], ":id" => $record["tid"]));
    if (empty($qrcode)) {
        message("参数错误", referer(), "error");
    }
    $red_info = pdo_fetch("SELECT * FROM " . tablename(TABLE_RED) . " WHERE tid = :tid", array(":tid" => $qrcode["id"]));
    $user = pdo_fetch("SELECT * FROM " . tablename(TABLE_USER) . " WHERE openid = :openid AND aid = :aid", array(":openid" => $record["openid"], ":aid" => $qrcode["aid"]));
    if ($status != 1) {
        $update_task = array("status" => 2, "check_time" => time());
        $status_res = pdo_update(TABLE_SHOP_TASK, $update_task, array("id" => $recid));
        if ($status_res === false) {
            message("审核失败！", referer());
        } else {
            if ($cfg["mid_check"]) {
                $url = $_W["siteroot"] . "app/" . substr($this->createMobileUrl("index", array("aid" => $qrcode["aid"], "uuid" => $qrcode["uuid"]), true), 2);
                $template = array("touser" => $record["openid"], "template_id" => $cfg["mid_check"], "url" => $url, "topcolor" => "#743a3a", "data" => array("first" => array("value" => urlencode("对不起，您的信息审核未通过"), "color" => "#2F1B58"), "keyword1" => array("value" => urlencode($activity["name"]), "color" => "#2F1B58"), "keyword2" => array("value" => urlencode($user["nickname"]), "color" => "#2F1B58"), "keyword3" => array("value" => urlencode(date("Y-m-d H：i:s", $record["createtime"])), "color" => "#2F1B58"), "remark" => array("value" => urlencode("审核未通过，您可以修改后提交"), "color" => "#2F1B58")));
                $this->send_temp_ms(urldecode(json_encode($template)));
            }
            message("审核成功", referer(), "success");
        }
    }
    if (!$activity) {
        message("活动不存在", referer(), "error");
    }
    if ($activity["begintime"] && $_W["timestamp"] < $activity["begintime"]) {
        message("活动还未开始", referer(), "error");
    }
    if ($activity["endtime"] && $_W["timestamp"] > $activity["endtime"]) {
        message("活动已结束", referer(), "error");
    }
    if ($activity["status"] == 2) {
        message("活动已暂停:" . $activity["stop_tips"], referer(), "error");
    }
    if ($activity["status"] != 1) {
        message("活动已关闭", referer(), "error");
    }
    if ($status == 1 && $activity["send_red_type"] == 1) {
        if ($red_info) {
            message("红包已存在", referer(), "error");
        }
        $update_task = array("status" => 1, "check_time" => time());
        $status_res = pdo_update(TABLE_SHOP_TASK, $update_task, array("id" => $recid));
        if ($status_res === false) {
            message("审核失败！", referer());
        } else {
            $cfg = $this->module["config"]["api"];
            if ($status == 1 && $cfg["mid_check"]) {
                $url = $_W["siteroot"] . "app/" . substr($this->createMobileUrl("index", array("aid" => $qrcode["aid"], "uuid" => $qrcode["uuid"]), true), 2);
                $template = array("touser" => $record["openid"], "template_id" => $cfg["mid_check"], "url" => $url, "topcolor" => "#743a3a", "data" => array("first" => array("value" => urlencode("恭喜，您的信息审核通过"), "color" => "#2F1B58"), "keyword1" => array("value" => urlencode($activity["name"]), "color" => "#2F1B58"), "keyword2" => array("value" => urlencode($user["nickname"]), "color" => "#2F1B58"), "keyword3" => array("value" => urlencode(date("Y-m-d H：i:s", $record["createtime"])), "color" => "#2F1B58"), "remark" => array("value" => urlencode("点击领取红包或扫码领取红包"), "color" => "#2F1B58")));
                $this->send_temp_ms(urldecode(json_encode($template)));
            }
            message("审核成功", referer(), "success");
        }
    }
    $sum_money_act = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_RED) . " WHERE aid='{$aid}'");
    $total_red = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_RED) . " WHERE aid='{$aid}'");
    $total_red_user = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_RED) . " WHERE openid = :openid AND aid = :aid", array(":openid" => $record["openid"], ":aid" => $aid));
    $today_start = strtotime(date("Y-m-d"));
    $total_red_user_day = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_RED) . " WHERE aid=:aid AND openid = :openid AND createtime>{$today_start}", array(":aid" => $aid, ":openid" => $record["openid"]));
    if ($red_info) {
        if ($red_info["aid"] != $qrcode["aid"]) {
            message("参数错误：活动ID不统一", referer(), "error");
        }
        if ($red_info["openid"] != $qrcode["openid"]) {
            message("参数错误：红包和二维码数据不统一", referer(), "error");
        }
        if ($red_info["status"] == 1) {
            message("已经发过红包了", referer(), "error");
        } else {
            if ($red_info["status"] == 4) {
                message("红包已退回", referer(), "error");
            } else {
                message("红包已生成，请到红包列表出发放", referer(), "error");
            }
        }
    } else {
        if ($activity["money_sum"] && $sum_money_act["sum_money"] >= $activity["money_sum"]) {
            message("红包已发完", referer(), "error");
        }
        if ($activity["qrcode_num"] && $total_red >= $activity["qrcode_num"]) {
            message("红包已发完", referer(), "error");
        }
    }
    if ($activity["get_num"] && $total_red_user >= $activity["get_num"]) {
        message("该用户领取红包个数超过限制", referer(), "error");
    }
    if ($activity["get_num_day"] && $total_red_user >= $activity["get_num_day"]) {
        message("该用户今日领取红包个数超过限制", referer(), "error");
    }
    $money = $this->get_red_money($activity, $total_red, $sum_money_act["sum_money"]);
    if ($money < 0.3) {
        message("红包金额数据错误", referer(), "error");
    }
    $data_red = array("uniacid" => $uniacid, "openid" => $record["openid"], "money" => $money, "aid" => $record["aid"], "shopid" => $activity["sid"], "status" => 0, "tid" => $qrcode["id"], "createtime" => time());
    if (pdo_fieldexists("crad_qrcode_red_red", "trade_no")) {
        if ($activity["payway"] == 0) {
            $data_red["trade_no"] = random(10) . date("Ymd") . random(3);
        } else {
            if ($cfg["sl_pay"] == 1) {
                $mchid_s = $this->data_decrypt($cfg["mchid_sl"], $cfg["ticket"]);
                $data_red["trade_no"] = $mchid_s . date("YmdHis") . rand(1000, 9999);
            } else {
                $data_red["trade_no"] = $cfg["mchid"] . date("YmdHis") . rand(1000, 9999);
            }
        }
    }
    if (pdo_insert(TABLE_RED, $data_red) === false) {
        message("红包数据写入失败", referer(), "error");
    }
    $insertid = pdo_insertid();
    if (!$insertid) {
        message("红包数据写入失败", referer(), "error");
    }
    pdo_update(TABLE_QRCODE, array("status" => 2), array("id" => $qrcode["id"]));
    $red_info = $data_red;
    $red_info["id"] = $insertid;
    $update_task = array("status" => 1, "check_time" => time());
    $status_res = pdo_update(TABLE_SHOP_TASK, $update_task, array("id" => $recid));
    if ($status_res === false) {
        pdo_delete(TABLE_RED, array("id" => $insertid));
        message("审核失败", referer(), "error");
    }
    $res_send = $this->cash($activity, $red_info, $qrcode["uuid"], $user);
    $res_arr = json_decode($res_send, true);
    if ($res_arr["sta"] == 1) {
        pdo_update(TABLE_QRCODE, array("status" => 3), array("id" => $qrcode["id"]));
        message("审核成功，红包" . $data_red["money"] . "元已发给用户", referer(), "success");
    } else {
        $update_task_no = array("status" => 0, "check_time" => 0);
        $status_res = pdo_update(TABLE_SHOP_TASK, $update_task_no, array("id" => $recid));
        pdo_delete(TABLE_RED, array("uniacid" => $uniacid, "id" => $insertid));
        message("审核失败：红包发送出错(" . $res_arr["error"] . ")", referer(), "error");
    }
}
$pindex = max(1, intval($_GPC["page"]));
$psize = 10;
$condition = "a.uniacid='{$uniacid}' ";
if ($aid) {
    $condition .= " AND a.aid = '{$aid}' ";
}
$status = intval($_GPC["status"]);
if ($status > 0) {
    if ($status == 1) {
        $status1 = 1;
    } else {
        $status1 = 0;
    }
    $condition .= " AND a.status = {$status1} ";
}
if (!empty($_GPC["keyword"])) {
    $condition .= " AND CONCAT(a.openid) LIKE '%{$_GPC["keyword"]}%' ";
}
$list = pdo_fetchall("select a.*,b.nickname,b.headimgurl as img  from " . tablename(TABLE_SHOP_TASK) . " as a left join " . tablename(TABLE_USER) . " as b on a.aid=b.aid and a.uniacid=b.uniacid and a.openid=b.openid \r\nwhere " . $condition . " order by a.id desc LIMIT " . ($pindex - 1) * $psize . "," . $psize);
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename(TABLE_SHOP_TASK) . " as a left join " . tablename(TABLE_USER) . " as b on a.aid=b.aid and a.uniacid=b.uniacid and a.openid=b.openid  where {$condition}");
$pager = pagination($total, $pindex, $psize);
include $this->template("task");