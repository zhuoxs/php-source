<?php

$params = ["place_dispatch" => $this->GPC["place_dispatch"], "start_lot" => $this->GPC["start_lot"], "start_lat" => $this->GPC["start_lat"], "shipper_name" => $this->GPC["shipper_name"], "shipper_phone" => $this->GPC["shipper_phone"], "place_receipt" => $this->GPC["place_receipt"], "consignee" => $this->GPC["consignee"], "consignee_phone" => $this->GPC["consignee_phone"], "end_lot" => $this->GPC["end_lot"], "end_lat" => $this->GPC["end_lat"], "distance" => $this->GPC["distance"], "car_id" => $this->GPC["car_id"], "uid" => $GLOBALS["USER_ID"], "appointment_time" => $this->GPC["appointment_time"], "car_id" => $this->GPC["car_id"], "price" => $this->GPC["price"]];
foreach ($params as $k => &$v) {
    $v = preg_replace("# #", '', $v);
    if (empty($v)) {
        return $this->result(0, $k . "参数为空");
    }
}
$car = pdo_get("freight_vehicle", ["id" => $params["car_id"]], ["title", "starting_price", "starting_km", "beyond_price"]);
if (!$car) {
    return $this->result(0, "车辆ID错误");
}
unset($params["car_id"]);
$params["remark"] = empty($this->GPC["remark"]) ? '' : $this->GPC["remark"];
$params["car_name"] = $car["title"];
$params["start_price"] = $car["starting_price"];
$params["start_km"] = $car["starting_km"];
$params["beyond"] = $car["beyond_price"];
$params["type"] = 2;
$params["status"] = 1;
$params["uniacid"] = $this->uniacid;
$params["create_time"] = time();
$params["order_number"] = makeOrderNo();
$re = pdo_insert("freight_order", $params);
if ($re) {
    return $this->result(0, "预约成功,请等待工作人员与您联系！");
}
return $this->result(0, "预约失败");