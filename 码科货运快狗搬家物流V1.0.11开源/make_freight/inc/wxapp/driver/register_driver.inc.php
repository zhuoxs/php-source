<?php

$params = ["driver_name" => $this->GPC["name"], "driver_phone" => $this->GPC["phone"], "driver_IDcard" => $this->GPC["IDcard"], "plate_number" => $this->GPC["plate_number"], "car_id" => $this->GPC["car_id"], "front_IDcard_image" => $this->GPC["front_IDcard"], "contrary_IDcard_image" => $this->GPC["contrary_IDcard"], "car_image" => $this->GPC["car_image"], "photo" => $this->GPC["photo"], "drivers_license" => $this->GPC["drivers_license"], "nick_name" => $this->W["fans"]["nickname"], "open_id" => $this->W["openid"], "uniacid" => $this->uniacid, "create_time" => time(), "user_id" => $GLOBALS["USER_ID"]];
foreach ($params as $k => &$v) {
    $v = preg_replace("# #", '', $v);
    if (empty($v)) {
        return $this->result(0, $k . "参数不能为空");
    }
}
if (!$this->checkIDcard($params["driver_IDcard"])) {
    return $this->result(0, "身份证号码格式不正确");
}
if (!is_mobile($params["driver_phone"])) {
    return $this->result(0, "手机号格式不正确");
}
if (!is_hanzi($params["driver_name"])) {
    return $this->result(0, "姓名只能输入汉字");
}
$params["status"] = 0;
$is_register = pdo_get("freight_driver", ["open_id" => $params["open_id"], "uniacid" => $this->uniacid, "status !=" => 2]);
if ($is_register) {
    if ((int) $is_register["status"] == 0) {
        $this->result(0, "您已经提交过审核啦，请等待工作人员审核");
    } else {
        if ((int) $is_register["status"] == 1) {
            $this->result(0, "您已经是司机了！");
        }
    }
}
$re = pdo_insert("freight_driver", $params);
if ($re) {
    return $this->result(0, "提交审核成功", "ok");
}
return $this->result(0, "提交失败");