<?php
defined("IN_IA") or exit("Access Denied");
global $_GPC, $_W;
checklogin();
$uniacid = $_W["uniacid"];
load()->func("tpl");
$op = $_GPC["op"] ? $_GPC["op"] : "display";
$id = intval($_GPC["id"]);
$aid = intval($_GPC["aid"]);
$cfg = $this->module["config"]["api"];
if ($aid) {
    $activity_name = pdo_fetch("SELECT name,pattern FROM " . tablename(TABLE_ACTIVITY) . " WHERE uniacid = :uniacid AND id = :id", array(":uniacid" => $uniacid, ":id" => $aid));
    if (empty($activity_name) || $activity_name["pattern"] != 6 && $activity_name["pattern"] != 12) {
        message("参数错误", referer(), "error");
    }
    $activity_name = $activity_name["name"];
}
$pattern = $activity_name["pattern"] ? $activity_name["pattern"] : 6;
if ($op == "del") {
    $item = pdo_fetch("SELECT * FROM " . tablename(TABLE_CUTEFACE) . " WHERE id = :id ", array(":id" => $id));
    if (empty($item)) {
        message("抱歉，数据不存在或是已经删除！", referer(), "error");
    }
    if ($item["aid"] != $aid || $item["uniacid"] != $uniacid) {
        message("您没有权限操作");
    }
    if (pdo_delete(TABLE_CUTEFACE, array("id" => $id)) === false) {
        message("删除失败！", referer(), "error");
    } else {
        if ($item["image_thumb_url"]) {
            if (!empty($cfg["isremote"])) {
                $this->file_picremote_delete($cfg, $item["image_thumb_url"]);
            } else {
                if (!empty($_W["setting"]["remote"]["type"])) {
                    file_remote_delete($item["image_thumb_url"]);
                } else {
                    file_delete(ATTACHMENT_ROOT . $item["image_thumb_url"]);
                }
            }
        }
        if ($item["image_head_url"]) {
            if (!empty($cfg["isremote"])) {
                $this->file_picremote_delete($cfg, $item["image_head_url"]);
            } else {
                if (!empty($_W["setting"]["remote"]["type"])) {
                    file_remote_delete($item["image_head_url"]);
                } else {
                    file_delete(ATTACHMENT_ROOT . $item["image_head_url"]);
                }
            }
        }
        message("删除成功！", referer());
    }
} else {
    if ($op == "deleteids") {
        $rowcount = 0;
        $notrowcount = 0;
        load()->func("file");
        foreach ($_GPC["ids"] as $k => $id) {
            $id = intval($id);
            if (!empty($id)) {
                $item_cuteface = pdo_fetch("SELECT id,image_thumb_url,image_head_url FROM " . tablename(TABLE_CUTEFACE) . " WHERE id = :id AND uniacid=:uniacid AND aid>0", array(":id" => $id, ":uniacid" => $uniacid));
                if (!empty($item_cuteface)) {
                    pdo_delete(TABLE_CUTEFACE, array("id" => $id, "uniacid" => $uniacid));
                    if ($item_cuteface["image_thumb_url"]) {
                        if (!empty($cfg["isremote"])) {
                            $this->file_picremote_delete($cfg, $item_cuteface["image_thumb_url"]);
                        } else {
                            if (!empty($_W["setting"]["remote"]["type"])) {
                                file_remote_delete($item_cuteface["image_thumb_url"]);
                            } else {
                                file_delete(ATTACHMENT_ROOT . $item_cuteface["image_thumb_url"]);
                            }
                        }
                    }
                    if ($item_cuteface["image_head_url"]) {
                        if (!empty($cfg["isremote"])) {
                            $this->file_picremote_delete($cfg, $item_cuteface["image_head_url"]);
                        } else {
                            if (!empty($_W["setting"]["remote"]["type"])) {
                                file_remote_delete($item_cuteface["image_head_url"]);
                            } else {
                                file_delete(ATTACHMENT_ROOT . $item_cuteface["image_head_url"]);
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
            if ($aid) {
                $search .= " AND aid='{$aid}'";
            }
            $cuteface_list = pdo_fetchall("select * from " . tablename(TABLE_CUTEFACE) . " where {$search}");
            if (pdo_delete(TABLE_CUTEFACE, $search) === false) {
                message("全清失败！", referer(), "error");
            } else {
                foreach ($cuteface_list as $val) {
                    if ($val["image_thumb_url"]) {
                        if (!empty($cfg["isremote"])) {
                            $this->file_picremote_delete($cfg, $val["image_thumb_url"]);
                        } else {
                            if (!empty($_W["setting"]["remote"]["type"])) {
                                file_remote_delete($val["image_thumb_url"]);
                            } else {
                                file_delete(ATTACHMENT_ROOT . $val["image_thumb_url"]);
                            }
                        }
                    }
                    if ($val["image_head_url"]) {
                        if (!empty($cfg["isremote"])) {
                            $this->file_picremote_delete($cfg, $val["image_head_url"]);
                        } else {
                            if (!empty($_W["setting"]["remote"]["type"])) {
                                file_remote_delete($val["image_head_url"]);
                            } else {
                                file_delete(ATTACHMENT_ROOT . $val["image_head_url"]);
                            }
                        }
                    }
                }
            }
            message("删除成功", referer(), "success");
        }
    }
}
$activity_info = pdo_fetchall("select * from " . tablename(TABLE_ACTIVITY) . " where uniacid='{$uniacid}' AND pattern='{$pattern}'");
$pindex = max(1, intval($_GPC["page"]));
$psize = 10;
$condition = "c.uniacid='{$uniacid}'";
if (!empty($_GPC["keyword"])) {
    $condition .= " AND CONCAT(u.nickname,u.tel,c.openid) LIKE '%{$_GPC["keyword"]}%'";
}
if ($aid) {
    $condition .= " AND c.aid='{$aid}'";
}
$list = pdo_fetchall("select c.*,u.nickname,u.tel from " . tablename(TABLE_CUTEFACE) . " c left join " . tablename(TABLE_USER) . " u on c.openid=u.openid  AND c.uniacid = u.uniacid AND c.aid = u.aid where {$condition}  ORDER BY c.id DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
$total = pdo_fetchcolumn("select COUNT(*) from " . tablename(TABLE_CUTEFACE) . " c left join " . tablename(TABLE_USER) . " u on c.openid=u.openid AND c.uniacid = u.uniacid AND c.aid = u.aid where {$condition}");
$pager = pagination($total, $pindex, $psize);
include $this->template("cuteface");