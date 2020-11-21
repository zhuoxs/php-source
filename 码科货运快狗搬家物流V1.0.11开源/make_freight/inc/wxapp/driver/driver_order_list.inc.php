<?php

$page = empty($this->GPC["page"]) ? 1 : $this->GPC["page"];
$status = empty($this->GPC["status"]) ? '' : (int) $this->GPC["status"];
$where = [];
switch ($status) {
    case 1:
        $where["o.status"] = 2;
        break;
    case 2:
        $where["o.status"] = 3;
        break;
    case 3:
        $where["o.status"] = [4, 5];
        break;
}
$query = load()->object("query");
$driver = pdo_get("freight_driver", ["user_id" => $GLOBALS["USER_ID"], "open_id" => $this->W["openid"], "uniacid" => $this->uniacid], ["id", "user_id"]);
if (!$driver) {
    return $this->result(0, "未获取到司机信息,请授权登录后再试");
}
$count = $query->from("freight_driver_order")->where(["driver_id" => $driver["id"]])->count();
$pagesize = 10;
$offest = ($page - 1) * $pagesize;
$totalPage = ($count + $pagesize - 1) / $pagesize;
$field = ["o.id", "o.order_number", "o.place_dispatch", "o.place_dispatch_detail", "o.place_receipt", "o.place_receipt_detail", "o.status", "o.create_time", "o.real_price"];
$where["do.driver_id"] = $driver["id"];
$orders = $query->from("freight_driver_order", "do")->select($field)->leftjoin("freight_order", "o")->on(["do.order_id" => "o.id"])->where($where)->page($offest, $pagesize)->orderby("o.id", "DESC")->getall();
if (!$orders) {
    return $this->result(0, '');
}
foreach ($orders as $k => &$v) {
    $v["create_time"] = date("Y-m-d H:i", $v["create_time"]);
}
$data = ["data" => $orders, "cur" => $page, "nextPage" => $page + 1, "totalPage" => $totalPage];
return $this->result(0, "ok", $data);