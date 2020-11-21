<?php

$query = load()->object("query");
$cates = $query->from("freight_cates")->select(["id", "title", "icon"])->where(["uniacid" => $this->uniacid, "status" => 1, "type" => 2])->orderby("sort", "DESC")->getall();
$cate_ids = array_column($cates, "id");
$service = pdo_getall("freight_counter", array("city_id in" => $cate_ids), ["id", "city_id", "name", "address", "phone"]);
if ($cates) {
    foreach ($cates as $k => &$v) {
        $v["icon"] = str_replace("/uploads", MODULE_URL . "core/public/uploads", $v["icon"]);
        $v["service"] = [];
        if ($service) {
            foreach ($service as $index => $item) {
                if ($v["id"] == $item["city_id"]) {
                    $v["service"][] = $item;
                    unset($service[$index]);
                }
            }
        }
    }
    return $this->result(0, "success", $cates);
} else {
    return $this->result(0, "null");
}