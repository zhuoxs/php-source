<?php

$orderId = $this->GPC["id"];
if (empty($orderId)) {
    return $this->result(0, "参数不能为空");
}
if (!pdo_get("freight_order", ["id" => $orderId, "uid" => $GLOBALS["USER_ID"]])) {
    return $this->result(0, "未查询到该订单");
}
if ($order["status"] == 7) {
    pdo_begin();
    $updateOrder = pdo_update("freight_order", ["status" => 6], ["id" => $order["id"]]);
    $updateCoupon = true;
    if (!empty($order["user_coupon_id"])) {
        $updateCoupon = pdo_update("freight_user_coupon", ["status" => 0], ["id" => $order["user_coupon_id"]]);
    }
    if ($updateOrder || $updateCoupon) {
        pdo_commit();
        return $this->result(0, "取消成功", "ok");
    }
    pdo_rollback();
    return $this->result(0, "取消失败");
}
if ($order["status"] !== 1) {
    return $this->result(0, "司机已接单无法取消，请联系客服人员取消订单！");
}
pdo_begin();
$updateOrder = pdo_update("freight_order", ["status" => 6], ["id" => $order["id"]]);
$updateCoupon = true;
if (!empty($order["user_coupon_id"])) {
    $updateCoupon = pdo_update("freight_user_coupon", ["status" => 0], ["id" => $order["user_coupon_id"]]);
}
$updateUserIntegral = pdo_update("freight_users", ["amount -=" => $order["real_price"]], ["id" => $GLOBALS["USER_ID"]]);
$delDriverOrder = true;
if ($order["status"] == 2) {
    $delDriverOrder = pdo_delete("freight_driver_order", ["order_id" => $order["id"]]);
}
load()->func("logging");
if ($updateOrder || $updateCoupon || $delDriverOrder || $updateUserIntegral) {
    $re = weixinRefund($order["order_number"], $order["real_price"]);
    if (is_error($re)) {
        logging_run($re["message"]);
        return $this->result(0, !empty($re["message"]) ? $re["message"] : "退款失败！");
    }
    if ($re !== true) {
        pdo_rollback();
        return $this->result(0, @$re["message"]);
    }
    pdo_commit();
    $this->sendCancelMsg($order);
    return $this->result(0, "取消成功!", $updateOrder . $updateCoupon . $delDriverOrder . $updateUserIntegral);
} else {
    pdo_rollback();
    return $this->result(0, $updateOrder . $updateCoupon . $delDriverOrder);
}