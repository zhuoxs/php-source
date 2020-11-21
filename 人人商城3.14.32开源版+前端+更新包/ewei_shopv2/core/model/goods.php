<?php

if (!defined("IN_IA")) {
    exit("Access Denied");
}
class Goods_EweiShopV2Model
{
    /**
     * 获取商品规格
     * @param type $goodsid
     * @param type $optionid
     * @return type
     */
    public function getOption($goodsid = 0, $optionid = 0)
    {
        global $_W;
        return pdo_fetch("select * from " . tablename("ewei_shop_goods_option") . " where id=:id and goodsid=:goodsid and uniacid=:uniacid Limit 1", array(":id" => $optionid, ":uniacid" => $_W["uniacid"], ":goodsid" => $goodsid));
    }
    /**
     * 获取商品规格的价格
     * @param type $goodsid
     * @param type $optionid
     * @return type
     */
    public function getOptionPirce($goodsid = 0, $optionid = 0)
    {
        global $_W;
        return pdo_fetchcolumn("select marketprice from " . tablename("ewei_shop_goods_option") . " where id=:id and goodsid=:goodsid and uniacid=:uniacid", array(":id" => $optionid, ":uniacid" => $_W["uniacid"], ":goodsid" => $goodsid));
    }
    /**
     * 获取宝贝
     * @param type $page
     * @param type $pagesize
     */
    public function getList($args = array())
    {
        global $_W;
        $openid = $_W["openid"];
        $page = !empty($args["page"]) ? intval($args["page"]) : 1;
        $pagesize = !empty($args["pagesize"]) ? intval($args["pagesize"]) : 10;
        $random = !empty($args["random"]) ? $args["random"] : false;
        $displayorder = "displayorder";
        $merchid = !empty($args["merchid"]) ? trim($args["merchid"]) : "";
        if (!empty($merchid)) {
            $displayorder = "merchdisplayorder";
        }
        $order = !empty($args["order"]) ? $args["order"] : " " . $displayorder . " desc,createtime desc";
        $orderby = empty($args["order"]) ? "" : (!empty($args["by"]) ? $args["by"] : "");
        $merch_plugin = p("merch");
        $merch_data = m("common")->getPluginset("merch");
        if ($merch_plugin && $merch_data["is_openmerch"]) {
            $is_openmerch = 1;
        } else {
            $is_openmerch = 0;
        }
        $condition = "`uniacid` = :uniacid AND `deleted` = 0 and status=1";
        $params = array(":uniacid" => $_W["uniacid"]);
        if (!empty($args["from"]) && $args["from"] == "miniprogram") {
            $condition .= " and type <> 4";
        }
        if (!empty($merchid)) {
            $condition .= " and merchid=:merchid and checked=0";
            $params[":merchid"] = $merchid;
        } else {
            if ($is_openmerch == 0) {
                $condition .= " and `merchid` = 0";
            } else {
                $condition .= " and `checked` = 0";
            }
        }
        if (empty($args["type"])) {
            $condition .= " and type !=10 ";
        } else {
            $condition .= " and type = " . $args["type"];
        }
        $ids = !empty($args["ids"]) ? trim($args["ids"]) : "";
        if (!empty($ids)) {
            $condition .= " and id in ( " . $ids . ")";
        }
        $isnew = !empty($args["isnew"]) ? 1 : 0;
        if (!empty($isnew)) {
            $condition .= " and isnew=1";
        }
        $ishot = !empty($args["ishot"]) ? 1 : 0;
        if (!empty($ishot)) {
            $condition .= " and ishot=1";
        }
        $isrecommand = !empty($args["isrecommand"]) ? 1 : 0;
        if (!empty($isrecommand)) {
            $condition .= " and isrecommand=1";
        }
        $isdiscount = !empty($args["isdiscount"]) ? 1 : 0;
        if (!empty($isdiscount)) {
            $condition .= " and isdiscount=1";
        }
        $issendfree = !empty($args["issendfree"]) ? 1 : 0;
        if (!empty($issendfree)) {
            $condition .= " and issendfree=1";
        }
        $istime = !empty($args["istime"]) ? 1 : 0;
        if (!empty($istime)) {
            $condition .= " and istime=1 ";
        }
        if (isset($args["nocommission"])) {
            $condition .= " AND `nocommission`=" . intval($args["nocommission"]);
        }
        $keywords = !empty($args["keywords"]) ? $args["keywords"] : "";
        if (!empty($keywords)) {
            $condition .= " AND (`title` LIKE :keywords OR `keywords` LIKE :keywords)";
            $params[":keywords"] = "%" . trim($keywords) . "%";
            if (empty($merchid)) {
                $condition .= " AND nosearch=0";
            }
        }
        if (isset($args["minprice"]) && isset($args["maxprice"]) && $args["minprice"] != "" && $args["maxprice"] != "") {
            $condition .= " AND marketprice BETWEEN :pricestart AND :priceend";
            $params[":pricestart"] = $args["minprice"];
            $params[":priceend"] = $args["maxprice"];
        }
        if (!empty($args["cate"])) {
            $category = m("shop")->getAllCategory();
            $catearr = array($args["cate"]);
            foreach ($category as $index => $row) {
                if ($row["parentid"] == $args["cate"]) {
                    $catearr[] = $row["id"];
                    foreach ($category as $ind => $ro) {
                        if ($ro["parentid"] == $row["id"]) {
                            $catearr[] = $ro["id"];
                        }
                    }
                }
            }
            $catearr = array_unique($catearr);
            $condition .= " AND ( ";
            foreach ($catearr as $key => $value) {
                if ($key == 0) {
                    $condition .= "FIND_IN_SET(" . $value . ",cates)";
                } else {
                    $condition .= " || FIND_IN_SET(" . $value . ",cates)";
                }
            }
            $condition .= " <>0 )";
        }
        $member = m("member")->getMember($openid);
        if ($args["ispc"] == 1) {
        } else {
            if (!empty($member)) {
                $levelid = intval($member["level"]);
                $groupid = trim($member["groupid"]);
                $condition .= " and ( ifnull(showlevels,'')='' or FIND_IN_SET( " . $levelid . ",showlevels)<>0 ) ";
                if (strpos($groupid, ",") !== false) {
                    $groupidArr = explode(",", $groupid);
                    $groupidStr = "";
                    foreach ($groupidArr as $grk => $grv) {
                        $groupidStr .= "INSTR( showgroups,'" . $grv . "')<>0 or ";
                        if ($grk == count($groupidArr) - 1) {
                            $groupidStr .= "INSTR( showgroups,'" . $grv . "')<>0 ";
                        }
                    }
                    $condition .= "and ( ifnull(showgroups,'')='' or  " . $groupidStr . " )";
                } else {
                    $condition .= " and ( ifnull(showgroups,'')='' or FIND_IN_SET( '" . $groupid . "',showgroups)<>0 ) ";
                }
            } else {
                $condition .= " and ifnull(showlevels,'')='' ";
                $condition .= " and   ifnull(showgroups,'')='' ";
            }
        }
        $condition .= " and type <> 99 ";
        $total = "";
        $officsql = "";
        if (p("offic")) {
            $officsql = ",officthumb";
        }
        if (!$random) {
            $sql = "SELECT id,title,subtitle,thumb,thumb_url" . $officsql . ",marketprice,productprice,minprice,maxprice,isdiscount,isdiscount_time,isdiscount_discounts,sales,salesreal,total,description,bargain,`type`,ispresell,`virtual`,hasoption,video,bargain,hascommission,nocommission,commission,commission1_rate,commission1_pay,presellprice,buylevels,buygroups\r\n            FROM " . tablename("ewei_shop_goods") . " where  " . $condition . " ORDER BY " . $order . " " . $orderby . " LIMIT " . ($page - 1) * $pagesize . "," . $pagesize;
            $total = pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_goods") . " where  " . $condition . " ", $params);
        } else {
            $sql = "SELECT id,title,thumb,thumb_url" . $officsql . ",marketprice,productprice,minprice,maxprice,isdiscount,isdiscount_time,isdiscount_discounts,sales,salesreal,total,description,bargain,`type`,ispresell,`virtual`,hasoption,bargain,hascommission,nocommission,commission,commission1_rate,commission1_pay,presellprice,buylevels,buygroups\r\n            FROM " . tablename("ewei_shop_goods") . " where  " . $condition . " ORDER BY rand() LIMIT " . $pagesize;
            $total = $pagesize;
        }
        $level = $this->getLevel($_W["openid"]);
        $set = $this->getSet();
        $list = pdo_fetchall($sql, $params);
        $levelid = intval($member["level"]);
        $groupid = intval($member["groupid"]);
        foreach ($list as $lk => $lv) {
            if ($lv["ispresell"] == 1) {
                $list[$lk]["minprice"] = $lv["presellprice"];
            }
            $list[$lk]["levelbuy"] = "1";
            if ($lv["buylevels"] != "") {
                $buylevels = explode(",", $lv["buylevels"]);
                if (!in_array($levelid, $buylevels)) {
                    $list[$lk]["levelbuy"] = 0;
                    $list[$lk]["canbuy"] = false;
                }
            }
            $list[$lk]["groupbuy"] = "1";
            if ($lv["buygroups"] != "" && !empty($groupid)) {
                $buygroups = explode(",", $lv["buygroups"]);
                $groupids = explode(",", $groupid);
                $intersect = array_intersect($groupids, $buygroups);
                if (empty($intersect)) {
                    $list[$lk]["groupbuy"] = 0;
                    $list[$lk]["canbuy"] = false;
                }
            }
            if ($lv["hasoption"] == 1) {
                $pricemax = array();
                $options = pdo_fetchall("select * from " . tablename("ewei_shop_goods_option") . " where goodsid=:goodsid and                               uniacid=:uniacid order by displayorder asc", array(":goodsid" => $lv["id"], ":uniacid" => $_W["uniacid"]));
                foreach ($options as $k => $v) {
                    array_push($pricemax, $v["marketprice"]);
                }
            }
            if ($lv["nocommission"] == 0) {
                if (p("seckill") && p("seckill")->getSeckill($lv["id"])) {
                    continue;
                }
                if (0 < $lv["bargain"]) {
                    continue;
                }
                $list[$lk]["seecommission"] = $this->getCommission($lv, $level, $set);
                if (0 < $list[$lk]["seecommission"]) {
                    $list[$lk]["seecommission"] = round($list[$lk]["seecommission"], 2);
                }
                $list[$lk]["cansee"] = $set["cansee"];
                $list[$lk]["seetitle"] = $set["seetitle"];
            } else {
                $list[$lk]["seecommission"] = 0;
                $list[$lk]["cansee"] = $set["cansee"];
                $list[$lk]["seetitle"] = $set["seetitle"];
            }
            if ($lv["type"] == 3) {
                $vsql = "SELECT * FROM " . tablename("ewei_shop_virtual_type") . " WHERE uniacid = " . intval($_W["uniacid"]) . " AND id = " . intval($lv["virtual"]);
                $vData = pdo_fetch($vsql);
                if ($vData["recycled"] == 1) {
                    array_splice($list, $lk, 1);
                }
            }
            if (empty($lv["isdiscount"]) || $lv["isdiscount_time"] < time()) {
                if (isset($options) && 0 < count($options) && $lv["hasoption"]) {
                    $optionids = array();
                    foreach ($options as $val) {
                        $optionids[] = $val["id"];
                    }
                    $sql = "update " . tablename("ewei_shop_goods") . " g set\r\n        g.minprice = (select min(marketprice) from " . tablename("ewei_shop_goods_option") . " where goodsid = " . $lv["id"] . "),\r\n        g.maxprice = (select max(marketprice) from " . tablename("ewei_shop_goods_option") . " where goodsid = " . $lv["id"] . ")\r\n        where g.id = " . $lv["id"] . " and g.hasoption=1";
                    pdo_query($sql);
                } else {
                    $sql = "update " . tablename("ewei_shop_goods") . " set minprice = marketprice,maxprice = marketprice where id = " . $lv["id"] . " and hasoption=0;";
                    pdo_query($sql);
                }
                $goods_price = pdo_fetch("select minprice,maxprice from " . tablename("ewei_shop_goods") . " where id=:id and uniacid=:uniacid limit 1", array(":id" => $lv["id"], ":uniacid" => $_W["uniacid"]));
                $list[$lk]["maxprice"] = (double) $goods_price["maxprice"];
                $list[$lk]["minprice"] = (double) $goods_price["minprice"];
            }
        }
        $list = set_medias($list, "thumb");
        array_walk($list, function (&$goods) {
            if ($goods["ispresell"] == 1 && $goods["presellprice"] < $goods["minprice"]) {
                $goods["minprice"] = $goods["presellprice"];
            }
        });
        return array("list" => $list, "total" => $total);
    }
    /**
     * 计算出此商品的佣金
     * @param type $goodsid
     * @return type
     */
    public function getCommission($goods, $level, $set)
    {
        global $_W;
        $commission = 0;
        if ($level == "false") {
            return $commission;
        }
        if (!empty($goods) && $goods["hasoption"]) {
            $option = pdo_fetchall("select * from " . tablename("ewei_shop_goods_option") . " where goodsid=:goodsid and uniacid=:uniacid order by displayorder asc", array(":goodsid" => $goods["id"], ":uniacid" => $_W["uniacid"]));
        }
        if ($goods["hascommission"] == 1) {
            $price = $goods["maxprice"];
            $levelid = "default";
            if ($level) {
                $levelid = "level" . $level["id"];
            }
            $goods_commission = !empty($goods["commission"]) ? json_decode($goods["commission"], true) : array();
            if ($goods_commission["type"] == 0) {
                $commission = 1 <= $set["level"] ? 0 < $goods["commission1_rate"] ? $goods["commission1_rate"] * $goods["marketprice"] / 100 : $goods["commission1_pay"] : 0;
            } else {
                if (!empty($option)) {
                    $price_all = array();
                    foreach ($goods_commission[$levelid] as $key => $value) {
                        foreach ($option as $k => $v) {
                            $optioncommission = 0;
                            if ("option" . $v["id"] == $key) {
                                if (strexists($value[0], "%")) {
                                    $optioncommission = floatval(str_replace("%", "", $value[0]) / 100) * $v["marketprice"];
                                } else {
                                    $optioncommission = $value[0];
                                }
                                array_push($price_all, $optioncommission);
                            }
                        }
                    }
                    if ($price_all) {
                        $commission = max($price_all);
                    } else {
                        $commission = 0;
                    }
                } else {
                    $price_all = array();
                    foreach ($goods_commission[$levelid] as $key => $value) {
                        foreach ($value as $k => $v) {
                            if (strexists($v, "%")) {
                                array_push($price_all, floatval(str_replace("%", "", $v) / 100) * $price);
                                continue;
                            }
                            array_push($price_all, $v);
                        }
                    }
                    if ($price_all) {
                        $commission = max($price_all);
                    } else {
                        $commission = 0;
                    }
                }
            }
        } else {
            if ($level != "false" && !empty($level)) {
                if ($goods["marketprice"] <= 0) {
                    $goods["marketprice"] = $goods["maxprice"];
                }
                $commission = 1 <= $set["level"] ? round($level["commission1"] * $goods["marketprice"] / 100, 2) : 0;
            } else {
                if ($goods["marketprice"] <= 0) {
                    $goods["marketprice"] = $goods["maxprice"];
                }
                $commission = 1 <= $set["level"] ? round($set["commission1"] * $goods["marketprice"] / 100, 2) : 0;
            }
        }
        return $commission;
    }
    public function getLevel($openid)
    {
        global $_W;
        $level = "false";
        if (empty($openid)) {
            return $level;
        }
        $member = m("member")->getMember($openid);
        if (empty($member["isagent"]) || $member["status"] == 0 || $member["agentblack"] == 1) {
            return $level;
        }
        $level = pdo_fetch("select * from " . tablename("ewei_shop_commission_level") . " where uniacid=:uniacid and id=:id limit 1", array(":uniacid" => $_W["uniacid"], ":id" => $member["agentlevel"]));
        return $level;
    }
    public function getSet()
    {
        $set = m("common")->getPluginset("commission");
        $set["texts"] = array("agent" => empty($set["texts"]["agent"]) ? "分销商" : $set["texts"]["agent"], "shop" => empty($set["texts"]["shop"]) ? "小店" : $set["texts"]["shop"], "myshop" => empty($set["texts"]["myshop"]) ? "我的小店" : $set["texts"]["myshop"], "center" => empty($set["texts"]["center"]) ? "分销中心" : $set["texts"]["center"], "become" => empty($set["texts"]["become"]) ? "成为分销商" : $set["texts"]["become"], "withdraw" => empty($set["texts"]["withdraw"]) ? "提现" : $set["texts"]["withdraw"], "commission" => empty($set["texts"]["commission"]) ? "佣金" : $set["texts"]["commission"], "commission1" => empty($set["texts"]["commission1"]) ? "分销佣金" : $set["texts"]["commission1"], "commission_total" => empty($set["texts"]["commission_total"]) ? "累计佣金" : $set["texts"]["commission_total"], "commission_ok" => empty($set["texts"]["commission_ok"]) ? "可提现佣金" : $set["texts"]["commission_ok"], "commission_apply" => empty($set["texts"]["commission_apply"]) ? "已申请佣金" : $set["texts"]["commission_apply"], "commission_check" => empty($set["texts"]["commission_check"]) ? "待打款佣金" : $set["texts"]["commission_check"], "commission_lock" => empty($set["texts"]["commission_lock"]) ? "未结算佣金" : $set["texts"]["commission_lock"], "commission_detail" => empty($set["texts"]["commission_detail"]) ? "提现明细" : ($set["texts"]["commission_detail"] == "佣金明细" ? "提现明细" : $set["texts"]["commission_detail"]), "commission_pay" => empty($set["texts"]["commission_pay"]) ? "成功提现佣金" : $set["texts"]["commission_pay"], "commission_wait" => empty($set["texts"]["commission_wait"]) ? "待收货佣金" : $set["texts"]["commission_wait"], "commission_fail" => empty($set["texts"]["commission_fail"]) ? "无效佣金" : $set["texts"]["commission_fail"], "commission_charge" => empty($set["texts"]["commission_charge"]) ? "扣除提现手续费" : $set["texts"]["commission_charge"], "order" => empty($set["texts"]["order"]) ? "分销订单" : $set["texts"]["order"], "c1" => empty($set["texts"]["c1"]) ? "一级" : $set["texts"]["c1"], "c2" => empty($set["texts"]["c2"]) ? "二级" : $set["texts"]["c2"], "c3" => empty($set["texts"]["c3"]) ? "三级" : $set["texts"]["c3"], "mydown" => empty($set["texts"]["mydown"]) ? "我的下线" : $set["texts"]["mydown"], "down" => empty($set["texts"]["down"]) ? "下线" : $set["texts"]["down"], "up" => empty($set["texts"]["up"]) ? "推荐人" : $set["texts"]["up"], "yuan" => empty($set["texts"]["yuan"]) ? "元" : $set["texts"]["yuan"], "icode" => empty($set["texts"]["icode"]) ? "邀请码" : $set["texts"]["icode"]);
        return $set;
    }
    /**
     * 获取宝贝
     * @param type $page
     * @param type $pagesize
     */
    public function getListbyCoupon($args = array())
    {
        global $_W;
        $openid = $_W["openid"];
        $page = !empty($args["page"]) ? intval($args["page"]) : 1;
        $pagesize = !empty($args["pagesize"]) ? intval($args["pagesize"]) : 10;
        $random = !empty($args["random"]) ? $args["random"] : false;
        $order = !empty($args["order"]) ? $args["order"] : " displayorder desc,createtime desc";
        $orderby = empty($args["order"]) ? "" : (!empty($args["by"]) ? $args["by"] : "");
        $couponid = empty($args["couponid"]) ? "" : $args["couponid"];
        $merch_plugin = p("merch");
        $merch_data = m("common")->getPluginset("merch");
        if ($merch_plugin && $merch_data["is_openmerch"]) {
            $is_openmerch = 1;
        } else {
            $is_openmerch = 0;
        }
        $condition = " and g.`uniacid` = :uniacid AND g.`deleted` = 0 and g.status=1";
        $params = array(":uniacid" => $_W["uniacid"]);
        $merchid = !empty($args["merchid"]) ? trim($args["merchid"]) : "";
        if (!empty($merchid)) {
            $condition .= " and g.merchid=:merchid and g.checked=0";
            $params[":merchid"] = $merchid;
        } else {
            if ($is_openmerch == 0) {
                $condition .= " and g.`merchid` = 0";
            } else {
                $condition .= " and g.`checked` = 0";
            }
        }
        if (empty($args["type"])) {
            $condition .= " and g.type !=10 ";
        }
        $ids = !empty($args["ids"]) ? trim($args["ids"]) : "";
        if (!empty($ids)) {
            $condition .= " and g.id in ( " . $ids . ")";
        }
        $isnew = !empty($args["isnew"]) ? 1 : 0;
        if (!empty($isnew)) {
            $condition .= " and g.isnew=1";
        }
        $ishot = !empty($args["ishot"]) ? 1 : 0;
        if (!empty($ishot)) {
            $condition .= " and g.ishot=1";
        }
        $isrecommand = !empty($args["isrecommand"]) ? 1 : 0;
        if (!empty($isrecommand)) {
            $condition .= " and g.isrecommand=1";
        }
        $isdiscount = !empty($args["isdiscount"]) ? 1 : 0;
        if (!empty($isdiscount)) {
            $condition .= " and g.isdiscount=1";
        }
        $issendfree = !empty($args["issendfree"]) ? 1 : 0;
        if (!empty($issendfree)) {
            $condition .= " and g.issendfree=1";
        }
        $istime = !empty($args["istime"]) ? 1 : 0;
        if (!empty($istime)) {
            $condition .= " and g.istime=1 ";
        }
        if (isset($args["nocommission"])) {
            $condition .= " AND g.`nocommission`=" . intval($args["nocommission"]);
        }
        $keywords = !empty($args["keywords"]) ? $args["keywords"] : "";
        if (!empty($keywords)) {
            $condition .= " AND (g.`title` LIKE :keywords OR g.`keywords` LIKE :keywords)";
            $params[":keywords"] = "%" . trim($keywords) . "%";
        }
        if (!empty($args["cate"])) {
            $category = m("shop")->getAllCategory();
            $catearr = array($args["cate"]);
            foreach ($category as $index => $row) {
                if ($row["parentid"] == $args["cate"]) {
                    $catearr[] = $row["id"];
                    foreach ($category as $ind => $ro) {
                        if ($ro["parentid"] == $row["id"]) {
                            $catearr[] = $ro["id"];
                        }
                    }
                }
            }
            $catearr = array_unique($catearr);
            $condition .= " AND ( ";
            foreach ($catearr as $key => $value) {
                if ($key == 0) {
                    $condition .= "FIND_IN_SET(" . $value . ",g.cates)";
                } else {
                    $condition .= " || FIND_IN_SET(" . $value . ",g.cates)";
                }
            }
            $condition .= " <>0 )";
        }
        $member = m("member")->getMember($openid);
        if (!empty($member)) {
            $levelid = intval($member["level"]);
            if (!empty($member["groupid"])) {
                $groupid = explode(",", $member["groupid"]);
                foreach ($groupid as $gid) {
                    $groupid_condition = " or FIND_IN_SET('" . $gid . "',g.showgroups)";
                }
            } else {
                $groupid_condition = "";
            }
            $condition .= " and ( ifnull(g.showlevels,'')='' or FIND_IN_SET( " . $levelid . ",g.showlevels)<>0 ) ";
            $condition .= " and ( ifnull(g.showgroups,'')='' " . $groupid_condition . " ) ";
        } else {
            $condition .= " and ifnull(g.showlevels,'')='' ";
            $condition .= " and ifnull(g.showgroups,'')='' ";
        }
        $table = tablename("ewei_shop_goods") . " g";
        if (0 < $couponid) {
            $data = pdo_fetch("select c.*  from " . tablename("ewei_shop_coupon_data") . "  cd inner join  " . tablename("ewei_shop_coupon") . " c on cd.couponid = c.id  where cd.id=:id and cd.uniacid=:uniacid and coupontype =0  limit 1", array(":id" => $couponid, ":uniacid" => $_W["uniacid"]));
            if (!empty($data)) {
                $i = 0;
                $condition2 = "";
                if ($data["limitgoodcatetype"] == 1 && !empty($data["limitgoodcateids"])) {
                    $limitcateids = explode(",", $data["limitgoodcateids"]);
                    if (0 < count($limitcateids)) {
                        foreach ($limitcateids as $cateid) {
                            $i++;
                            if (1 < $i) {
                                $condition2 .= " or ";
                            }
                            $condition2 .= " FIND_IN_SET(" . $cateid . ",g.cates)";
                        }
                    }
                }
                if ($data["limitgoodtype"] == 1 && !empty($data["limitgoodids"])) {
                    $i++;
                    if (1 < $i) {
                        $condition2 .= " or ";
                    }
                    $condition2 .= "  g.id in (" . $data["limitgoodids"] . ") ";
                }
                if (!empty($condition2)) {
                    $condition .= "and (" . $condition2 . ") ";
                }
            }
        }
        if (!$random) {
            $sql = "SELECT  g.*  FROM " . $table . " where 1 " . $condition . " ORDER BY " . $order . " " . $orderby . " LIMIT " . ($page - 1) * $pagesize . "," . $pagesize;
            $total = pdo_fetchcolumn("select  count(*) from " . $table . " where 1 " . $condition . " ", $params);
        } else {
            $sql = "SELECT  g.*  FROM " . $table . " where 1 " . $condition . " ORDER BY rand() LIMIT " . $pagesize;
            $total = $pagesize;
        }
        $list = pdo_fetchall($sql, $params);
        $list = set_medias($list, "thumb");
        return array("list" => $list, "total" => $total);
    }
    public function getTotals()
    {
        global $_W;
        return array("sale" => pdo_fetchcolumn("select count(1) from " . tablename("ewei_shop_goods") . " where status > 0 and checked=0 and deleted=0 and total>0 and  type !=30 and uniacid=:uniacid", array(":uniacid" => $_W["uniacid"])), "out" => pdo_fetchcolumn("select count(1) from " . tablename("ewei_shop_goods") . " where status > 0 and deleted=0 and total=0 and type !=30 and uniacid=:uniacid", array(":uniacid" => $_W["uniacid"])), "stock" => pdo_fetchcolumn("select count(1) from " . tablename("ewei_shop_goods") . " where (status=0 or checked=1) and deleted=0 and uniacid=:uniacid and type !=30", array(":uniacid" => $_W["uniacid"])), "cycle" => pdo_fetchcolumn("select count(1) from " . tablename("ewei_shop_goods") . " where deleted=1 and uniacid=:uniacid and type !=30", array(":uniacid" => $_W["uniacid"])), "verify" => pdo_fetchcolumn("select count(1) from " . tablename("ewei_shop_goods") . " where deleted=0  and uniacid=:uniacid and type !=30 and merchid>0 and checked=1", array(":uniacid" => $_W["uniacid"])));
    }
    /**
     * 获取宝贝评价
     * @param type $page
     * @param type $pagesize
     */
    public function getComments($goodsid = "0", $args = array())
    {
        global $_W;
        $page = !empty($args["page"]) ? intval($args["page"]) : 1;
        $pagesize = !empty($args["pagesize"]) ? intval($args["pagesize"]) : 10;
        $condition = " and `uniacid` = :uniacid AND `goodsid` = :goodsid and deleted=0";
        $params = array(":uniacid" => $_W["uniacid"], ":goodsid" => $goodsid);
        $sql = "SELECT id,nickname,headimgurl,content,images FROM " . tablename("ewei_shop_goods_comment") . " where 1 " . $condition . " ORDER BY createtime desc LIMIT " . ($page - 1) * $pagesize . "," . $pagesize;
        $list = pdo_fetchall($sql, $params);
        foreach ($list as &$row) {
            $row["images"] = set_medias(unserialize($row["images"]));
        }
        unset($row);
        return $list;
    }
    public function isFavorite($id = "")
    {
        global $_W;
        $count = pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_member_favorite") . " where goodsid=:goodsid and deleted=0 and openid=:openid and uniacid=:uniacid limit 1", array(":goodsid" => $id, ":openid" => $_W["openid"], ":uniacid" => $_W["uniacid"]));
        return 0 < $count;
    }
    public function addHistory($goodsid = 0)
    {
        global $_W;
        pdo_query("update " . tablename("ewei_shop_goods") . " set viewcount=viewcount+1 where id=:id and uniacid='" . $_W[uniacid] . "' ", array(":id" => $goodsid));
        $history = pdo_fetch("select id,times from " . tablename("ewei_shop_member_history") . " where goodsid=:goodsid and uniacid=:uniacid and openid=:openid limit 1", array(":goodsid" => $goodsid, ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"]));
        if (empty($history)) {
            $history = array("uniacid" => $_W["uniacid"], "openid" => $_W["openid"], "goodsid" => $goodsid, "deleted" => 0, "createtime" => time(), "times" => 1);
            pdo_insert("ewei_shop_member_history", $history);
        } else {
            pdo_update("ewei_shop_member_history", array("deleted" => 0, "times" => $history["times"] + 1), array("id" => $history["id"]));
        }
    }
    public function getCartCount($isnewstore = 0)
    {
        global $_W;
        global $_GPC;
        $paras = array(":uniacid" => $_W["uniacid"]);
        $paras[":openid"] = $_W["openid"];
        $sqlcondition = "";
        if ($isnewstore != 0) {
            $sqlcondition = " and isnewstore=:isnewstore";
            $paras[":isnewstore"] = $isnewstore;
        }
        $count = pdo_fetchcolumn("select sum(total) from " . tablename("ewei_shop_member_cart") . " where uniacid=:uniacid and openid=:openid " . $sqlcondition . " and deleted=0 limit 1", $paras);
        return $count;
    }
    /**
     * 获取商品规格图片
     * @param type $specs
     * @return type
     */
    public function getSpecThumb($specs)
    {
        global $_W;
        $thumb = "";
        $cartspecs = explode("_", $specs);
        $specid = $cartspecs[0];
        if (!empty($specid)) {
            $spec = pdo_fetch("select thumb from " . tablename("ewei_shop_goods_spec_item") . " " . " where id=:id and uniacid=:uniacid limit 1 ", array(":id" => $specid, ":uniacid" => $_W["uniacid"]));
            if (!empty($spec) && !empty($spec["thumb"])) {
                $thumb = $spec["thumb"];
            }
        }
        return $thumb;
    }
    /**
     * 获取商品规格图片
     * @param type $specs
     * @return type
     */
    public function getOptionThumb($goodsid = 0, $optionid = 0)
    {
        global $_W;
        $thumb = "";
        $option = $this->getOption($goodsid, $optionid);
        if (!empty($option)) {
            $specs = $option["specs"];
            $thumb = $this->getSpecThumb($specs);
        }
        return $thumb;
    }
    public function getAllMinPrice($goods)
    {
        global $_W;
        if (is_array($goods)) {
            $openid = $_W["openid"];
            $level = m("member")->getLevel($openid);
            $member = m("member")->getMember($openid);
            $levelid = $member["level"];
            foreach ($goods as &$value) {
                $minprice = $value["minprice"];
                $maxprice = $value["maxprice"];
                if ($value["isdiscount"] && time() <= $value["isdiscount_time"]) {
                    $value["oldmaxprice"] = $maxprice;
                    $isdiscount_discounts = json_decode($value["isdiscount_discounts"], true);
                    $prices = array();
                    if (!isset($isdiscount_discounts["type"]) || empty($isdiscount_discounts["type"])) {
                        $prices_array = m("order")->getGoodsDiscountPrice($value, $level, 1);
                        $prices[] = $prices_array["price"];
                    } else {
                        $goods_discounts = m("order")->getGoodsDiscounts($value, $isdiscount_discounts, $levelid);
                        $prices = $goods_discounts["prices"];
                    }
                    $minprice = min($prices);
                    $maxprice = max($prices);
                }
                $value["minprice"] = $minprice;
                $value["maxprice"] = $maxprice;
            }
            unset($value);
        } else {
            $goods = array();
        }
        return $goods;
    }
    public function getOneMinPrice($goods)
    {
        $goods = array($goods);
        $res = $this->getAllMinPrice($goods);
        return $res[0];
    }
    public function getMemberPrice($goods, $level)
    {
        global $_W;
        global $_GPC;
        if (!empty($goods["isnodiscount"])) {
            return NULL;
        }
        $liveid = intval($_GPC["liveid"]);
        if (!empty($liveid)) {
            $isliving = p("live")->isLiving($liveid);
            if (!$isliving) {
                $liveid = 0;
            }
        }
        $levelBak = $level;
        if (!empty($level["id"])) {
            $level = pdo_fetch("select * from " . tablename("ewei_shop_member_level") . " where id=:id and uniacid=:uniacid and enabled=1 limit 1", array(":id" => $level["id"], ":uniacid" => $_W["uniacid"]));
            $level = empty($level) ? $levelBak : $level;
        }
        $discounts = json_decode($goods["discounts"], true);
        if (empty($goods["discounts"]) && 0 < $goods["merchid"]) {
            $goods["discounts"] = array("type" => "0", "default" => "", "default_pay" => "");
            if (!empty($level)) {
                $goods["discounts"]["level" . $level["id"]] = "";
                $goods["discounts"]["level" . $level["id"] . "_pay"] = "";
            }
            $discounts = $goods["discounts"];
        }
        if (is_array($discounts)) {
            $key = !empty($level["id"]) ? "level" . $level["id"] : "default";
            if (!isset($discounts["type"]) || empty($discounts["type"])) {
                $memberprice = $goods["minprice"];
                if (!empty($discounts[$key])) {
                    $dd = floatval($discounts[$key]);
                    if (0 < $dd && $dd < 10) {
                        $memberprice = round($dd / 10 * $goods["minprice"], 2);
                    }
                } else {
                    $dd = floatval($discounts[$key . "_pay"]);
                    $md = floatval($level["discount"]);
                    if (!empty($dd)) {
                        $memberprice = round($dd, 2);
                    } else {
                        if (0 < $md && $md < 10) {
                            $memberprice = round($md / 10 * $goods["minprice"], 2);
                        }
                    }
                }
                if ($memberprice == $goods["minprice"]) {
                    return false;
                }
                return $memberprice;
            }
            $options = m("goods")->getOptions($goods);
            $marketprice = array();
            foreach ($options as $option) {
                $discount = trim($discounts[$key]["option" . $option["id"]]);
                if ($discount == "") {
                    $discount = round(floatval($level["discount"]) * 10, 2) . "%";
                }
                if (!empty($liveid) && !empty($option["islive"]) && 0 < $option["liveprice"] && $option["liveprice"] < $option["marketprice"]) {
                    $option["marketprice"] = $option["liveprice"];
                }
                $optionprice = m("order")->getFormartDiscountPrice($discount, $option["marketprice"]);
                $marketprice[] = $optionprice;
            }
            $minprice = min($marketprice);
            $maxprice = max($marketprice);
            $memberprice = array("minprice" => (double) $minprice, "maxprice" => (double) $maxprice);
            if ($memberprice["minprice"] < $memberprice["maxprice"]) {
                $memberprice = $memberprice["minprice"] . "~" . $memberprice["maxprice"];
            } else {
                $memberprice = $memberprice["minprice"];
            }
            if ($memberprice == $goods["minprice"]) {
                return false;
            }
            return $memberprice;
        }
    }
    public function getOptions($goods)
    {
        global $_W;
        $id = $goods["id"];
        $specs = false;
        $options = false;
        if (!empty($goods) && $goods["hasoption"]) {
            $specs = pdo_fetchall("select* from " . tablename("ewei_shop_goods_spec") . " where goodsid=:goodsid and uniacid=:uniacid order by displayorder asc", array(":goodsid" => $id, ":uniacid" => $_W["uniacid"]));
            foreach ($specs as &$spec) {
                $spec["items"] = pdo_fetchall("select * from " . tablename("ewei_shop_goods_spec_item") . " where specid=:specid order by displayorder asc", array(":specid" => $spec["id"]));
            }
            unset($spec);
            $options = pdo_fetchall("select * from " . tablename("ewei_shop_goods_option") . " where goodsid=:goodsid and uniacid=:uniacid order by displayorder asc", array(":goodsid" => $id, ":uniacid" => $_W["uniacid"]));
        }
        if (0 < $goods["ispresell"] && ($goods["preselltimeend"] == 0 || time() < $goods["preselltimeend"])) {
            foreach ($options as &$val) {
                $val["marketprice"] = $val["presellprice"];
            }
            unset($val);
        }
        return $options;
    }
    /**
     * 商品访问权限
     * @param array $goods
     * @param array $member
     * @return int
     */
    public function visit($goods = array(), $member = array())
    {
        global $_W;
        if (empty($goods)) {
            return 1;
        }
        if (empty($member)) {
            $member = m("member")->getMember($_W["openid"]);
        }
        $showlevels = $goods["showlevels"] != "" ? explode(",", $goods["showlevels"]) : array();
        $showgroups = $goods["showgroups"] != "" ? $goods["showgroups"] : "";
        $showgoods = 0;
        $isShow = false;
        if (empty($showgroups) != true) {
            $showgroupsArr = explode(",", $showgroups);
        }
        if (empty($member["groupid"])) {
            $member["groupid"] = 0;
        }
        if (count($showgroupsArr) == 0) {
            $showgroupsArr = array();
        }
        if (strpos($member["groupid"], ",") !== false || strpos($showgroups, ",") !== false) {
            $groupidArr = explode(",", $member["groupid"]);
            foreach ($groupidArr as $grk => $grv) {
                if (in_array($grv, $showgroupsArr)) {
                    $isShow = true;
                }
            }
        } else {
            if (strpos($showgroups, $member["groupid"]) !== false) {
                $isShow = true;
            }
        }
        if (!empty($member)) {
            if (!empty($showlevels) && in_array($member["level"], $showlevels) || !empty($showgroups) && $isShow || empty($showlevels) && empty($showgroups)) {
                $showgoods = 1;
            }
        } else {
            if (empty($showlevels) && empty($showgroups)) {
                $showgoods = 1;
            }
        }
        return $showgoods;
    }
    /**
     *
     * 是否已经有重复购买的商品
     * @param $goods
     * @return bool
     */
    public function canBuyAgain($goods)
    {
        global $_W;
        $condition = "";
        $id = $goods["id"];
        if (isset($goods["goodsid"])) {
            $id = $goods["goodsid"];
        }
        if (empty($goods["buyagain_islong"])) {
            $condition = " AND canbuyagain = 1";
        }
        $order_goods = pdo_fetchall("SELECT id,orderid FROM " . tablename("ewei_shop_order_goods") . " WHERE uniacid=:uniaicd AND openid=:openid AND goodsid=:goodsid " . $condition, array(":uniaicd" => $_W["uniacid"], ":openid" => $_W["openid"], ":goodsid" => $id), "orderid");
        if (empty($order_goods)) {
            return false;
        }
        $order = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename("ewei_shop_order") . " WHERE uniacid=:uniaicd AND status>=:status AND id IN (" . implode(",", array_keys($order_goods)) . ")", array(":uniaicd" => $_W["uniacid"], ":status" => empty($goods["buyagain_condition"]) ? "1" : "3"));
        return !empty($order);
    }
    /**
     * 使用掉重复购买的变量
     * @param $goods
     */
    public function useBuyAgain($orderid)
    {
        global $_W;
        $order_goods = pdo_fetchall("SELECT id,goodsid FROM " . tablename("ewei_shop_order_goods") . " WHERE uniacid=:uniaicd AND openid=:openid AND canbuyagain = 1 AND orderid <> :orderid", array(":uniaicd" => $_W["uniacid"], ":openid" => $_W["openid"], "orderid" => $orderid), "goodsid");
        if (empty($order_goods)) {
            return false;
        }
        pdo_query("UPDATE " . tablename("ewei_shop_order_goods") . " SET `canbuyagain`='0' WHERE uniacid=:uniacid AND goodsid IN (" . implode(",", array_keys($order_goods)) . ")", array(":uniacid" => $_W["uniacid"]));
    }
    public function getTaskGoods($openid, $goodsid, $rank, $log_id = 0, $join_id = 0, $optionid = 0, $total = 0)
    {
        global $_W;
        $is_task_goods = 0;
        $is_task_goods_option = 0;
        if (!empty($join_id)) {
            $task_plugin = p("task");
            $flag = 1;
        } else {
            if (!empty($log_id)) {
                $task_plugin = p("lottery");
                $flag = 2;
            }
        }
        $param = array();
        $param["openid"] = $openid;
        $param["goods_id"] = $goodsid;
        $param["rank"] = $rank;
        $param["join_id"] = $join_id;
        $param["log_id"] = $log_id;
        $param["goods_spec"] = $optionid;
        $param["goods_num"] = $total;
        if ($task_plugin && (!empty($join_id) || !empty($log_id))) {
            $task_goods = $task_plugin->getGoods($param);
        }
        if (!empty($task_goods) && empty($total) && (!empty($join_id) || !empty($log_id))) {
            if (!empty($task_goods["spec"])) {
                foreach ($task_goods["spec"] as $k => $v) {
                    if (empty($v["total"])) {
                        unset($task_goods["spec"][$k]);
                        continue;
                    }
                    if (!empty($optionid)) {
                        if ($k == $optionid) {
                            $task_goods["marketprice"] = $v["marketprice"];
                            $task_goods["total"] = $v["total"];
                        } else {
                            unset($task_goods["spec"][$k]);
                        }
                    }
                    if (!empty($optionid) && $k != $optionid) {
                        unset($task_goods["spec"][$k]);
                    } else {
                        if (!empty($optionid) && $k != $optionid) {
                            $task_goods["marketprice"] = $v["marketprice"];
                            $task_goods["total"] = $v["total"];
                        }
                    }
                }
                if (!empty($task_goods["spec"])) {
                    $is_task_goods = $flag;
                    $is_task_goods_option = 1;
                }
            } else {
                if (!empty($task_goods["total"])) {
                    $is_task_goods = $flag;
                }
            }
        }
        $data = array();
        $data["is_task_goods"] = $is_task_goods;
        $data["is_task_goods_option"] = $is_task_goods_option;
        $data["task_goods"] = $task_goods;
        return $data;
    }
    public function wholesaleprice($goods)
    {
        $goods2 = array();
        foreach ($goods as $good) {
            if ($good["type"] == 4) {
                if (empty($goods2[$good["goodsid"]])) {
                    $intervalprices = array();
                    if (0 < $good["intervalfloor"]) {
                        $intervalprices[] = array("intervalnum" => intval($good["intervalnum1"]), "intervalprice" => floatval($good["intervalprice1"]));
                    }
                    if (1 < $good["intervalfloor"]) {
                        $intervalprices[] = array("intervalnum" => intval($good["intervalnum2"]), "intervalprice" => floatval($good["intervalprice2"]));
                    }
                    if (2 < $good["intervalfloor"]) {
                        $intervalprices[] = array("intervalnum" => intval($good["intervalnum3"]), "intervalprice" => floatval($good["intervalprice3"]));
                    }
                    $goods2[$good["goodsid"]] = array("goodsid" => $good["goodsid"], "total" => $good["total"], "intervalfloor" => $good["intervalfloor"], "intervalprice" => $intervalprices);
                } else {
                    $goods2[$good["goodsid"]]["total"] += $good["total"];
                }
            }
        }
        foreach ($goods2 as $good2) {
            $intervalprices2 = iunserializer($good2["intervalprice"]);
            $price = 0;
            foreach ($intervalprices2 as $intervalprice) {
                if ($intervalprice["intervalnum"] <= $good2["total"]) {
                    $price = $intervalprice["intervalprice"];
                }
            }
            foreach ($goods as &$good) {
                if ($good["goodsid"] == $good2["goodsid"]) {
                    $good["wholesaleprice"] = $price;
                    $good["goodsalltotal"] = $good2["total"];
                }
            }
            unset($good);
        }
        return $goods;
    }
    public function createcode($parameter)
    {
        global $_W;
        $path = IA_ROOT . "/addons/ewei_shopv2/data/goodscode/" . $_W["uniacid"] . "/";
        $goodsid = $parameter["goodsid"];
        $qrcode = $parameter["qrcode"];
        $data = $parameter["codedata"];
        $mid = $parameter["mid"];
        $codeshare = $parameter["codeshare"];
        if (!is_dir($path)) {
            load()->func("file");
            mkdirs($path);
        }
        $md5 = md5(json_encode(array("uniacid" => $_W["uniacid"], "goodsid" => $goodsid, "title" => $data["title"]["text"], "price" => $data["price"]["text"], "codeshare" => $parameter["codeshare"], "codedata" => $data, "mid" => $mid)));
        $file = $md5 . ".jpg";
        if (!is_file($path . $file)) {
            set_time_limit(0);
            @ini_set("memory_limit", "256M");
            if ($codeshare == 1) {
                $target = imagecreatetruecolor(640, 1060);
                $color = imagecolorAllocate($target, 255, 255, 255);
                imagefill($target, 0, 0, $color);
                imagecopy($target, $target, 0, 0, 0, 0, 640, 1060);
                $target = $this->mergeText($target, $data["shopname"], $data["shopname"]["text"]);
                $thumb = preg_replace("/\\/0\$/i", "/96", $data["portrait"]["thumb"]);
                $target = $this->mergeImage($target, $data["portrait"], $thumb);
                $thumb = preg_replace("/\\/0\$/i", "/96", $data["thumb"]["thumb"]);
                $target = $this->mergeImage($target, $data["thumb"], $thumb);
                $qrcode = preg_replace("/\\/0\$/i", "/96", $data["qrcode"]["thumb"]);
                $target = $this->mergeImage($target, $data["qrcode"], $qrcode);
                $target = $this->mergeText($target, $data["title"], $data["title"]["text"]);
                $target = $this->mergeText($target, $data["price"], $data["price"]["text"]);
                $target = $this->mergeText($target, $data["desc"], $data["desc"]["text"]);
                imagepng($target, $path . $file);
                imagedestroy($target);
            }
            if ($codeshare == 2) {
                $target = imagecreatetruecolor(640, 640);
                $color = imagecolorAllocate($target, 255, 255, 255);
                imagefill($target, 0, 0, $color);
                $colorline = imagecolorallocate($target, 0, 0, 0);
                imageline($target, 0, 190, 640, 190, $colorline);
                $red = imagecolorallocate($target, 254, 155, 68);
                imagefilledrectangle($target, 0, 560, 640, 640, $red);
                imagecopy($target, $target, 0, 0, 0, 0, 640, 640);
                $thumb = preg_replace("/\\/0\$/i", "/96", $data["thumb"]["thumb"]);
                $target = $this->mergeImage($target, $data["thumb"], $thumb);
                $target = $this->mergeText($target, $data["title"], $data["title"]["text"]);
                $target = $this->mergeText($target, $data["price"], $data["price"]["text"]);
                $qrcode = preg_replace("/\\/0\$/i", "/96", $data["qrcode"]["thumb"]);
                $target = $this->mergeImage($target, $data["qrcode"], $qrcode);
                $target = $this->mergeText($target, $data["desc"], $data["desc"]["text"]);
                $target = $this->mergeText($target, $data["shopname"], $data["shopname"]["text"], true);
                imagepng($target, $path . $file);
                imagedestroy($target);
            } else {
                if ($codeshare == 3) {
                    $target = imagecreatetruecolor(640, 1060);
                    $color = imagecolorAllocate($target, 245, 244, 249);
                    imagefill($target, 0, 0, $color);
                    imagecopy($target, $target, 0, 0, 0, 0, 640, 1008);
                    $target = $this->mergeText($target, $data["title"], $data["title"]["text"]);
                    $target = $this->mergeText($target, $data["price"], $data["price"]["text"]);
                    $target = $this->mergeText($target, $data["desc"], $data["desc"]["text"]);
                    $thumb = preg_replace("/\\/0\$/i", "/96", $data["thumb"]["thumb"]);
                    $target = $this->mergeImage($target, $data["thumb"], $thumb);
                    $qrcode = preg_replace("/\\/0\$/i", "/96", $data["qrcode"]["thumb"]);
                    $target = $this->mergeImage($target, $data["qrcode"], $qrcode);
                    imagepng($target, $path . $file);
                    imagedestroy($target);
                }
            }
        }
        $img = $_W["siteroot"] . "addons/ewei_shopv2/data/goodscode/" . $_W["uniacid"] . "/" . $file;
        return $img;
    }
    public function createImage($imgurl)
    {
        global $_W;
        ini_set("memory_limit", "-1");
        if (strpos($imgurl, str_replace(array("https://", "http://"), "", $_W["siteroot"])) !== 0) {
            load()->func("communication");
            $resp = ihttp_request($imgurl);
            if ($resp["code"] == 200 && !empty($resp["content"])) {
                return imagecreatefromstring($resp["content"]);
            }
            for ($i = 0; $i < 3; $i++) {
                $resp = ihttp_request($imgurl);
                if ($resp["code"] == 200 && !empty($resp["content"])) {
                    return imagecreatefromstring($resp["content"]);
                }
            }
            return "";
        }
        $count = str_replace($_W["siteroot"], IA_ROOT . "/", $imgurl);
        $imgurl = file_get_contents($count);
        return imagecreatefromstring($imgurl);
    }
    public function mergeImage($target, $data, $imgurl)
    {
        $img = $this->createImage($imgurl);
        $w = imagesx($img);
        $h = imagesy($img);
        imagecopyresized($target, $img, $data["left"], $data["top"], 0, 0, $data["width"], $data["height"], $w, $h);
        imagedestroy($img);
        return $target;
    }
    public function mergeText($target, $data, $text, $center = false)
    {
        $font = IA_ROOT . "/addons/ewei_shopv2/static/fonts/msyh.ttf";
        $colors = $this->hex2rgb($data["color"]);
        $color = imagecolorallocate($target, $colors["red"], $colors["green"], $colors["blue"]);
        if ($center) {
            $fontBox = imagettfbbox($data["size"], 0, $font, $data["text"]);
            imagettftext($target, $data["size"], 0, ceil(($data["width"] - $fontBox[2]) / 2), $data["top"] + $data["size"], $color, $font, $text);
        } else {
            imagettftext($target, $data["size"], 0, $data["left"], $data["top"] + $data["size"], $color, $font, $text);
        }
        return $target;
    }
    public function hex2rgb($colour)
    {
        if ($colour[0] == "#") {
            $colour = substr($colour, 1);
        }
        if (strlen($colour) == 6) {
            list($r, $g, $b) = array($colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5]);
        } else {
            if (strlen($colour) == 3) {
                list($r, $g, $b) = array($colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2]);
            } else {
                return false;
            }
        }
        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
        return array("red" => $r, "green" => $g, "blue" => $b);
    }
}

?>