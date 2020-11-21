<?php
defined("IN_IA") or exit("Access Denied");
global $_GPC, $_W;
checklogin();
$uniacid = $_W["uniacid"];
$op = $_GPC["op"];
$id = intval($_GPC["id"]);
$aid = intval($_GPC["aid"]);
$sid = intval($_GPC["sid"]);
if ($op == "del") {
    $item = pdo_fetch("SELECT * FROM " . tablename(TABLE_USER) . " WHERE id = :id", array(":id" => $id));
    if (empty($item)) {
        message("抱歉，数据不存在或是已经删除！", referer(), "error");
    }
    if ($item["uniacid"] != $uniacid) {
        message("您没有权限操作");
    }
    if (pdo_delete(TABLE_USER, array("id" => $id)) === false) {
        message("删除失败！", referer(), "error");
    } else {
        message("删除成功！", referer());
    }
}
if ($op == "deleteids") {
    $rowcount = 0;
    $notrowcount = 0;
    foreach ($_GPC["ids"] as $k => $id) {
        $id = intval($id);
        if (!empty($id)) {
            $item_task = pdo_fetch("SELECT * FROM " . tablename(TABLE_USER) . " WHERE id = :id AND uniacid=:uniacid", array(":id" => $id, ":uniacid" => $uniacid));
            if (!empty($item_task)) {
                pdo_delete(TABLE_USER, array("id" => $id, "uniacid" => $uniacid));
                $rowcount++;
            } else {
                $notrowcount++;
            }
        }
    }
}
if ($op == "white") {
    if ($aid) {
        $where = "id ='{$id}' AND aid='{$aid}'";
    } else {
        if ($sid) {
            $where = "id ='{$id}' AND sid='{$sid}'";
        }
    }
    $item = pdo_fetch("SELECT * FROM " . tablename(TABLE_USER) . " WHERE {$where}");
    if (empty($item)) {
        message("抱歉，数据不存在或是已经删除！", referer(), "error");
    }
    if ($item["uniacid"] != $uniacid) {
        message("您没有权限操作");
    }
    $update = array("is_white" => intval($_GPC["is_white"]));
    if (pdo_update(TABLE_USER, $update, array("uniacid" => $uniacid, "id" => $id)) === false) {
        message("操作失败！", referer(), "error");
    } else {
        $cfg = $this->module["config"]["api"];
        if ($_GPC["is_white"] && $cfg["mid"]) {
            $url = $_W["siteroot"] . "app/" . substr($this->createMobileUrl("index", array("aid" => $item["aid"], "op" => "register"), true), 2);
            $template = array("touser" => $item["openid"], "template_id" => $cfg["mid"], "url" => $url, "topcolor" => "#743a3a", "data" => array("first" => array("value" => urlencode("恭喜您的用户信息审核通过"), "color" => "#2F1B58"), "keyword1" => array("value" => urlencode($item["realname"]), "color" => "#2F1B58"), "keyword2" => array("value" => urlencode($item["tel"]), "color" => "#2F1B58"), "keyword3" => array("value" => urlencode(date("Y-m-d", time())), "color" => "#2F1B58"), "remark" => array("value" => urlencode("点击查看用户信息详情"), "color" => "#2F1B58")));
            $this->send_temp_ms(urldecode(json_encode($template)));
        }
        message("操作成功！", referer());
    }
} else {
    if ($op == "btnwhiteall") {
        if ($aid) {
            $where = "AND aid='{$aid}'";
        } else {
            if ($sid) {
                $where = "AND sid='{$sid}'";
            }
        }
        foreach ($_GPC["ids"] as $k => $id) {
            $id = intval($id);
            if (!empty($id)) {
                $item_task = pdo_fetch("SELECT * FROM " . tablename(TABLE_USER) . " WHERE id = :id AND uniacid=:uniacid {$where}", array(":id" => $id, ":uniacid" => $uniacid));
                if (!empty($item_task)) {
                    $update = array("is_white" => 1);
                    pdo_update(TABLE_USER, $update, array("uniacid" => $uniacid, "id" => $id));
                }
            }
        }
    } else {
        if ($op == "btnnowhiteall") {
            if ($aid) {
                $where = " AND aid='{$aid}'";
            } else {
                if ($sid) {
                    $where = " AND sid='{$sid}'";
                }
            }
            foreach ($_GPC["ids"] as $k => $id) {
                $id = intval($id);
                if (!empty($id)) {
                    $item_task = pdo_fetch("SELECT * FROM " . tablename(TABLE_USER) . " WHERE id = :id AND uniacid=:uniacid {$where}", array(":id" => $id, ":uniacid" => $uniacid));
                    if (!empty($item_task)) {
                        $update = array("is_white" => 0);
                        pdo_update(TABLE_USER, $update, array("uniacid" => $uniacid, "id" => $id));
                    }
                }
            }
        } else {
            if ($op == "excel") {
                $where = " WHERE uniacid = '{$uniacid}'";
                if ($aid) {
                    $where .= " AND aid='{$aid}'";
                    $activity = pdo_fetch("SELECT name,pattern,other_field FROM " . tablename(TABLE_ACTIVITY) . " WHERE id = :id", array(":id" => $aid));
                }
                $list_excel = pdo_fetchall("SELECT * FROM " . tablename(TABLE_USER) . " {$where} ORDER BY id DESC");
                foreach ($list_excel as $key => $value) {
                    $arr[$i]["openid"] = $value["openid"];
                    $arr[$i]["nickname"] = iconv("UTF-8", "GB2312", $value["nickname"]);
                    $arr[$i]["realname"] = iconv("UTF-8", "GB2312", $value["realname"]);
                    $arr[$i]["tel"] = iconv("UTF-8", "GB2312", $value["tel"]);
                    if ($value["is_check"] == 1) {
                        $arr[$i]["is_check"] = iconv("UTF-8", "GB2312", "是");
                    } else {
                        $arr[$i]["is_check"] = iconv("UTF-8", "GB2312", "否");
                    }
                    if ($value["subscribe"] == 1) {
                        $arr[$i]["subscribe"] = iconv("UTF-8", "GB2312", "是");
                    } else {
                        $arr[$i]["subscribe"] = iconv("UTF-8", "GB2312", "否");
                    }
                    if ($activity["pattern"] == 3 && $activity["other_field"]) {
                        $arr[$i]["other_info"] = iconv("UTF-8", "GB2312", $value["other_info"]);
                    }
                    $i++;
                }
            }
        }
    }
}
if (!($op == "delete_user")) {
    if ($aid) {
        $activity = pdo_fetch("SELECT * FROM " . tablename(TABLE_ACTIVITY) . " WHERE uniacid = :uniacid AND id = :id", array(":uniacid" => $uniacid, ":id" => $aid));
    }
    if (empty($sid)) {
        $activity_info = pdo_fetchall("select id,name from " . tablename(TABLE_ACTIVITY) . " where uniacid='{$uniacid}'");
    }
    if (empty($aid) && pdo_tableexists(tablename("crad_qrcode_red_superqrcode"))) {
        $superqrcode_info = pdo_fetchall("select id,name from " . tablename("crad_qrcode_red_superqrcode") . " where uniacid='{$uniacid}'");
    }
    $pindex = max(1, intval($_GPC["page"]));
    $psize = 10;
    $condition = "uniacid='{$_W["uniacid"]}' ";
    if ($aid) {
        $condition .= " AND aid='{$aid}' ";
    }
    if ($sid) {
        $condition .= " AND sid='{$sid}' ";
    }
    if ($activity["pattern"] == 3) {
        $condition .= " AND realname!='' ";
    }
    if (!empty($_GPC["keyword"])) {
        $condition .= " AND CONCAT(realname,nickname,tel,openid) LIKE '%{$_GPC["keyword"]}%'";
    }
    if ($op == "get_users") {
        $list_users = pdo_fetchall("SELECT * FROM " . tablename(TABLE_USER) . " WHERE {$condition} ORDER BY id DESC");
        exit(json_encode($list_users));
    }
    $list = pdo_fetchall("SELECT * FROM " . tablename(TABLE_USER) . " WHERE {$condition} ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . "," . $psize);
    $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename(TABLE_USER) . " WHERE {$condition} ");
    $pager = pagination($total, $pindex, $psize);
    include $this->template("user");
} else {
    $user_id = intval($_GPC["user_id"]);
    $ids1 = $_GPC["ids1"];
    $key = trim($_GPC["key"]);
    if ($ids1) {
        $n = 0;
        foreach ($ids1 as $v) {
            $r = pdo_delete(TABLE_IMPORT_MODE, array("id" => $v, "uniacid" => $uniacid, "aid" => $aid));
            if ($r) {
                $n++;
            }
        }
    }
    if ($user_id) {
        $result = pdo_delete(TABLE_IMPORT_MODE, array("id" => $user_id, "uniacid" => $uniacid, "aid" => $aid));
        if (!empty($result)) {
            message("删除成功", referer(), "success");
        }
    }
    $condition = "uniacid='{$_W["uniacid"]}' AND aid='{$aid}'";
    if ($key) {
        $condition .= " AND CONCAT(name,phone) LIKE '%{$key}%'";
    }
    $pindex1 = max(1, intval($_GPC["page"]));
    $psize1 = 10;
    $list = pdo_fetchall("SELECT * FROM " . tablename(TABLE_IMPORT_MODE) . " WHERE {$condition} limit " . ($pindex1 - 1) * $psize1 . "," . $psize1);
    $total1 = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename(TABLE_IMPORT_MODE) . " WHERE {$condition}");
    $pager1 = pagination($total1, $pindex1, $psize1);
    include $this->template("user");
    exit;
}