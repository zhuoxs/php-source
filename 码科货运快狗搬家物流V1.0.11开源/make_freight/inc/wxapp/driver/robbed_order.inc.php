<?php

$params = ["order_id" => intval($this->GPC["order_id"]), "latitude" => $this->GPC["latitude"], "longitude" => $this->GPC["longitude"]];
foreach ($params as $k => $v) {
    if (empty($v) || $v == "undefined") {
        return $this->result(0, $k . "不能为空");
    }
}
if (!pdo_get("freight_order", ["id" => $params["order_id"]], ["id", "car_id", "uid", "status", "start_lat", "start_lot"])) {
    return $this->result(0, "订单不存在!");
}
if ((int) $order["status"] !== 1) {
    return $this->result(0, "该订单已被抢走或用户已取消");
}
$driver = pdo_get("freight_driver", ["user_id" => $GLOBALS["USER_ID"], "open_id" => $this->W["openid"]], ["id", "car_id", "status"]);
if (!$driver) {
    return $this->result(0, "没有司机信息");
}
if ((int) $driver["status"] !== 1) {
    return $this->result(0, "司机认证审核未通过");
}
$params["driver_id"] = $driver["id"];
$driver_info = pdo_get("freight_driver_info", ["driver_id" => $driver["id"]], ["latitude", "longitude", "statef"]);
if ((int) $driver_info["statef"] !== 1) {
    return $this->result(0, "当前不是接单状态");
}
$params["create_time"] = time();
$params["uniacid"] = $this->uniacid;
if ($driver["car_id"] !== $order["car_id"]) {
    return $this->result(0, "用户下单选择车型与您车型不匹配！");
}
if ($driver_info["latitude"] && $driver_info["longitude"]) {
    $distance = getDistance($driver_info["latitude"], $driver_info["longitude"], $order["start_lat"], $order["start_lot"]);
    $config = pdo_get("freight_config", ["name" => "scope", "uniacid" => $this->uniacid], ["value"]);
    if ($distance > $config["value"]) {
        return $this->result(0, "不在该订单接单范围内，无法接单!");
    }
}
$query = load()->object("query");
$driver_order = $query->from("freight_driver_order")->select("id")->where(["order_id" => $params["order_id"]])->get();
if ($driver_order) {
    return $this->result(0, "订单已被抢走啦!");
}
pdo_begin();
$update_order = pdo_update("freight_order", ["status" => 2], ["id" => $params["order_id"]]);
$insertDriverOrder = pdo_insert("freight_driver_order", $params);
if (!$update_order || !$insertDriverOrder) {
    pdo_rollback();
    return $this->result(0, "订单已被抢走啦");
} else {
    pdo_commit();
    $this->sendOrderUser($order);
    $this->sendOrder($order);
    return $this->result(0, "抢单成功", "ok");
}