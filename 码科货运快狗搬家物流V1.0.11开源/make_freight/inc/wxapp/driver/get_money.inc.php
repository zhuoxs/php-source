<?php

$driver = pdo_get("freight_driver", ["user_id" => $GLOBALS["USER_ID"]], ["id"]);
$query = load()->object("query");
$field = ["i.balance"];
$orders = $query->from("freight_driver", "d")->select($field)->leftjoin("freight_driver_info", "i")->on(["d.id" => "i.driver_id"])->where(["user_id" => $GLOBALS["USER_ID"], "status" => 1])->get();
if (!$orders) {
    return $this->result(0, '', 0);
}
return $this->result(0, "ok", $orders);