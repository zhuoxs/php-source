<?php

$query = load()->object("query");
$cates = $query->from("freight_cates")->select(["id", "title"])->where(["uniacid" => $this->uniacid, "type" => 1, "status" => 1])->orderby("sort", "DESC")->getall();
if ($cates) {
    return $this->result(0, "success", $cates);
} else {
    return $this->result(0, "null");
}