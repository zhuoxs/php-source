<?php

$mobile = preg_replace("# #", '', $this->GPC["mobile"]);
$code = preg_replace("# #", '', $this->GPC["code"]);
if (empty($mobile) || empty($code)) {
    return $this->result(0, "验证码或手机号不能为空!");
}
$driver = pdo_get("freight_driver", ["open_id" => $this->W["openid"], "user_id" => $GLOBALS["USER_ID"], "uniacid" => $this->uniacid], ["id"]);
if (!$driver) {
    return $this->result(0, "请先授权登录后再操作!");
}
$mobileMsg = cache_load(strval($mobile));
if (empty($mobileMsg)) {
    return $this->result(0, "请先发送验证码");
} else {
    if ($mobileMsg["exp_time"] < time()) {
        return $this->result(0, "验证码已过期，请重新发送");
    } else {
        if ($mobileMsg["code"] !== intval($code)) {
            return $this->result(0, "验证码不正确");
        }
    }
}
$update_driver = pdo_update("freight_driver", ["driver_phone" => $mobile], ["id" => $driver]);
if (!$update_driver) {
    return $this->result(0, "手机号码修改失败");
}
cache_delete($mobile);
return $this->result(0, "修改成功", $update_driver);