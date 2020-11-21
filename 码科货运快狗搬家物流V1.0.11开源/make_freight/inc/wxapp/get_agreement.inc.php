<?php

$field = ["user_agm", "driver_agm"];
$config = pdo_getall("freight_config", ["name" => $field, "uniacid" => $this->uniacid], ["name", "value"]);
if ($config) {
    $agreement = array_column($config, "value", "name");
    return $this->result(0, "success", $agreement);
} else {
    return $this->result(0, "null");
}