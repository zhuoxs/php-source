<?php

$query = load()->object("query");
$banners = $query->from("freight_banner")->select(["id", "url", "image", "sort", "show_switch", "app_url", "appid", "type"])->where(["uniacid" => $this->uniacid, "show_switch" => 1])->orderby("sort", "DESC")->getall();
if ($banners) {
    $banners = $this->replaceUrl($banners);
    return $this->result(0, "success", $banners);
} else {
    return $this->result(0, "null");
}