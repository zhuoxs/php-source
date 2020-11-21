<?php
defined("IN_IA") or exit("Access Denied");
global $_GPC, $_W;
checklogin();
$uniacid = $_W["uniacid"];
load()->func("tpl");
$op = $_GPC["op"] ? $_GPC["op"] : "display";
$id = intval($_GPC["id"]);
if ($op == "del") {
    $item = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_adcenter") . " WHERE id = :id", array(":id" => $id));
    if (empty($item)) {
        message("抱歉，数据不存在或是已经删除！", referer(), "error");
    }
    if ($item["uniacid"] != $uniacid) {
        message("您没有权限操作");
    }
    if (pdo_delete("crad_qrcode_red_adcenter", array("id" => $id)) === false) {
        message("删除失败！", referer(), "error");
    } else {
        message("删除成功！", referer());
    }
} 
if($op=="display"){
    $pindex = max(1, intval($_GPC["page"]));
    $psize = 10;
    $condition = "uniacid='{$uniacid}'";
    if (!empty($_GPC["keyword"])) {
        $condition .= " AND CONCAT(name) LIKE '%{$_GPC["keyword"]}%'";
    }
    $position = intval($_GPC["position"]);
    if ($position) {
        $condition .= " AND position='{$position}'";
    }
    $list = pdo_fetchall("select * from " . tablename("crad_qrcode_red_adcenter") . " where {$condition}  LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
    $total = pdo_fetchcolumn("select COUNT(*) from " . tablename("crad_qrcode_red_adcenter") . " where {$condition}");
    $pager = pagination($total, $pindex, $psize);
    include $this->template("adcenter");  
}
if ($op == "deleteids") {
    $rowcount = 0;
    $notrowcount = 0;
    foreach ($_GPC["ids"] as $k => $id) {
        $id = intval($id);
        if (!empty($id)) {
            $item_task = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_adcenter") . " WHERE id = :id AND uniacid=:uniacid", array(":id" => $id, ":uniacid" => $uniacid));
            if (!empty($item_task)) {
                pdo_delete("crad_qrcode_red_adcenter", array("id" => $id, "uniacid" => $uniacid));
                $rowcount++;
            } else {
                $notrowcount++;
            }
        }
    }
} 

if ($op == "deleteall") {
    $search = array("id" => $id, "uniacid" => $uniacid);
    $position = $_GPC["position"];
    if ($position) {
        $search["position"] = intval($position);
    }
    pdo_delete("crad_qrcode_red_adcenter", $search);
    message("删除成功", referer(), "success");
}
if ($op == "post") {
    $set = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_adcenter") . " WHERE uniacid = :uniacid AND id = :id", array(":uniacid" => $uniacid, ":id" => $id));
    if (checksubmit("submit")) {
        if (empty($_GPC["name"])) {
            message("请输入广告名称！", '', "error");
        }
        if (!empty($set)) {
            $has_name = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_adcenter") . " WHERE uniacid = :uniacid AND name = :name  AND id != :id", array(":uniacid" => $uniacid, ":name" => trim($_GPC["name"]), ":id" => $id));
        } else {
            $has_name = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_adcenter") . " WHERE uniacid = :uniacid AND name = :name", array(":uniacid" => $uniacid, ":name" => trim($_GPC["name"])));
        }
        if ($has_name) {
            message("广告名称已经存在！", '', "error");
        }
        $data = array(
            "uniacid" => $uniacid,
            "createtime" => time(),
            "name" =>trim($_GPC["name"]),
            "status" =>intval($_GPC["status"]),
            "total_num" =>intval($_GPC["total_num"]),
            "start_time" =>strtotime($_GPC["start_time"]),
            "end_time" =>strtotime($_GPC["end_time"]),
            "weight" =>trim($_GPC["weight"]),
            "position" =>trim($_GPC["position"]),
            "user_type" =>trim($_GPC["user_type"]),
            "per" =>trim($_GPC["per"]),
            "text" =>trim($_GPC["text"]),
            "music" =>trim($_GPC["music"]),
            "audio_volume" =>trim($_GPC["audio_volume"]),
            "share_title" =>trim($_GPC["share_title"]),
            "share_desc" =>trim($_GPC["share_desc"]),
            "share_img" =>trim($_GPC["share_img"]),
            "share_link" =>trim($_GPC["share_link"]),
            "image_url" =>trim($_GPC["image_url"]),
            "link" =>trim($_GPC["link"])
        );

        if (!empty($_GPC['aids'])) {
            $aids = array();
            foreach ($_GPC['aids'] as $key => $row) {
                $aids[] = $_GPC['aids'][$key];
            }
            unset($key, $row);
            if (count($aids) > 1) {
                $data['aids'] = implode(",", $aids);
            } else {
                $data['aids'] = $aids[0];
            }
            unset($aids);
        }
        if (!empty($_GPC['shopids'])) {
            $shopids = array();
            foreach ($_GPC['shopids'] as $key => $row) {
                $shopids[] = $_GPC['shopids'][$key];
            }
            unset($key, $row);
            if (count($aids) > 1) {
                $data['shopids'] = implode(",", $shopids);
            } else {
                $data['shopids'] = $shopids[0];
            }
            unset($shopids);
        }
        if ($set) {
            unset($data['uniacid'],$data['createtime']);
            pdo_update("crad_qrcode_red_adcenter", $data, array("id" => $set["id"]));
            $insertid = $set["id"];
        } else {
            pdo_insert("crad_qrcode_red_adcenter", $data);
            $insertid = pdo_insertid();
            if (!$insertid) {
                message("数据添加失败！", '', "error");
            }
        }
        if ($data["position"] < 3) {
            if ($data["text"]) {
                $fileoutroot = ATTACHMENT_ROOT . "audio/";
                if (!is_dir($fileoutroot)) {
                    mkdir($fileoutroot, 0777);
                }
                if (!is_writable($fileoutroot)) {
                    chmod($fileoutroot, 0777);
                }
                $per = $data["per"] ? $data["per"] : 0;
                $filename_ad = "ad_audio_" . $insertid . $per . ".mp3";
                if (file_exists($fileoutroot . $filename_ad)) {
                    file_delete($fileoutroot . $filename_ad);
                }
                $result_audio = $this->get_audio_shop($filename_ad, $per, $data["text"]);
                if (empty($result_audio)) {
                    message("生成语音文件失败", referer(), "error");
                }
                pdo_update("crad_qrcode_red_adcenter", array("music" => $result_audio), array("id" => $insertid));
            }
        }
        message("数据操作成功！", referer(), '');
    }
    if ($set["shopids"]) {
        $set["shopids"] = explode(",", $set["shopids"]);
        foreach ($set["shopids"] as $key_shopid => $value_shopid) {
            if ($value_shopid) {
                $shopname_info = pdo_fetch("SELECT name FROM " . tablename(TABLE_SHOP) . " WHERE uniacid = :uniacid AND id = :id", array(":uniacid" => $uniacid, ":id" => $value_shopid));
                $set["shopnames"][$key_shopid] = $shopname_info["name"];
            } else {
                $set["shopnames"][$key_shopid] = '';
            }
        }
    }
    if ($set["aids"]) {
        $set["aids"] = explode(",", $set["aids"]);
        foreach ($set["aids"] as $key_shopid => $value_shopid) {
            if ($value_shopid) {
                $shopname_info = pdo_fetch("SELECT name FROM " . tablename(TABLE_ACTIVITY) . " WHERE uniacid = :uniacid AND id = :id", array(":uniacid" => $uniacid, ":id" => $value_shopid));
                $set["activitynames"][$key_shopid] = $shopname_info["name"];
            } else {
                $set["activitynames"][$key_shopid] = '';
            }
        }
    }
    if (empty($set)) {
        $set["user_type"] = 1;
        $set["position"] = 1;
        $set["audio_volume"] = 1.0;
    }
    $circle = pdo_fetchall("select * from " . tablename(TABLE_CIRCLE) . " where uniacid='{$uniacid}' AND status = 1");
    include $this->template("adcenter");
} 

if ($op == "config") {
    $setting = $this->module["config"];
    $config = $setting["baidu_config"];
    if (checksubmit("submit")) {
        if (empty($_GPC["baidu_appid"]) || empty($_GPC["baidu_api_key"]) || empty($_GPC["baidu_api_secret"])) {
            message("请输入完整的参数", '', "error");
        }
        $setting["baidu_config"]["baidu_appid"] = trim($_GPC["baidu_appid"]);
        $setting["baidu_config"]["baidu_api_key"] = trim($_GPC["baidu_api_key"]);
        $setting["baidu_config"]["baidu_api_secret"] = trim($_GPC["baidu_api_secret"]);
        $this->saveSettings($setting);
        message("数据操作成功！", referer(), '');
    }
    include $this->template("adcenter");
}
if ($op == "get_activitys") {
    $condition = '';
    if (!empty($_GPC["keyword"])) {
        $condition .= " AND CONCAT(name) LIKE '%{$_GPC["keyword"]}%'";
    }
    $list_activitys = pdo_fetchall("SELECT id,name FROM " . tablename(TABLE_ACTIVITY) . " WHERE uniacid='{$uniacid}' {$condition} ORDER BY id DESC");
    exit(json_encode($list_activitys));
}
if ($op == "get_shops") {
    $condition = '';
    if (!empty($_GPC["keyword"])) {
        $condition .= " AND CONCAT(name) LIKE '%{$_GPC["keyword"]}%'";
    }
    $list_shops = pdo_fetchall("SELECT id,name FROM " . tablename(TABLE_SHOP) . " WHERE uniacid='{$uniacid}' {$condition} ORDER BY id DESC");
    exit(json_encode($list_shops));
}
