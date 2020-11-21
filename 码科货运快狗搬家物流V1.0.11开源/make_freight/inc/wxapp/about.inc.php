<?php

$query = load()->object("query");
$about = $query->from("freight_about")->select(["id", "img_url", "versions", "work_time", "phone", "email", "wechat", "company"])->where(["uniacid" => $this->uniacid])->orderby("id", "DESC")->get();
if ($about) {
    $about = $this->replaceUrl($about);
    return $this->result(0, "success", $about);
} else {
    return $this->result(0, "没有数据");
}