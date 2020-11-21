<?php

$orderId = $this->GPC["order_id"];
if (empty($orderId)) {
    return $this->result(0, "订单ID不能为空");
}
$driver = pdo_get("freight_driver", ["user_id" => $GLOBALS["USER_ID"], "uniacid" => $this->uniacid], ["id"]);
if (!$driver) {
    return $this->result(0, "司机信息不存在");
}
$query = load()->object("query");
$field = ["o.id", "o.order_number", "o.place_dispatch", "o.place_dispatch_detail", "o.place_receipt", "o.place_receipt_detail", "o.status", "o.create_time", "o.real_price", "o.uid"];
$where = ["do.driver_id" => $driver["id"], "do.order_id" => $orderId];
$orders = $query->from("freight_driver_order", "do")->select($field)->leftjoin("freight_order", "o")->on(["do.order_id" => "o.id"])->where($where)->get();
if (!$orders) {
    return $this->result(0, "订单不存在或用户已取消");
}
if ((int) $orders["status"] == 6) {
    return $this->result(0, "订单已取消");
}
if (in_array((int) $orders["status"], [1, 4, 5])) {
    return $this->result(0, "此订单不可取消!");
}
pdo_begin();
$cancel = pdo_update("freight_order", ["status" => 1], ["id" => $orderId]);
$del_order = pdo_delete("freight_driver_order", ["driver_id" => $driver["id"], "order_id" => $orderId]);
$cancelData = ["order_id" => $orderId, "driver_id" => $driver["id"], "create_time" => time(), "uniacid" => $this->uniacid, "order_number" => $orders["order_number"]];
$cancel_order = pdo_insert("freight_driver_cancel_order", $cancelData);
$cance_num = pdo_update("freight_driver_info", ["cancel_number +=" => 1], ["driver_id" => $driver["id"]]);
if (!$cancel || !$del_order || !$cancelData || !$cance_num) {
    pdo_rollback();
    return $this->result(0, "订单取消失败");
}
pdo_commit();
$this->sendOrderUser($orders);
return $this->result(0, '', "ok");