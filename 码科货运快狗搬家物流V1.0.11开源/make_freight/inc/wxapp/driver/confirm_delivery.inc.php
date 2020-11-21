<?php

$order_id = $this->GPC["order_id"];
$lat = $this->GPC["lat"];
$lng = $this->GPC["lng"];
if (empty($order_id)) {
    return $this->result(0, "订单ID不能为空");
}
if (empty($lat) || empty($lng)) {
    return $this->result(0, "未获取到司机经纬度");
}
$driver = pdo_get("freight_driver", ["user_id" => $GLOBALS["USER_ID"], "uniacid" => $this->uniacid, "open_id" => $this->W["openid"]], ["id"]);
$query = load()->object("query");
$field = ["do.id as doid", "o.id as id", "o.real_price", "o.distance", "o.uid", "o.start_lat", "o.start_lot"];
$order = $query->from("freight_driver_order", "do")->select($field)->innerjoin("freight_order", "o")->on(["do.order_id" => "o.id"])->where(["do.order_id" => $order_id, "do.driver_id" => $driver["id"]])->get();
if (!isset($order["id"])) {
    return $this->result(0, "订单不存在或用户已取消");
}
$get_score = pdo_get("freight_config", ["name" => "get_scope", "uniacid" => $this->uniacid], ["value"]);
$get_score = empty($get_score) ? 5 : (int) $get_score["value"];
$distance = getDistance($lat, $lng, $order["start_lat"], $order["start_lot"]);
if ($distance > $get_score) {
    return $this->result(0, "不在收货范围内，无法确认送达！");
}
$config = pdo_get("freight_config", ["name" => "order_ratio", "uniacid" => $this->uniacid], ["value"]);
if (!$config) {
    return $this->result(0, "后台未设置订单抽成比例");
}
$service_charge = $order["real_price"] * ($config["value"] / 100);
$price = $order["real_price"] - $service_charge;
pdo_begin();
$update_order = pdo_update("freight_order", ["status" => 4], ["id" => $order["id"]]);
$upData = ["balance +=" => $price, "service_number +=" => 1, "count_km +=" => $order["distance"]];
$update_balance = pdo_update("freight_driver_info", $upData, ["driver_id" => $driver["id"]]);
$updateDriOrder = pdo_update("freight_driver_order", ["deduct_price" => $service_charge, "end_time" => time()], ["id" => $order["doid"]]);
$data = ["driver_id" => $driver["id"], "amount" => $price, "type" => 1, "title" => "完成订单", "create_time" => time(), "uniacid" => $this->uniacid];
$insert_amount = pdo_insert("freight_amount_detail", $data);
if (!$update_order || !$update_balance || !$insert_amount) {
    pdo_rollback();
    return $this->result(0, "修改失败!");
}
pdo_commit();
$this->sendOrderUser($order);
return $this->result(0, "确认成功!", "ok");