<?php
if (!defined("IN_IA")) {
    exit("Access Denied");
}
class Index_EweiShopV2Page extends MobileLoginPage
{
    protected function merchData()
    {
        $merch_plugin = p("merch");
        $merch_data = m("common")->getPluginset("merch");
        if ($merch_plugin && $merch_data["is_openmerch"]) {
            $is_openmerch = 1;
        } else {
            $is_openmerch = 0;
        }
        return array("is_openmerch" => $is_openmerch, "merch_plugin" => $merch_plugin, "merch_data" => $merch_data);
    }
    public function main()
    {
        global $_W;
        global $_GPC;
        $openid = $_W["openid"];
        $cateid = trim($_GPC["catid"]);
        $timestamp = time();
        $set = m("common")->getPluginset("coupon");
        if (!empty($set["closecenter"])) {
            header("location: " . mobileUrl("member"));
            exit;
        }
        $merchdata = $this->merchData();
        extract($merchdata);
        $advs = is_array($set["advs"]) ? $set["advs"] : array();
        $shop = m("common")->getSysset("shop");
        $param = array();
        $param[":uniacid"] = $_W["uniacid"];
        $sql = "select * from " . tablename("ewei_shop_coupon_category") . " where uniacid=:uniacid";
        if ($is_openmerch == 0) {
            $sql .= " and merchid=0";
        } else {
            if (!empty($_GPC["merchid"])) {
                $sql .= " and merchid=:merchid";
                $param[":merchid"] = intval($_GPC["merchid"]);
            }
        }
        $sql .= " and status=1 order by displayorder desc";
        $category = pdo_fetchall($sql, $param);
        include $this->template();
    }
    public function getcoupon($cateid)
    {
        global $_W;
        $merchdata = $this->merchData();
        extract($merchdata);
        $time = time();
        $param = array();
        $param[":uniacid"] = $_W["uniacid"];
        $sql = "select id,timelimit,coupontype,timedays,timestart,timeend,couponname,enough,backtype,deduct,discount,backmoney,backcredit,backredpack,bgcolor,thumb,credit,money,getmax,merchid,total as t,tagtitle,settitlecolor,titlecolor  from " . tablename("ewei_shop_coupon");
        $sql .= " where uniacid=:uniacid";
        if ($is_openmerch == 0) {
            $sql .= " and merchid=0";
        } else {
            if (!empty($_GPC["merchid"])) {
                $sql .= " and merchid=:merchid";
                $param[":merchid"] = intval($_GPC["merchid"]);
            }
        }
        $plugin_com = p("commission");
        if ($plugin_com) {
            $plugin_com_set = $plugin_com->getSet();
            if (empty($plugin_com_set["level"])) {
                $sql .= " and ( limitagentlevels = \"\" or  limitagentlevels is null )";
            }
        } else {
            $sql .= " and ( limitagentlevels = \"\" or  limitagentlevels is null )";
        }
        $plugin_globonus = p("globonus");
        if ($plugin_globonus) {
            $plugin_globonus_set = $plugin_globonus->getSet();
            if (empty($plugin_globonus_set["open"])) {
                $sql .= " and ( limitpartnerlevels = \"\"  or  limitpartnerlevels is null )";
            }
        } else {
            $sql .= " and ( limitpartnerlevels = \"\"  or  limitpartnerlevels is null )";
        }
        $plugin_abonus = p("abonus");
        if ($plugin_abonus) {
            $plugin_abonus_set = $plugin_abonus->getSet();
            if (empty($plugin_abonus_set["open"])) {
                $sql .= " and ( limitaagentlevels = \"\" or  limitaagentlevels is null )";
            }
        } else {
            $sql .= " and ( limitaagentlevels = \"\" or  limitaagentlevels is null )";
        }
        $sql .= " and gettype=1 and (total=-1 or total>0) and ( timelimit = 0 or  (timelimit=1 and timeend>unix_timestamp()))";
        if (!empty($cateid)) {
            $sql .= " and catid=" . $cateid;
        }
        $sql .= " order by displayorder desc, id desc ";
        $coupons = set_medias(pdo_fetchall($sql, $param), "thumb");
        if (empty($coupons)) {
            $coupons = array();
        }
        foreach ($coupons as $i => &$row) {
            $row = com("coupon")->setCoupon($row, $time);
            $last = com("coupon")->get_last_count($row["id"]);
            $row["contype"] = 2;
            if ($row["t"] != -1) {
                if ($last <= 0) {
                    $row["last"] = 0;
                    $row["isdisa"] = "1";
                } else {
                    $totle = $row["t"];
                    $row["last"] = $last;
                    $row["lastratio"] = intval($last / $totle * 100);
                }
            } else {
                $row["last"] = 1;
                $row["lastratio"] = 100;
            }
            $title2 = "";
            $title3 = "";
            $title4 = "";
            $tagtitle = "";
            if ($row["coupontype"] == "0") {
                if (0 < $row["enough"]) {
                    $title2 = "满" . (double) $row["enough"] . "元可用";
                } else {
                    $title2 = "无金额门槛";
                }
            } else {
                if ($row["coupontype"] == "1") {
                    if (0 < $row["enough"]) {
                        $title2 = "充值满" . (double) $row["enough"] . "元可用";
                    } else {
                        $title2 = "无金额门槛";
                    }
                }
            }
            if ($row["coupontype"] == "2") {
                if (0 < $row["enough"]) {
                    $title2 = "满" . (double) $row["enough"] . "元可用";
                } else {
                    $title2 = "无金额门槛";
                }
            }
            if ($row["backtype"] == 0) {
                $title3 = "<span class=\"subtitle\">￥</span>" . (double) $row["deduct"];
                if ($row["enough"] == "0") {
                    $title5 = "消费任意金额立减" . (double) $row["deduct"];
                    $row["color"] = "orange ";
                    $tagtitle = "代金券";
                } else {
                    $title5 = "消费满" . (double) $row["enough"] . "立减" . (double) $row["deduct"];
                    $row["color"] = "blue";
                    $tagtitle = "满减券";
                }
            } else {
                if ($row["backtype"] == 1) {
                    $row["color"] = "red ";
                    $title3 = (double) $row["discount"] . "<span class=\"subtitle\"> 折</span> ";
                    $tagtitle = "打折券";
                    if ($row["enough"] == "0") {
                        $title5 = "消费任意金额" . "打" . (double) $row["discount"] . "折";
                    } else {
                        $title5 = "消费满" . (double) $row["enough"] . "打" . (double) $row["discount"] . "折";
                    }
                } else {
                    if ($row["backtype"] == 2) {
                        if ($row["coupontype"] == "0") {
                            $row["color"] = "red ";
                            $tagtitle = "购物返现券";
                        } else {
                            if ($row["coupontype"] == "1") {
                                $row["color"] = "pink ";
                                $tagtitle = "充值返现券";
                            } else {
                                if ($row["coupontype"] == "2") {
                                    $row["color"] = "red ";
                                    $tagtitle = "购物返现券";
                                }
                            }
                        }
                        if ($row["enough"] == "0") {
                            $title5 = "消费任意金额";
                        } else {
                            $title5 = "消费满" . (double) $row["enough"];
                        }
                        if (!empty($row["backmoney"]) && 0 < $row["backmoney"]) {
                            $title3 = "立返";
                            $title5 = $title5 . "立返余额";
                        } else {
                            if (!empty($row["backcredit"]) && 0 < $row["backcredit"]) {
                                $title3 = "立返";
                                $title5 = $title5 . "立返积分";
                            } else {
                                if (!empty($row["backredpack"]) && 0 < $row["backredpack"]) {
                                    $title5 = $title5 . "立返红包";
                                }
                            }
                        }
                    }
                }
            }
            if ($row["tagtitle"] == "") {
                $row["tagtitle"] = $tagtitle;
            }
            if ($row["timestr"] == "0") {
                $title4 = "永久有效";
            } else {
                if ($row["timestr"] == "1") {
                    $title4 = "即" . $row["gettypestr"] . "日内" . $row["timedays"] . "天有效";
                } else {
                    $title4 = $row["timestr"];
                }
            }
            $row["title2"] = $title2;
            $row["title3"] = $title3;
            $row["title4"] = $title4;
            $row["title5"] = $title5;
        }
        unset($row);
        return $coupons;
    }
    public function getwxcard()
    {
        global $_W;
        $merchdata = $this->merchData();
        extract($merchdata);
        $time = time();
        $param = array();
        $param[":uniacid"] = $_W["uniacid"];
        $sql = "select id,card_id,0 as coupontype,card_type, least_cost,reduce_cost,discount,datetype,begin_timestamp,end_timestamp,fixed_term,fixed_begin_term, merchid,title as couponname,logo_url as thumb ,total_quantity as t,quantity as `last`,tagtitle,settitlecolor,titlecolor,islimitlevel, limitmemberlevels,limitagentlevels,limitpartnerlevels,limitaagentlevels  from " . tablename("ewei_shop_wxcard");
        $sql .= " where uniacid=:uniacid";
        if ($is_openmerch == 0) {
            $sql .= " and merchid=0";
        } else {
            if (!empty($_GPC["merchid"])) {
                $sql .= " and merchid=:merchid";
                $param[":merchid"] = intval($_GPC["merchid"]);
            }
        }
        $plugin_com = p("commission");
        if ($plugin_com) {
            $plugin_com_set = $plugin_com->getSet();
            if (empty($plugin_com_set["level"])) {
                $sql .= " and ( limitagentlevels = \"\" or  limitagentlevels is null )";
            }
        } else {
            $sql .= " and ( limitagentlevels = \"\" or  limitagentlevels is null )";
        }
        $plugin_globonus = p("globonus");
        if ($plugin_globonus) {
            $plugin_globonus_set = $plugin_globonus->getSet();
            if (empty($plugin_globonus_set["open"])) {
                $sql .= " and ( limitpartnerlevels = \"\"  or  limitpartnerlevels is null )";
            }
        } else {
            $sql .= " and ( limitpartnerlevels = \"\"  or  limitpartnerlevels is null )";
        }
        $plugin_abonus = p("abonus");
        if ($plugin_abonus) {
            $plugin_abonus_set = $plugin_abonus->getSet();
            if (empty($plugin_abonus_set["open"])) {
                $sql .= " and ( limitaagentlevels = \"\" or  limitaagentlevels is null )";
            }
        } else {
            $sql .= " and ( limitaagentlevels = \"\" or  limitaagentlevels is null )";
        }
        $sql .= " and gettype=1 and quantity>0 and ( datetype = 'DATE_TYPE_FIX_TERM' or  (datetype='DATE_TYPE_FIX_TIME_RANGE' and end_timestamp>unix_timestamp()))";
        if (!empty($cateid)) {
            $sql .= " and catid=" . $cateid;
        }
        $sql .= " order by displayorder desc, id desc ";
        $wxcard = pdo_fetchall($sql, $param);
        if (empty($wxcard)) {
            $wxcard = array();
        }
        $hascommission = false;
        $plugin_com = p("commission");
        if ($plugin_com) {
            $plugin_com_set = $plugin_com->getSet();
            $hascommission = !empty($plugin_com_set["level"]);
        }
        $hasglobonus = false;
        $plugin_globonus = p("globonus");
        if ($plugin_globonus) {
            $plugin_globonus_set = $plugin_globonus->getSet();
            $hasglobonus = !empty($plugin_globonus_set["open"]);
        }
        $hasabonus = false;
        $plugin_abonus = p("abonus");
        if ($plugin_abonus) {
            $plugin_abonus_set = $plugin_abonus->getSet();
            $hasabonus = !empty($plugin_abonus_set["open"]);
        }
        foreach ($wxcard as $i => &$row) {
            $limitmemberlevels = explode(",", $row["limitmemberlevels"]);
            $limitagentlevels = explode(",", $row["limitagentlevels"]);
            $limitpartnerlevels = explode(",", $row["limitpartnerlevels"]);
            $limitaagentlevels = explode(",", $row["limitaagentlevels"]);
            $pass = false;
            if ($row["islimitlevel"] == 1) {
                $openid = trim($_W["openid"]);
                $member = m("member")->getMember($openid);
                if (!empty($row["limitmemberlevels"]) || $row["limitmemberlevels"] == "0") {
                    $shop = $_W["shopset"]["shop"];
                    if (in_array($member["level"], $limitmemberlevels)) {
                        $pass = true;
                    }
                }
                if ((!empty($row["limitagentlevels"]) || $row["limitagentlevels"] == "0") && $hascommission && $member["isagent"] == "1" && $member["status"] == "1" && in_array($member["agentlevel"], $limitagentlevels)) {
                    $pass = true;
                }
                if ((!empty($row["limitpartnerlevels"]) || $row["limitpartnerlevels"] == "0") && $hasglobonus && $member["ispartner"] == "1" && $member["partnerstatus"] == "1" && in_array($member["partnerlevel"], $limitpartnerlevels)) {
                    $pass = true;
                }
                if ((!empty($row["limitaagentlevels"]) || $row["limitaagentlevels"] == "0") && $hasabonus && $member["isaagent"] == "1" && $member["aagentstatus"] == "1" && in_array($member["aagentlevel"], $limitaagentlevels)) {
                    $pass = true;
                }
            } else {
                $pass = true;
            }
            $row["pass"] = $pass;
            $row["contype"] = 1;
            $totle = $row["t"];
            $last = $row["last"];
            $row["lastratio"] = intval($last / $totle * 100);
            $title2 = "";
            $title3 = "";
            $title4 = "";
            $tagtitle = "";
            if ($row["coupontype"] == "0") {
                if (0 < $row["least_cost"]) {
                    $title2 = "满" . (double) $row["least_cost"] / 100 . "元可用";
                } else {
                    $title2 = "无金额门槛";
                }
            }
            if ($row["card_type"] == "CASH") {
                $title3 = "<span class=\"subtitle\">￥</span>" . (double) $row["reduce_cost"] / 100;
                if (empty($row["least_cost"])) {
                    $title5 = "消费任意金额立减" . (double) $row["deduct"];
                    $row["color"] = "orange ";
                    $tagtitle = "代金券";
                } else {
                    $title5 = "消费满" . (double) $row["least_cost"] / 100 . "立减" . (double) $row["reduce_cost"] / 100;
                    $row["color"] = "blue";
                    $tagtitle = "满减券";
                }
            }
            if ($row["card_type"] == "DISCOUNT") {
                $discount = (double) (100 - intval($row["discount"])) / 10;
                $row["color"] = "red ";
                $title3 = $discount . "<span class=\"subtitle\"> 折</span> ";
                $tagtitle = "打折券";
                $title5 = "消费任意金额" . "打" . $discount . "折";
            }
            if ($row["tagtitle"] == "") {
                $row["tagtitle"] = $tagtitle;
            }
            if ($row["datetype"] == "DATE_TYPE_FIX_TIME_RANGE") {
                $title4 = date("Y.m.d", $row["begin_timestamp"]) . "-" . date("Y.m.d", $row["end_timestamp"]);
            } else {
                if ($row["datetype"] == "DATE_TYPE_FIX_TERM") {
                    if (empty($row["fixed_begin_term"])) {
                        $begin = "当日生效";
                    } else {
                        $begin = "内" . $row["fixed_begin_term"] . "生效,";
                    }
                    $title4 = "即领取日" . $begin . $row["fixed_term"] . "天有效";
                }
            }
            $row["title2"] = $title2;
            $row["title3"] = $title3;
            $row["title4"] = $title4;
            $row["title5"] = $title5;
        }
        unset($row);
        $wxcardlist = array();
        foreach ($wxcard as $row) {
            if (!empty($row["pass"])) {
                $wxcardlist[] = $row;
            }
        }
        return $wxcardlist;
    }
    public function getlist()
    {
        global $_W;
        global $_GPC;
        $cateid = trim($_GPC["cateid"]);
        $coupons = $this->getcoupon($cateid);
        $wxcard = $this->getwxcard($cateid);
        $cards = array_merge($wxcard, $coupons);
        $pindex = max(1, intval($_GPC["page"]));
        $psize = 10;
        $cardslist = array();
        for ($i = 0; $i < count($cards); $i++) {
            if (($pindex - 1) * $psize <= $i && $i < $pindex * $psize) {
                $cardslist[] = $cards[$i];
            }
        }
        show_json(1, array("list" => $cardslist, "pagesize" => $psize, "total" => count($cards)));
    }
    public function getsignature()
    {
        global $_W;
        global $_GPC;
        $timestamp = time() + "";
        $nonce_str = random(16) + "";
        $card_id = $_GPC["card_id"];
        $openid = $_GPC["openid"];
        $code = empty($_GPC["code"]) ? "" : $_GPC["code"];
        $signature = com("wxcard")->getsignature($card_id, $timestamp, $nonce_str, $openid, $code);
        $arr = array("code" => $code, "openid" => $openid, "timestamp" => $timestamp, "nonce_str" => $nonce_str, "signature" => $signature);
        show_json(1, array("cardExt" => json_encode($arr)));
    }
    public function updateQuantity()
    {
        global $_W;
        global $_GPC;
        $cardList = $_GPC["cardList"];
        if ($cardList && !is_array($cardList)) {
            $cardList = json_decode($cardList, true);
        }
        sleep(5);
        foreach ($cardList as $card) {
            if ($card && !is_array($card)) {
                $card = json_decode($card, true);
            }
            if (com("wxcard")) {
                com("wxcard")->wxCardUpdateQuantity($card["cardId"]);
            }
        }
        show_json(1);
    }
}

?>