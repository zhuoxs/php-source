<?php

load()->func("logging");
$form_id = preg_replace("# #", '', $this->GPC["form_id"]);
if (empty($form_id) || $form_id == "undefined" || $form_id == "theformIdisamockone") {
    return $this->result(0, "formID为空", 1);
}
$params = ["user_id" => $GLOBALS["USER_ID"], "uniacid" => $this->uniacid, "open_id" => $this->W["openid"], "form_id" => $form_id, "expire_time" => strtotime("+7 day")];
foreach ($params as $k => $v) {
    if (empty($v)) {
        return $this->result(0, $k . "为空", 1);
    }
}
$re = pdo_insert("freight_user_formid", $params);
if (!$re) {
    logging_run("插入失败");
}
return $this->result(0, "添加成功", "ok");