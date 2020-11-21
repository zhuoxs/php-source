<?php

$code = empty($this->GPC["code"]) ? '' : $this->GPC["code"];
$coupon_id = intval($this->GPC["coupon_id"]);
$where = [];
if ($code) {
    $where = ["code" => $code, "uniacid" => $this->uniacid];
} else {
    $where = ["id" => $coupon_id];
}
$field = ["id", "name", "amount", "price", "desc", "use_limit", "start_time", "end_time", "over_time", "get_number"];
$coupon = pdo_get("freight_coupon", $where, $field);
if (!$coupon) {
    return $this->result(0, "优惠券不存在");
}
$time = time();
if ($time < $coupon["start_time"] || $time > $coupon["end_time"]) {
    $start_time = date("Y-m-d H:i:s", $coupon["start_time"]);
    $end_time = date("Y-m-d H:i:s", $coupon["end_time"]);
    return $this->result(0, "优惠券领取时间为" . $start_time . "," . "结束时间为" . $end_time);
} else {
    if ($coupon["amount"] < 1) {
        return $this->result(0, "优惠券已被抢光啦");
    }
}
$user_coupon = pdo_get("freight_user_coupon", ["coupon_id" => $coupon["id"], "user_id" => $GLOBALS["USER_ID"]], ["id"]);
if ($user_coupon) {
    return $this->result(0, "您已经领取过该优惠券啦");
}
$over_time = strtotime("+" . $coupon["over_time"] . "day", $time);
$insData = ["coupon_id" => $coupon["id"], "title" => $coupon["name"], "price" => $coupon["price"], "desc" => $coupon["desc"], "use_limit" => $coupon["use_limit"], "user_id" => $GLOBALS["USER_ID"], "end_time" => $over_time, "uniacid" => $this->uniacid, "create_time" => $time];
pdo_begin();
$re = pdo_insert("freight_user_coupon", $insData);
$co = pdo_update("freight_coupon", ["amount -=" => 1, "get_number +=" => 1], ["id" => $coupon["id"]]);
if (empty($re) || empty($co)) {
    pdo_rollback();
    return $this->result(0, "优惠券领取失败");
}
pdo_commit();
return $this->result(0, "优惠券领取成功", "ok");