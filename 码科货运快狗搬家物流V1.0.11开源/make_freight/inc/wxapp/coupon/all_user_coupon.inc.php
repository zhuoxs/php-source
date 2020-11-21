<?php

$page = empty($this->GPC["page"]) ? 1 : $this->GPC["page"];
$status = empty($this->GPC["status"]) ? 0 : $this->GPC["status"];
$query = load()->object("query");
if (empty($GLOBALS["USER_ID"])) {
    return $this->result(0, "请登录");
}
$where = ["uniacid" => $this->uniacid, "user_id" => $GLOBALS["USER_ID"]];
switch ($status) {
    case 2:
        $where["status"] = ["1", "2"];
        break;
    case 1:
        $where["status"] = 0;
        break;
}
$count = $query->from("freight_user_coupon")->where($where)->count();
$pagesize = 10;
$offest = ($page - 1) * $pagesize;
$totalPage = intval(($count + $pagesize - 1) / $pagesize);
$fileid = ["id", "title", "price", "desc", "use_limit", "create_time", "end_time", "status"];
$user_coupon = $query->from("freight_user_coupon")->select($fileid)->where($where)->page($offest, $pagesize)->orderby("id", "DESC")->getall();
if ($user_coupon) {
    foreach ($user_coupon as $k => &$v) {
        if ($v["end_time"] < time()) {
            $v["status"] = 2;
            pdo_update("freight_user_coupon", ["status" => 2], ["id" => $v["id"]]);
        }
        $v["price"] = intPrice($v["price"]);
        $v["create_time"] = date("Y-m-d", $v["create_time"]);
        $v["end_time"] = date("Y-m-d", $v["end_time"]);
    }
    return $this->result(0, "success", $user_coupon);
}
return $this->result(0, '');