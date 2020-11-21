<?php

$type = !isset($this->GPC["status"]) ? 1 : $this->GPC["status"];
$page = empty($this->GPC["page"]) ? 1 : $this->GPC["page"];
if ((int) $type === 0) {
    $type = 1;
} else {
    $type = 2;
}
$query = load()->object("query");
$driver = $query->from("freight_driver")->select("id")->where(["user_id" => $GLOBALS["USER_ID"], "uniacid" => $this->uniacid])->get();
$where = ["uniacid" => $this->uniacid, "driver_id" => $driver["id"], "type" => $type];
$count = $query->from("freight_amount_detail")->where($where)->count();
$pagesize = 10;
$offest = ($page - 1) * $pagesize;
$totalPage = intval(($count + $pagesize - 1) / $pagesize);
$field = ["id", "title", "type", "amount", "create_time"];
$amountDetail = $query->from("freight_amount_detail")->select($field)->page($offest, $pagesize)->where($where)->getall();
if (!$amountDetail) {
    return $this->result(0, '');
}
foreach ($amountDetail as $key => &$v) {
    $v["create_time"] = date("Y-m-d H:i");
}
$data = ["data" => $amountDetail, "cur" => $page, "nextPage" => $page + 1, "totalPage" => $totalPage];
return $this->result(0, "ok", $data);