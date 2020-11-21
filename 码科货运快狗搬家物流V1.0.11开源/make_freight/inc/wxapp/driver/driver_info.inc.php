<?php

$field = ["id", "driver_name", "driver_phone", "car_id", "status"];
$query = load()->object("query");
$driver = $query->from("freight_driver")->select($field)->where(["open_id" => $this->W["openid"], "uniacid" => $this->uniacid])->get();
if (!$driver) {
    return $this->result(0, '', ["is_driver" => 0, "today_order" => 0, "today_income" => 0]);
}
if ((int) $driver["status"] !== 1) {
    return $this->result(0, '', ["is_driver" => 0, "today_order" => 0, "today_income" => 0]);
}
$driver["is_driver"] = $driver["status"];
$info_field = ["balance", "service_mark", "statef"];
$info = $query->from("freight_driver_info")->select($info_field)->where(["driver_id" => $driver["id"]])->get();
$car_field = ["title", "load_capacity"];
$car = $query->from("freight_vehicle")->select($car_field)->where(["id" => $driver["car_id"]])->get();
$driver["info"] = $info;
$driver["car"] = $car;
unset($driver["car_id"]);
$startTime = strtotime(date("Y-m-d"));
$endTime = strtotime(date("Y-m-d 23:59:59", time()));
$where = ["create_time >=" => $startTime, "create_time <=" => $endTime, "driver_id" => $driver["id"]];
$todayOrder = pdo_get("freight_driver_order", $where, ["COUNT(*) as today_order"]);
$todayIncome = pdo_get("freight_amount_detail", array_merge($where, ["type" => 1]), ["SUM(amount) as today_incom"]);
if (!$todayIncome["today_incom"]) {
    $todayIncome["today_incom"] = 0;
}
$driver["today_order"] = $todayOrder["today_order"];
$driver["today_income"] = $todayIncome["today_incom"];
return $this->result(0, "success", $driver);