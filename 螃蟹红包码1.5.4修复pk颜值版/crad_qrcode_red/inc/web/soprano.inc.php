<?php
defined("IN_IA") or exit("Access Denied");
global $_GPC, $_W;
checklogin();
$uniacid = intval($_W["uniacid"]);
load()->func("tpl");
$op = $_GPC["op"] ? $_GPC["op"] : "display";
if ($op == "del") {
    $id = intval($_GPC["id"]);
    $item = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_soprano") . " WHERE id = :id", array(":id" => $id));
    if (empty($item)) {
        message("抱歉，数据不存在或是已经删除！", referer(), "error");
    }
    if ($item["uniacid"] != $uniacid) {
        message("您没有权限操作");
    }
    if (pdo_delete("crad_qrcode_red_soprano", array("id" => $id)) === false) {
        message("删除失败！", referer(), "error");
    } else {
        message("删除成功！", referer());
    }
}
if ($op == "get_activitys") {
    $condition = '';
    if (!empty($_GPC["keyword"])) {
        $condition .= " AND CONCAT(name) LIKE '%{$_GPC["keyword"]}%'";
    }
    $list_activitys = pdo_fetchall("SELECT id,name FROM " . tablename(TABLE_ACTIVITY) . " WHERE uniacid='{$uniacid}' {$condition} ORDER BY id DESC");
    exit(json_encode($list_activitys));
}
if ($op == "deleteids") {
    $rowcount = 0;
    $notrowcount = 0;
    foreach ($_GPC["ids"] as $k => $id) {
        $id = intval($id);
        if (!empty($id)) {
            $item_task = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_soprano") . " WHERE id = :id AND uniacid=:uniacid", array(":id" => $id, ":uniacid" => $uniacid));
            if (!empty($item_task)) {
                pdo_delete("crad_qrcode_red_soprano", array("id" => $id, "uniacid" => $uniacid));
                $rowcount++;
            } else {
                $notrowcount++;
            }
        }
    }
}
if ($op == "deleteall") {
    $search = "uniacid='{$uniacid}'";
    pdo_delete("crad_qrcode_red_soprano", $search);
    message("删除成功", referer(), "success");
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
    include $this->template("soprano");
}

