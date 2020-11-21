<?php

$page = empty($this->GPC["page"]) ? 1 : $this->GPC["page"];
$query = load()->object("query");
$count = $query->from("freight_order")->where(["status" => 1, "uniacid" => $this->uniacid])->count();
$pagesize = 10;
$offest = ($page - 1) * $pagesize;
$totalPage = intval(($count + $pagesize - 1) / $pagesize);
$driver = pdo_get("freight_driver", ["user_id" => $GLOBALS["USER_ID"], "uniacid" => $this->uniacid], ["id", "car_id"]);
if (!$driver) {
    return $this->result(0, "司机不存在!");
}
$driver_info = pdo_get("freight_driver_info", ["driver_id" => $driver], ["latitude", "longitude"]);
$config = pdo_getall("freight_config", ["name" => ["order_ratio", "scope"], "uniacid" => $this->uniacid], ["name", "value"]);
$config = array_column($config, "value", "name");
$scope = SquarePoint($driver_info["longitude"], $driver_info["latitude"], isset($config["scope"]) ? $config["scope"] : 50);
$where = array("start_lat >=" => $scope["minlat"], "start_lat <=" => $scope["maxlat"], "start_lot >=" => $scope["minlng"], "start_lot <=" => $scope["maxlng"]);
$where["car_id"] = $driver["car_id"];
$field = ["id", "place_dispatch", "place_dispatch_detail", "appointment_time", "place_receipt", "place_receipt_detail", "order_number", "create_time", "price", "real_price", "start_lat", "start_lot", "end_lat", "end_lot", "status", "distance", "remark", "car_name"];
if (!$query->from("freight_order")->select($field)->where(["status" => 1, "type" => 1, "uniacid" => $this->uniacid])->page($offest, $pagesize)->orderby("id", "DESC")->where($where)->getall()) {
    return $this->result(0, '');
}
foreach ($order as $k => $v) {
    $order[$k]["order_id"] = $v["id"];
    if (isset($config["order_ratio"])) {
        $order[$k]["price"] = substr($v["price"] - $v["price"] * ($config["order_ratio"] / 100), 0, -2);
    }
    $order[$k]["create_time"] = date("Y-m-d H:i", $v["create_time"]);
}
$data = ["data" => $order, "cur" => $page, "nextPage" => $page + 1, "totalPage" => $totalPage];
return $this->result(0, "success", $data);