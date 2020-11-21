<?php

$params = ["distance" => intval($this->GPC["distance"]), "car_id" => intval($this->GPC["car_id"])];
foreach ($params as $k => &$v) {
    if (!isset($v)) {
        return $this->result(0, $k . "参数为空");
    }
}
$params["user_coupon_id"] = empty($this->GPC["user_coupon_id"]) ? 0 : $this->GPC["user_coupon_id"];
$discount = 0;
$use_limit = 0;
if ($params["user_coupon_id"]) {
    $query = load()->object("query");
    $fileid = ["id", "price", "use_limit", "end_time"];
    $user_coupon = $query->from("freight_user_coupon")->select($fileid)->where(["id" => $params["user_coupon_id"], "user_id" => $GLOBALS["USER_ID"], "status" => 0, "end_time >" => time()])->get();
    if ($user_coupon) {
        $discount = $user_coupon["price"];
        $use_limit = $user_coupon["use_limit"];
        $params["user_coupon_id"] = $user_coupon["uc_id"];
    }
}
$car = pdo_get("freight_vehicle", ["id" => $params["car_id"]], ["id", "starting_price", "starting_km", "beyond_price"]);
if (!$car) {
    return $this->result(0, "车辆信息不存在");
}
if ($params["distance"] <= $car["starting_km"]) {
    $price = $car["starting_price"];
} else {
    $price = ($params["distance"] - $car["starting_km"]) * $car["beyond_price"] + $car["starting_price"];
}
if ($price < $use_limit) {
    return $this->result(0, "优惠券需要金额大于" . $use_limit . "才能使用~");
}
$price = intPrice($price);
$real_price = $price - $discount;
$real_price = $real_price;
$data = ["price" => $price, "real_price" => $real_price, "discount_price" => $discount, "user_coupon_id" => $params["user_coupon_id"], "car_id" => $car["id"]];
return $this->result(0, "success", $data);