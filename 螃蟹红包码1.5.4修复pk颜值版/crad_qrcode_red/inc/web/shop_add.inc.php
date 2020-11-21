<?php
defined("IN_IA") or exit("Access Denied");
global $_GPC, $_W;
checklogin();
$uniacid = $_W["uniacid"];
$id = intval($_GPC["id"]);
$op = $_GPC["op"];
if (empty($op)) {
    $op = "add";
}
load()->func("tpl");
load()->func("file");
if ($id) {
    $set = pdo_fetch("SELECT * FROM " . tablename(TABLE_SHOP) . " WHERE uniacid = :uniacid AND id = :id", array(":uniacid" => $uniacid, ":id" => $id));
    if ($set["begintime"]) {
        $set["begintime"] = date("Y-m-d H:i", $set["begintime"]);
    }
    if ($set["endtime"]) {
        $set["endtime"] = date("Y-m-d H:i", $set["endtime"]);
    }
}
if (checksubmit("submit")) {
    if (empty($_GPC["name"])) {
        message("请输入商家名称！", '', "error");
    }
    if ($op == "add") {
        $has_name = pdo_fetch("SELECT * FROM " . tablename(TABLE_SHOP) . " WHERE uniacid = :uniacid AND name = :name", array(":uniacid" => $uniacid, ":name" => trim($_GPC["name"])));
        if ($has_name) {
            message("商家名称已经存在！", '', "error");
        }
    }
    if ($op == "edit" && !empty($set)) {
        $has_name = pdo_fetch("SELECT * FROM " . tablename(TABLE_SHOP) . " WHERE uniacid = :uniacid AND name = :name  AND id != :id", array(":uniacid" => $uniacid, ":name" => trim($_GPC["name"]), ":id" => $id));
        if ($has_name) {
            message("商家名称已经存在！", '', "error");
        }
    }
    $time_open = $_GPC["time_open"] ? 1 : 0;
    if ($time_open && $_GPC["begintime"] && $_GPC["endtime"] && strtotime($_GPC["begintime"]) > strtotime($_GPC["endtime"])) {
        message("授权开始时间不能大于结束时间！", '', "error");
    }
    $data = array("uniacid" => $uniacid, "name" => addslashes($_GPC["name"]), "description" => addslashes($_GPC["description"]), "tel" => addslashes($_GPC["tel"]), "circleid" => $_GPC["circleid"] ? intval($_GPC["circleid"]) : 0, "address" => $_GPC["address"] ? addslashes(trim($_GPC["address"])) : '', "time_open" => $time_open, "begintime" => $_GPC["begintime"] ? strtotime($_GPC["begintime"]) : 0, "endtime" => $_GPC["endtime"] ? strtotime($_GPC["endtime"]) : 0, "image_logo" => trim($_GPC["image_logo"]), "image_banner" => trim($_GPC["image_banner"]), "longitude" => trim($_GPC["map"]["lng"]), "latitude" => trim($_GPC["map"]["lat"]), "use_tips" => trim($_GPC["use_tips"]), "check_open" => intval($_GPC["check_open"]), "coupon_sort" => intval($_GPC["coupon_sort"]), "recharge_open" => intval($_GPC["recharge_open"]), "activity_open" => intval($_GPC["activity_open"]), "coupon_open" => intval($_GPC["coupon_open"]), "other_fee" => intval($_GPC["other_fee"]), "income_charge" => intval($_GPC["income_charge"]), "qrcode_create_open" => intval($_GPC["qrcode_create_open"]), "createtime" => time());
    if (!empty($_GPC["pattern"])) {
        $data["pattern"] = implode(",", $_GPC["pattern"]);
    }
    if ($op == "add" && empty($set)) {
        pdo_insert(TABLE_SHOP, $data);
        $insertid = pdo_insertid();
        if (!$insertid) {
            message("数据添加失败！", '', "error");
        }
    }
    if ($op == "edit" && !empty($set)) {
        pdo_update(TABLE_SHOP, $data, array("id" => $set["id"]));
        $insertid = $set["id"];
    }
    if ($_GPC["help_recharge"] < 0) {
        $sum_money_all = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_FINANCE) . " WHERE shopid = :shopid AND type<2 AND status=1", array(":shopid" => $insertid));
        $sum_money = sprintf("%.2f", $sum_money_all["sum_money"]);
        $sum_money_use = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_FINANCE) . " WHERE shopid = :shopid AND type>1 AND status=1", array(":shopid" => $insertid));
        $use_money = $sum_money_use["sum_money"];
        $least_money = $sum_money - $use_money + $_GPC["help_recharge"];
        if ($least_money < 0) {
            message("充值金额错误！", '', "error");
        }
    }
    if ($insertid && $_GPC["help_recharge"] && $_GPC["help_recharge"] != "0.00") {
        $data_finance = array("uniacid" => $uniacid, "openid" => '', "shopid" => $insertid, "type" => 1, "status" => 1, "money" => intval($_GPC["help_recharge"] * 100) / 100, "money_all" => intval($_GPC["help_recharge"] * 100) / 100, "money_fee" => "0.00", "order_no" => '', "createtime" => time(), "paytime" => time());
        pdo_insert(TABLE_FINANCE, $data_finance);
    }
    $pids = $_GPC["pids"];
    $usernames = $_GPC["usernames"];
    $passwords = $_GPC["passwords"];
    $powers = $_GPC["powers"];
    $openids = $_GPC["openids"];
    if (is_array($pids)) {
        foreach ($pids as $key => $value) {
            if (!(empty($usernames[$key]) || empty($powers[$key]))) {
                $value = intval($value);
                if ($value) {
                    $has_user = pdo_fetch("SELECT * FROM " . tablename(TABLE_MANAGER) . " WHERE uniacid = :uniacid AND username = :username AND id != :id", array(":uniacid" => $uniacid, ":id" => $value, ":username" => trim($usernames[$key])));
                    if ($openids[$key]) {
                        $has_openid = pdo_fetch("SELECT * FROM " . tablename(TABLE_MANAGER) . " WHERE uniacid = :uniacid AND shopid='{$insertid}' AND openid = :openid AND id != :id", array(":uniacid" => $uniacid, ":id" => $value, ":openid" => trim($openids[$key])));
                    }
                } else {
                    if (!empty($passwords[$key])) {
                        $has_user = pdo_fetch("SELECT * FROM " . tablename(TABLE_MANAGER) . " WHERE uniacid = :uniacid AND username = :username", array(":uniacid" => $uniacid, ":username" => trim($usernames[$key])));
                        if ($openids[$key]) {
                            $has_openid = pdo_fetch("SELECT * FROM " . tablename(TABLE_MANAGER) . " WHERE uniacid = :uniacid AND shopid='{$insertid}' AND openid = :openid", array(":uniacid" => $uniacid, ":id" => $value, ":openid" => trim($openids[$key])));
                        }
                        if (!$has_user) {
                            if (!$has_openid) {
                                $data_manager = array("uniacid" => $uniacid, "shopid" => $insertid, "username" => trim($usernames[$key]), "power" => intval($powers[$key]), "openid" => trim($openids[$key]), "createtime" => TIMESTAMP);
                                if ($passwords[$key]) {
                                    $data_manager["password"] = md5(sha1(trim($passwords[$key])));
                                }
                                if (empty($value)) {
                                    pdo_insert(TABLE_MANAGER, $data_manager);
                                } else {
                                    pdo_update(TABLE_MANAGER, $data_manager, array("uniacid" => $uniacid, "shopid" => $insertid, "id" => $value));
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    message("数据操作成功！", referer(), '');
}
if ($op == "delmanager") {
    $pid = intval($_GPC["pid"]);
    if ($pid > 0) {
        $item_manager = pdo_fetch("SELECT * FROM " . tablename(TABLE_MANAGER) . " WHERE id = :id", array(":id" => $pid));
        if (empty($item_manager)) {
            $data["sta"] = 0;
            $data["error"] = "数据不存在";
            echo json_encode($data);
            exit;
        }
        if ($item_manager["uniacid"] != $uniacid || $item_manager["shopid"] != $id) {
            $data["sta"] = 0;
            $data["error"] = "您没有权限操作";
            echo json_encode($data);
            exit;
        }
        if (!(pdo_delete(TABLE_MANAGER, array("id" => $pid)) === false)) {
            $data["sta"] = 1;
            echo json_encode($data);
            exit;
        }
        $data["sta"] = 0;
        $data["error"] = "删除失败";
        echo json_encode($data);
        exit;
    }
} else {
    if ($op == "band_qrcode") {
        $start_code = intval($_GPC["start_code"]);
        $bid = intval($_GPC["bid"]);
        $end_code = intval($_GPC["end_code"]);
        $band_num = intval($_GPC["band_num"]);
        if (empty($bid)) {
            echo json_encode(array("sta" => 0, "error" => "参数错误:请选择预印码"));
            exit;
        }
        $bid_max_min = pdo_fetch("SELECT MAX(code) as max_id,MIN(code) as min_id FROM " . tablename(TABLE_QRCODE) . " where bid = :id AND aid<1 AND sid<1", array(":id" => $bid));
        if (empty($bid_max_min["max_id"]) || empty($bid_max_min["min_id"])) {
            echo json_encode(array("sta" => 0, "error" => "参数错误"));
            exit;
        }
        $min_code = $start_code ? max($start_code, $bid_max_min["min_id"]) : $bid_max_min["min_id"];
        $max_code = $end_code ? min($end_code, $bid_max_min["max_id"]) : $bid_max_min["max_id"];
        $count_qrcode_code = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " WHERE bid = :id AND aid<1 AND sid<1 AND code<={$max_code} AND code>={$min_code}", array(":id" => $bid));
        $count_qrcode_code = $count_qrcode_code ? $count_qrcode_code : 0;
        $band_num = $band_num ? $band_num : $count_qrcode_code;
        if ($count_qrcode_code < $band_num) {
            echo json_encode(array("sta" => 0, "error" => "预印码数量不足"));
            exit;
        }
        pdo_query("UPDATE " . tablename(TABLE_QRCODE) . " SET sid={$id} WHERE bid = :id AND aid<1 AND sid<1 AND code<={$max_code} AND code>={$min_code} ORDER BY code ASC LIMIT {$band_num}", array(":id" => $bid));
        echo json_encode(array("sta" => 1, "count" => $band_num));
        exit;
    } else {
        if ($op == "unband_qrcode") {
            $where = "WHERE sid ='{$id}' AND status=0";
            $start_code = intval($_GPC["start_code"]);
            $bid = intval($_GPC["bid"]);
            $end_code = intval($_GPC["end_code"]);
            $band_num = intval($_GPC["band_num"]);
            if ($bid) {
                $where .= " AND bid='{$bid}'";
            } else {
                $where .= " AND bid>0";
            }
            $bid_max_min = pdo_fetch("SELECT MAX(code) as max_id,MIN(code) as min_id FROM " . tablename(TABLE_QRCODE) . " {$where}");
            if (empty($bid_max_min["max_id"]) || empty($bid_max_min["min_id"])) {
                echo json_encode(array("sta" => 0, "error" => "参数错误"));
                exit;
            }
            $min_code = $start_code ? max($start_code, $bid_max_min["min_id"]) : $bid_max_min["min_id"];
            $max_code = $end_code ? min($end_code, $bid_max_min["max_id"]) : $bid_max_min["max_id"];
            $count_qrcode_code = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " {$where} AND code<={$max_code} AND code>={$min_code}");
            $temp_count = $band_num ? $band_num : $count_qrcode_code;
            if ($count_qrcode_code < $temp_count) {
                echo json_encode(array("sta" => 0, "error" => "可解绑的预印码数量不足"));
                exit;
            }
            pdo_query("UPDATE " . tablename(TABLE_QRCODE) . " SET sid=0 {$where} AND code<={$max_code} AND code>={$min_code} ORDER BY code ASC LIMIT {$temp_count}");
            echo json_encode(array("sta" => 1, "count" => $temp_count));
            exit;
        } else {
            if ($op == "del") {
                if ($id > 0) {
                    $item = pdo_fetch("SELECT * FROM " . tablename(TABLE_SHOP) . " WHERE id = :id", array(":id" => $id));
                    if (empty($item)) {
                        message("抱歉，数据不存在或是已经删除！", referer(), "error");
                    }
                    if ($item["uniacid"] != $uniacid) {
                        message("您没有权限操作");
                    }
                    if (pdo_delete(TABLE_SHOP, array("id" => $id)) === false) {
                        message("删除失败！", referer(), "error");
                    } else {
                        pdo_delete(TABLE_MANAGER, array("shopid" => $id, "uniacid" => $uniacid));
                        pdo_delete(TABLE_SHOP_COUPON, array("shopid" => $id, "uniacid" => $uniacid));
                        pdo_update(TABLE_COUPON, array("status" => 2), array("shopid" => $id, "uniacid" => $uniacid));
                        message("删除成功！", referer());
                    }
                }
            } else {
                if ($set) {
                    $manager = pdo_fetchall("select * from " . tablename(TABLE_MANAGER) . " where uniacid='{$uniacid}' AND shopid ='{$id}'");
                    $set["token"] = $this->get_shoptoken($uniacid, $set["id"]);
                } else {
                    $set["begintime"] = date("Y-m-d H:i", $_W["timestamp"]);
                    $set["endtime"] = date("Y-m-d H:i", strtotime(" +1 year"));
                    $set["pattern"] = "1,2,3,4,5,6,7,8,9,10,11,12";
                }
                if (!empty($set["pattern"])) {
                    $set["pattern"] = explode(",", $set["pattern"]);
                } else {
                    $set["pattern"] = array();
                }
                $circle = pdo_fetchall("select * from " . tablename(TABLE_CIRCLE) . " where uniacid='{$uniacid}' AND status = 1");
                include $this->template("shop_add");
            }
        }
    }
}