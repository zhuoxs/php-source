<?php
defined("IN_IA") or exit("Access Denied");
global $_GPC, $_W;
checklogin();
$uniacid = intval($_W["uniacid"]);
$shopid = intval($_GPC["shopid"]);
if ($shopid) {
    $shop_name = pdo_fetch("SELECT name FROM " . tablename(TABLE_SHOP) . " WHERE uniacid = :uniacid AND id = :id", array(":uniacid" => $uniacid, ":id" => $shopid));
    if (empty($shop_name)) {
        message("参数错误", referer(), "error");
    }
    $shop_name = $shop_name["name"];
}
load()->func("tpl");
$op = $_GPC["op"] ? $_GPC["op"] : "display";
if ($op == "get_coupons") {
    $list_coupons["coupon"] = pdo_fetchall("SELECT id,name FROM " . tablename(TABLE_SHOP_COUPON) . " WHERE uniacid='{$uniacid}' AND shopid='{$shopid}' AND coupon_probability<1 AND status=1 ORDER BY id DESC");
    $list_coupons["coupon_prize"] = pdo_fetchall("SELECT id,name FROM " . tablename(TABLE_SHOP_COUPON) . " WHERE uniacid='{$uniacid}' AND shopid='{$shopid}' AND coupon_probability>0 AND status=1 ORDER BY id DESC");
    exit(json_encode($list_coupons));
}
if ($op == "del") {
    $id = intval($_GPC["id"]);
    $item = pdo_fetch("SELECT * FROM " . tablename(TABLE_SHOP_COUPON) . " WHERE id = :id AND shopid=:shopid", array(":id" => $id, ":shopid" => $shopid));
    if (empty($item)) {
        message("抱歉，数据不存在或是已经删除！", referer(), "error");
    }
    if ($item["uniacid"] != $uniacid) {
        message("您没有权限操作");
    }
    if (pdo_delete(TABLE_SHOP_COUPON, array("id" => $id)) === false) {
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
                $item_task = pdo_fetch("SELECT * FROM " . tablename(TABLE_SHOP_COUPON) . " WHERE id = :id AND uniacid=:uniacid AND shopid='{$shopid}'", array(":id" => $id, ":uniacid" => $uniacid));
                if (!empty($item_task)) {
                    pdo_delete(TABLE_SHOP_COUPON, array("id" => $id, "uniacid" => $uniacid));
                    $rowcount++;
                } else {
                    $notrowcount++;
                }
            }
        }
    } else {
        if ($op == "deleteall") {
            $search = "uniacid='{$uniacid}' AND shopid='{$shopid}'";
            pdo_delete(TABLE_SHOP_COUPON, $search);
            message("删除成功", referer(), "success");
        } else {
            if ($op == "post") {
                $id = intval($_GPC["id"]);
                if ($id) {
                    $set = pdo_fetch("SELECT * FROM " . tablename(TABLE_SHOP_COUPON) . " WHERE uniacid = :uniacid AND id = :id AND shopid=:shopid", array(":uniacid" => $uniacid, ":shopid" => $shopid, ":id" => $id));
                    if (empty($set)) {
                        message("数据错误！", '', "error");
                    }
                    if ($set["wechat_coupon"] == 1) {
                        message("微信卡券无法编辑！", '', "error");
                    }
                }
                if (checksubmit("submit")) {
                    if (empty($_GPC["name"])) {
                        message("请输入卡券名称！", '', "error");
                    }
                    if (!empty($set)) {
                        $has_name = pdo_fetch("SELECT * FROM " . tablename(TABLE_SHOP_COUPON) . " WHERE uniacid = :uniacid AND shopid=:shopid AND name = :name  AND id != :id", array(":uniacid" => $uniacid, ":shopid" => $shopid, ":name" => trim($_GPC["name"]), ":id" => $id));
                    } else {
                        $has_name = pdo_fetch("SELECT * FROM " . tablename(TABLE_SHOP_COUPON) . " WHERE uniacid = :uniacid AND shopid=:shopid AND name = :name", array(":uniacid" => $uniacid, ":shopid" => $shopid, ":name" => trim($_GPC["name"])));
                    }
                    if ($has_name) {
                        message("卡券名称已经存在！", '', "error");
                    }
                    $data["coupon_type"] = intval($_GPC["coupon_type"]);
                    if ($data["coupon_type"]) {
                        $time_type = intval($_GPC["time_type"]);
                        if ($time_type == 1) {
                            if ($_GPC["time_limit"]["start"] && $_GPC["time_limit"]["end"] && strtotime($_GPC["time_limit"]["start"]) > strtotime($_GPC["time_limit"]["end"])) {
                                message("卡券有效期设置错误：开始不能大于结束！", '', "error");
                            }
                            $validity["time_type"] = 1;
                            $validity["start"] = trim($_GPC["time_limit"]["start"]);
                            $validity["end"] = trim($_GPC["time_limit"]["end"]);
                        } else {
                            if ($time_type == 2) {
                                $validity["time_type"] = 2;
                                $validity["deadline"] = $_GPC["deadline"];
                                $validity["limit"] = $_GPC["limit"];
                            }
                        }
                        $data["coupon_validity"] = $validity ? json_encode($validity) : '';
                        $coupon_friend = intval($_GPC["coupon_friend"]);
                        $data["coupon_friend"] = intval($_GPC["coupon_friend"]) ? 1 : 0;
                        $data["coupon_num"] = intval($_GPC["coupon_num"]);
                        $data["consume_type"] = intval($_GPC["consume_type"]);
                        $data["consume_code"] = trim($_GPC["consume_code"]);
                        $data["use_condition"] = trim($_GPC["use_condition"]);
                        $data["use_tip"] = trim($_GPC["use_tip"]);
                        $data["coupon_probability"] = intval($_GPC["coupon_probability"]);
                    } else {
                        message("请选择卡券类型！", '', "error");
                    }
                    if ($data["coupon_friend"] && $data["coupon_probability"] > 0) {
                        message("联盟券不能设置概率展示！", '', "error");
                    }
                    if ($data["coupon_type"] == 1) {
                        $coupon_content["discount"] = intval($_GPC["discount"]);
                    } else {
                        if ($data["coupon_type"] == 2) {
                            $coupon_content["reduce_cost"] = intval($_GPC["reduce_cost"]);
                        } else {
                            if ($data["coupon_type"] == 3) {
                                $coupon_content["gift"] = $_GPC["gift"];
                            }
                        }
                    }
                    $data["coupon_content"] = $coupon_content ? json_encode($coupon_content) : '';
                    $data["coupon_times"] = intval($_GPC["coupon_times"]);
                    $data["friend_coupon_times"] = intval($_GPC["friend_coupon_times"]);
                    $data["name"] = trim($_GPC["name"]);
                    $data["uniacid"] = $uniacid;
                    $data["status"] = 1;
                    $data["shopid"] = $shopid;
                    $data["createtime"] = time();
                    if ($data["coupon_friend"]) {
                        pdo_update(TABLE_SHOP_COUPON, array("coupon_friend" => 0), array("shopid" => $shopid, "uniacid" => $uniacid));
                    }
                    if ($set) {
                        pdo_update(TABLE_SHOP_COUPON, $data, array("id" => $set["id"]));
                    } else {
                        pdo_insert(TABLE_SHOP_COUPON, $data);
                    }
                    message("数据操作成功！", referer(), '');
                }
                if (empty($set)) {
                    $coupon_validity["time_limit"] = array("start" => date("Y-m-d"), "end" => date("Y-m-d", time() + 30 * 86400));
                    $coupon_validity["time_type"] = 1;
                    $set["coupon_type"] = 1;
                }
                if ($set["coupon_validity"]) {
                    $coupon_validity = json_decode($set["coupon_validity"], true);
                    $coupon_validity["time_limit"] = array("start" => $coupon_validity["start"], "end" => $coupon_validity["end"]);
                }
                if ($set["coupon_content"]) {
                    $coupon_content = json_decode($set["coupon_content"], true);
                }
                include $this->template("shop_coupon");
            } else {
                $pindex = max(1, intval($_GPC["page"]));
                $psize = 10;
                $condition = "uniacid='{$uniacid}' AND shopid='{$shopid}'";
                if (!empty($_GPC["keyword"])) {
                    $condition .= " AND CONCAT(name) LIKE '%{$_GPC["keyword"]}%'";
                }
                $coupon_type = intval($_GPC["coupon_type"]);
                if ($coupon_type) {
                    $condition .= " AND coupon_type = '{$coupon_type}'";
                }
                $list = pdo_fetchall("select * from " . tablename(TABLE_SHOP_COUPON) . " WHERE {$condition}  LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
                if (!empty($list)) {
                    foreach ($list as &$coupon_row) {
                        if ($coupon_row["coupon_validity"]) {
                            $coupon_validity = json_decode($coupon_row["coupon_validity"], true);
                            if ($coupon_validity["time_type"] == 1) {
                                if ($coupon_validity["start"] || $coupon_validity["end"]) {
                                    $coupon_row["coupon_validity"] = $coupon_validity["start"] . "至" . $coupon_validity["end"];
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
                $total = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_SHOP_COUPON) . " where {$condition}");
                $pager = pagination($total, $pindex, $psize);
                include $this->template("shop_coupon");
            }
        }
    }
}