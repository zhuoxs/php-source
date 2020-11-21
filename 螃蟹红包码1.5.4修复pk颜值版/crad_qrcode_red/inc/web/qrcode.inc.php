<?php

defined("IN_IA") or exit("Access Denied");
global $_GPC, $_W;
checklogin();
$uniacid = $_W["uniacid"];
$op = $_GPC["op"];
$id = intval($_GPC["id"]);
$aid = intval($_GPC["aid"]);
$bid = intval($_GPC["bid"]);
$sid = intval($_GPC["sid"]);
$cfg = $this->module["config"]["api"];
$url = $this->auth_url . "/index/red/checkauth";
$post_data = array("time" => time(), "ticket" => $cfg["ticket"], "module_id" => 4);
ksort($post_data);
$post_data["token"] = md5(sha1(implode('', $post_data)));
load()->func("communication");
if ($aid) {
    $activity_name = pdo_fetch("SELECT name FROM " . tablename(TABLE_ACTIVITY) . " WHERE uniacid = :uniacid AND id = :id", array(":uniacid" => $uniacid, ":id" => $aid));
    if (empty($activity_name)) {
        message("参数错误", referer(), "error");
    }
    $activity_name = $activity_name["name"];
}
load()->func("file");
if ($op == "del") {
    $item = pdo_fetch("SELECT * FROM " . tablename(TABLE_QRCODE) . " WHERE id = :id", array(":id" => $id));
    if (empty($item)) {
        message("抱歉，数据不存在或是已经删除！", referer(), "error");
    }
    if ($item["uniacid"] != $uniacid) {
        message("您没有权限操作");
    }
    if (pdo_delete(TABLE_QRCODE, array("id" => $id)) === false) {
        message("删除失败！", referer(), "error");
    } else {
        message("删除成功！", referer());
    }
}
if ($op == "reset") {
    $item = pdo_fetch("SELECT * FROM " . tablename(TABLE_QRCODE) . " WHERE id = :id", array(":id" => $id));
    if (empty($item)) {
        message("抱歉，数据不存在或是已经删除！", referer(), "error");
    }
    if ($item["uniacid"] != $uniacid) {
        message("您没有权限操作");
    }
    if ($item["status"] != 1) {
        message("状态错误");
    }
    $red_record = pdo_get(TABLE_RED, array("tid" => $item["id"]));
    if ($red_record) {
        message("红包数据存在，不能重置");
    }
    if (pdo_update(TABLE_QRCODE, array("status" => 0, "openid" => '', "usetime" => 0, "times" => 0, "times_day" => 0, "last_time" => 0), array("id" => $id)) === false) {
        message("重置失败！", referer(), "error");
    } else {
        $activity = pdo_fetch("SELECT pattern FROM " . tablename(TABLE_ACTIVITY) . " WHERE id = :id", array(":id" => $item["aid"]));
        if ($activity["pattern"] == 1) {
            pdo_delete(TABLE_SHOP_TASK, array("aid" => $item["aid"], "tid" => $item["id"]));
        } else {
            if ($activity["pattern"] == 5) {
                pdo_delete(TABLE_INVITATION_USER, array("aid" => $item["aid"], "tid" => $item["id"]));
            } else {
                if ($activity["pattern"] == 6) {
                    pdo_delete(TABLE_CUTEFACE, array("aid" => $item["aid"], "tid" => $item["id"]));
                } else {
                    if ($activity["pattern"] == 4) {
                        pdo_update(TABLE_IMPORT_MODE, array("tid" => 0), array("aid" => $item["aid"], "tid" => $item["id"]));
                    }
                }
            }
        }
        message("重置成功！", referer());
    }
} else {
    if ($op == "deleteids") {
        $rowcount = 0;
        $notrowcount = 0;
        foreach ($_GPC["ids"] as $k => $id) {
            $id = intval($id);
            if (!empty($id)) {
                $item_task = pdo_fetch("SELECT * FROM " . tablename(TABLE_QRCODE) . " WHERE id = :id AND uniacid=:uniacid", array(":id" => $id, ":uniacid" => $uniacid));
                if (!empty($item_task)) {
                    pdo_delete(TABLE_QRCODE, array("id" => $id));
                    $rowcount++;
                } else {
                    $notrowcount++;
                }
            }
        }
        message("操作成功！共删除{$rowcount}条数据,{$notrowcount}条数据不能删除!", referer(), "success");
    } else {
        if ($op == "deleteall") {
            $search = "uniacid='{$uniacid}'";
            if ($aid) {
                $search .= " AND aid='{$aid}'";
            }
            if ($bid) {
                $search .= " AND bid='{$bid}'";
            }
            if ($sid) {
                $search .= " AND sid='{$sid}'";
            }
            $status = intval($_GPC["status"]);
            if ($status) {
                $search .= " AND status='" . ($status == 4 ? 0 : $status) . "'";
            }
            if (pdo_delete(TABLE_QRCODE, $search) === false) {
                message("删除失败！", referer(), "error");
            } else {
                message("删除成功！", referer());
            }
        }
    }
}
$activity_info = pdo_fetchall("select id,name from " . tablename(TABLE_ACTIVITY) . " where uniacid='{$uniacid}'");
$beforehand_list = pdo_fetchall("select id,name from " . tablename(TABLE_BEFOREHAND) . " where uniacid='{$uniacid}'");
$pindex = max(1, intval($_GPC["page"]));
$psize = 10;
$condition = "WHERE uniacid='{$uniacid}'";
if ($aid) {
    $condition .= " AND aid = '{$aid}'";
}
if ($bid) {
    $condition .= " AND bid = '{$bid}'";
}
if ($sid) {
    $condition .= " AND sid = '{$sid}'";
}
$status = intval($_GPC["status"]);
if ($status) {
    $condition .= " AND status = :status";
    $params[":status"] = $status == 4 ? 0 : $status;
}
if (!empty($_GPC["keyword"])) {
    $condition .= " AND CONCAT(openid) LIKE '%{$_GPC["keyword"]}%'";
}
$list = pdo_fetchall("SELECT * FROM " . tablename(TABLE_QRCODE) . " {$condition} ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . "," . $psize, $params);
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename(TABLE_QRCODE) . $condition, $params);
foreach ($list as &$value) {
    $value["qrcode_url"] = $value["qrcode"] ? $value["qrcode"] : $_W["siteroot"] . "app/index.php?i=" . $uniacid . "&c=entry&m=crad_qrcode_red&do=index&aid=" . $value["aid"] . "&uuid=" . $value["uuid"];
    if ($value["aid"]) {
        $activity_name = pdo_fetch("SELECT name,subscribe,qrcode_type FROM " . tablename(TABLE_ACTIVITY) . " WHERE id = :id", array(":id" => $value["aid"]));
        $value["activity_name"] = $activity_name["name"];
    }
    if ($value["code"]) {
        $value["qrcode_url"] = $value["qrcode"] ? $value["qrcode"] : $_W["siteroot"] . "app/index.php?i=" . $uniacid . "&c=entry&m=crad_qrcode_red&do=index&uuid=" . $value["uuid"] . "&code=" . $value["code"];
    } else {
        if ($value["aid"]) {
            if ($activity_name["subscribe"] == 2) {
                if (empty($value["qrcode"])) {
                    $res_get = $this->get_qrcode_url($value["uuid"] . "red" . $value["aid"], $activity_name["qrcode_type"]);
                    $value["qrcode_url"] = $res_get["url"];
                    pdo_update(TABLE_QRCODE, array("qrcode" => $res_get["url"]), array("id" => $value["id"]));
                }
            }
        }
    }
    if ($value["openid"]) {
        $user_name = pdo_fetch("SELECT nickname FROM " . tablename(TABLE_USER) . " WHERE uniacid = :uniacid AND openid = :openid", array(":uniacid" => $uniacid, ":openid" => $value["openid"]));
        $value["nickname"] = $user_name["nickname"];
    }
}
$pager = pagination($total, $pindex, $psize);
include $this->template("qrcode");