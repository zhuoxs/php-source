<?php

$params = ["place_dispatch" => $this->GPC["place_dispatch"], "start_lot" => $this->GPC["start_lot"], "start_lat" => $this->GPC["start_lat"], "shipper_name" => $this->GPC["shipper_name"], "shipper_phone" => $this->GPC["shipper_phone"], "place_receipt" => $this->GPC["place_receipt"], "consignee" => $this->GPC["consignee"], "consignee_phone" => $this->GPC["consignee_phone"], "end_lot" => $this->GPC["end_lot"], "end_lat" => $this->GPC["end_lat"], "price" => $this->GPC["price"], "distance" => $this->GPC["distance"], "car_id" => $this->GPC["car_id"], "uid" => $GLOBALS["USER_ID"], "place_dispatch_detail" => $this->GPC["place_dispatch_detail"], "place_receipt_detail" => $this->GPC["place_receipt_detail"], "type" => intval($this->GPC["type"])];
foreach ($params as $k => &$v) {
    $v = preg_replace("# #", '', $v);
    if (!isset($v) || $v == "undefined") {
        return $this->result(0, $k . $v . "参数为空");
    }
}
if (empty($params["uid"])) {
    return $this->result(0, "请登录!");
}
if ($params["type"] == 0) {
    $params["type"] = 1;
    $params["status"] = 7;
} else {
    if ($params["type"] == 1) {
        $params["type"] = 2;
        $params["status"] = 1;
    } else {
        $params["type"] = 1;
        $params["status"] = 7;
    }
}
$car = pdo_get("freight_vehicle", ["id" => $params["car_id"]], ["title", "starting_price", "starting_km", "beyond_price"]);
if (!$car) {
    return $this->result(0, "车辆ID错误");
}
$params["goods_name"] = empty($this->GPC["goods_name"]) || $this->GPC["goods_name"] == "undefined" ? '' : $this->GPC["goods_name"];
$params["bulk"] = empty($this->GPC["bulk"]) || $this->GPC["goods_name"] == "undefined" ? '' : $this->GPC["bulk"];
$params["user_coupon_id"] = empty($this->GPC["user_coupon_id"]) ? 0 : $this->GPC["user_coupon_id"];
$params["remark"] = empty($this->GPC["remark"]) ? '' : $this->GPC["remark"];
$params["appointment_time"] = empty($this->GPC["appointment_time"]) ? '' : $this->GPC["appointment_time"];
$params["car_name"] = $car["title"];
$params["start_price"] = $car["starting_price"];
$params["start_km"] = $car["starting_km"];
$params["beyond"] = $car["beyond_price"];
$params["uniacid"] = $this->uniacid;
$params["create_time"] = time();
$params["order_number"] = makeOrderNo();
$params["discount_price"] = 0;
$params["real_price"] = floatval($params["price"]);
if ($params["type"] == 1) {
    if ($params["user_coupon_id"]) {
        $couponRe = pdo_get("freight_user_coupon", ["id" => $params["user_coupon_id"], "user_id" => $params["uid"]]);
        if ($couponRe) {
            if ($couponRe["status"] !== strval(0)) {
                return $this->result(0, "优惠券已使用");
            } else {
                if ($couponRe["end_time"] < time()) {
                    return $this->result(0, "优惠券已过期");
                } else {
                    if ($params["price"] <= $couponRe["use_limit"]) {
                        return $this->result(0, "下单金额需要大于" . $couponRe["use_limit"] . "才能使用！");
                    }
                }
            }
            $params["discount_price"] = $couponRe["price"];
            $params["real_price"] = $params["price"] - $couponRe["price"];
            $fee = floatval($params["real_price"]);
            if ($fee <= 0) {
                $this->result(0, "订单金额不能小于0");
            }
        } else {
            return $this->result(0, "优惠券不存在");
        }
    }
}
pdo_begin();
$coupon = true;
$re = pdo_insert("freight_order", $params);
$order_id = pdo_insertid();
if (!empty($params["user_coupon_id"])) {
    $coupon = pdo_update("freight_user_coupon", ["status" => 1], ["id" => $params["user_coupon_id"]]);
}
if ($re && $coupon) {
    pdo_commit();
    return $this->result(0, "提交订单成功", ["order_id" => $order_id, "order_num" => $params["order_number"]]);
} else {
    pdo_rollback();
    return $this->result(0, "提交订单失败");
}