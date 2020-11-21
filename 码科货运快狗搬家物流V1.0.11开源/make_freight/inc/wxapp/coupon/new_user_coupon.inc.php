<?php
$config = pdo_getall("freight_config", ["name" => ["coupon_id", "coupon_back"], "uniacid" => $this->uniacid], ["name", "value"]);
if (!$config) {
	return $this->result(0, '');
}
$config = array_column($config, "value", "name");
if ((int) $config["coupon_id"] == 0) {
    return $this->result(0, "333");
}
$coupon = pdo_get("freight_coupon", ["id" => $config["coupon_id"]], ["id", "name"]);
if (!$coupon) {
	return $this->result(0, "优惠券不存在!");
}
$user_coupon = pdo_get("freight_user_coupon", ["coupon_id" => $coupon["id"], "user_id" => $GLOBALS["USER_ID"]], ["id"]);
if ($user_coupon) {
    return $this->result(0, '');
}
$order = pdo_get("freight_order", ["uid" => $GLOBALS["USER_ID"], "status <>" => [6, 7]], ["id"]);
if ($order) {
    return $this->result(0, '');
}
$coupon["background"] = $this->replaceUrl($config["coupon_back"]);
return $this->result(0, "ok", $coupon);