if ($op == "post") {
    $id = intval($_GPC["id"]);
    if ($id) {
        $set = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_soprano") . " WHERE uniacid = :uniacid AND id = :id", array(":uniacid" => $uniacid, ":id" => $id));
        if (empty($set)) {
            message("数据错误！", '', "error");
        }
    }
    if (checksubmit("submit")) {
        if (empty($_GPC["name"])) {
            message("请输入高音喇叭名称！", '', "error");
        }
        if (!empty($set)) {
            $has_name = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_soprano") . " WHERE uniacid = :uniacid AND name = :name  AND id != :id", array(":uniacid" => $uniacid, ":name" => trim($_GPC["name"]), ":id" => $id));
        } else {
            $has_name = pdo_fetch("SELECT * FROM " . tablename("crad_qrcode_red_soprano") . " WHERE uniacid = :uniacid AND name = :name", array(":uniacid" => $uniacid, ":name" => trim($_GPC["name"])));
        }
        if ($has_name) {
            message("名称已经存在！", '', "error");
        }
        //lonedev
        $data = array(
            "uniacid" => $uniacid,
            "createtime" => time(),
            "name" => trim($_GPC["name"]),
            "status" => trim($_GPC["status"]),
            "starttime" => trim($_GPC["starttime"]),
            "endtime" => trim($_GPC["endtime"]),
            "music_open" => trim($_GPC["music_open"]),
            "music" => trim($_GPC["music"]),
            "bg_volume" => trim($_GPC["bg_volume"]),
            "audio_volume" => trim($_GPC["audio_volume"]),
            "entry_audio_open" => trim($_GPC["entry_audio_open"]),
            "free_audio_open" => trim($_GPC["free_audio_open"]),
            "audio_open" => trim($_GPC["audio_open"]),
            "per" => trim($_GPC["per"]),
            "audio_before" => trim($_GPC["audio_before"]),
        );
        if(!empty($_GPC['money'])){
            foreach($_GPC['money'] as $key=>$row){
                $rules[$key]["money"]=$row;
                $rules[$key]["text"]=$_GPC["text"][$key];
            }
            $data['rules']=json_encode($rules);
            unset($key,$row); 
        }
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
        if ($set) {
            pdo_update("crad_qrcode_red_soprano", $data, array("id" => $set["id"]));
            $insertid = $set["id"];
        } else {
            pdo_insert("crad_qrcode_red_soprano", $data);
            $insertid = pdo_insertid();
            if (!$insertid) {
                message("数据添加失败！", '', "error");
            }
        }
        $fileoutroot = ATTACHMENT_ROOT . "audio/";
        if (!is_dir($fileoutroot)) {
            mkdir($fileoutroot, 0777);
        }
        if (!is_writable($fileoutroot)) {
            chmod($fileoutroot, 0777);
        }
        if ($data["entry_audio_open"] == 2) {
            if ($_GPC["entry_audio_text"]) {
                $entry_audio_per = $_GPC["entry_audio_per"] ? intval($_GPC["entry_audio_per"]) : 0;
                $filename_entry = "entry_audio_" . $insertid . $entry_audio_per . ".mp3";
                if (file_exists($fileoutroot . $filename_entry)) {
                    file_delete($fileoutroot . $filename_entry);
                }
                $result_audio = $this->get_audio_shop($filename_entry, $entry_audio_per, trim($_GPC["entry_audio_text"]));
                if (!$result_audio) {
                    message("进场语音文件创建失败！", referer(), "error");
                }
                $entry_audio = json_decode($data["entry_audio"], true);
                $entry_audio["music"] = $result_audio;
                $entry_audio["text"]=trim($_GPC["entry_audio_text"]);
                $entry_audio["per"]=$entry_audio_per;
                pdo_update("crad_qrcode_red_soprano", array("entry_audio" => json_encode($entry_audio)), array("id" => $insertid));
            }
        }
        if ($data["free_audio_open"] == 2) {
            if ($_GPC["free_audio_text"]) {
                $free_audio_per = $_GPC["free_audio_per"] ? intval($_GPC["free_audio_per"]) : 0;
                $filename_free = "free_audio_" . $insertid . $free_audio_per . ".mp3";
                if (file_exists($fileroot . $filename_free)) {
                    file_delete($fileroot . $filename_free);
                }
                $result_audio = $this->get_audio_shop($filename_free, $free_audio_per, trim($_GPC["free_audio_text"]));
                if (!$result_audio) {
                    message("空闲语音文件创建失败！", referer(), "error");
                }
                $free_audio = json_decode($data["free_audio"], true);
                $free_audio["music"] = $result_audio;
                $free_audio["text"] = trim($_GPC["free_audio_text"]);
                $free_audio["per"]=$free_audio_per;
                pdo_update("crad_qrcode_red_soprano", array("free_audio" => json_encode($free_audio)), array("id" => $insertid));
            }
        }
        message("数据操作成功！", referer(), '');
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
    if ($set["entry_audio"]) {
        $entry_audio = json_decode($set["entry_audio"], true);
    }
    $set["rules"] = $set["rules"] ? json_decode($set["rules"], true) : array();
    if ($set["free_audio"]) {
        $free_audio = json_decode($set["free_audio"], true);
    }
    if (empty($set)) {
        $set["audio_volume"] = 1.0;
        $set["bg_volume"] = 1.0;
    }
    include $this->template("soprano");
}
if($op=="display"){
    $pindex = max(1, intval($_GPC["page"]));
    $psize = 10;
    $condition = "uniacid='{$uniacid}'";
    if (!empty($_GPC["keyword"])) {
        $condition .= " AND CONCAT(name) LIKE '%{$_GPC["keyword"]}%'";
    }
    $list = pdo_fetchall("select * from " . tablename("crad_qrcode_red_soprano") . " WHERE {$condition}  LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
    if (!empty($list)) {
        foreach ($list as &$s_row) {
            $s_row["token"] = $this->get_shoptoken($uniacid, $s_row["id"]);
            $s_row["a_url"] = $_W["siteroot"] . "app/index.php?i=" . $uniacid . "&c=entry&m=crad_qrcode_red&do=soprano&id=" . $s_row["id"] . "&token=" . $s_row["token"];
        }
    }
    $total = pdo_fetchcolumn("select COUNT(*) from " . tablename("crad_qrcode_red_soprano") . " where {$condition}");
    $pager = pagination($total, $pindex, $psize);
    include $this->template("soprano");
}