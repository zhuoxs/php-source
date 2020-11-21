<?php

if (!$this->W["openid"]) {
    return $this->result(0, "未获取openid！");
}
$userData = array("nick_name" => $this->W["fans"]["nickname"], "avatar" => $this->W["fans"]["avatar"], "gender" => $this->W["fans"]["gender"], "open_id" => $this->W["openid"], "uniacid" => $this->uniacid, "last_time" => time());
$exits = pdo_get("freight_users", array("open_id" => $this->W["openid"], "uniacid" => $this->uniacid), array("id"));
$add = null;
if (!empty($exits)) {
    $add = pdo_update("freight_users", $userData, array("open_id" => $this->W["openid"], "uniacid" => $this->uniacid));
} else {
    $userData["create_time"] = time();
    $add = pdo_insert("freight_users", $userData);
}
if (empty($add)) {
    return $this->result(0, "信息保存失败！");
}
return $this->result(0, "信息已获取成功！", "ok");