<?php

$orderID = $this->GPC["order_id"];
if (empty($orderID)) {
    $this->result(0, "id不能为空");
}
$query = load()->object("query");
$driver = pdo_get("freight_driver", ["user_id" => $GLOBALS["USER_ID"], "open_id" => $this->W["openid"], "uniacid" => $this->uniacid], ["id"]);
if (!$driver) {
    return $this->result(0, "未获取到司机信息,请授权登录后再试");
}
$field = ["o.id", "o.order_number", "o.place_dispatch", "o.place_dispatch_detail", "o.place_receipt", "o.place_receipt_detail", "o.status", "o.create_time", "o.appointment_time", "o.car_name", "o.remark", "o.discount_price", "o.real_price", "do.create_time as dcreatetime", "do.get_cargo_time", "do.end_time"];
$where = ["o.id" => $orderID];
$orders = $query->from("freight_order", "o")->select($field)->leftjoin("freight_driver_order", "do")->on(["do.order_id" => "o.id"])->where($where)->get();
$orders["create_time"] = date("Y-m-d H:i", $orders["create_time"]);
$orders["dcreatetime"] = date("Y-m-d H:i", $orders["dcreatetime"]);
$orders["get_cargo_time"] = date("Y-m-d H:i", $orders["get_cargo_time"]);
$orders["end_time"] = date("Y-m-d H:i", $orders["end_time"]);
if (!$orders) {
    return $this->result(0, "未有该订单记录");
}
return $this->result(0, "success", $orders);