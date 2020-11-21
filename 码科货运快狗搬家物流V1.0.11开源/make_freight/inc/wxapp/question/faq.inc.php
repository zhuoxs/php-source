<?php

$query = load()->object("query");
$faq = $query->from("freight_faq")->select(["id", "name", "content", "sort", "uniacid"])->where(["uniacid" => $this->uniacid])->orderby("sort", "DESC")->getall();
if ($faq) {
    return $this->result(0, "success", $faq);
} else {
    return $this->result(0, "null");
}