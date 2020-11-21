<?php

$params = ["picture" => $this->GPC["picture"], "order_id" => $this->GPC["order_id"], "lat" => $this->GPC["lat"], "lng" => $this->GPC["lng"]];
foreach ($params as $k => $v) {
    if (empty($v)) {
        return $this->result(0, $k . "参数不能为空");
    }
}
$driver = pdo_get("freight_driver", ["user_id" => $GLOBALS["USER_ID"], "uniacid" => $this->uniacid, "open_id" => $this->W["openid"]], ["id"]);
$query = load()->object("query");
$field = ["do.id as doid", "o.id as id", "o.status", "o.uid", "o.start_lat", "o.start_lot"];
$order = $query->from("freight_driver_order", "do")->select($field)->innerjoin("freight_order", "o")->on(["do.order_id" => "o.id"])->where(["do.order_id" => $params["order_id"], "do.driver_id" => $driver["id"]])->get();
if (!isset($order["id"])) {
    return $this->result(0, "订单不存在");
}
if ((int) $order["status"] !== 2) {
    return $this->result(0, "该订单不是待取货状态");
}
$get_score = pdo_get("freight_config", ["name" => "get_scope", "uniacid" => $this->uniacid], ["value"]);
$get_score = empty($get_score) ? 5 : (int) $get_score["value"];
$distance = getDistance($params["lat"], $params["lng"], $order["start_lat"], $order["start_lot"]);
if ($distance > $get_score) {
    return $this->result(0, "不在取货范围内，无法取货！");
}
pdo_begin();
$updateDriverO = pdo_update("freight_driver_order", ["picture" => $params["picture"], "get_cargo_time" => time()], ["id" => $order["doid"]]);
$updateOreder = pdo_update("freight_order", ["status" => 3], ["id" => $order["id"]]);
if (!$updateDriverO || !$updateOreder) {
    pdo_rollback();
    return $this->result(0, "订单修改失败");
}
pdo_commit();
$this->sendOrderUser($order);
return $this->result(0, "修改成功", "ok");