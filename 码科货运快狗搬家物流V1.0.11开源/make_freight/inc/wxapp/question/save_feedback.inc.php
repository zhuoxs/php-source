<?php

if (empty($GLOBALS["USER_ID"])) {
    return $this->result(0, "用户未登录");
}
$params = $this->checkParams(["name", "content"]);
if (false == $params) {
    return $this->result(0, "必填参数不能为空");
}
$params["contact"] = empty($this->GPC["contact"]) ? '' : $this->GPC["contact"];
$params["images"] = empty($this->GPC["image"]) ? '' : $this->GPC["image"];
$params["create_time"] = time();
$params["uid"] = $GLOBALS["USER_ID"];
$params["uniacid"] = $this->uniacid;
$re = pdo_insert("freight_feedback", $params);
if (!empty($re)) {
    return $this->result(0, "反馈成功", "ok");
}
return $this->result(0, "反馈失败");