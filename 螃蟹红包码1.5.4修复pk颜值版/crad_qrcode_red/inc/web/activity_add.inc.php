<?php
defined("IN_IA") or exit("Access Denied");
global $_GPC, $_W;
checklogin();
$uniacid = $_W["uniacid"];
$openid = $_W["openid"];
$id = intval($_GPC["id"]);
$op = $_GPC["op"] ? $_GPC["op"] : "add";
$cfg = $this->module["config"]["api"];
load()->func("tpl");
load()->func("file");
if ($id) {
    $set = pdo_fetch("SELECT * FROM " . tablename(TABLE_ACTIVITY) . " WHERE id = :id", array(":id" => $id));
    if (empty($set)) {
        message("抱歉，数据不存在或是已经删除！", referer(), "error");
    }
    if ($set["uniacid"] != $uniacid) {
        message("您没有权限操作", referer(), "error");
    }
}
if ($op == "examine") {
    $update = array("status" => intval($_GPC["status"]));
    if (pdo_update(TABLE_ACTIVITY, $update, array("uniacid" => $uniacid, "id" => $id)) === false) {
        message("操作失败！", referer(), "error");
    } else {
        if ($update["status"] == 1 && $set["openid"]) {
            if ($cfg["mid_check"]) {
                if ($set["sid"]) {
                    $shop_name = pdo_fetch("select id,name from " . tablename(TABLE_SHOP) . " where uniacid='{$uniacid}' AND id='" . $set["sid"] . "'");
                }
                $url = $_W["siteroot"] . "app/" . substr($this->createMobileUrl("shop_activity", array("token" => $this->get_shoptoken($uniacid, $set["sid"]), "shopid" => $set["sid"])), 2);
                $template = array("touser" => $set["openid"], "template_id" => $cfg["mid_check"], "url" => $url, "topcolor" => "#743a3a", "data" => array("first" => array("value" => urlencode("恭喜您的活动审核通过"), "color" => "#2F1B58"), "keyword1" => array("value" => urlencode($set["name"]), "color" => "#2F1B58"), "keyword2" => array("value" => urlencode($shop_name["name"]), "color" => "#2F1B58"), "keyword3" => array("value" => urlencode(date("Y-m-d H:i:s", time())), "color" => "#2F1B58"), "remark" => array("value" => urlencode("点击查看活动信息详情"), "color" => "#2F1B58")));
                $this->send_temp_ms(urldecode(json_encode($template)));
            }
        }
    }
    message("操作成功！", $this->createWebUrl("activity"));
} else {
    if ($op == "settlement") {
        if (empty($set["sid"]) || empty($set["use_balance"])) {
            message("参数错误", referer(), "error");
        }
        $payment = pdo_fetch("SELECT * FROM " . tablename(TABLE_FINANCE) . " WHERE shopid = :shopid  AND aid = :aid AND uniacid = :uniacid", array(":uniacid" => $uniacid, ":shopid" => $set["sid"], ":aid" => $set["id"]));
        if (empty($payment) || $payment["type"] != 2 || $payment["status"] != 1) {
            message("商家资金数据错误", referer(), "error");
        }
        if ($set["refund_open"]) {
            $where = " WHERE uniacid = '{$uniacid}' AND status=1 AND aid='{$id}' AND refund_check!=1 AND mch_billno!='' ";
            $list_red_check = pdo_fetchall("SELECT id,aid,status,mch_billno,refund_check,createtime,money FROM " . tablename(TABLE_RED) . " {$where}");
            foreach ($list_red_check as $value) {
                $res_check = $this->getRedStatus($value["mch_billno"]);
                if (empty($res_check) || $res_check["sta"] != 1) {
                    message("调用接口出错：" . $res_check["sta"], referer(), "error");
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
        }
        $sum_money_activity = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_RED) . "  WHERE aid='{$set["id"]}' AND shopid='{$set["sid"]}' AND status=1");
        $data_pinance = array("type" => 3, "status" => 1, "money" => $sum_money_activity["sum_money"] ? $sum_money_activity["sum_money"] : "0.00", "paytime" => time());
        pdo_update(TABLE_FINANCE, $data_pinance, array("id" => $payment["id"]));
        pdo_update(TABLE_ACTIVITY, array("endtime" => time(), "status" => 2), array("id" => $id));
        message("结算成功！", $this->createWebUrl("activity"));
    } else {
        if ($op == "del") {
            if (pdo_delete(TABLE_ACTIVITY, array("id" => $id)) === false) {
                message("删除失败！", referer(), "error");
            } else {
                if ($set["sid"] && $set["use_balance"]) {
                    $payment = pdo_fetch("SELECT * FROM " . tablename(TABLE_FINANCE) . " WHERE shopid = :shopid  AND aid = :aid", array(":shopid" => $set["sid"], ":aid" => $set["id"]));
                    if ($payment && $payment["type"] == 2 && $payment["status"] == 1) {
                        if ($set["refund_open"]) {
                            $where = " WHERE status=1 AND aid='{$id}' AND refund_check!=1 AND mch_billno!='' ";
                            $list_red_check = pdo_fetchall("SELECT id,aid,status,mch_billno,refund_check,createtime,money FROM " . tablename(TABLE_RED) . " {$where}");
                            foreach ($list_red_check as $value) {
                                $res_check = $this->getRedStatus($value["mch_billno"]);
                                if (empty($res_check) || $res_check["sta"] != 1) {
                                    message("调用接口出错：" . $res_check["sta"], referer(), "error");
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
                                    pdo_update(TABLE_RED, $update_check, array("id" => $value["id"]));
                                }
                            }
                        }
                        $sum_money_activity = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_RED) . " WHERE aid='{$set["id"]}' AND shopid='{$set["sid"]}' AND status=1");
                        $data_pinance = array("type" => 3, "status" => 1, "money" => $sum_money_activity["sum_money"] ? $sum_money_activity["sum_money"] : "0.00", "paytime" => time());
                        pdo_update(TABLE_FINANCE, $data_pinance, array("id" => $payment["id"]));
                    }
                }
                message("删除成功！", $this->createWebUrl("activity"));
                exit;
            }
        } else {
            if ($op == "create_qrcode") {
                if (empty($set) || $set["qrcode_num"] < 1) {
                    echo json_encode(array("sta" => 0, "error" => "数据错误"));
                    exit;
                }
                if ($set["endtime"] && $_W["timestamp"] >= $set["endtime"]) {
                    echo json_encode(array("sta" => 0, "error" => "活动已结束,无法生成二维码"));
                    exit;
                }
                $count_qrcode = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " where aid = :id", array(":id" => $id));
                if ($count_qrcode >= $set["qrcode_num"]) {
                    echo json_encode(array("sta" => 2, "count" => $set["qrcode_num"]));
                    exit;
                }
                $create_type = intval($_GPC["create_type"]);
                if ($create_type == 1) {
                    if ($set["sid"]) {
                        $where = " aid<1 AND (sid<1 OR sid='{$set["sid"]}')";
                    } else {
                        $where = " aid<1 AND sid<1";
                    }
                    $start_code = intval($_GPC["start_code"]);
                    $bid = intval($_GPC["bid"]);
                    $end_code = intval($_GPC["end_code"]);
                    $band_num = intval($_GPC["band_num"]);
                    if (empty($bid)) {
                        echo json_encode(array("sta" => 0, "error" => "参数错误:请选择预印码"));
                        exit;
                    }
                    $temp_count = $band_num ? min($band_num, $set["qrcode_num"] - $count_qrcode) : $set["qrcode_num"] - $count_qrcode;
                    $bid_max_min = pdo_fetch("SELECT MAX(code) as max_id,MIN(code) as min_id FROM " . tablename(TABLE_QRCODE) . " where bid = :id AND {$where}", array(":id" => $bid));
                    if (empty($bid_max_min["max_id"]) || empty($bid_max_min["min_id"])) {
                        echo json_encode(array("sta" => 0, "error" => "参数错误"));
                        exit;
                    }
                    $min_code = $start_code ? max($start_code, $bid_max_min["min_id"]) : $bid_max_min["min_id"];
                    $max_code = $end_code ? min($end_code, $bid_max_min["max_id"]) : $bid_max_min["max_id"];
                    $count_qrcode_code = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " WHERE bid = :id AND {$where} AND code<={$max_code} AND code>={$min_code}", array(":id" => $bid));
                    if ($count_qrcode_code < $temp_count) {
                        echo json_encode(array("sta" => 0, "error" => "预印码数量不足"));
                        exit;
                    }
                    pdo_query("UPDATE " . tablename(TABLE_QRCODE) . " SET aid={$id} WHERE bid = :id AND {$where} AND code<={$max_code} AND code>={$min_code} ORDER BY code ASC LIMIT {$temp_count}", array(":id" => $bid));
                } else {
                    if ($set["subscribe"] == 2) {

						$temp_min = 5;

					} else {

						$temp_min = 100;

					}

					$temp_count = min($temp_min, $set["qrcode_num"] - $count_qrcode);

					$x = 1;

					while ($x <= $temp_count) {

						$uuid = $this->get_uuid($id, $uniacid);

						if ($set["subscribe"] == 2) {

							$set["qrcode_type"] = $set["qrcode_one"] ? 0 : $set["qrcode_type"];

							$res_get = $this->get_qrcode_url($uuid . "red" . $id, $set["qrcode_type"]);

							$qrcode = $res_get["url"];

						}

						$data = array("uniacid" => $uniacid, "uuid" => $uuid, "aid" => $id, "qrcode" => $qrcode ? $qrcode : '', "status" => 0, "createtime" => time());

						pdo_insert(TABLE_QRCODE, $data);

						$x++;

					}
                }
                echo json_encode(array("sta" => 1, "count" => $count_qrcode + $temp_count));
				exit;
            } else {
                if ($op == "download_qrcode") {
                    $count_qrcode = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " where uniacid = :uniacid AND aid = :id", array(":uniacid" => $uniacid, ":id" => $id));
                    if (empty($set) || $count_qrcode < 1) {
                        echo json_encode(array("sta" => 0, "error" => "请先生成二维码"));
                        exit;
                    }
                    $pindex = max(1, intval($_GPC["page"]));
                    $psize = 20;
                    $list_qrcode = pdo_fetchall("SELECT id,aid,uuid,qrcode FROM " . tablename(TABLE_QRCODE) . " where aid = :id ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . "," . $psize, array(":id" => $id));
                    if (empty($list_qrcode)) {
                        echo json_encode(array("sta" => 2));
                        exit;
                    }
                    foreach ($list_qrcode as $value) {
                        $this->get_qrcode($value["id"], $value["uuid"], $id, 0, 0, $value["qrcode"]);
                    }
                } else {
                    if ($op == "download_qrcode_notuse") {
                        $count_qrcode = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " WHERE aid = :id AND status=0", array(":id" => $id));
                        if (empty($set) || $count_qrcode < 1) {
                            echo json_encode(array("sta" => 0, "error" => "没有未使用二维码"));
                            exit;
                        }
                        $pindex = max(1, intval($_GPC["page"]));
                        $psize = 20;
                        $list_qrcode = pdo_fetchall("SELECT id,aid,uuid,qrcode FROM " . tablename(TABLE_QRCODE) . " WHERE aid = :id AND status=0 ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . "," . $psize, array(":id" => $id));
                        if (empty($list_qrcode)) {
                            echo json_encode(array("sta" => 2));
                            exit;
                        }
                        foreach ($list_qrcode as $value) {
                            $this->get_qrcode($value["id"], $value["uuid"], $id, 0, 0, $value["qrcode"]);
                        }
                    } else {
                        if ($op == "unband_qrcode") {
                            $where = "WHERE aid ='{$id}' AND status=0";
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
                            pdo_query("UPDATE " . tablename(TABLE_QRCODE) . " SET aid=0 {$where} AND code<={$max_code} AND code>={$min_code} ORDER BY code ASC LIMIT {$temp_count}");
                            echo json_encode(array("sta" => 1, "count" => $temp_count));
                            exit;
                        } else {
                            if ($op == "download_qrcode_zip") {
                                $count_qrcode = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " where uniacid = :uniacid AND aid = :id", array(":uniacid" => $uniacid, ":id" => $id));
                                if (empty($set) || $count_qrcode < 1) {
                                    message("请先生成二维码", '', "error");
                                }
                                load()->func("file");
                                $qrcode_path = ATTACHMENT_ROOT . "crad_qrcode_red/" . $id . "/qrcode/";
                                $qrcode_zip = $qrcode_path . $id . ".zip";
                                if (file_exists($qrcode_zip)) {
                                    file_delete($qrcode_zip);
                                }
                                $zip = new ZipArchive();
                                if ($zip->open($qrcode_zip, ZipArchive::CREATE) === true) {
                                    $this->addFileToZip($qrcode_path, $zip);
                                    $zip->close();
                                } else {
                                    message("生成压缩文件失败，请稍后重试！", '', "error");
                                }
                                if (file_exists($qrcode_zip)) {
                                    ob_clean();
                                    header("Pragma: public");
                                    header("Last-Modified:" . gmdate("D, d M Y H:i:s") . "GMT");
                                    header("Cache-Control:no-store, no-cache, must-revalidate");
                                    header("Cache-Control:pre-check=0, post-check=0, max-age=0");
                                    header("Content-Transfer-Encoding:binary");
                                    header("Content-Encoding:none");
                                    header("Content-type:multipart/form-data");
                                    header("Content-Disposition:attachment; filename=\"" . $id . ".zip\"");
                                    header("Content-length:" . filesize($qrcode_zip));
                                    $fp = fopen($qrcode_zip, "r");
                                } else {
                                    if (is_dir($qrcode_path)) {
                                        $p = scandir($qrcode_path);
                                        foreach ($p as $val) {
                                            if ($val != "." && $val != "..") {
                                                if (file_exists($qrcode_path . $val)) {
                                                    file_delete($qrcode_path . $val);
                                                }
                                            }
                                        }
                                    }
                                    message("下载失败，请稍后重试！", '', "error");
                                }
                            } else {
                                if ($op == "download_excel") {
                                    $count_qrcode = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " where uniacid = :uniacid AND aid = :id AND status=0", array(":uniacid" => $uniacid, ":id" => $id));
                                    if (empty($set) || $count_qrcode < 1) {
                                        message("请先生成二维码！", '', "error");
                                    }
                                    $list_excel = pdo_fetchall("SELECT id,uuid,bid,sbid,code,qrcode FROM " . tablename(TABLE_QRCODE) . " where uniacid = :uniacid AND aid = :id AND status=0", array(":uniacid" => $uniacid, ":id" => $id));
                                    foreach ($list_excel as $key => $value) {
                                        $arr[$i]["id"] = $value["id"];
                                        if ($value["code"]) {
                                            $arr[$i]["code"] = ($value["sbid"] ? $value["sbid"] : $value["bid"]) . "_" . $value["code"];
                                        } else {
                                            $arr[$i]["code"] = $value["id"];
                                        }
                                        if ($set["subscribe"] == 2) {
                                            $arr[$i]["url"] = $value["qrcode"];
                                        } else {
                                            $arr[$i]["url"] = $value["qrcode"] ? $value["qrcode"] : $this->domain_site() . "app/index.php?i=" . $uniacid . "&c=entry&m=crad_qrcode_red&do=index&aid=" . $id . "&uuid=" . $value["uuid"];
                                        }
                                        $i++;
                                    }
                                } else {
                                    if (!($op == "download_txt")) {
                                        if ($set["sid"]) {
                                            $shop_coupon = pdo_fetchall("select id,name from " . tablename(TABLE_SHOP_COUPON) . " where  shopid='" . $set["sid"] . "' AND coupon_probability<1 AND status=1");
                                            $shop_coupon_p = pdo_fetchall("select id,name from " . tablename(TABLE_SHOP_COUPON) . " where  shopid='" . $set["sid"] . "' AND coupon_probability>0 AND status=1");
                                        }
                                        if (!checksubmit("submit")) {
                                            $shops = pdo_fetchall("select id,name from " . tablename(TABLE_SHOP) . " where uniacid='{$uniacid}'");
                                            if ($set["begintime"]) {
                                                $set["begintime"] = date("Y-m-d H:i:s", $set["begintime"]);
                                            }
                                            if ($set["endtime"]) {
                                                $set["endtime"] = date("Y-m-d H:i:s", $set["endtime"]);
                                            }
                                            $set["rules"] = $set["rules"] ? json_decode($set["rules"], true) : array();
                                            $set["buy_rules"] = $set["buy_rules"] ? json_decode($set["buy_rules"], true) : array();
                                            $lipstick_image = $set["lipstick_image"] ? json_decode($set["lipstick_image"], true) : array();
                                            if ($op == "add") {
                                                $set["status"] = 1;
                                                $set["audio_volume"] = 1.0;
                                                $set["start_success_time"] = 10.0;
                                                $set["end_success_time"] = 10.0;
                                                $set["begintime"] = date("Y-m-d H:i:s", $_W["timestamp"]);
                                                $set["endtime"] = date("Y-m-d H:i", strtotime(" +1 year"));
                                            }
                                            if ($_GPC["copy"] == 1 && $set["endtime"] && $_W["timestamp"] >= $set["endtime"]) {
                                                $set["begintime"] = date("Y-m-d H:i:s", $_W["timestamp"]);
                                                $set["endtime"] = date("Y-m-d H:i", strtotime(" +1 year"));
                                            }
                                            if ($id && empty($_GPC["copy"])) {
                                                $count_qrcode = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " where uniacid = :uniacid AND aid = :id", array(":uniacid" => $uniacid, ":id" => $id));
                                                $sum_money_send = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_RED) . " WHERE uniacid='{$uniacid}' AND aid='{$id}' AND status!=2");
                                            }
                                            include $this->template("activity_add");
                                        } else {
                                            if ($_GPC["copy"] == 1) {
                                                $set = array();
                                                $id = 0;
                                                $op = "add";
                                            }
                                            if (empty($_GPC["name"])) {
                                                message("请输入活动名称！", '', "error");
                                            }
                                            if ($op == "add") {
                                                $has_name = pdo_fetch("SELECT * FROM " . tablename(TABLE_ACTIVITY) . " WHERE uniacid = :uniacid AND name = :name", array(":uniacid" => $uniacid, ":name" => trim($_GPC["name"])));
                                                if ($has_name) {
                                                    message("活动名称已经存在！", '', "error");
                                                }
                                            }
                                            if ($op == "edit" && !empty($set)) {
                                                $has_name = pdo_fetch("SELECT * FROM " . tablename(TABLE_ACTIVITY) . " WHERE uniacid = :uniacid AND name = :name  AND id != :id", array(":uniacid" => $uniacid, ":name" => trim($_GPC["name"]), ":id" => $id));
                                                if ($has_name) {
                                                    message("活动名称已经存在！", '', "error");
                                                }
                                            }
                                            if ($_GPC["begintime"] && $_GPC["endtime"] && strtotime($_GPC["begintime"]) > strtotime($_GPC["endtime"])) {
                                                message("活动开始时间不能大于结束时间！", '', "error");
                                            }
                                            if ($cfg["sl_pay"] == 1 && $cfg["sub_mch_id"] && empty($_GPC["payway"])) {
                                                message("服务商子商户只能使用现金红包，不能使用企业付款到零钱！", '', "error");
                                            }
                                            //lonedev
                                            $data = array(
                                                "uniacid" => $uniacid,
                                                "createtime" => time(),
                                                "name" => trim($_GPC["name"]),
                                                "pattern" => intval($_GPC["pattern"]),
                                                "friend_cuteface_num" => intval($_GPC["friend_cuteface_num"]), 
                                                "loser_coupon_open" => intval($_GPC["loser_coupon_open"]), 
                                                "lipstick_level" => intval($_GPC["lipstick_level"]), 
                                                "lipstick_difficulty" => trim($_GPC["lipstick_difficulty"]),
                                                "lipstick_num_day" => trim($_GPC["lipstick_num_day"]), 
                                                "lipstick_num" => trim($_GPC["lipstick_num"]),
                                                "buy_times" => trim($_GPC["buy_times"]),
                                                "game_tip_before" => trim($_GPC["game_tip_before"]),
                                                "click_people" => trim($_GPC["click_people"]),
                                                "click_tip_before" => trim($_GPC["click_tip_before"]),
                                                "click_tip" => trim($_GPC["click_tip"]), 
                                                "countdown_tip" => trim($_GPC["countdown_tip"]),
                                                "countdown" => trim($_GPC["countdown"]), 
                                                "countdown_type" => intval($_GPC["countdown_type"]),
                                                "comment_open" => trim($_GPC["comment_open"]), 
                                                "start_success_time" => trim($_GPC["start_success_time"]),
                                                "end_success_time" => trim($_GPC["end_success_time"]),
                                                "time_speed" => trim($_GPC["time_speed"]),
                                                "challenge_rule" => trim($_GPC["challenge_rule"]),
                                                "challenge_num_day" => trim($_GPC["challenge_num_day"]),
                                                "challenge_num" => trim($_GPC["challenge_num"]),
                                                "content_open" => trim($_GPC["content_open"]),
                                                "task_tips" => trim($_GPC["task_tips"]),
                                                "image_task" => trim($_GPC["image_task"]),
                                                "invitation_num" => trim($_GPC["invitation_num"]),
                                                "invitation_tip" => trim($_GPC["invitation_tip"]),
                                                "invitation_link" => trim($_GPC["invitation_link"]),
                                                "send_red_type" => trim($_GPC["send_red_type"]),
                                                "command" => trim($_GPC["command"]),
                                                "image_command" => trim($_GPC["image_command"]),
                                                "img_link" => trim($_GPC["img_link"]),
                                                "hint" => trim($_GPC["hint"]),
                                                "cuteface_name" => trim($_GPC["cuteface_name"]),
                                                "cuteface_image" => trim($_GPC["cuteface_image"]),
                                                "cuteface_mark" => trim($_GPC["cuteface_mark"]),
                                                "cuteface_num_day" => trim($_GPC["cuteface_num_day"]),
                                                "cuteface_num" => trim($_GPC["cuteface_num"]),
                                                "share_open" => trim($_GPC["share_open"]),
                                                "share_num" => trim($_GPC["share_num"]),
                                                "add_one" => trim($_GPC["add_one"]),
                                                "share_tips" => trim($_GPC["share_tips"]),
                                                "share_title" => trim($_GPC["share_title"]),
                                                "share_desc" => trim($_GPC["share_desc"]),
                                                "share_img" => trim($_GPC["share_img"]),
                                                "share_type" => trim($_GPC["share_type"]),
                                                "share_link" => trim($_GPC["share_link"]),
                                                "white_check" => trim($_GPC["white_check"]),
                                                "other_field" => trim($_GPC["other_field"]),
                                                "upload_type" => trim($_GPC["upload_type"]),
                                                "music_game" => trim($_GPC["music_game"]),
                                                "cover1" => trim($_GPC["cover1"]),
                                                "cover2" => trim($_GPC["cover2"]),
                                                "cover3" => trim($_GPC["cover3"]),
                                                "circle_center1" => trim($_GPC["circle_center1"]),
                                                "circle_left1" => trim($_GPC["circle_left1"]),
                                                "circle_right1" => trim($_GPC["circle_right1"]),
                                                "launch1" => trim($_GPC["launch1"]),
                                                "launch_horizontal1" => trim($_GPC["launch_horizontal1"]),
                                                "launch_gray1" => trim($_GPC["launch_gray1"]),
                                                "circle_center2" => trim($_GPC["circle_center2"]),
                                                "circle_left2" => trim($_GPC["circle_left2"]),
                                                "circle_right2" => trim($_GPC["circle_right2"]),
                                                "launch2" => trim($_GPC["launch2"]),
                                                "launch_horizontal2" => trim($_GPC["launch_horizontal2"]),
                                                "launch_gray2" => trim($_GPC["launch_gray2"]),
                                                "circle_center3" => trim($_GPC["circle_center3"]),
                                                "circle_left3" => trim($_GPC["circle_left3"]),
                                                "circle_right3" => trim($_GPC["circle_right3"]),
                                                "launch3" => trim($_GPC["launch3"]),
                                                "launch_horizontal3" => trim($_GPC["launch_horizontal3"]),
                                                "launch_gray3" => trim($_GPC["launch_gray3"]),
                                                "statusd" => trim($_GPC["statusd"]),
                                                "limit_distance" => trim($_GPC["limit_distance"]),
                                                "site" => trim($_GPC["site"]),
                                                "check_tel" => trim($_GPC["check_tel"]),
                                                "qrcode_one" => trim($_GPC["qrcode_one"]),
                                                "url_key" => trim($_GPC["url_key"]),
                                                "get_num" => trim($_GPC["get_num"]),
                                                "get_num_day" => trim($_GPC["get_num_day"]),
                                                "over_limit_url" => trim($_GPC["over_limit_url"]),
                                                "sid" => intval($_GPC["sid"]),
                                                "edit_open" => trim($_GPC["edit_open"]),
                                                "coupon_open" => trim($_GPC["coupon_open"]),
                                                "red_jump_link" => trim($_GPC["red_jump_link"]),
                                                "red_jump_time" => trim($_GPC["red_jump_time"]),
                                                "pcid" => intval($_GPC["pcid"]),
                                                "coupon_deputy_num" => intval($_GPC["coupon_deputy_num"]),
                                                "coupon_circle" => trim($_GPC["coupon_circle"]),
                                                "coupon_circle_num" => intval($_GPC["coupon_circle_num"]),
                                                "subscribe" => trim($_GPC["subscribe"]),
                                                "qrcode_type" => intval($_GPC["qrcode_type"]),
                                                "scan_title" => trim($_GPC["scan_title"]),
                                                "scan_descriotion" => trim($_GPC["scan_descriotion"]),
                                                "scan_image" => trim($_GPC["scan_image"]),
                                                "sub_image" => trim($_GPC["sub_image"]),
                                                "sub_tips" => trim($_GPC["sub_tips"]),
                                                "status" => trim($_GPC["status"]),
                                                "stop_tips" => trim($_GPC["stop_tips"]),
                                                "description" => trim($_GPC["description"]),
                                                "tel" => trim($_GPC["tel"]),
                                                "image_logo" => trim($_GPC["image_logo"]),
                                                "image_body" => trim($_GPC["image_body"]),
                                                "begintime" => strtotime(trim($_GPC["begintime"])),
                                                "endtime" => strtotime(trim($_GPC["endtime"])),
                                                "top_tips" => trim($_GPC["top_tips"]),
                                                "top_tips_red" => trim($_GPC["top_tips_red"]),
                                                "closed_wish" => trim($_GPC["closed_wish"]),
                                                "open_wish" => trim($_GPC["open_wish"]),
                                                "open_tips" => trim($_GPC["open_tips"]),
                                                "open_coupon_wish" => trim($_GPC["open_coupon_wish"]),
                                                "qrcode_power" => trim($_GPC["qrcode_power"]),
                                                "use_balance" => trim($_GPC["use_balance"]),
                                                "settlement_open" => trim($_GPC["settlement_open"]),
                                                "refund_open" => trim($_GPC["refund_open"]),
                                                "payway" => trim($_GPC["payway"]),
                                                "validate_open" => trim($_GPC["validate_open"]),
                                                "money_type" => trim($_GPC["money_type"]),
                                                "start_money" => trim($_GPC["start_money"]),
                                                "end_money" => trim($_GPC["end_money"]),
                                                "qrcode_num" => trim($_GPC["qrcode_num"]),
                                                "money_sum" => trim($_GPC["money_sum"]),
                                                "send_name" => trim($_GPC["send_name"]), 
                                                "wish" => trim($_GPC["wish"]),
                                                "red_name" => trim($_GPC["red_name"]),
                                                "pay_desc" => trim($_GPC["pay_desc"]),
                                                "audio_volume" => trim($_GPC["audio_volume"]),
                                                "per" => trim($_GPC["per"]),
                                                "entry_audio_text" => trim($_GPC["entry_audio_text"]),
                                                "music_entry" => trim($_GPC["music_entry"]),
                                                "red_audio_text" => trim($_GPC["red_audio_text"]),
                                                "music" => trim($_GPC["music"])
                                            );
                                            if(!empty($_GPC['game_times'])){
                                                foreach($_GPC['game_times'] as $key=>$row){
                                                    $buy_rules[$key]["game_times"]=$row;
                                                    $buy_rules[$key]["game_money"]=$_GPC["game_money"][$key];
                                                }
                                                $data['buy_rules']=json_encode($buy_rules);
                                                unset($key,$row); 
                                            }
                                            if ($data["sid"]) {
                                                $sum_money_all = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_FINANCE) . " WHERE shopid = :shopid AND type<2 AND status=1 AND uniacid = :uniacid", array(":uniacid" => $uniacid, ":shopid" => $data["sid"]));
                                                $sum_money = $sum_money_all["sum_money"];
                                                $sum_money_use = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_FINANCE) . " WHERE shopid = :shopid AND type>1 AND status=1 AND uniacid = :uniacid", array(":uniacid" => $uniacid, ":shopid" => $data["sid"]));
                                                $use_money = $sum_money_use["sum_money"];
                                            }
                                            if ($op == "add" && empty($set)) {
                                                if (round($data["start_money"] * $data["qrcode_num"] * 100) > round($data["money_sum"] * 100) || round($data["end_money"] * $data["qrcode_num"] * 100) < round($data["money_sum"] * 100)) {
                                                    message("红包金额不在正常范围内", '', "error");
                                                }
                                                $data["use_balance"] = $_GPC["use_balance"] && $data["sid"] ? 1 : 0;
                                                $data["coupon_open"] = $_GPC["coupon_open"] && $data["sid"] ? 1 : 0;
                                                if ($data["use_balance"] && $data["money_sum"] && $sum_money - $use_money - $data["money_sum"] < 0) {
                                                    message("商家余额不足！", '', "error");
                                                }
                                                pdo_insert(TABLE_ACTIVITY, $data);
                                                $insertid = pdo_insertid();
                                                if (!$insertid) {
                                                    message("数据添加失败！", '', "error");
                                                }
                                                if ($data["subscribe"] == 2 && $data["qrcode_one"] == 1) {
                                                    $res_get = $this->get_qrcode_url("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaared" . $insertid, $data["qrcode_type"]);
                                                    pdo_update(TABLE_ACTIVITY, array("qrcode_url" => $res_get["url"]), array("id" => $insertid));
                                                }
                                            }
                                            if ($op == "edit" && $set) {
                                                $count_qrcode = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " where uniacid = :uniacid AND aid = :id", array(":uniacid" => $uniacid, ":id" => $set["id"]));
                                                if ($count_qrcode > $data["qrcode_num"]) {
                                                    message("红包个数不能小于已生成二维码个数", '', "error");
                                                }
                                                if ($count_qrcode > 0) {
                                                    $data["subscribe"] = $set["subscribe"];
                                                    $data["qrcode_type"] = $set["qrcode_type"];
                                                }
                                                $sum_money_send = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_RED) . " WHERE aid='{$set["id"]}'");
                                                if ($sum_money_send["sum_money"] > 0) {
                                                    $data["sid"] = $set["sid"];
                                                    $data["use_balance"] = $set["use_balance"];
                                                    $qrcode_use_count = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_RED) . " where aid='{$set["id"]}'");
                                                    $surplus_red = $data["qrcode_num"] - $qrcode_use_count;
                                                    $surplus_money = $data["money_sum"] - $sum_money_send["sum_money"];
                                                    $start_all = $data["start_money"] * $surplus_red;
                                                    $end_all = $data["end_money"] * $surplus_red;
                                                    if ($surplus_red > 0 && (round($start_all * 100) > round($surplus_money * 100) || round($end_all * 100) < round($surplus_money * 100))) {
                                                        message("红包总金额错误", '', "error");
                                                    } else {
                                                        if ($surplus_red < 1 && round($sum_money_send["sum_money"] * 100) != round($data["money_sum"] * 100)) {
                                                            message("红包金额不在正常范围内", '', "error");
                                                        }
                                                    }
                                                } else {
                                                    if (round($data["start_money"] * $data["qrcode_num"] * 100) > round($data["money_sum"] * 100) || round($data["end_money"] * $data["qrcode_num"] * 100) < round($data["money_sum"] * 100)) {
                                                        message("红包金额不在正常范围内", '', "error");
                                                    }
                                                    $data["use_balance"] = $_GPC["use_balance"] && $data["sid"] ? 1 : 0;
                                                }
                                                $data["settlement_open"] = $_GPC["settlement_open"] && $data["use_balance"] ? 1 : 0;
                                                $data["coupon_open"] = $_GPC["coupon_open"] && $data["sid"] ? 1 : 0;
                                                if ($data["sid"] && $data["use_balance"]) {
                                                    $payment = pdo_fetch("SELECT * FROM " . tablename(TABLE_FINANCE) . " WHERE aid = :aid", array(":aid" => $set["id"]));
                                                    if ($payment["type"] == 3 && $payment["status"] == 1) {
                                                        message("活动已结算,无法编辑", '', "error");
                                                    }
                                                    $sum_money_all = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_FINANCE) . " WHERE shopid = :shopid AND type<2 AND status=1 AND uniacid = :uniacid", array(":uniacid" => $uniacid, ":shopid" => $data["sid"]));
                                                    $sum_money = $sum_money_all["sum_money"];
                                                    $sum_money_use = pdo_fetch("SELECT SUM(money) AS sum_money FROM " . tablename(TABLE_FINANCE) . " WHERE shopid = :shopid AND type>1 AND status=1 AND uniacid = :uniacid", array(":uniacid" => $uniacid, ":shopid" => $data["sid"]));
                                                    $use_money = $sum_money_use["sum_money"];
                                                    if ($payment["shopid"] == $data["sid"]) {
                                                        if ($data["money_sum"] && $sum_money - $use_money - $data["money_sum"] + $payment["money"] < 0) {
                                                            message("商家余额不足！", '', "error");
                                                        }
                                                    } else {
                                                        if ($data["money_sum"] && $sum_money - $use_money - $data["money_sum"] < 0) {
                                                            message("商家余额不足！", '', "error");
                                                        }
                                                    }
                                                }
                                                if ($data["subscribe"] == 2 && $data["qrcode_one"] == 1 && empty($set["qrcode_url"])) {
                                                    $res_get = $this->get_qrcode_url("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaared" . $set["id"], $data["qrcode_type"]);
                                                    $data["qrcode_url"] = $res_get["url"];
                                                }
                                                pdo_update(TABLE_ACTIVITY, $data, array("id" => $set["id"]));
                                                $insertid = $set["id"];
                                            }
                                            if ($data["use_balance"] && $data["sid"] && $insertid && $data["money_sum"]) {
                                                $data_pinance = array("uniacid" => $uniacid, "openid" => '', "shopid" => $data["sid"], "aid" => $insertid, "type" => 2, "status" => 1, "money" => $data["money_sum"], "order_no" => '', "createtime" => time());
                                                if (empty($payment)) {
                                                    pdo_insert(TABLE_FINANCE, $data_pinance);
                                                } else {
                                                    pdo_update(TABLE_FINANCE, $data_pinance, array("id" => $payment["id"]));
                                                }
                                            }
                                            if (empty($data["use_balance"]) && $insertid && $payment) {
                                                pdo_delete(TABLE_FINANCE, array("id" => $payment["id"]));
                                            }
                                            $excel = $_FILES["excel"];
                                            if (!($data["pattern"] == 4 && $excel["name"] && $excel["tmp_name"])) {
                                                if ($data["pattern"] == 4 && empty($excel["name"]) && empty($excel["tmp_name"]) && $_GPC["copy"] == 1) {
                                                    $import_users = pdo_fetchall("select * from " . tablename(TABLE_IMPORT_MODE) . " WHERE uniacid = :uniacid AND aid = :aid", array(":uniacid" => $uniacid, ":aid" => intval($_GPC["id"])));
                                                    if ($import_users) {
                                                        foreach ($import_users as $copy_import_user) {
                                                            $data_import_user = array("aid" => intval($insertid), "uniacid" => intval($uniacid), "name" => trim($copy_import_user["name"]), "phone" => trim($copy_import_user["phone"]), "comment" => trim($copy_import_user["comment"]));
                                                            $import_user = pdo_fetch("SELECT * FROM " . tablename(TABLE_IMPORT_MODE) . " WHERE uniacid = :uniacid AND aid = :aid AND name = :name AND phone=:phone", array(":uniacid" => $uniacid, ":aid" => $insertid, ":name" => $data_import_user["name"], ":phone" => $data_import_user["phone"]));
                                                            if (!$import_user) {
                                                                pdo_insert(TABLE_IMPORT_MODE, $data_import_user);
                                                            }
                                                        }
                                                    }
                                                }
                                                message("数据操作成功！", referer(), '');
                                            } else {
                                                $type = explode(".", $excel["name"]);
                                                $type = end($type);
                                                $inputFileType = '';
                                                if ($type == "xls") {
                                                    $inputFileType = "Excel5";
                                                } else {
                                                    if ($type == "xlsx") {
                                                        $inputFileType = "Excel2007";
                                                    }
                                                }
                                                if (!$inputFileType) {
                                                    message("上传数据不是excel文件！", '', "error");
                                                }
                                                set_time_limit(0);
                                                include_once IA_ROOT . "/framework/library/phpexcel/PHPExcel.php";
                                                include_once IA_ROOT . "/framework/library/phpexcel/PHPExcel/IOFactory.php";
                                                include_once IA_ROOT . "/framework/library/phpexcel/PHPExcel/Reader/Excel5.php";
                                                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                                                $objPHPExcel = $objReader->load($excel["tmp_name"]);
                                                $objWorksheet = $objPHPExcel->getActiveSheet();
                                                $highestRow = $objWorksheet->getHighestRow();
                                                $all_column = $objWorksheet->getHighestColumn();
                                                $wrong = 0;
                                                $row = 2;
                                            }
                                        }
                                    } else {
                                        $count_qrcode = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_QRCODE) . " where uniacid = :uniacid AND aid = :id AND status=0", array(":uniacid" => $uniacid, ":id" => $id));
                                        if (empty($set) || $count_qrcode < 1) {
                                            message("请先生成二维码！", '', "error");
                                        }
                                        ob_clean();
                                        header("Content-type:application/octet-stream");
                                        header("Accept-Ranges:bytes ");
                                        header("Content-Disposition:attachment;filename=二维码列表-" . $set["name"] . ".txt");
                                        header("Expires:0");
                                        header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
                                        header("Pragma:public");
                                        $list_excel = pdo_fetchall("SELECT id,uuid,bid,sbid,code,qrcode FROM " . tablename(TABLE_QRCODE) . " where uniacid = :uniacid AND aid = :id AND status=0", array(":uniacid" => $uniacid, ":id" => $id));
                                        echo "ID 编号 二维码参数\r\n";
                                        foreach ($list_excel as $key => $value) {
                                            $id_q = $value["id"];
                                            if ($value["code"]) {
                                                $code_q = ($value["sbid"] ? $value["sbid"] : $value["bid"]) . "_" . $value["code"];
                                            } else {
                                                $code_q = $value["id"];
                                            }
                                            if ($set["subscribe"] == 2) {
                                                $url_q = $value["qrcode"];
                                            } else {
                                                $url_q = $value["qrcode"] ? $value["qrcode"] : $this->domain_site() . "app/index.php?i=" . $uniacid . "&c=entry&m=crad_qrcode_red&do=index&aid=" . $id . "&uuid=" . $value["uuid"];
                                            }
                                            echo $id_q . " " . $code_q . " " . $url_q . "\r\n";
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
