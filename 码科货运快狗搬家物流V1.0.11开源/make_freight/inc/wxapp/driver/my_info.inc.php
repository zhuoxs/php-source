<?php

$field = ["id", "driver_name", "driver_phone", "car_id", "driver_IDcard", "plate_number", "status", "front_IDcard_image", "contrary_IDcard_image", "driving_license", "car_image", "photo", "drivers_license", "drivers_license_copy", "flank_car_image"];
$query = load()->object("query");
$driver = $query->from("freight_driver")->select($field)->where(["open_id" => $this->W["openid"], "uniacid" => $this->uniacid])->get();
if (!$driver) {
    return $this->result(0, "未查询到司机信息");
}
$driver["driver_IDcard"] = substr_replace($driver["driver_IDcard"], "***********", 3, -4);
$arr = ["front_IDcard_image", "contrary_IDcard_image", "photo", "drivers_license", "drivers_license_copy", "driving_license", "car_image", "flank_car_image"];
foreach ($arr as $k => $v) {
    $driver["image"][$k] = $driver[$v];
}
foreach ($arr as $key => $val) {
    $driver["image_url"][] = str_replace("/uploads", MODULE_URL . "core/public/uploads", $driver[$val]);
}
return $this->result(0, "ok", $driver);