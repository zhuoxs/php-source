<?php
global $_GPC, $_W;
checklogin();
$uniacid = $_W["uniacid"];
load()->func("tpl");
$op = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
$aid = intval($_GPC["aid"]);
if ($aid) {
    $activity_name = pdo_fetch("SELECT name,refund_open FROM " . tablename(TABLE_ACTIVITY) . " WHERE uniacid = :uniacid AND id = :id", array(":uniacid" => $uniacid, ":id" => $aid));
}
if ($op == "display") {
    $condition = '';
    $where = " WHERE a.uniacid = '{$uniacid}' ";
    $params = array();
    if (!empty($_GPC["keyword"])) {
        $where .= " AND CONCAT(b.nickname,b.tel,b.realname,b.openid) LIKE '%{$_GPC["keyword"]}%'";
    }
    $status = intval($_GPC["status"]);
    if ($status) {
        $where .= " AND a.status = :status";
        $params[":status"] = $status == 3 ? 0 : $status;
    }
    if ($aid) {
        $where .= " AND a.aid = :aid";
        $params[":aid"] = $aid;
    }
    $pindex = max(1, intval($_GPC["page"]));
    $psize = 10;
    $list = pdo_fetchall("SELECT a.*, b.nickname,b.tel, b.realname,b.headimgurl FROM " . tablename(TABLE_RED) . " AS a LEFT JOIN " . tablename(TABLE_USER) . " AS b ON a.openid = b.openid  AND a.aid = b.aid  " . $where . " ORDER BY a.id DESC LIMIT " . ($pindex - 1) * $psize . "," . $psize, $params);
    $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename(TABLE_RED) . " AS a LEFT JOIN " . tablename(TABLE_USER) . " AS b ON a.openid = b.openid AND a.aid = b.aid " . $where, $params);
    $total_send = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename(TABLE_RED) . " AS a LEFT JOIN " . tablename(TABLE_USER) . " AS b ON a.openid = b.openid  AND a.aid = b.aid " . $where . " AND a.status=1", $params);
    $total_refund = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename(TABLE_RED) . " AS a LEFT JOIN " . tablename(TABLE_USER) . " AS b ON a.openid = b.openid AND a.aid = b.aid " . $where . " AND a.status=4", $params);
    $count_user = pdo_fetchall("SELECT a.id FROM " . tablename(TABLE_RED) . " AS a LEFT JOIN " . tablename(TABLE_USER) . " AS b ON a.openid = b.openid AND a.aid = b.aid " . $where . " GROUP BY a.openid", $params);
    $count_user = count($count_user);
    $sum_money_all = pdo_fetch("SELECT SUM(a.money) AS sum_money FROM " . tablename(TABLE_RED) . " AS a LEFT JOIN " . tablename(TABLE_USER) . " AS b ON a.openid = b.openid AND a.aid = b.aid " . " {$where} AND a.status=1", $params);
    $sum_money = $sum_money_all["sum_money"] ? $sum_money_all["sum_money"] : "0.00";
    $sum_money_refund = pdo_fetch("SELECT SUM(a.money) AS sum_money FROM " . tablename(TABLE_RED) . " AS a LEFT JOIN " . tablename(TABLE_USER) . " AS b ON a.openid = b.openid AND a.aid = b.aid " . " {$where} AND a.status=4", $params);
    $refund_money = $sum_money_refund["sum_money"] ? $sum_money_refund["sum_money"] : "0.00";
    $pager = pagination($total, $pindex, $psize);
} else {
    if ($op == "get_refund") {
        exit(json_encode($activity_name));
    } else {
        if ($op == "consume") {
            $recid = intval($_GPC["id"]);
            $record = pdo_get(TABLE_RED, array("id" => $recid));
            if (empty($record)) {
                message("抱歉，数据不存在或是已经删除！", referer(), "error");
            }
            if ($record["uniacid"] != $uniacid) {
                message("您没有权限操作", referer(), "error");
            }
            if ($record["status"]) {
                message("数据异常", referer(), "error");
            }
            $activity = pdo_fetch("SELECT * FROM " . tablename(TABLE_ACTIVITY) . " WHERE uniacid = :uniacid AND id = :aid", array(":uniacid" => $uniacid, ":aid" => $record["aid"]));
            if (empty($activity)) {
                message("数据异常", referer(), "error");
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
            $qrcode = pdo_fetch("SELECT id FROM " . tablename(TABLE_QRCODE) . " WHERE uniacid = :uniacid AND id = :tid", array(":uniacid" => $uniacid, ":tid" => $record["tid"]));
            if (empty($qrcode)) {
                message("数据错误", referer(), "error");
            }
            $user = pdo_fetch("SELECT * FROM " . tablename(TABLE_USER) . " WHERE aid = :aid AND openid = :openid", array(":aid" => $record["aid"], ":openid" => $record["openid"]));
            $res_send = $this->cash($activity, $record, $qrcode["uuid"], $user);
            $res_arr = json_decode($res_send, true);
            if ($res_arr["sta"] == 1) {
                $update = array("status" => 3);
                pdo_update(TABLE_QRCODE, $update, array("id" => $qrcode["id"]));
                message("发送成功！", referer());
            } else {
                message("发送失败:" . $res_arr["error"], referer(), "error");
            }
        } else {
            if ($op == "refund") {
                if (empty($aid)) {
                    echo json_encode(array("sta" => 0, "error" => "请先选择一个活动"));
                    exit;
                }
                $activity = pdo_fetch("SELECT sid,refund_open,use_balance FROM " . tablename(TABLE_ACTIVITY) . " WHERE uniacid = :uniacid AND id = :aid", array(":uniacid" => $uniacid, ":aid" => $aid));
                if (empty($activity["refund_open"])) {
                    echo json_encode(array("sta" => 0, "error" => "该活动关闭了校验退回红包功能"));
                    exit;
                }
                if ($activity["sid"] && $activity["use_balance"]) {
                    $payment = pdo_fetch("SELECT id,type,status FROM " . tablename(TABLE_FINANCE) . " WHERE uniacid = :uniacid  AND shopid = :shopid  AND aid = :aid", array(":uniacid" => $uniacid, ":shopid" => $activity["sid"], ":aid" => $aid));
                    if ($payment["type"] == 3 && $payment["status"] == 1) {
                        echo json_encode(array("sta" => 0, "error" => "活动已结算，无法校验红包数据"));
                        exit;
                    }
                }
                $settlement = $_W["timestamp"] - 86400;
                $where = " WHERE uniacid = '{$uniacid}' AND status=1 AND refund_check!=1 AND mch_billno!='' AND createtime<{$settlement}";
                if ($aid) {
                    $where .= " AND aid='{$aid}'";
                }
                $list_red_check = pdo_fetchall("SELECT id,aid,status,mch_billno,refund_check,createtime,money FROM " . tablename(TABLE_RED) . " {$where} LIMIT 0,50");
                if (empty($list_red_check)) {
                    echo json_encode(array("sta" => 2));
                    exit;
                }
                foreach ($list_red_check as $value) {
                    $res_check = $this->getRedStatus($value["mch_billno"]);
                    if (empty($res_check) || $res_check["sta"] != 1) {
                        echo json_encode(array("sta" => 0, "error" => "调用接口出错：" . $res_check["sta"]));
                        exit;
                    }
                    if (!empty($res_check["status"])) {
                        $update_check = array("refund_check" => 1);
                        if ($res_check["status"] == 4 && $res_check["mch_billno"] == $value["mch_billno"] && $res_check["refund_amount"] == $value["money"] * 100) {
                            $update_check["status"] = 4;
                            $update_check["refund_time"] = $res_check["refund_time"];
                        }
                        if ($res_check["status"] == 1 && $res_check["mch_billno"] == $value["mch_billno"] && $res_check["total_amount"] == $value["money"] * 100) {
                            $update_check["status"] = 1;
                        }
                        if ($res_check["status"] == 3 && $res_check["mch_billno"] == $value["mch_billno"]) {
                            $update_check["status"] = 0;
                        }
                        pdo_update(TABLE_RED, $update_check, array("uniacid" => $uniacid, "id" => $value["id"]));
                    }
                }
            } else {
                if ($op == "del") {
                    $recid = intval($_GPC["id"]);
                    $record = pdo_get(TABLE_RED, array("uniacid" => $uniacid, "id" => $recid));
                    if (empty($record)) {
                        message("抱歉，数据不存在或是已经删除！", referer(), "error");
                    }
                    if ($record["status"]) {
                        message("数据异常", referer(), "error");
                    }
                    if ($record["uniacid"] != $uniacid) {
                        message("您没有权限操作");
                    }
                    $status = pdo_delete(TABLE_RED, array("id" => $recid));
                    if ($status === false) {
                        message("删除失败！", referer(), "error");
                    } else {
                        $qrcode = pdo_fetch("SELECT * FROM " . tablename(TABLE_QRCODE) . " WHERE uniacid = :uniacid AND id = :tid", array(":uniacid" => $uniacid, ":tid" => $record["tid"]));
                        if ($qrcode) {
                            $activity = pdo_fetch("SELECT pattern FROM " . tablename(TABLE_ACTIVITY) . " WHERE id = :id", array(":uniacid" => $uniacid, ":id" => $record["aid"]));
                            pdo_update(TABLE_QRCODE, array("status" => 0, "usetime" => 0, "openid" => '', "times" => 0, "times_day" => 0, "last_time" => 0), array("id" => $qrcode["id"]));
                            if ($activity["pattern"] == 1) {
                                pdo_delete(TABLE_SHOP_TASK, array("aid" => $qrcode["aid"], "tid" => $qrcode["id"], "uniacid" => $uniacid));
                            } else {
                                if ($activity["pattern"] == 5) {
                                    pdo_delete(TABLE_INVITATION_USER, array("aid" => $qrcode["aid"], "tid" => $qrcode["id"], "uniacid" => $uniacid));
                                } else {
                                    if ($activity["pattern"] == 6) {
                                        pdo_delete(TABLE_CUTEFACE, array("aid" => $qrcode["aid"], "tid" => $qrcode["id"], "uniacid" => $uniacid));
                                    } else {
                                        if ($activity["pattern"] == 4) {
                                            pdo_update(TABLE_IMPORT_MODE, array("tid" => 0), array("aid" => $qrcode["aid"], "tid" => $qrcode["id"], "uniacid" => $uniacid));
                                        }
                                    }
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
                                $item_red = pdo_fetch("SELECT * FROM " . tablename(TABLE_RED) . " WHERE id = :id AND uniacid=:uniacid", array(":id" => $id, ":uniacid" => $uniacid));
                                if (!(empty($item_red) || $item_red["status"])) {
                                    $status = pdo_delete(TABLE_RED, array("id" => $id));
                                    if (!($status === false)) {
                                        $qrcode = pdo_fetch("SELECT * FROM " . tablename(TABLE_QRCODE) . " WHERE uniacid = :uniacid AND id = :tid", array(":uniacid" => $uniacid, ":uuid" => $item_red["tid"]));
                                        if ($qrcode) {
                                            $activity = pdo_fetch("SELECT pattern FROM " . tablename(TABLE_ACTIVITY) . " WHERE id = :id", array(":id" => $item_red["aid"]));
                                            pdo_update(TABLE_QRCODE, array("status" => 0, "usetime" => 0, "openid" => '', "times" => 0, "times_day" => 0, "last_time" => 0), array("id" => $qrcode["id"]));
                                            if ($activity["pattern"] == 1) {
                                                pdo_delete(TABLE_SHOP_TASK, array("aid" => $qrcode["aid"], "tid" => $qrcode["id"], "uniacid" => $uniacid));
                                            } else {
                                                if ($activity["pattern"] == 5) {
                                                    pdo_delete(TABLE_INVITATION_USER, array("aid" => $qrcode["aid"], "tid" => $qrcode["id"], "uniacid" => $uniacid));
                                                } else {
                                                    if ($activity["pattern"] == 6) {
                                                        pdo_delete(TABLE_CUTEFACE, array("aid" => $qrcode["aid"], "tid" => $qrcode["id"], "uniacid" => $uniacid));
                                                    } else {
                                                        if ($activity["pattern"] == 4) {
                                                            pdo_update(TABLE_IMPORT_MODE, array("tid" => 0), array("aid" => $qrcode["aid"], "tid" => $qrcode["id"], "uniacid" => $uniacid));
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        $rowcount++;
                                    } else {
                                        $notrowcount++;
                                    }
                                } else {
                                    $notrowcount++;
                                }
                            }
                        }
                    } else {
                        if ($op == "excel") {
                            $where = " WHERE a.uniacid = '{$uniacid}'";
                            if ($aid) {
                                $where .= " AND a.aid='{$aid}'";
                            }
                            $list_excel = pdo_fetchall("SELECT a.*, b.nickname, b.tel, b.realname FROM " . tablename(TABLE_RED) . " AS a LEFT JOIN " . tablename(TABLE_USER) . " AS b ON a.openid = b.openid  AND a.uniacid = b.uniacid AND a.aid = b.aid" . " {$where} ORDER BY a.id DESC");
                            foreach ($list_excel as $key => $value) {
                                $arr[$i]["openid"] = $value["openid"];
                                $arr[$i]["nickname"] = iconv("UTF-8", "GB2312", $value["nickname"]);
                                $arr[$i]["realname"] = iconv("UTF-8", "GB2312", $value["realname"]);
                                $arr[$i]["tel"] = iconv("UTF-8", "GB2312", $value["tel"]);
                                $arr[$i]["money"] = $value["money"];
                                $arr[$i]["mch_billno"] = " " . $value["mch_billno"];
                                if (empty($value["status"])) {
                                    $arr[$i]["status"] = "未发放";
                                } else {
                                    if ($value["status"] == 1) {
                                        $arr[$i]["status"] = "已发放";
                                    } else {
                                        if ($value["status"] == 4) {
                                            $arr[$i]["status"] = "已退回";
                                        } else {
                                            if ($value["status"] == 2) {
                                                $arr[$i]["status"] = "已删除";
                                            }
                                        }
                                    }
                                }
                                $arr[$i]["status"] = iconv("UTF-8", "GB2312", $arr[$i]["status"]);
                                $arr[$i]["createtime"] = date("Y-m-d H:i:s", $value["createtime"]);
                                $i++;
                            }
                        }
                    }
                }
            }
        }
    }
}
$activity_info = pdo_fetchall("select * from " . tablename(TABLE_ACTIVITY) . " where uniacid='{$uniacid}'");
include $this->template("red");