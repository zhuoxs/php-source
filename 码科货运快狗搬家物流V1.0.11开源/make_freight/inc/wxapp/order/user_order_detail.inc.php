<?php

$orderId = $this->GPC["order_id"];
if (empty($orderId)) {
    return $this->result(0, "ID不能为空");
}
$field = ["o.id", "o.order_number", "o.place_dispatch", "o.place_dispatch_detail", "o.place_receipt", "o.place_receipt_detail", "o.status", "o.create_time", "o.appointment_time", "o.shipper_name", "o.remark", "o.real_price", "o.start_lat", "o.start_lot", "o.end_lat", "o.end_lot", "o.type", "o.shipper_phone", "d.driver_phone", "d.photo", "d.driver_name", "d.id as driver_id", "i.latitude", "i.longitude", "i.service_mark", "do.create_time as dcreate_time", "do.get_cargo_time", "do.end_time"];
$query = load()->object("query");
$orders = $query->from("freight_order", "o")->select($field)->leftjoin("freight_driver_order", "do")->on(["o.id" => "do.order_id"])->leftjoin("freight_driver", "d")->on(["do.driver_id" => "d.id"])->leftjoin("freight_driver_info", "i")->on(["i.driver_id" => "d.id"])->where(["o.id" => $orderId, "uid" => $GLOBALS["USER_ID"]])->get();
if (!$orders) {
    return $this->result(0, "暂未有订单记录");
}
$orders["photo"] = $this->replaceUrl($orders["photo"]);
$orders["dcreate_time"] = date("Y-m-d H:i", $orders["dcreate_time"]);
$orders["create_time"] = date("Y-m-d H:i", $orders["create_time"]);
$orders["get_cargo_time"] = date("Y-m-d H:i", $orders["get_cargo_time"]);
$orders["end_time"] = date("Y-m-d H:i", $orders["end_time"]);
return $this->result(0, "ok", $orders);