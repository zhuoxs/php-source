<?php

$filed = ["id", "title", "load_capacity", "length", "width", "height", "icon", "image", "starting_price", "starting_km", "beyond_price", "s_icon"];
$query = load()->object("query");
$cars = $query->from("freight_vehicle")->select($filed)->where(["uniacid" => $this->uniacid, "status" => 1])->orderby("sort", "DESC")->getall();
if ($cars) {
    $cars = $this->replaceUrl($cars);
    return $this->result(0, "success", $cars);
} else {
    return $this->result(0, "null");
}