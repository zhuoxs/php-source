<?php

$amount = $this->GPC["amount"];
if (empty($amount)) {
    return $this->result(0, "请输入提现金额");
}
$config = pdo_get("freight_config", ["name" => "withdrawal_condition", "uniacid" => $this->uniacid], ["value"]);
if ($amount < $config["value"]) {
    return $this->result(0, "满" . $config["value"] . "才能提现!");
}
$query = load()->object("query");
$field = ["i.balance", "i.id", "d.id as did"];
$where = ["d.open_id" => $this->W["openid"], "d.user_id" => $GLOBALS["USER_ID"]];
$driver = $query->from("freight_driver", "d")->leftjoin("freight_driver_info", "i")->on(["d.id" => "i.driver_id"])->select($field)->where($where)->get();
if (!$driver["did"]) {
    return $this->result(0, "未查询到信息");
}
if ($driver["balance"] < $amount) {
    return $this->result(0, "余额不足！");
}
$params = ["order_number" => makeOrderNo() . "t", "driver_id" => $driver["did"], "title" => "提现", "open_id" => $this->W["open_id"], "status" => 0, "uniacid" => $this->uniacid, "create_time" => time()];
$amount_ins = ["driver_id" => $driver["did"], "amount" => $amount, "type" => 2, "title" => "提现到微信", "create_time" => time(), "uniacid" => $this->uniacid];
pdo_begin();
$re = pdo_insert("freight_withdrawal", $params);
$amount_detail = pdo_insert("freight_amount_detail", $amount_ins);
$upd_balance = pdo_update("freight_driver_info", ["balance -=" => $amount], ["driver_id" => $driver["did"]]);
if (empty($re) || empty($amount_detail) || empty($upd_balance)) {
    pdo_rollback();
    return $this->result(0, "提现失败");
}
pdo_commit();
return $this->result(0, "申请已提交,请等待工作人员审核!");