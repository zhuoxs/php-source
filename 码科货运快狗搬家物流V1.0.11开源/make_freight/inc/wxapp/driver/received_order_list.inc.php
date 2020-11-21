<?php

$driver = pdo_get("freight_driver", ["user_id" => $GLOBALS["USER_ID"], "open_id" => $this->W["openid"]], ["id"]);
if (!$driver) {
    return $this->result(0, "司机不存在");
}
$query = load()->object("query");
$field = ["o.id as order_id", "o.place_dispatch", "o.place_dispatch_detail", "o.place_receipt", "o.place_receipt_detail", "o.order_number", "o.create_time", "o.price", "o.real_price", "o.start_lat", "o.start_lot", "o.end_lat", "o.end_lot", "o.distance", "o.remark", "o.shipper_name", "o.shipper_phone", "d.id as driver_order_id", "d.latitude", "d.longitude", "u.avatar"];
$driver_order = $query->from("freight_driver_order", "d")->select($fileid)->innerjoin("freight_order", "o")->on(["d.order_id" => "o.id"])->innerjoin("freight_users", "u")->on(["o.uid" => "u.id"])->where(["o.status" => [2, 3], "d.uniacid" => $this->uniacid, "d.driver_id" => $driver["id"]])->orderby("id", "DESC")->getall();
if (!$driver_order) {
    return $this->result(0, '');
}
return $this->result(0, "ok", $driver_order);