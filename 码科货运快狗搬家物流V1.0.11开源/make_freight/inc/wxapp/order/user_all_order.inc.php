<?php

$status = $this->GPC["status"];
$page = empty($this->GPC["page"]) ? 1 : $this->GPC["page"];
$query = load()->object("query");
$where = ["o.uniacid" => $this->uniacid, "o.uid" => $GLOBALS["USER_ID"]];
if (!empty($status)) {
    switch ($status) {
        case 1:
            $where["o.status"] = 7;
            break;
        case 2:
            $where["o.status"] = [1, 2, 3];
            break;
        case 3:
            $where["o.status"] = 5;
    }
}
$countWhere = ["uniacid" => $this->uniacid, "uid" => $GLOBALS["USER_ID"]];
if ($status) {
    $countWhere["status"] = $where["o.status"];
}
$count = $query->from("freight_order")->where($countWhere)->count();
$pagesize = 10;
$offest = ($page - 1) * $pagesize;
$totalPage = intval(($count + $pagesize - 1) / $pagesize);
$field = ["o.id", "o.order_number", "o.place_dispatch", "o.place_dispatch_detail", "o.place_receipt", "o.place_receipt_detail", "o.status", "o.create_time", "o.type", "d.driver_phone", "d.id as driver_id"];
$orders = $query->from("freight_order", "o")->select($field)->leftjoin("freight_driver_order", "do")->on(["o.id" => "do.order_id"])->leftjoin("freight_driver", "d")->on(["do.driver_id" => "d.id"])->where($where)->orderby("o.id", "DESC")->page($offest, $pagesize)->getall();
if (!$orders) {
    return;
}
foreach ($orders as &$v) {
    $v["create_time"] = date("Y-m-d H:s", $v["create_time"]);
}
$data = ["data" => $orders, "cur" => $page, "nextPage" => $page + 1, "totalPage" => $totalPage];
return $this->result(0, "ok", $data);