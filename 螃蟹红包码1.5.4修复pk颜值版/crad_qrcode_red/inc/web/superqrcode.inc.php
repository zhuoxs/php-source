<?php
defined("IN_IA") or exit("Access Denied");
global $_GPC, $_W;
checklogin();
$uniacid = intval($_W["uniacid"]);
load()->func("tpl");
$op = $_GPC["op"] ? $_GPC["op"] : "display";
if ($op == "del") {
    $id = intval($_GPC["id"]);
    $item = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_superqrcode") . " WHERE id = :id", array(":id" => $id));
    if (empty($item)) {
        message("抱歉，数据不存在或是已经删除！", referer(), "error");
    }
    if ($item["uniacid"] != $uniacid) {
        message("您没有权限操作");
    }
    if (pdo_delete("crad_qrcode_red_superqrcode", array("id" => $id)) === false) {
        message("删除失败！", referer(), "error");
    } else {
        message("删除成功！", referer());
    }
}
if ($op == "rules_del") {
    $id = intval($_GPC["id"]);
    $item = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_superqrcode_rules") . " WHERE id = :id", array(":id" => $id));
    if (empty($item)) {
        message("抱歉，数据不存在或是已经删除！", referer(), "error");
    }
    if ($item["uniacid"] != $uniacid) {
        message("您没有权限操作");
    }
    if (pdo_delete("crad_qrcode_red_superqrcode_rules", array("id" => $id)) === false) {
        message("删除失败！", referer(), "error");
    } else {
        message("删除成功！", referer());
    }
} else {
    if ($op == "get_activitys") {
        $condition = '';
        if (!empty($_GPC["keyword"])) {
            $condition .= " AND CONCAT(name) LIKE '%{$_GPC["keyword"]}%'";
        }
        $list_activitys = pdo_fetchall("SELECT id,name FROM " . tablename(TABLE_ACTIVITY) . " WHERE uniacid='{$uniacid}' {$condition} ORDER BY id DESC");
        exit(json_encode($list_activitys));
    } else {
        if ($op == "deleteids") {
            $rowcount = 0;
            $notrowcount = 0;
            foreach ($_GPC["ids"] as $k => $id) {
                $id = intval($id);
                if (!empty($id)) {
                    $item_task = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_superqrcode") . " WHERE id = :id AND uniacid=:uniacid", array(":id" => $id, ":uniacid" => $uniacid));
                    if (!empty($item_task)) {
                        pdo_delete("crad_qrcode_red_superqrcode", array("id" => $id, "uniacid" => $uniacid));
                        $rowcount++;
                    } else {
                        $notrowcount++;
                    }
                }
            }
        } else {
            if ($op == "deleteall") {
                $search = "uniacid='{$uniacid}'";
                pdo_delete("crad_qrcode_red_superqrcode", $search);
                message("删除成功", referer(), "success");
            } else {
                if ($op == "rules_deleteids") {
                    $rowcount = 0;
                    $notrowcount = 0;
                    foreach ($_GPC["ids"] as $k => $id) {
                        $id = intval($id);
                        if (!empty($id)) {
                            $item_task = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_superqrcode_rules") . " WHERE id = :id AND uniacid=:uniacid", array(":id" => $id, ":uniacid" => $uniacid));
                            if (!empty($item_task)) {
                                pdo_delete("crad_qrcode_red_superqrcode_rules", array("id" => $id, "uniacid" => $uniacid));
                                $rowcount++;
                            } else {
                                $notrowcount++;
                            }
                        }
                    }
                } else {
                    if ($op == "rules_deleteall") {
                        $sid = intval($_GPC["sid"]);
                        $search = "uniacid='{$uniacid}' AND sid='{$sid}'";
                        pdo_delete("crad_qrcode_red_superqrcode_rules", $search);
                        message("删除成功", referer(), "success");
                    } else {
                        if ($op == "post") {
                            $id = intval($_GPC["id"]);
                            if ($id) {
                                $set = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_superqrcode") . " WHERE uniacid = :uniacid AND id = :id", array(":uniacid" => $uniacid, ":id" => $id));
                                if (empty($set)) {
                                    message("数据错误！", '', "error");
                                }
                            }
                            if (checksubmit("submit")) {
                                if (empty($_GPC["name"])) {
                                    message("请输入名称！", '', "error");
                                }
                                if (!empty($set)) {
                                    $has_name = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_superqrcode") . " WHERE uniacid = :uniacid AND name = :name  AND id != :id", array(":uniacid" => $uniacid, ":name" => trim($_GPC["name"]), ":id" => $id));
                                } else {
                                    $has_name = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_superqrcode") . " WHERE uniacid = :uniacid AND name = :name", array(":uniacid" => $uniacid, ":name" => trim($_GPC["name"])));
                                }
                                if ($has_name) {
                                    message("名称已经存在！", '', "error");
                                }
                                $data = array("uniacid" => $uniacid,
                                    "createtime" => time(),
                                    "name" =>trim($_GPC["name"]),
                                    "status" =>trim($_GPC["status"]),
                                    "num_day" =>trim($_GPC["num_day"]),
                                    "num" =>trim($_GPC["num"]),
                                    "num_day_user" =>trim($_GPC["num_day_user"]),
                                    "num_user" =>trim($_GPC["num_user"]),
                                    "subscribe" =>trim($_GPC["subscribe"]),
                                    "scan_title" =>trim($_GPC["scan_title"]),
                                    "scan_descriotion" =>trim($_GPC["scan_descriotion"]),
                                    "scan_image" =>trim($_GPC["scan_image"]),
                                    "jump_type" =>trim($_GPC["jump_type"])
                                );
                                if ($set) {
                                    if ($data["subscribe"] == 1 && empty($set["url"])) {
                                        $res_get = $this->get_qrcode_url("bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbred" . $set["id"], 0);
                                        $data["url"] = $res_get["url"];
                                    }
                                    unset($data['uniacid'],$data['createtime']);
                                    pdo_update("crad_qrcode_red_superqrcode", $data, array("id" => $set["id"]));
                                    $insertid = $set["id"];
                                } else {
                                    pdo_insert("crad_qrcode_red_superqrcode", $data);
                                    $insertid = pdo_insertid();
                                    if (!$insertid) {
                                        message("数据添加失败！", '', "error");
                                    }
                                    if ($data["subscribe"] == 1) {
                                        $res_get = $this->get_qrcode_url("bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbred" . $insertid, 0);
                                        pdo_update("crad_qrcode_red_superqrcode", array("url" => $res_get["url"]), array("id" => $insertid));
                                    }
                                }
                                message("数据操作成功！", referer(), '');
                            }
                            include $this->template("superqrcode");
                        } else {
                            if ($op == "rules_post") {
                                $id = intval($_GPC["id"]);
                                $sid = intval($_GPC["sid"]);
                                if ($id) {
                                    $set = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_superqrcode_rules") . " WHERE uniacid = :uniacid AND id = :id", array(":uniacid" => $uniacid, ":id" => $id));
                                    if (empty($set)) {
                                        message("数据错误！", '', "error");
                                    }
                                }
                                if (checksubmit("submit")) {
                                    if (empty($_GPC["name"])) {
                                        message("请输入规则名称！", '', "error");
                                    }
                                    if (!empty($set)) {
                                        $has_name = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_superqrcode_rules") . " WHERE uniacid = :uniacid AND name = :name  AND id != :id", array(":uniacid" => $uniacid, ":name" => trim($_GPC["name"]), ":id" => $id));
                                    } else {
                                        $has_name = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_superqrcode_rules") . " WHERE uniacid = :uniacid AND name = :name", array(":uniacid" => $uniacid, ":name" => trim($_GPC["name"])));
                                    }
                                    if ($has_name) {
                                        message("名称已经存在！", '', "error");
                                    }
                                    $data = array(
                                        "uniacid" => $uniacid,
                                        "createtime" => time(),
                                        'name' => trim($_GPC['name']),
                                        'scan_title' => trim($_GPC['scan_title']),
                                        'scan_image' => trim($_GPC['scan_image']),
                                        'last_time' => strtotime($_GPC['last_time']),
                                        'last_rid' => intval($_GPC['last_rid']),
                                        'jump_type' => intval($_GPC['jump_type']),
                                        'url' => trim($_GPC['url']),
                                        'num_day' => intval($_GPC['num_day']),
                                        'num_user' => intval($_GPC['num_user']),
                                        'num' => intval($_GPC['num']),
                                        'num_day_user' => intval($_GPC['num_day_user']),
                                        'status' => intval($_GPC['status']),
                                    );
                                    if ($set) {
                                        unset($data['uniacid'], $data['createtime']);
                                        pdo_update("crad_qrcode_red_superqrcode_rules", $data, array("id" => $set["id"]));
                                        $insertid = $set["id"];
                                    } else {
                                        $data["sid"] = $sid;
                                        if (empty($sid)) {
                                            message("参数错误！", '', "error");
                                        }
                                        pdo_insert("crad_qrcode_red_superqrcode_rules", $data);
                                        $insertid = pdo_insertid();
                                        if (!$insertid) {
                                            message("数据添加失败！", '', "error");
                                        }
                                    }
                                    message("数据操作成功！", referer(), '');
                                }
                                $activity_list = pdo_fetchall("SELECT id,name FROM " . tablename(TABLE_ACTIVITY) . " WHERE uniacid='{$uniacid}' AND qrcode_one=1 ORDER BY id DESC");
                                include $this->template("jumprules");
                            } else {
                                if ($op == "rules") {
                                    $pindex = max(1, intval($_GPC["page"]));
                                    $psize = 10;
                                    $sid = intval($_GPC["sid"]);
                                    $condition = "uniacid='{$uniacid}' AND sid='{$sid}'";
                                    if (!empty($_GPC["keyword"])) {
                                        $condition .= " AND CONCAT(name) LIKE '%{$_GPC["keyword"]}%'";
                                    }
                                    $superqrcode_info = pdo_fetchall("select id,name from " . tablename("crad_qrcode_red_superqrcode") . " WHERE uniacid='{$uniacid}'");
                                    $list = pdo_fetchall("select * from " . tablename("crad_qrcode_red_superqrcode_rules") . " WHERE {$condition}  LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
                                    $total = pdo_fetchcolumn("select COUNT(*) from " . tablename("crad_qrcode_red_superqrcode_rules") . " WHERE {$condition}");
                                    $pager = pagination($total, $pindex, $psize);
                                    include $this->template("jumprules");
                                } else {
                                    $pindex = max(1, intval($_GPC["page"]));
                                    $psize = 10;
                                    $condition = "uniacid='{$uniacid}'";
                                    if (!empty($_GPC["keyword"])) {
                                        $condition .= " AND CONCAT(name) LIKE '%{$_GPC["keyword"]}%'";
                                    }
                                    $list = pdo_fetchall("select * from " . tablename("crad_qrcode_red_superqrcode") . " WHERE {$condition}  ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
                                    if (!empty($list)) {
                                        foreach ($list as &$s_row) {
                                            if ($s_row["subscribe"] == 1) {
                                                if ($s_row["url"]) {
                                                    $s_row["a_url"] = $s_row["url"];
                                                } else {
                                                    $res_get = $this->get_qrcode_url("bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbred" . $s_row["id"], 0);
                                                    $s_row["a_url"] = $res_get["url"];
                                                }
                                            } else {
                                                $s_row["a_url"] = $this->domain_site() . "app/index.php?i=" . $uniacid . "&c=entry&m=crad_qrcode_red&do=q&u=" . $s_row["uuid"];
                                            }
                                        }
                                    }
                                    $total = pdo_fetchcolumn("select COUNT(*) from " . tablename("crad_qrcode_red_superqrcode") . " WHERE {$condition}");
                                    $pager = pagination($total, $pindex, $psize);
                                    include $this->template("superqrcode");
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
