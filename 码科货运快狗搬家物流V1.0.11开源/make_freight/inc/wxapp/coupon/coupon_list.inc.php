<?php

$page = empty($this->GPC["page"]) ? 1 : $this->GPC["page"];
$where = ["uniacid" => $this->uniacid, "is_show_switch" => 1];
$count = $query->from("freight_user_coupon")->where($where)->count();
$pagesize = 10;
$offest = ($page - 1) * $pagesize;
$totalPage = intval(($count + $pagesize - 1) / $pagesize);
$query = load()->object("query");
$coupon = $query->from("freight_coupon")->select(["id", "name", "price", "desc", "start_time", "end_time", "sort"])->where($where)->orderby("sort", "DESC")->page($offest, $pagesize)->getall();
if ($coupon) {
    foreach ($coupon as $k => &$v) {
        $v["start_time"] = empty($v["start_time"]) ? '' : date("Y-m-d", $v["start_time"]);
        $v["end_time"] = empty($v["end_time"]) ? '' : date("Y-m-d", $v["end_time"]);
    }
    return $this->result(0, "success", $coupon);
} else {
    return $this->result(0, "null");
}