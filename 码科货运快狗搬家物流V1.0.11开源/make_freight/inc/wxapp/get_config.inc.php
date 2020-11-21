<?php

$field = ["program_background", "program_font", "program_title", "amap", "tmap", "logo", "share", "service_tel"];
$config = pdo_getall("freight_config", ["name" => $field, "uniacid" => $this->uniacid], ["name", "value"]);
if ($config) {
    $arrs = array_column($config, "value", "name");
    $arrs["uid"] = $GLOBALS["USER_ID"];
    $arrs = $this->replaceUrl($arrs);
    return $this->result(0, "success", $arrs);
} else {
    return $this->result(0, "null");
}