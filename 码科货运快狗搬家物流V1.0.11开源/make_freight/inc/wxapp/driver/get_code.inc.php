<?php

$mobile = preg_replace("# #", '', $this->GPC["mobile"]);
if (empty($mobile)) {
    return $this->result(0, "请输入手机号码");
}
$mobileMsg = cache_load($mobile);
if (!empty($mobileMsg)) {
    if ($mobileMsg["nextTime"] > time()) {
        $nextTime = $mobileMsg["nextTime"] - time();
        return $this->result(0, "距离下次发送还有" . $nextTime);
    }
}
$field = ["sign_name", "code_sms", "ali_secret", "ali_secret", "ali_access"];
$config = pdo_getall("freight_config", ["name in" => $field, "uniacid" => $this->uniacid]);
$config = array_column($config, "value", "name");
foreach ($field as $k => $v) {
    if (!array_key_exists($v, $config)) {
        return $this->result(0, $v . "参数未配置");
    }
}
$randCode = mt_rand(1000, 9999);
$sms = send_aliyun_sms($mobile, ["code" => $randCode], $config);
if (empty($sms["Code"]) || strtolower($sms["Code"]) !== "ok") {
    return $this->result(0, !empty($sms["Message"]) ? $sms["Message"] : "短信发送失败!");
}
$data = ["code" => $randCode, "nextTime" => time() + 60, "mobile" => $mobile, "exp_time" => strtotime("+5minute")];
$is = cache_write($mobile, $data);
return $this->result(0, "发送成功", $is);