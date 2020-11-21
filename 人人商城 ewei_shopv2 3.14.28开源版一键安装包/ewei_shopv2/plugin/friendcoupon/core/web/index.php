<?php
if (!defined("IN_IA")) {
    exit("Access Denied");
}
class Index_EweiShopV2Page extends PluginWebPage
{
    public function main()
    {
        global $_W;
        if (cv("friendcoupon.activity_list")) {
            header("location: " . webUrl("friendcoupon.activity_list"));
        } else {
            if (cv("friendcoupon.set")) {
                header("location: " . webUrl("friendcoupon.set"));
            } else {
                if (cv("friendcoupon.activity_list.edit")) {
                    header("location: " . webUrl("friendcoupon.edit"));
                } else {
                    if (cv("friendcoupon.statistics")) {
                        header("location: " . webUrl("membercard.getrecord"));
                    } else {
                        header("location: " . webUrl());
                    }
                }
            }
        }
    }
    public function activity_list()
    {
        global $_W;
        global $_GPC;
        $keyword = isset($_GPC["keyword"]) ? trim($_GPC["keyword"]) : NULL;
        $type = isset($_GPC["type"]) ? $_GPC["type"] : NULL;
        $condition = "";
        if (isset($type)) {
            if ((int) $type === -2) {
                $condition = " and status = -1 and stop_time <> 0 ";
            } else {
                if ((int) $type === -1) {
                    $condition = " and status = -1 and stop_time = 0 ";
                } else {
                    $condition = " and status = " . $type . " ";
                }
            }
        }
        if (isset($keyword) && $keyword != "") {
            $condition .= " and title like '%" . $keyword . "%' ";
        }
        $pindex = isset($_GPC["page"]) ? max(1, intval($_GPC["page"])) : 1;
        $psize = 20;
        $list = pdo_fetchall("select * from " . tablename("ewei_shop_friendcoupon") . " where 1 " . $condition . " and uniacid = :uniacid and deleted = :deleted order by create_time desc limit " . ($pindex - 1) * $psize . "," . $psize, array(":uniacid" => $_W["uniacid"], ":deleted" => 0));
        $time = time();
        foreach ($list as &$item) {
            $initStatus = $item["status"];
            if ($time < $item["activity_start_time"]) {
                $item["status"] = 0;
            } else {
                if ($item["activity_end_time"] < $time || !empty($item["stop_time"]) && $item["stop_time"] < $time) {
                    $item["status"] = -1;
                } else {
                    $item["status"] = 1;
                }
            }
            if ($item["status"] != $initStatus) {
                pdo_update("ewei_shop_friendcoupon", array("status" => $item["status"]), array("id" => $item["id"]));
            }
            $item["codeUrl"] = mobileUrl("friendcoupon", array("id" => $item["id"]), true);
        }
        unset($item);
        $total = pdo_fetchcolumn("select count(1) from " . tablename("ewei_shop_friendcoupon") . " where 1 " . $condition . " and uniacid = :uniacid and deleted = 0", array(":uniacid" => $_W["uniacid"]));
        $pager = pagination2($total, $pindex, $psize);
        include $this->template();
    }
    public function add()
    {
        $this->post();
    }
    public function copy()
    {
        $this->post();
    }
    /**
     * @param null $operation
     */
    public function post()
    {
        global $_W;
        global $_GPC;
        if (!cv("friendcoupon.activity_list.edit")) {
            header("location: " . webUrl());
        }
        $id = $this->isCopyLink() ? (int) $_GPC["cp_id"] : (int) $_GPC["id"];
        $activity = $this->model->getActivity($id);
        if ($this->isCopyLink()) {
            $id = 0;
            $activity["title"] .= "-副本";
            $activity["stop_time"] = 0;
            $activity["launches_count"] = 0;
        }
        if ($_W["ispost"]) {
            $data = array("uniacid" => (int) $_W["uniacid"], "title" => trim($_GPC["title"]), "people_count" => (int) $_GPC["people_count"], "coupon_money" => (double) $_GPC["coupon_money"], "duration" => (int) $_GPC["duration"], "allocate" => (int) $_GPC["allocate"], "upper_limit" => (double) $_GPC["upper_limit"], "launches_limit" => (int) $_GPC["launches_limit"], "activity_start_time" => strtotime($_GPC["activity_time"]["start"]), "activity_end_time" => strtotime($_GPC["activity_time"]["end"]), "desc" => $_GPC["desc"], "use_condition" => (double) $_GPC["use_condition"], "use_time_limit" => (int) $_GPC["use_time_limit"], "use_start_time" => strtotime($_GPC["use_time"]["start"]), "use_end_time" => strtotime($_GPC["use_time"]["end"]), "limitdiscounttype" => (int) $_GPC["limitdiscounttype"], "limitgoodcatetype" => (int) $_GPC["limitgoodcatetype"], "limitgoodtype" => (int) $_GPC["limitgoodtype"], "use_valid_days" => (int) $_GPC["use_valid_days"]);
            if (empty($data["use_condition"])) {
                $data["use_condition"] = 0;
            }
            if (empty($data["upper_limit"]) || round($data["upper_limit"], 2) < round(0.01, 2)) {
                $data["upper_limit"] = 0.01;
            }
            $minLimit = floor($data["coupon_money"] / $data["people_count"] * 100) / 100;
            if ($minLimit < round($data["upper_limit"], 2)) {
                show_json(0, "瓜分最小金额不可超过（" . $minLimit . "）元");
            }
            if ($data["duration"] <= 0) {
                show_json(0, "请设置瓜分时长");
            }
            if (15 < mb_strlen($data["title"], "utf-8")) {
                show_json(0, "活动名称的长度请控制在15字以内");
            }
            $titleExists = pdo_fetchcolumn("select count(1) from " . tablename("ewei_shop_friendcoupon") . " where uniacid = :uniacid and deleted = :deleted and title = :title and id <> :id", array(":uniacid" => $_W["uniacid"], ":title" => $data["title"], ":deleted" => 0, ":id" => $id));
            if ($titleExists) {
                show_json(0, "标题不允许重复");
            }
            if ($data["people_count"] < 2) {
                show_json(0, "瓜分人数不能少于2人");
            }
            if (50 < $data["people_count"]) {
                show_json(0, "瓜分人数不能超过50人");
            }
            if ($data["use_time_limit"] === 0 && !$data["use_valid_days"]) {
                show_json(0, "请填写在瓜分后有效时间");
            }
            if ($data["allocate"] === 0 && !$data["upper_limit"]) {
                show_json(0, "随机金额必须要填写瓜分券金额上限");
            }
            if (empty($data["desc"])) {
                $desc[] = "1.领取活动";
                $desc[] = "2.在规定时间内邀请指定人数一起瓜分红包";
                $desc[] = "3.满足条件后开奖瓜分";
                $data["desc"] = implode("\r\n", $desc);
            }
            $time = time();
            if ($time < $data["activity_start_time"]) {
                $data["status"] = 0;
            } else {
                if ($data["activity_end_time"] < $time) {
                    $data["status"] = -1;
                } else {
                    $data["status"] = 1;
                }
            }
            $limitgoodcatetype = intval($_GPC["limitgoodcatetype"]);
            $limitgoodtype = intval($_GPC["limitgoodtype"]);
            $data["limitgoodcatetype"] = $limitgoodcatetype;
            $data["limitgoodtype"] = $limitgoodtype;
            if ($limitgoodcatetype == 1 || $limitgoodcatetype == 2) {
                $data["limitgoodcateids"] = "";
                $cates = array();
                if (is_array($_GPC["cates"])) {
                    $cates = $_GPC["cates"];
                    $data["limitgoodcateids"] = implode(",", $cates);
                }
            } else {
                $data["limitgoodcateids"] = "";
            }
            if ($limitgoodtype == 1 || $limitgoodtype == 2) {
                $data["limitgoodids"] = "";
                $goodids = array();
                if (is_array($_GPC["goodsid"])) {
                    $goodids = $_GPC["goodsid"];
                    $data["limitgoodids"] = implode(",", $goodids);
                }
            } else {
                $data["limitgoodids"] = "";
            }
            if (!$id) {
                $data["create_time"] = time();
                pdo_insert("ewei_shop_friendcoupon", $data);
                $insert_id = pdo_insertid();
                show_json(1, array("url" => webUrl("friendcoupon.post", array("id" => $insert_id))));
            } else {
                pdo_update("ewei_shop_friendcoupon", $data, array("id" => $id));
                show_json(1);
            }
        }
        $goodcategorys = m("shop")->getFullCategory(true, true);
        if ($activity["limitgoodcatetype"] == 1 || $activity["limitgoodcatetype"] == 2) {
            $cates = array();
            $cates = explode(",", $activity["limitgoodcateids"]);
        }
        if (($activity["limitgoodtype"] == 1 || $activity["limitgoodtype"] == 2) && $activity["limitgoodids"]) {
            $goods = pdo_fetchall("SELECT id,title,thumb FROM " . tablename("ewei_shop_goods") . " WHERE uniacid = :uniacid and id in (" . $activity["limitgoodids"] . ") ", array(":uniacid" => $_W["uniacid"]));
        }
        if (!empty($goods)) {
            $goodsArr = array_column($goods, "title");
            $goodsStr = implode($goodsArr, ";");
        }
        if (empty($activity)) {
            $activity["activity_start_time"] = date("Y-m-d H:i:s");
            $activity["use_start_time"] = $activity["activity_start_time"];
            $activity["activity_end_time"] = date("Y-m-d H:i:s", time() + 86400 * 7);
            $activity["use_end_time"] = $activity["activity_end_time"];
        } else {
            $activity["activity_start_time"] = date("Y-m-d H:i:s", $activity["activity_start_time"]);
            $activity["activity_end_time"] = date("Y-m-d H:i:s", $activity["activity_end_time"]);
            $activity["use_start_time"] = date("Y-m-d H:i:s", $activity["use_start_time"]);
            $activity["use_end_time"] = date("Y-m-d H:i:s", $activity["use_end_time"]);
        }
        include $this->template("friendcoupon/post");
    }
    public function delete()
    {
        global $_W;
        global $_GPC;
        pdo_update("ewei_shop_friendcoupon", array("deleted" => 1), array("id" => $_GPC["id"]));
        show_json(1, "删除成功!");
    }
    /**
     * 这里停止活动,friendcoupon_data和friendcoupon表里面的状态修改为-1
     */
    public function stop()
    {
        global $_W;
        global $_GPC;
        $activity_id = $_GPC["id"];
        pdo_update("ewei_shop_friendcoupon", array("status" => -1, "stop_time" => time()), array("id" => $activity_id, "uniacid" => $_W["uniacid"]));
        pdo_update("ewei_shop_friendcoupon_data", array("status" => -1), array("uniacid" => $_W["uniacid"], "id" => $activity_id));
        show_json(1, "操作成功");
    }
    private function isCopyLink()
    {
        $queryString = $_SERVER["QUERY_STRING"];
        return strpos($queryString, "friendcoupon.copy") !== false;
    }
}

?>