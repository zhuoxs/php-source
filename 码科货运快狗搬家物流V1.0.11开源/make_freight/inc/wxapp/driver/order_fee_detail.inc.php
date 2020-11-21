<?php

$order_id = (int) $this->GPC["order_id"];
if (empty($order_id) || $order_id == "undefined") {
    return $this->result(0, "订单id为空");
}
$driver = pdo_get("freight_driver", ["user_id" => $GLOBALS["USER_ID"], "open_id" => $this->W["openid"], "uniacid" => $this->uniacid], ["id"]);
if (!$driver) {
    return $this->result(0, "未获取到司机信息,请授权登录后再试");
}
$field = ["o.id", "o.real_price", "o.discount_price", "o.distance", "o.start_price", "o.start_km", "o.beyond", "o.price"];
$query = load()->object("query");
$where = ["o.id" => $order_id];
if (!$query->from("freight_order", "o")->select($field)->leftjoin("freight_driver_order", "do")->on(["do.order_id" => "o.id"])->where($where)->get()) {
    return $this->result(0, '');
}
$fee = [];
$config = pdo_get("freight_config", ["name" => "order_ratio", "uniacid" => $this->uniacid], ["value"]);
if (!$config) {
    return $this->result(0, "后台未设置订单抽成比例");
}
$service_charge = $order["real_price"] * ($config["value"] / 100);
$price = $order["real_price"] - $service_charge;
$fee["service_fee"] = $service_charge;
$fee["income"] = $price;
$fee["start_price"] = $order["start_price"];
$fee["start_km"] = $order["start_km"];
$fee["user_pay"] = $order["real_price"];
$fee["beyond_km"] = $order["beyond"];
$fee["price"] = $order["price"];
return $this->result(0, "ok", $fee);