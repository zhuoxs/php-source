<?php
defined("IN_IA") or exit("Access Denied");
global $_GPC, $_W;
checklogin();
$uniacid = intval($_W["uniacid"]);
load()->func("tpl");
load()->classs("coupon");
$op = $_GPC["op"] ? $_GPC["op"] : "display";
if ($op == "get_coupons") {
    $shopid = intval($_GPC["shopid"]);
    $list_coupons["coupon"] = pdo_fetchall("SELECT id,name,coupon_type FROM " . tablename(TABLE_SHOP_COUPON) . " WHERE uniacid='{$uniacid}' AND shopid='{$shopid}' AND wechat_coupon<1 AND status=1 ORDER BY id DESC");
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
    load()->classs("coupon");
    $coupon_api = new coupon();
    $return = $coupon_api->DeleteCard($item["card_id"]);
    if (is_error($return)) {
        message("删除卡券失败，错误为" . $return["message"], '', "error");
    }
    if (pdo_update(TABLE_SHOP_COUPON, array("wechat_coupon" => 0, "card_id" => ''), array("id" => $id)) === false) {
        message("删除失败！", referer(), "error");
    } else {
        message("删除成功！", referer());
    }
} else {
    if ($op == "sync") {
        load()->classs("coupon");
        $coupon_api = new coupon();
        $cards = pdo_getall(TABLE_SHOP_COUPON, array("uniacid" => $uniacid), array("id", "status", "card_id", "uniacid"));
        foreach ($cards as $val) {
            $card = $coupon_api->fetchCard($val["card_id"]);
            if (!is_error($card)) {
                $type = strtolower($card["card_type"]);
                $coupon_status = array("CARD_STATUS_NOT_VERIFY" => 0, "CARD_STATUS_VERIFY_FAIL" => 2, "CARD_STATUS_VERIFY_OK" => 1, "CARD_STATUS_USER_DELETE" => 4, "CARD_STATUS_DELETE" => 4, "CARD_STATUS_USER_DISPATCH" => 5, "CARD_STATUS_DISPATCH" => 5);
                $status = $coupon_status[$card[$type]["base_info"]["status"]];
                pdo_update(TABLE_SHOP_COUPON, array("status" => $status), array("id" => $val["id"]));
            }
        }
    } else {
        if ($op == "modifystock") {
            $id = intval($_GPC["id"]);
            $coupon_num = intval($_GPC["coupon_num"]);
            $item = pdo_fetch("SELECT * FROM " . tablename(TABLE_SHOP_COUPON) . " WHERE id = :id ", array(":id" => $id));
            if (empty($item)) {
                message("抱歉，数据不存在或是已经删除！", referer(), "ajax");
            }
            if ($item["uniacid"] != $uniacid) {
                message("您没有权限操作", '', "ajax");
            }
            load()->classs("coupon");
            $coupon_api = new coupon();
            pdo_update(TABLE_SHOP_COUPON, array("coupon_num" => $coupon_num), array("id" => $id, "uniacid" => $uniacid));
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename(TABLE_COUPON) . "WHERE uniacid = :uniacid AND cid = :id AND wechat_coupon=1 AND code!=''", array(":uniacid" => $uniacid, ":id" => $id));
            $modify_quantity = $coupon_num - $total;
            $modify_quantity = $modify_quantity < 1 ? 0 : $modify_quantity;
            $return = $coupon_api->ModifyStockCard($item["card_id"], $modify_quantity);
            if (is_error($return)) {
                message(error(1, "修改卡券库存失败，错误为" . $return["message"]), '', "ajax");
            }
            message(error(0, "修改卡券数量成功"), referer(), "ajax");
        } else {
            if ($op == "detail") {
                $id = intval($_GPC["id"]);
                $colors = array("Color010" => "#55bd47", "Color020" => "#10ad61", "Color030" => "#35a4de", "Color040" => "#3d78da", "Color050" => "#9058cb", "Color060" => "#de9c33", "Color070" => "#ebac16", "Color080" => "#f9861f", "Color081" => "#f08500", "Color082" => "#a9d92d", "Color090" => "#e75735", "Color100" => "#d54036", "Color101" => "#cf3e36", "Color102" => "#5e6671");
                if (!empty($id)) {
                    $coupon = pdo_fetch("SELECT * FROM " . tablename(TABLE_SHOP_COUPON) . " WHERE uniacid = :uniacid AND id = :id", array(":uniacid" => $uniacid, ":id" => $id));
                    if (empty($coupon)) {
                        message("卡券不存在或是已经删除", '', "error");
                    }
                }
                if ($coupon["shopid"]) {
                    $shop_info = pdo_fetch("SELECT * FROM " . tablename(TABLE_SHOP) . " WHERE id = :id", array(":id" => $coupon["shopid"]));
                }
                if ($coupon["coupon_validity"]) {
                    $coupon_validity = json_decode($coupon["coupon_validity"], true);
                    if ($coupon_validity["time_type"] == "1") {
                        $coupon["extra_date_info"] = "有效期:" . $coupon_validity["start"] . "-" . $coupon_validity["end"];
                    } else {
                        $coupon["extra_date_info"] = "有效期:领取后" . $coupon_validity["deadline"] . "天可用，有效期" . $coupon_validity["limit"] . "天";
                    }
                }
                if ($coupon["coupon_content"]) {
                    $coupon_content = json_decode($coupon["coupon_content"], true);
                }
                if ($coupon["type"] == 1) {
                    $coupon["extra_instruction"] = "凭此券消费打" . $coupon_content["discount"] * 0.1 . "折";
                } else {
                    if ($coupon["type"] == 2) {
                        $coupon["extra_instruction"] = "消费满" . $coupon_content["least_cost"] . "元，减" . $coupon_content["reduce_cost"] . "元";
                    }
                }
                $coupon["logo_url"] = tomedia($coupon["logo_url"]);
                include $this->template("wechat_coupon");
            } else {
                if ($op == "post") {
                    $id = intval($_GPC["cid"]);
                    if ($id) {
                        $set = pdo_fetch("SELECT * FROM " . tablename(TABLE_SHOP_COUPON) . " WHERE uniacid = :uniacid AND id = :id", array(":uniacid" => $uniacid, ":id" => $id));
                        if (empty($set)) {
                            message("数据错误！", '', "error");
                        }
                    }
                    if (checksubmit("submit")) {
                        if (empty($_GPC["title"])) {
                            message("请输入卡券标题！", '', "error");
                        }
                        if (!empty($set)) {
                            $has_name = pdo_fetch("SELECT * FROM " . tablename(TABLE_SHOP_COUPON) . " WHERE uniacid = :uniacid AND title = :title  AND id != :id", array(":uniacid" => $uniacid, ":title" => trim($_GPC["title"]), ":id" => $id));
                        } else {
                            $has_name = pdo_fetch("SELECT * FROM " . tablename(TABLE_SHOP_COUPON) . " WHERE uniacid = :uniacid AND title = :title", array(":uniacid" => $uniacid, ":title" => trim($_GPC["title"])));
                        }
                        if ($has_name) {
                            message("卡券标题已经存在！", '', "error");
                        }
                        $shopid = intval($_GPC["shopid"]);
                        if ($shopid) {
                            $shop_info = pdo_fetch("SELECT * FROM " . tablename(TABLE_SHOP) . " WHERE id = :id", array(":id" => $shopid));
                        }
                        $data["wechat_coupon"] = 1;
                        $data["title"] = trim($_GPC["title"]);
                        $data["sub_title"] = trim($_GPC["sub_title"]);
                        if ($_GPC["logo_url"]) {
                            load()->model("material");
                            $logo_url = material_get($_GPC["logo_url"]);
                            $data["logo_url"] = $logo_url["url"];
                        }
                        $data["color"] = empty($_GPC["color"]) ? "Color082" : $_GPC["color"];
                        $data["can_share"] = intval($_GPC["can_share"]);
                        $data["can_give_friend"] = intval($_GPC["can_give_friend"]);
                        $data["notice"] = trim($_GPC["notice"]);
                        $data["promotion_url_name"] = trim($_GPC["promotion_url_name"]);
                        $data["promotion_url"] = trim($_GPC["promotion_url"]);
                        $data["promotion_url_sub_title"] = trim($_GPC["promotion_url_sub_title"]);
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
                            if ($data["coupon_num"] < 1 || $data["coupon_num"] > 100000000) {
                                message("卡券数量错误，应在[1,100000000]之间", '', "error");
                            }
                            $data["consume_type"] = intval($_GPC["consume_type"]);
                            $data["consume_code"] = trim($_GPC["consume_code"]);
                            $data["use_condition"] = trim($_GPC["sub_title"]);
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
                                $coupon_content["least_cost"] = intval($_GPC["least_cost"]);
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
                        $data["name"] = trim($_GPC["title"]);
                        $data["uniacid"] = $uniacid;
                        $data["status"] = 0;
                        $data["shopid"] = $shopid;
                        $data["createtime"] = time();
                        if ($data["coupon_friend"]) {
                            pdo_update(TABLE_SHOP_COUPON, array("coupon_friend" => 0), array("shopid" => $shopid, "uniacid" => $uniacid));
                        }
                        load()->classs("coupon");
                        $coupon_api = new coupon();
                        $coupon = Card::create($data["coupon_type"] == 3 ? 4 : $data["coupon_type"]);
                        $coupon->logo_url = tomedia(trim($data["logo_url"]));
                        $coupon->brand_name = $shop_info["name"];
                        $coupon->title = substr($data["title"], 0, 27);
                        $coupon->sub_title = $data["sub_title"];
                        $coupon->color = $data["color"];
                        $coupon->notice = $data["notice"];
                        $coupon->service_phone = $shop_info["tel"];
                        $coupon->description = $data["use_tip"];
                        $coupon->get_limit = intval($data["coupon_times"]);
                        $coupon->can_share = intval($_GPC["can_share"]) ? true : false;
                        $coupon->can_give_friend = intval($_GPC["can_give_friend"]) ? true : false;
                        if ($validity["time_type"] == 1) {
                            $coupon->setDateinfoRange($validity["start"], $validity["end"]);
                        } else {
                            $coupon->setDateinfoFix($validity["deadline"], $validity["limit"]);
                        }
                        if (!empty($_GPC["promotion_url_name"]) && !empty($_GPC["promotion_url"])) {
                            $coupon->setPromotionMenu($_GPC["promotion_url_name"], $_GPC["promotion_url_sub_title"], $_GPC["promotion_url"]);
                        }
                        $coupon->setCenterMenu('', '', '');
                        $coupon->setCustomMenu("立即核销", "更多惊喜", murl("entry", array("m" => "crad_qrcode_red", "do" => "my"), true, true));
                        $coupon->setQuantity($data["coupon_num"]);
                        $coupon->setCodetype($data["consume_type"] + 1);
                        $coupon->discount = 100 - intval($coupon_content["discount"]);
                        $coupon->least_cost = $coupon_content["least_cost"] * 100;
                        $coupon->reduce_cost = $coupon_content["reduce_cost"] * 100;
                        $coupon->gift = $coupon_content["gift"];
                        $check = $coupon->validate();
                        if (is_error($check)) {
                            message($check["message"], '', "error");
                        }
                        $status = $coupon_api->CreateCard($coupon->getCardData());
                        if (is_error($status)) {
                            message($status["message"], '', "error");
                        }
                        $data["card_id"] = $status["card_id"];
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
                        $set["shopid"] = intval($_GPC["shopid"]);
                    }
                    if ($set["coupon_validity"]) {
                        $coupon_validity = json_decode($set["coupon_validity"], true);
                        $coupon_validity["time_limit"] = array("start" => $coupon_validity["start"], "end" => $coupon_validity["end"]);
                    }
                    if ($set["coupon_content"]) {
                        $coupon_content = json_decode($set["coupon_content"], true);
                    }
                    $shop_lists = pdo_fetchall("select id,name from " . tablename(TABLE_SHOP) . " where uniacid='{$uniacid}'");
                    if ($set["shopid"]) {
                        $shop_coupon = pdo_fetchall("SELECT id,name,coupon_type FROM " . tablename(TABLE_SHOP_COUPON) . " WHERE uniacid='{$uniacid}' AND shopid='{$set["shopid"]}' AND wechat_coupon<1 AND status=1 ORDER BY id DESC");
                    }
                    include $this->template("wechat_coupon");
                } else {
                    $pindex = max(1, intval($_GPC["page"]));
                    $psize = 10;
                    $condition = "uniacid='{$uniacid}' AND wechat_coupon=1";
                    if (!empty($_GPC["keyword"])) {
                        $condition .= " AND CONCAT(title) LIKE '%{$_GPC["keyword"]}%'";
                    }
                    $coupon_type = intval($_GPC["coupon_type"]);
                    if ($coupon_type) {
                        $condition .= " AND coupon_type = '{$coupon_type}'";
                    }
                    $status = intval($_GPC["status"]);
                    if ($status) {
                        $status_s = $status == 3 ? 0 : $status;
                        $condition .= " AND status = '{$status_s}'";
                    }
                    $sid = intval($_GPC["sid"]);
                    if ($shopid) {
                        $condition .= " AND shopid = '{$sid}'";
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
                            if ($coupon_row["shopid"]) {
                                $shop_coupon = pdo_fetch("SELECT id,name,tel FROM " . tablename(TABLE_SHOP) . " WHERE uniacid='{$uniacid}' AND id='{$coupon_row["shopid"]}'");
                                $coupon_row["shopname"] = $shop_coupon["name"];
                                $coupon_row["tel"] = $shop_coupon["tel"];
                            }
                            if ($coupon_row["coupon_content"]) {
                                $coupon_content = json_decode($coupon_row["coupon_content"], true);
                                if ($coupon_row["coupon_type"] == 1) {
                                    $coupon_row["coupon_content"] = "折扣券：" . $coupon_content["discount"] / 10 . "折";
                                } else {
                                    if ($coupon_row["coupon_type"] == 2) {
                                        $coupon_row["coupon_content"] = "现金券：满 {$coupon_content["least_cost"]} 元减 {$coupon_content["reduce_cost"]}元";
                                    } else {
                                        if ($coupon_row["coupon_type"] == 3) {
                                            $coupon_row["coupon_content"] = "礼品券：" . $coupon_content["gift"];
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $shop_lists = pdo_fetchall("select id,name from " . tablename(TABLE_SHOP) . " where uniacid='{$uniacid}'");
                    $total = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_SHOP_COUPON) . " where {$condition}");
                    $pager = pagination($total, $pindex, $psize);
                    include $this->template("wechat_coupon");
                }
            }
        }
    }
}