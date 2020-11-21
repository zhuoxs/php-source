<?php

if (!empty($this->GPC["statef"])) {
    $params = ["statef" => $this->GPC["statef"]];
} else {
    $params = ["latitude" => $this->GPC["lat"], "longitude" => $this->GPC["lng"], "address" => $this->GPC["address"]];
}
foreach ($params as $k => $v) {
    if (empty($v)) {
        return $this->result(0, $k . "字段不能为空");
    }
}
$driver = pdo_get("freight_driver", ["user_id" => $GLOBALS["USER_ID"], "uniacid" => $this->uniacid], ["id"]);
$update = pdo_update("freight_driver_info", $params, ["driver_id" => $driver["id"]]);
if (!$update) {
    return $this->result(0, '');
}
return $this->result(0, "修改成功", "ok");