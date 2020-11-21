<?php
defined("IN_IA") or exit("Access Denied");
global $_W, $_GPC;
checklogin();
load()->func("tpl");
$operation = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
$uniacid = $_W["uniacid"];
if ($operation == "del") {
    $id = intval($_GPC["id"]);
    $item = pdo_fetch("SELECT * FROM " . tablename(TABLE_CIRCLE) . " WHERE id = '{$id}'");
    if (empty($item)) {
        message("抱歉，数据不存在或是已经删除！", referer(), "error");
    }
    if ($item["uniacid"] != $uniacid) {
        message("您没有权限删除");
    }
    if (pdo_delete(TABLE_CIRCLE, array("id" => $id)) === false) {
        pdo_update(TABLE_SHOP, array("circleid" => 0), array("circleid" => $id));
        message("删除失败！", referer(), "error");
    } else {
        message("删除成功！", referer());
    }
} else {
    if ($operation == "post") {
        $id = intval($_GPC["id"]);
        if ($id) {
            $item = pdo_fetch("SELECT * FROM " . tablename(TABLE_CIRCLE) . " WHERE id = {$id} and uniacid = {$uniacid}");
            if (!$item) {
                message("联盟信息不存在");
            }
        }
        if (checksubmit("submit")) {
            if (empty($_GPC["name"])) {
                message("请输入联盟名称");
            }
            $data["longitude"] = trim($_GPC["map"]["lng"]);
            $data["latitude"] = trim($_GPC["map"]["lat"]);
            $data["name"] = addslashes($_GPC["name"]);
            $data["address"] = addslashes($_GPC["address"]);
            $data["description"] = addslashes($_GPC["description"]);
            $data["status"] = 1;
            $data["createtime"] = time();
            $data["uniacid"] = $uniacid;
            if (!empty($id)) {
                pdo_update(TABLE_CIRCLE, $data, array("id" => $id));
            } else {
                pdo_insert(TABLE_CIRCLE, $data);
            }
            message("数据操作成功！", referer(), '');
        }
    } else {
        if ($operation == "display") {
            $pindex = max(1, intval($_GPC["page"]));
            $psize = 15;
            $keyword = trim($_GPC["keyword"]);
            $condition = " WHERE uniacid = {$uniacid} ";
            $params = array();
            if (!empty($keyword)) {
                $condition .= " AND name LIKE :keyword";
                $params[":keyword"] = "%{$keyword}%";
            }
            $order_condition = " ORDER BY id DESC ";
            $sql = "SELECT * FROM " . tablename(TABLE_CIRCLE) . $condition . $order_condition . " LIMIT " . ($pindex - 1) * $psize . "," . $psize;
            $list = pdo_fetchall($sql, $params);
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename(TABLE_CIRCLE) . $condition, $params);
            $xx = $this->createWebUrl("circle", array("op" => "display"));
            $url = str_replace("./index.php?", '', $xx) . "&page=*&keyword={$keyword}";
            $pager = pagination($total, $pindex, $psize, $url);
        }
    }
}
include $this->template("circle");