<?php

$params = ["score" => $this->GPC["score"], "uniacid" => $this->uniacid, "score1" => $this->GPC["score1"], "score2" => $this->GPC["score2"], "order_id" => $this->GPC["order_id"], "driver_id" => $this->GPC["driver_id"], "user_id" => $GLOBALS["USER_ID"]];
$status = $this->GPC["status"];
if (intval($status) == 5) {
    $field = ["score", "score1", "score2", "suggest"];
    if (!pdo_get("freight_score", ["order_id" => $params["order_id"], "driver_id" => $params["driver_id"], "user_id" => $params["user_id"]], $field)) {
        return $this->result(0, "未获取到评价信息");
    }
    return $this->result(0, "ok", $score);
}
foreach ($params as $k => $v) {
    if (empty($v)) {
        return $this->result(0, $k . "不能为空");
    }
}
$params["suggest"] = !empty($this->GPC["suggest"]) ? $this->GPC["suggest"] : '';
if (!pdo_get("freight_order", ["id" => $params["order_id"], "uid" => $params["user_id"]], ["status", "id"])) {
    return $this->result(0, "订单不存在");
}
if ((int) $order["status"] !== 4) {
    return $this->result(0, "该订单不是待评价状态");
}
$driverOrder = pdo_get("freight_driver_order", ["driver_id" => $params["driver_id"], "order_id" => $params["order_id"]], ["id", "driver_id"]);
if (!$driverOrder) {
    $this->result(0, "订单信息与司机信息不匹配");
}
pdo_begin();
$params["create_time"] = time();
$re = pdo_insert("freight_score", $params);
$updateOrder = pdo_update("freight_order", ["status" => 5], ["id" => $order["id"]]);
$avg = pdo_get("freight_score", ["driver_id" => $driverOrder["driver_id"], "uniacid" => $this->uniacid], ["AVG(score) as avg"]);
$driverInfoRes = pdo_get("freight_driver_info", ["driver_id" => $driverOrder["driver_id"], "uniacid" => $this->uniacid], ["service_mark"]);
$driverInfo = false;
if ($driverInfoRes["service_mark"] !== $avg) {
    $driverInfo = pdo_update("freight_driver_info", ["service_mark" => $avg["avg"]], ["driver_id" => $driverOrder["driver_id"]]);
}
if (!$re || !$updateOrder || !$driverInfo) {
    pdo_rollback();
    return $this->result(0, "评价失败");
}
pdo_commit();
return $this->result(0, '', 1);