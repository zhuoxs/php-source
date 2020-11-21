<?php

if (!defined("IN_IA")) {
    exit("Access Denied");
}
define("TM_COMMISSION_AGENT_NEW", "TM_COMMISSION_AGENT_NEW");
define("TM_COMMISSION_ORDER_PAY", "TM_COMMISSION_ORDER_PAY");
define("TM_COMMISSION_ORDER_FINISH", "TM_COMMISSION_ORDER_FINISH");
define("TM_COMMISSION_APPLY", "TM_COMMISSION_APPLY");
define("TM_COMMISSION_APPLYMONEY", "TM_COMMISSION_APPLYMONEY");
define("TM_COMMISSION_CHECK", "TM_COMMISSION_CHECK");
define("TM_COMMISSION_PAY", "TM_COMMISSION_PAY");
define("TM_COMMISSION_UPGRADE", "TM_COMMISSION_UPGRADE");
define("TM_COMMISSION_BECOME", "TM_COMMISSION_BECOME");
if (!class_exists("CommissionModel")) {
    class CommissionModel extends PluginModel
    {
        public function getSet($uniacid = 0)
        {
            $set = parent::getSet($uniacid);
            $tradeSet = m("common")->getSysset("trade");
            $moneytext = isset($tradeSet["moneytext"]) ? trim($tradeSet["moneytext"]) : "余额";
            $set["texts"] = array("agent" => empty($set["texts"]["agent"]) ? "分销商" : $set["texts"]["agent"], "shop" => empty($set["texts"]["shop"]) ? "小店" : $set["texts"]["shop"], "myshop" => empty($set["texts"]["myshop"]) ? "我的小店" : $set["texts"]["myshop"], "center" => empty($set["texts"]["center"]) ? "分销中心" : $set["texts"]["center"], "become" => empty($set["texts"]["become"]) ? "成为分销商" : $set["texts"]["become"], "withdraw" => empty($set["texts"]["withdraw"]) ? "提现" : $set["texts"]["withdraw"], "commission" => empty($set["texts"]["commission"]) ? "佣金" : $set["texts"]["commission"], "commission1" => empty($set["texts"]["commission1"]) ? "分销佣金" : $set["texts"]["commission1"], "commission_total" => empty($set["texts"]["commission_total"]) ? "累计佣金" : $set["texts"]["commission_total"], "commission_ok" => empty($set["texts"]["commission_ok"]) ? "可提现佣金" : $set["texts"]["commission_ok"], "commission_apply" => empty($set["texts"]["commission_apply"]) ? "已申请佣金" : $set["texts"]["commission_apply"], "commission_check" => empty($set["texts"]["commission_check"]) ? "待打款佣金" : $set["texts"]["commission_check"], "commission_lock" => empty($set["texts"]["commission_lock"]) ? "未结算佣金" : $set["texts"]["commission_lock"], "commission_detail" => empty($set["texts"]["commission_detail"]) ? "提现明细" : ($set["texts"]["commission_detail"] == "佣金明细" ? "提现明细" : $set["texts"]["commission_detail"]), "commission_pay" => empty($set["texts"]["commission_pay"]) ? "成功提现佣金" : $set["texts"]["commission_pay"], "commission_wait" => empty($set["texts"]["commission_wait"]) ? "待收货佣金" : $set["texts"]["commission_wait"], "commission_fail" => empty($set["texts"]["commission_fail"]) ? "无效佣金" : $set["texts"]["commission_fail"], "commission_charge" => empty($set["texts"]["commission_charge"]) ? "扣除提现手续费" : $set["texts"]["commission_charge"], "order" => empty($set["texts"]["order"]) ? "分销订单" : $set["texts"]["order"], "c1" => empty($set["texts"]["c1"]) ? "一级" : $set["texts"]["c1"], "c2" => empty($set["texts"]["c2"]) ? "二级" : $set["texts"]["c2"], "c3" => empty($set["texts"]["c3"]) ? "三级" : $set["texts"]["c3"], "mydown" => empty($set["texts"]["mydown"]) ? "我的下线" : $set["texts"]["mydown"], "down" => empty($set["texts"]["down"]) ? "下线" : $set["texts"]["down"], "up" => empty($set["texts"]["up"]) ? "推荐人" : $set["texts"]["up"], "yuan" => empty($set["texts"]["yuan"]) ? "元" : $set["texts"]["yuan"], "icode" => empty($set["texts"]["icode"]) ? "邀请码" : $set["texts"]["icode"], "moneytext" => $moneytext);
            return $set;
        }
        /**
         * 计算订单商品的佣金，及下单时候上级分晓商登记
         * @global type $_W
         * @param type $order_goods
         * @return type
         */
        public function calculate($orderid = 0, $update = true, $order_agentid = NULL)
        {
            global $_W;
            $set = $this->getSet();
            $levels = $this->getLevels();
            $order = pdo_fetch("select agentid,price,goodsprice,deductcredit2,discountprice,isdiscountprice,dispatchprice,changeprice,ispackage,packageid,couponprice,buyagainprice,deductprice,deductenough,merchdeductenough,grprice from " . tablename("ewei_shop_order") . " where id=:id limit 1", array(":id" => $orderid));
            $commission = m("common")->getPluginset("commission");
            if (empty($commission["commissiontype"])) {
                $rate = 1;
            } else {
                $numm = $order["goodsprice"] - $order["isdiscountprice"] - $order["discountprice"] - $order["couponprice"] - $order["buyagainprice"];
                if ($numm != 0) {
                    $rate = ($order["price"] - $order["changeprice"] - $order["dispatchprice"] + $order["deductcredit2"]) / $numm;
                } else {
                    $rate = 1;
                }
            }
            $agentid = !is_null($order_agentid) ? $order_agentid : $order["agentid"];
            $hascommission = false;
            if ($order["isparent"] && $order["parentid"] == 0) {
                $parent_sql = "select id from " . tablename("ewei_shop_order") . "where parentid=" . $orderid;
                $condition = " WHERE  og.uniacid=:uniacid";
                $param[":uniacid"] = $_W["uniacid"];
                $condition .= " AND og.orderid in(" . $parent_sql . ")";
                $goods_sql = "select og.id,og.realprice,og.total,g.hasoption,og.goodsid,og.optionid,g.hascommission,g.nocommission, g.commission1_rate,g.commission1_pay,g.commission2_rate,g.commission2_pay,\r\n          g.commission3_rate,g.commission3_pay,g.commission,og.commissions,og.seckill,og.seckill_taskid,og.seckill_timeid from " . tablename("ewei_shop_order_goods") . "  og " . " left join " . tablename("ewei_shop_goods") . " g on g.id = og.goodsid " . $condition;
                $goods = pdo_fetchall($goods_sql, $param);
            } else {
                $goods = pdo_fetchall("select og.id,og.realprice,og.total,g.hasoption,og.goodsid,og.optionid,g.hascommission,g.nocommission, g.commission1_rate,g.commission1_pay,g.commission2_rate,g.commission2_pay,\r\n                  g.commission3_rate,g.commission3_pay,g.commission,og.commissions,og.seckill,og.seckill_taskid,og.seckill_timeid from " . tablename("ewei_shop_order_goods") . "  og " . " left join " . tablename("ewei_shop_goods") . " g on g.id = og.goodsid" . " where og.orderid=:orderid and og.uniacid=:uniacid", array(":orderid" => $orderid, ":uniacid" => $_W["uniacid"]));
            }
            $real_pay_price = false;
            if (1 < count($goods) && $commission["commissiontype"] == 1 && 0 < $order["couponprice"]) {
                $real_pay_price = true;
            }
            $single_default = false;
            if (count($goods) == 1 && empty($commission["commissiontype"]) && 0 < $order["couponprice"]) {
                $single_default = true;
            }
            if (0 < $set["level"]) {
                foreach ($goods as &$cinfo) {
                    if ($real_pay_price) {
                        $order_discount = $order["deductprice"] + $order["deductcredit2"] + $order["deductenough"] + $order["merchdeductenough"] + $order["couponprice"];
                        $goods_discount = round($order_discount * $cinfo["realprice"] / ($order["goodsprice"] - $order["isdiscountprice"]), 2);
                        $cinfo["realprice"] = $cinfo["realprice"] - $goods_discount;
                    }
                    if ($single_default) {
                        $cinfo["realprice"] = $cinfo["realprice"] + $order["couponprice"];
                    }
                    $price = $cinfo["realprice"] * $rate;
                    $seckill_goods = false;
                    if ($cinfo["seckill"]) {
                        $seckill_goods = pdo_fetch("select commission1,commission2,commission3 from " . tablename("ewei_shop_seckill_task_goods") . "\r\n                                            where  goodsid=:goodsid and optionid =:optionid and taskid=:taskid and timeid=:timeid and uniacid=:uniacid limit 1", array(":goodsid" => $cinfo["goodsid"], ":optionid" => $cinfo["optionid"], ":taskid" => $cinfo["seckill_taskid"], ":timeid" => $cinfo["seckill_timeid"], ":uniacid" => $_W["uniacid"]));
                    }
                    if (!empty($seckill_goods)) {
                        $hascommission = true;
                        $cinfo["commission1"] = array("default" => 1 <= $set["level"] ? $seckill_goods["commission1"] * $cinfo["total"] : 0);
                        $cinfo["commission2"] = array("default" => 2 <= $set["level"] ? $seckill_goods["commission2"] * $cinfo["total"] : 0);
                        $cinfo["commission3"] = array("default" => 3 <= $set["level"] ? $seckill_goods["commission3"] * $cinfo["total"] : 0);
                        foreach ($levels as $level) {
                            $cinfo["commission1"]["level" . $level["id"]] = $seckill_goods["commission1"] * $cinfo["total"];
                            $cinfo["commission2"]["level" . $level["id"]] = $seckill_goods["commission2"] * $cinfo["total"];
                            $cinfo["commission3"]["level" . $level["id"]] = $seckill_goods["commission3"] * $cinfo["total"];
                        }
                    } else {
                        $goods_commission = !empty($cinfo["commission"]) ? json_decode($cinfo["commission"], true) : "";
                        if (empty($cinfo["nocommission"])) {
                            $hascommission = true;
                            if ($cinfo["hascommission"] == 1) {
                                if (empty($goods_commission["type"])) {
                                    $cinfo["commission1"] = array("default" => 1 <= $set["level"] ? 0 < $cinfo["commission1_rate"] ? round($cinfo["commission1_rate"] * $price / 100, 2) . "" : round($cinfo["commission1_pay"] * $cinfo["total"], 2) : 0);
                                    $cinfo["commission2"] = array("default" => 2 <= $set["level"] ? 0 < $cinfo["commission2_rate"] ? round($cinfo["commission2_rate"] * $price / 100, 2) . "" : round($cinfo["commission2_pay"] * $cinfo["total"], 2) : 0);
                                    $cinfo["commission3"] = array("default" => 3 <= $set["level"] ? 0 < $cinfo["commission3_rate"] ? round($cinfo["commission3_rate"] * $price / 100, 2) . "" : round($cinfo["commission3_pay"] * $cinfo["total"], 2) : 0);
                                    foreach ($levels as $level) {
                                        $cinfo["commission1"]["level" . $level["id"]] = 0 < $cinfo["commission1_rate"] ? round($cinfo["commission1_rate"] * $price / 100, 2) . "" : round($cinfo["commission1_pay"] * $cinfo["total"], 2);
                                        $cinfo["commission2"]["level" . $level["id"]] = 0 < $cinfo["commission2_rate"] ? round($cinfo["commission2_rate"] * $price / 100, 2) . "" : round($cinfo["commission2_pay"] * $cinfo["total"], 2);
                                        $cinfo["commission3"]["level" . $level["id"]] = 0 < $cinfo["commission3_rate"] ? round($cinfo["commission3_rate"] * $price / 100, 2) . "" : round($cinfo["commission3_pay"] * $cinfo["total"], 2);
                                    }
                                } else {
                                    if (empty($cinfo["hasoption"])) {
                                        $temp_price = array();
                                        for ($i = 0; $i < $set["level"]; $i++) {
                                            if (!empty($goods_commission["default"]["option0"][$i])) {
                                                if (strexists($goods_commission["default"]["option0"][$i], "%")) {
                                                    $dd = floatval(str_replace("%", "", $goods_commission["default"]["option0"][$i]));
                                                    if (0 < $dd && $dd < 100) {
                                                        $temp_price[$i] = round($dd / 100 * $price, 2);
                                                    } else {
                                                        $temp_price[$i] = 0;
                                                    }
                                                } else {
                                                    $temp_price[$i] = round($goods_commission["default"]["option0"][$i] * $cinfo["total"], 2);
                                                }
                                            }
                                        }
                                        $cinfo["commission1"] = array("default" => 1 <= $set["level"] ? $temp_price[0] : 0);
                                        $cinfo["commission2"] = array("default" => 2 <= $set["level"] ? $temp_price[1] : 0);
                                        $cinfo["commission3"] = array("default" => 3 <= $set["level"] ? $temp_price[2] : 0);
                                        foreach ($levels as $level) {
                                            $temp_price = array();
                                            for ($i = 0; $i < $set["level"]; $i++) {
                                                if (!empty($goods_commission["level" . $level["id"]]["option0"][$i])) {
                                                    if (strexists($goods_commission["level" . $level["id"]]["option0"][$i], "%")) {
                                                        $dd = floatval(str_replace("%", "", $goods_commission["level" . $level["id"]]["option0"][$i]));
                                                        if (0 < $dd && $dd < 100) {
                                                            $temp_price[$i] = round($dd / 100 * $price, 2);
                                                        } else {
                                                            $temp_price[$i] = 0;
                                                        }
                                                    } else {
                                                        $temp_price[$i] = round($goods_commission["level" . $level["id"]]["option0"][$i] * $cinfo["total"], 2);
                                                    }
                                                }
                                            }
                                            list($cinfo["commission1"]["level" . $level["id"]], $cinfo["commission2"]["level" . $level["id"]], $cinfo["commission3"]["level" . $level["id"]]) = $temp_price;
                                        }
                                    } else {
                                        $temp_price = array();
                                        for ($i = 0; $i < $set["level"]; $i++) {
                                            if (!empty($goods_commission["default"]["option" . $cinfo["optionid"]][$i])) {
                                                if (strexists($goods_commission["default"]["option" . $cinfo["optionid"]][$i], "%")) {
                                                    $dd = floatval(str_replace("%", "", $goods_commission["default"]["option" . $cinfo["optionid"]][$i]));
                                                    if (0 < $dd && $dd < 100) {
                                                        $temp_price[$i] = round($dd / 100 * $price, 2);
                                                    } else {
                                                        $temp_price[$i] = 0;
                                                    }
                                                } else {
                                                    $temp_price[$i] = round($goods_commission["default"]["option" . $cinfo["optionid"]][$i] * $cinfo["total"], 2);
                                                }
                                            }
                                        }
                                        $cinfo["commission1"] = array("default" => 1 <= $set["level"] ? $temp_price[0] : 0);
                                        $cinfo["commission2"] = array("default" => 2 <= $set["level"] ? $temp_price[1] : 0);
                                        $cinfo["commission3"] = array("default" => 3 <= $set["level"] ? $temp_price[2] : 0);
                                        foreach ($levels as $level) {
                                            $temp_price = array();
                                            for ($i = 0; $i < $set["level"]; $i++) {
                                                if (!empty($goods_commission["level" . $level["id"]]["option" . $cinfo["optionid"]][$i])) {
                                                    if (strexists($goods_commission["level" . $level["id"]]["option" . $cinfo["optionid"]][$i], "%")) {
                                                        $dd = floatval(str_replace("%", "", $goods_commission["level" . $level["id"]]["option" . $cinfo["optionid"]][$i]));
                                                        if (0 < $dd && $dd < 100) {
                                                            $temp_price[$i] = round($dd / 100 * $price, 2);
                                                        } else {
                                                            $temp_price[$i] = 0;
                                                        }
                                                    } else {
                                                        $temp_price[$i] = round($goods_commission["level" . $level["id"]]["option" . $cinfo["optionid"]][$i] * $cinfo["total"], 2);
                                                    }
                                                }
                                            }
                                            list($cinfo["commission1"]["level" . $level["id"]], $cinfo["commission2"]["level" . $level["id"]], $cinfo["commission3"]["level" . $level["id"]]) = $temp_price;
                                        }
                                    }
                                }
                            } else {
                                $cinfo["commission1"] = array("default" => 1 <= $set["level"] ? round($set["commission1"] * $price / 100, 2) . "" : 0);
                                $cinfo["commission2"] = array("default" => 2 <= $set["level"] ? round($set["commission2"] * $price / 100, 2) . "" : 0);
                                $cinfo["commission3"] = array("default" => 3 <= $set["level"] ? round($set["commission3"] * $price / 100, 2) . "" : 0);
                                foreach ($levels as $level) {
                                    $cinfo["commission1"]["level" . $level["id"]] = 1 <= $set["level"] ? round($level["commission1"] * $price / 100, 2) . "" : 0;
                                    $cinfo["commission2"]["level" . $level["id"]] = 2 <= $set["level"] ? round($level["commission2"] * $price / 100, 2) . "" : 0;
                                    $cinfo["commission3"]["level" . $level["id"]] = 3 <= $set["level"] ? round($level["commission3"] * $price / 100, 2) . "" : 0;
                                }
                            }
                            if (0 < $order["ispackage"]) {
                                $packoption = array();
                                if (!empty($cinfo["optionid"])) {
                                    $packoption = pdo_fetch("select commission1,commission2,commission3 from " . tablename("ewei_shop_package_goods_option") . "\r\n                                            where uniacid = " . $_W["uniacid"] . " and pid = " . $order["packageid"] . " and optionid = " . $cinfo["optionid"] . " ");
                                } else {
                                    $packoption = pdo_fetch("select commission1,commission2,commission3 from " . tablename("ewei_shop_package_goods") . "\r\n                                            where uniacid = " . $_W["uniacid"] . " and pid = " . $order["packageid"] . " and goodsid = " . $cinfo["goodsid"] . " ");
                                }
                                $cinfo["commission1"] = array("default" => 1 <= $set["level"] ? $packoption["commission1"] : 0);
                                $cinfo["commission2"] = array("default" => 2 <= $set["level"] ? $packoption["commission2"] : 0);
                                $cinfo["commission3"] = array("default" => 3 <= $set["level"] ? $packoption["commission3"] : 0);
                                foreach ($levels as $level) {
                                    $cinfo["commission1"]["level" . $level["id"]] = $packoption["commission1"];
                                    $cinfo["commission2"]["level" . $level["id"]] = $packoption["commission2"];
                                    $cinfo["commission3"]["level" . $level["id"]] = $packoption["commission3"];
                                }
                            }
                        } else {
                            $cinfo["commission1"] = array("default" => 0);
                            $cinfo["commission2"] = array("default" => 0);
                            $cinfo["commission3"] = array("default" => 0);
                            foreach ($levels as $level) {
                                $cinfo["commission1"]["level" . $level["id"]] = 0;
                                $cinfo["commission2"]["level" . $level["id"]] = 0;
                                $cinfo["commission3"]["level" . $level["id"]] = 0;
                            }
                        }
                    }
                    if ($update) {
                        $commissions = array("level1" => 0, "level2" => 0, "level3" => 0);
                        if (!empty($agentid)) {
                            $m1 = m("member")->getMember($agentid);
                            if ($m1["isagent"] == 1 && $m1["status"] == 1) {
                                $l1 = $this->getLevel($m1["openid"]);
                                $commissions["level1"] = empty($l1) ? round($cinfo["commission1"]["default"], 2) : round($cinfo["commission1"]["level" . $l1["id"]], 2);
                                if (!empty($m1["agentid"])) {
                                    $m2 = m("member")->getMember($m1["agentid"]);
                                    $l2 = $this->getLevel($m2["openid"]);
                                    $commissions["level2"] = empty($l2) ? round($cinfo["commission2"]["default"], 2) : round($cinfo["commission2"]["level" . $l2["id"]], 2);
                                    if (!empty($m2["agentid"])) {
                                        $m3 = m("member")->getMember($m2["agentid"]);
                                        $l3 = $this->getLevel($m3["openid"]);
                                        $commissions["level3"] = empty($l3) ? round($cinfo["commission3"]["default"], 2) : round($cinfo["commission3"]["level" . $l3["id"]], 2);
                                    }
                                }
                            }
                        }
                        pdo_update("ewei_shop_order_goods", array("commission1" => iserializer($cinfo["commission1"]), "commission2" => iserializer($cinfo["commission2"]), "commission3" => iserializer($cinfo["commission3"]), "commissions" => iserializer($commissions), "nocommission" => $cinfo["nocommission"]), array("id" => $cinfo["id"]));
                    }
                }
                unset($cinfo);
            }
            if (!$hascommission) {
                pdo_update("ewei_shop_order", array("agentid" => 0), array("id" => $orderid));
            }
            return $goods;
        }
        public function getOrderCommissions($orderid = 0, $ogid = 0)
        {
            global $_W;
            $set = $this->getSet();
            $agentid = pdo_fetchcolumn("select agentid from " . tablename("ewei_shop_order") . " where id=:id limit 1", array(":id" => $orderid));
            $goods = pdo_fetch("select commission1,commission2,commission3 from " . tablename("ewei_shop_order_goods") . " where id=:id and orderid=:orderid and uniacid=:uniacid and nocommission=0 limit 1", array(":id" => $ogid, ":orderid" => $orderid, ":uniacid" => $_W["uniacid"]));
            $commissions = array("level1" => 0, "level2" => 0, "level3" => 0);
            if (0 < $set["level"]) {
                $commission1 = iunserializer($goods["commission1"]);
                $commission2 = iunserializer($goods["commission2"]);
                $commission3 = iunserializer($goods["commission3"]);
                if (!empty($agentid)) {
                    $m1 = m("member")->getMember($agentid);
                    if ($m1["isagent"] == 1 && $m1["status"] == 1) {
                        $l1 = $this->getLevel($m1["openid"]);
                        $commissions["level1"] = empty($l1) ? round($commission1["default"], 2) : round($commission1["level" . $l1["id"]], 2);
                        if (!empty($m1["agentid"])) {
                            $m2 = m("member")->getMember($m1["agentid"]);
                            $l2 = $this->getLevel($m2["openid"]);
                            $commissions["level2"] = empty($l2) ? round($commission2["default"], 2) : round($commission2["level" . $l2["id"]], 2);
                            if (!empty($m2["agentid"])) {
                                $m3 = m("member")->getMember($m2["agentid"]);
                                $l3 = $this->getLevel($m3["openid"]);
                                $commissions["level3"] = empty($l3) ? round($commission3["default"], 2) : round($commission3["level" . $l3["id"]], 2);
                            }
                        }
                    }
                }
            }
            return $commissions;
        }
        public function getStatistics($options)
        {
            $array = array("total");
            $level1_commission_total = 0;
            $level2_commission_total = 0;
            $level3_commission_total = 0;
            if (!empty($options["level1_agentids"])) {
                foreach ($options["level1_agentids"] as $k => $v) {
                    $info = $this->getInfo($v["id"], $array);
                    $level1_commission_total += $info["commission_total"];
                }
            }
            if (!empty($options["level2_agentids"])) {
                foreach ($options["level2_agentids"] as $k => $v) {
                    $info = $this->getInfo($v["id"], $array);
                    $level2_commission_total += $info["commission_total"];
                }
            }
            if (!empty($options["level3_agentids"])) {
                foreach ($options["level3_agentids"] as $k => $v) {
                    $info = $this->getInfo($v["id"], $array);
                    $level3_commission_total += $info["commission_total"];
                }
            }
            $level_commission_total = $level1_commission_total + $level2_commission_total + $level3_commission_total;
            $data = array();
            $data["level_commission_total"] = $level_commission_total;
            $data["level1_commission_total"] = $level1_commission_total;
            $data["level2_commission_total"] = $level2_commission_total;
            $data["level3_commission_total"] = $level3_commission_total;
            return $data;
        }
        /**
         * 获取分销商所有信息
         * @param type $openid
         * @param type $options 获取参数 total 累计   ordercount 订单统计 ok 可提现拥挤 lock 未结算佣金 apply 待审核佣金 check 待打款用尽 id 是否返回代理ids
         */
        public function getInfo($openid, $options = NULL)
        {
            if (empty($options) || !is_array($options)) {
                $options = array();
            }
            $where_time = "";
            if (isset($options["starttime"]) && isset($options["endtime"])) {
                $options["starttime"] = strexists($options["starttime"], "-") ? strtotime($options["starttime"]) : $options["starttime"];
                $options["endtime"] = strexists($options["endtime"], "-") ? strtotime($options["endtime"]) : $options["endtime"];
                $where_time = " and o.createtime between " . $options["starttime"] . " and " . $options["endtime"];
            }
            global $_W;
            $set = $this->getSet();
            $level = intval($set["level"]);
            $member = m("member")->getMember($openid);
            $agentLevel = $this->getLevel($openid);
            $time = time();
            $day_times = intval($set["settledays"]) * 3600 * 24;
            $agentcount = 0;
            $ordercount0 = 0;
            $ordermoney0 = 0;
            $ordercount = 0;
            $ordermoney = 0;
            $ordercount3 = 0;
            $ordermoney3 = 0;
            $commission_total = 0;
            $commission_ok = 0;
            $commission_apply = 0;
            $commission_check = 0;
            $commission_lock = 0;
            $commission_pay = 0;
            $commission_wait = 0;
            $commission_fail = 0;
            $level1 = 0;
            $level2 = 0;
            $level3 = 0;
            $order10 = 0;
            $order20 = 0;
            $order30 = 0;
            $order1 = 0;
            $order2 = 0;
            $order3 = 0;
            $order13 = 0;
            $order23 = 0;
            $order33 = 0;
            $order13money = 0;
            $order23money = 0;
            $order33money = 0;
            if (1 <= $level) {
                if (in_array("ordercount0", $options)) {
                    $level1_ordercount = pdo_fetch("select sum(og.realprice) as ordermoney,count(distinct o.id) as ordercount from " . tablename("ewei_shop_order") . " o " . " left join  " . tablename("ewei_shop_order_goods") . " og on og.orderid=o.id " . " where o.agentid=:agentid and o.status>=0 and og.status1>=0 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0 " . $where_time . " limit 1", array(":uniacid" => $_W["uniacid"], ":agentid" => $member["id"]));
                    $order10 += $level1_ordercount["ordercount"];
                    $ordercount0 += $level1_ordercount["ordercount"];
                    $ordermoney0 += $level1_ordercount["ordermoney"];
                }
                if (in_array("ordercount", $options)) {
                    $level1_ordercount = pdo_fetch("select sum(og.realprice) as ordermoney,count(distinct o.id) as ordercount from " . tablename("ewei_shop_order") . " o " . " left join  " . tablename("ewei_shop_order_goods") . " og on og.orderid=o.id " . " where o.agentid=:agentid and o.status>=1 and og.status1>=0 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0 " . $where_time . " limit 1", array(":uniacid" => $_W["uniacid"], ":agentid" => $member["id"]));
                    $order1 += $level1_ordercount["ordercount"];
                    $ordercount += $level1_ordercount["ordercount"];
                    $ordermoney += $level1_ordercount["ordermoney"];
                }
                if (in_array("ordercount3", $options)) {
                    $level1_ordercount3 = pdo_fetch("select sum(og.realprice) as ordermoney,count(distinct o.id) as ordercount from " . tablename("ewei_shop_order") . " o " . " left join  " . tablename("ewei_shop_order_goods") . " og on og.orderid=o.id " . " where o.agentid=:agentid and o.status>=3 and og.status1>=0 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0 " . $where_time . " limit 1", array(":uniacid" => $_W["uniacid"], ":agentid" => $member["id"]));
                    $order13 += $level1_ordercount3["ordercount"];
                    $ordercount3 += $level1_ordercount3["ordercount"];
                    $ordermoney3 += $level1_ordercount3["ordermoney"];
                    $order13money += $level1_ordercount3["ordermoney"];
                }
                if (in_array("total", $options)) {
                    $level1_commissions = pdo_fetchall("select og.commission1,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid" . " where o.agentid=:agentid and o.status>=1 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"], ":agentid" => $member["id"]));
                    foreach ($level1_commissions as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission1"]);
                        if (empty($commissions)) {
                            $commission_total += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : isset($commission["default"]) ? $commission["default"] : 0;
                        } else {
                            $commission_total += isset($commissions["level1"]) ? floatval($commissions["level1"]) : 0;
                        }
                    }
                }
                if (in_array("ok", $options)) {
                    $level1_commissions = pdo_fetchall("select og.commission1,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid" . " where o.agentid=:agentid and o.status>=3 and og.nocommission=0 and (" . $time . " - o.finishtime > " . $day_times . ") and og.status1=0  and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"], ":agentid" => $member["id"]));
                    foreach ($level1_commissions as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission1"]);
                        if (empty($commissions)) {
                            $commission_ok += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : $commission["default"];
                        } else {
                            $commission_ok += isset($commissions["level1"]) ? $commissions["level1"] : 0;
                        }
                    }
                }
                if (in_array("lock", $options)) {
                    $level1_commissions1 = pdo_fetchall("select og.commission1,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid" . " where o.agentid=:agentid and o.status>=3 and og.nocommission=0 and (" . $time . " - o.finishtime <= " . $day_times . ")  and og.status1=0  and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"], ":agentid" => $member["id"]));
                    foreach ($level1_commissions1 as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission1"]);
                        if (empty($commissions)) {
                            $commission_lock += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : $commission["default"];
                        } else {
                            $commission_lock += isset($commissions["level1"]) ? $commissions["level1"] : 0;
                        }
                    }
                }
                if (in_array("apply", $options)) {
                    $level1_commissions2 = pdo_fetchall("select og.commission1,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid" . " where o.agentid=:agentid and o.status>=3 and og.status1=1 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"], ":agentid" => $member["id"]));
                    foreach ($level1_commissions2 as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission1"]);
                        if (empty($commissions)) {
                            $commission_apply += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : $commission["default"];
                        } else {
                            $commission_apply += isset($commissions["level1"]) ? $commissions["level1"] : 0;
                        }
                    }
                }
                if (in_array("check", $options)) {
                    $level1_commissions2 = pdo_fetchall("select og.commission1,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid" . " where o.agentid=:agentid and o.status>=3 and og.status1=2 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"], ":agentid" => $member["id"]));
                    foreach ($level1_commissions2 as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission1"]);
                        if (empty($commissions)) {
                            $commission_check += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : $commission["default"];
                        } else {
                            $commission_check += isset($commissions["level1"]) ? $commissions["level1"] : 0;
                        }
                    }
                }
                if (in_array("pay", $options)) {
                    $level1_commissions2 = pdo_fetchall("select og.commission1,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid" . " where o.agentid=:agentid and o.status>=3 and og.status1=3 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"], ":agentid" => $member["id"]));
                    foreach ($level1_commissions2 as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission1"]);
                        if (empty($commissions)) {
                            $commission_pay += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : (!empty($commission) ? $commission["default"] : 0);
                        } else {
                            $commission_pay += isset($commissions["level1"]) ? $commissions["level1"] : 0;
                        }
                    }
                }
                if (in_array("wait", $options)) {
                    $level1_commissions2 = pdo_fetchall("select og.commission1,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid" . " where o.agentid=:agentid and (o.status=2 or o.status=1) and og.status1=0  and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"], ":agentid" => $member["id"]));
                    foreach ($level1_commissions2 as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission1"]);
                        if (empty($commissions)) {
                            $commission_wait += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : $commission["default"];
                        } else {
                            $commission_wait += isset($commissions["level1"]) ? $commissions["level1"] : 0;
                        }
                    }
                }
                if (in_array("fail", $options)) {
                    $level1_commissions2 = pdo_fetchall("select og.commission1,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid" . " where o.agentid=:agentid and o.status=3 and og.status1=-1  and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"], ":agentid" => $member["id"]));
                    foreach ($level1_commissions2 as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission1"]);
                        if (empty($commissions)) {
                            $commission_fail += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : $commission["default"];
                        } else {
                            $commission_fail += isset($commissions["level1"]) ? $commissions["level1"] : 0;
                        }
                    }
                }
                $level1_agentids = pdo_fetchall("select id from " . tablename("ewei_shop_member") . " where agentid=:agentid and isagent=1 and status=1 and uniacid=:uniacid ", array(":uniacid" => $_W["uniacid"], ":agentid" => $member["id"]), "id");
                $level1 = count($level1_agentids);
                $agentcount += $level1;
            }
            if (2 <= $level && 0 < $level1) {
                if (in_array("ordercount0", $options)) {
                    $level2_ordercount = pdo_fetch("select sum(og.realprice) as ordermoney,count(distinct o.id) as ordercount from " . tablename("ewei_shop_order") . " o " . " left join  " . tablename("ewei_shop_order_goods") . " og on og.orderid=o.id " . " where o.agentid in( " . implode(",", array_keys($level1_agentids)) . ")  and o.status>=0 and og.status2>=0 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0 " . $where_time . " limit 1", array(":uniacid" => $_W["uniacid"]));
                    $order20 += $level2_ordercount["ordercount"];
                    $ordercount0 += $level2_ordercount["ordercount"];
                    $ordermoney0 += $level2_ordercount["ordermoney"];
                }
                if (in_array("ordercount", $options)) {
                    $level2_ordercount = pdo_fetch("select sum(og.realprice) as ordermoney,count(distinct o.id) as ordercount from " . tablename("ewei_shop_order") . " o " . " left join  " . tablename("ewei_shop_order_goods") . " og on og.orderid=o.id " . " where o.agentid in( " . implode(",", array_keys($level1_agentids)) . ")  and o.status>=1 and og.status2>=0 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0 " . $where_time . " limit 1", array(":uniacid" => $_W["uniacid"]));
                    $order2 += $level2_ordercount["ordercount"];
                    $ordercount += $level2_ordercount["ordercount"];
                    $ordermoney += $level2_ordercount["ordermoney"];
                }
                if (in_array("ordercount3", $options)) {
                    $level2_ordercount3 = pdo_fetch("select sum(og.realprice) as ordermoney,count(distinct o.id) as ordercount from " . tablename("ewei_shop_order") . " o " . " left join  " . tablename("ewei_shop_order_goods") . " og on og.orderid=o.id " . " where o.agentid in( " . implode(",", array_keys($level1_agentids)) . ")  and o.status>=3 and og.status2>=0 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0 " . $where_time . " limit 1", array(":uniacid" => $_W["uniacid"]));
                    $order23 += $level2_ordercount3["ordercount"];
                    $ordercount3 += $level2_ordercount3["ordercount"];
                    $ordermoney3 += $level2_ordercount3["ordermoney"];
                    $order23money += $level2_ordercount3["ordermoney"];
                }
                if (in_array("total", $options)) {
                    $level2_commissions = pdo_fetchall("select og.commission2,og.commissions from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid " . " where o.agentid in( " . implode(",", array_keys($level1_agentids)) . ")  and o.status>=1 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"]));
                    foreach ($level2_commissions as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission2"]);
                        if (empty($commissions)) {
                            $commission_total += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : $commission["default"];
                        } else {
                            $commission_total += isset($commissions["level2"]) ? $commissions["level2"] : 0;
                        }
                    }
                }
                if (in_array("ok", $options)) {
                    $level2_commissions = pdo_fetchall("select og.commission2,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid " . " where o.agentid in( " . implode(",", array_keys($level1_agentids)) . ")  and (" . $time . " - o.finishtime > " . $day_times . ") and o.status>=3 and og.status2=0 and og.nocommission=0  and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"]));
                    foreach ($level2_commissions as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission2"]);
                        if (empty($commissions)) {
                            $commission_ok += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : $commission["default"];
                        } else {
                            $commission_ok += isset($commissions["level2"]) ? $commissions["level2"] : 0;
                        }
                    }
                }
                if (in_array("lock", $options)) {
                    $level2_commissions1 = pdo_fetchall("select og.commission2,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid " . " where o.agentid in( " . implode(",", array_keys($level1_agentids)) . ")  and (" . $time . " - o.finishtime <= " . $day_times . ") and og.status2=0 and o.status>=3 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"]));
                    foreach ($level2_commissions1 as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission2"]);
                        if (empty($commissions)) {
                            $commission_lock += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : $commission["default"];
                        } else {
                            $commission_lock += isset($commissions["level2"]) ? $commissions["level2"] : 0;
                        }
                    }
                }
                if (in_array("apply", $options)) {
                    $level2_commissions2 = pdo_fetchall("select og.commission2,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid " . " where o.agentid in( " . implode(",", array_keys($level1_agentids)) . ")  and o.status>=3 and og.status2=1 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"]));
                    foreach ($level2_commissions2 as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission2"]);
                        if (empty($commissions)) {
                            $commission_apply += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : $commission["default"];
                        } else {
                            $commission_apply += isset($commissions["level2"]) ? $commissions["level2"] : 0;
                        }
                    }
                }
                if (in_array("check", $options)) {
                    $level2_commissions3 = pdo_fetchall("select og.commission2,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid " . " where o.agentid in( " . implode(",", array_keys($level1_agentids)) . ")  and o.status>=3 and og.status2=2 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"]));
                    foreach ($level2_commissions3 as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission2"]);
                        if (empty($commissions)) {
                            $commission_check += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : $commission["default"];
                        } else {
                            $commission_check += isset($commissions["level2"]) ? $commissions["level2"] : 0;
                        }
                    }
                }
                if (in_array("pay", $options)) {
                    $level2_commissions3 = pdo_fetchall("select og.commission2,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid " . " where o.agentid in( " . implode(",", array_keys($level1_agentids)) . ")  and o.status>=3 and og.status2=3 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"]));
                    foreach ($level2_commissions3 as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission2"]);
                        if (empty($commissions)) {
                            $commission_pay += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : $commission["default"];
                        } else {
                            $commission_pay += isset($commissions["level2"]) ? $commissions["level2"] : 0;
                        }
                    }
                }
                if (in_array("wait", $options)) {
                    $level2_commissions3 = pdo_fetchall("select og.commission2,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid " . " where o.agentid in( " . implode(",", array_keys($level1_agentids)) . ")  and (o.status=1 or o.status=2) and og.status2=0 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"]));
                    foreach ($level2_commissions3 as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission2"]);
                        if (empty($commissions)) {
                            $commission_wait += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : $commission["default"];
                        } else {
                            $commission_wait += isset($commissions["level2"]) ? $commissions["level2"] : 0;
                        }
                    }
                }
                if (in_array("fail", $options)) {
                    $level2_commissions3 = pdo_fetchall("select og.commission2,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid " . " where o.agentid in( " . implode(",", array_keys($level1_agentids)) . ")  and o.status=3 and og.status2=-1 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"]));
                    foreach ($level2_commissions3 as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission2"]);
                        if (empty($commissions)) {
                            $commission_fail += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : $commission["default"];
                        } else {
                            $commission_fail += isset($commissions["level2"]) ? $commissions["level2"] : 0;
                        }
                    }
                }
                $level2_agentids = pdo_fetchall("select id from " . tablename("ewei_shop_member") . " where agentid in( " . implode(",", array_keys($level1_agentids)) . ") and isagent=1 and status=1 and uniacid=:uniacid", array(":uniacid" => $_W["uniacid"]), "id");
                $level2 = count($level2_agentids);
                $agentcount += $level2;
            }
            if (3 <= $level && 0 < $level2) {
                if (in_array("ordercount0", $options)) {
                    $level3_ordercount = pdo_fetch("select sum(og.realprice) as ordermoney,count(distinct og.orderid) as ordercount from " . tablename("ewei_shop_order") . " o " . " left join  " . tablename("ewei_shop_order_goods") . " og on og.orderid=o.id " . " where o.agentid in( " . implode(",", array_keys($level2_agentids)) . ")  and o.status>=0 and og.status3>=0 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0 " . $where_time . " limit 1", array(":uniacid" => $_W["uniacid"]));
                    $order30 += $level3_ordercount["ordercount"];
                    $ordercount0 += $level3_ordercount["ordercount"];
                    $ordermoney0 += $level3_ordercount["ordermoney"];
                }
                if (in_array("ordercount", $options)) {
                    $level3_ordercount = pdo_fetch("select sum(og.realprice) as ordermoney,count(distinct og.orderid) as ordercount from " . tablename("ewei_shop_order") . " o " . " left join  " . tablename("ewei_shop_order_goods") . " og on og.orderid=o.id " . " where o.agentid in( " . implode(",", array_keys($level2_agentids)) . ")  and o.status>=1 and og.status3>=0 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0 " . $where_time . " limit 1", array(":uniacid" => $_W["uniacid"]));
                    $order3 += $level3_ordercount["ordercount"];
                    $ordercount += $level3_ordercount["ordercount"];
                    $ordermoney += $level3_ordercount["ordermoney"];
                }
                if (in_array("ordercount3", $options)) {
                    $level3_ordercount3 = pdo_fetch("select sum(og.realprice) as ordermoney,count(distinct og.orderid) as ordercount from " . tablename("ewei_shop_order") . " o " . " left join  " . tablename("ewei_shop_order_goods") . " og on og.orderid=o.id " . " where o.agentid in( " . implode(",", array_keys($level2_agentids)) . ")  and o.status>=3 and og.status3>=0 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0 " . $where_time . " limit 1", array(":uniacid" => $_W["uniacid"]));
                    $order33 += $level3_ordercount3["ordercount"];
                    $ordercount3 += $level3_ordercount3["ordercount"];
                    $ordermoney3 += $level3_ordercount3["ordermoney"];
                    $order33money += $level3_ordercount["ordermoney"];
                }
                if (in_array("total", $options)) {
                    $level3_commissions = pdo_fetchall("select og.commission3,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid" . " where o.agentid in( " . implode(",", array_keys($level2_agentids)) . ")  and o.status>=1 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"]));
                    foreach ($level3_commissions as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission3"]);
                        if (empty($commissions)) {
                            $commission_total += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : (isset($commission["default"]) ? $commission["default"] : 0);
                        } else {
                            $commission_total += isset($commissions["level3"]) ? $commissions["level3"] : 0;
                        }
                    }
                }
                if (in_array("ok", $options)) {
                    $level3_commissions = pdo_fetchall("select og.commission3,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid" . " where o.agentid in( " . implode(",", array_keys($level2_agentids)) . ")  and (" . $time . " - o.finishtime > " . $day_times . ") and o.status>=3 and og.status3=0  and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"]));
                    foreach ($level3_commissions as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission3"]);
                        if (empty($commissions)) {
                            $commission_ok += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : $commission["default"];
                        } else {
                            $commission_ok += isset($commissions["level3"]) ? $commissions["level3"] : 0;
                        }
                    }
                }
                if (in_array("lock", $options)) {
                    $level3_commissions1 = pdo_fetchall("select og.commission3,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid" . " where o.agentid in( " . implode(",", array_keys($level2_agentids)) . ")  and o.status>=3 and (" . $time . " - o.finishtime <= " . $day_times . ") and og.status3=0  and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"]));
                    foreach ($level3_commissions1 as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission3"]);
                        if (empty($commissions)) {
                            $commission_lock += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : $commission["default"];
                        } else {
                            $commission_lock += isset($commissions["level3"]) ? $commissions["level3"] : 0;
                        }
                    }
                }
                if (in_array("apply", $options)) {
                    $level3_commissions2 = pdo_fetchall("select og.commission3,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid" . " where o.agentid in( " . implode(",", array_keys($level2_agentids)) . ")  and o.status>=3 and og.status3=1 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"]));
                    foreach ($level3_commissions2 as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission3"]);
                        if (empty($commissions)) {
                            $commission_apply += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : $commission["default"];
                        } else {
                            $commission_apply += isset($commissions["level3"]) ? $commissions["level3"] : 0;
                        }
                    }
                }
                if (in_array("check", $options)) {
                    $level3_commissions3 = pdo_fetchall("select og.commission3,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid" . " where o.agentid in( " . implode(",", array_keys($level2_agentids)) . ")  and o.status>=3 and og.status3=2 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"]));
                    foreach ($level3_commissions3 as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission3"]);
                        if (empty($commissions)) {
                            $commission_check += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : $commission["default"];
                        } else {
                            $commission_check += isset($commissions["level3"]) ? $commissions["level3"] : 0;
                        }
                    }
                }
                if (in_array("pay", $options)) {
                    $level3_commissions3 = pdo_fetchall("select og.commission3,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid" . " where o.agentid in( " . implode(",", array_keys($level2_agentids)) . ")  and o.status>=3 and og.status3=3 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"]));
                    foreach ($level3_commissions3 as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission3"]);
                        if (empty($commissions)) {
                            $commission_pay += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : $commission["default"];
                        } else {
                            $commission_pay += isset($commissions["level3"]) ? $commissions["level3"] : 0;
                        }
                    }
                }
                if (in_array("wait", $options)) {
                    $level3_commissions3 = pdo_fetchall("select og.commission3,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid" . " where o.agentid in( " . implode(",", array_keys($level2_agentids)) . ")  and ( o.status=1 or o.status=2) and og.status3=0 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"]));
                    foreach ($level3_commissions3 as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission3"]);
                        if (empty($commissions)) {
                            $commission_wait += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : $commission["default"];
                        } else {
                            $commission_wait += isset($commissions["level3"]) ? $commissions["level3"] : 0;
                        }
                    }
                }
                if (in_array("fail", $options)) {
                    $level3_commissions3 = pdo_fetchall("select og.commission3,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join  " . tablename("ewei_shop_order") . " o on o.id = og.orderid" . " where o.agentid in( " . implode(",", array_keys($level2_agentids)) . ")  and o.status=3 and og.status3=-1 and og.nocommission=0 and o.uniacid=:uniacid and o.isparent=0", array(":uniacid" => $_W["uniacid"]));
                    foreach ($level3_commissions3 as $c) {
                        $commissions = iunserializer($c["commissions"]);
                        $commission = iunserializer($c["commission3"]);
                        if (empty($commissions)) {
                            $commission_fail += isset($commission["level" . $agentLevel["id"]]) ? $commission["level" . $agentLevel["id"]] : $commission["default"];
                        } else {
                            $commission_fail += isset($commissions["level3"]) ? $commissions["level3"] : 0;
                        }
                    }
                }
                $level3_agentids = pdo_fetchall("select id from " . tablename("ewei_shop_member") . " where uniacid=:uniacid and agentid in( " . implode(",", array_keys($level2_agentids)) . ") and isagent=1 and status=1", array(":uniacid" => $_W["uniacid"]), "id");
                $level3 = count($level3_agentids);
                $agentcount += $level3;
            }
            $member["agentcount"] = $agentcount;
            $member["ordercount"] = $ordercount;
            $member["ordermoney"] = $ordermoney;
            $member["order1"] = $order1;
            $member["order2"] = $order2;
            $member["order3"] = $order3;
            $member["ordercount3"] = $ordercount3;
            $member["ordermoney3"] = $ordermoney3;
            $member["order13"] = $order13;
            $member["order23"] = $order23;
            $member["order33"] = $order33;
            $member["order13money"] = $order13money;
            $member["order23money"] = $order23money;
            $member["order33money"] = $order33money;
            $member["ordercount0"] = $ordercount0;
            $member["ordermoney0"] = $ordermoney0;
            $member["order10"] = $order10;
            $member["order20"] = $order20;
            $member["order30"] = $order30;
            $member["commission_total"] = round($commission_total, 2);
            $member["commission_ok"] = round($commission_ok, 2);
            $member["commission_lock"] = round($commission_lock, 2);
            $member["commission_apply"] = round($commission_apply, 2);
            $member["commission_check"] = round($commission_check, 2);
            $member["commission_pay"] = round($commission_pay, 2);
            $member["commission_wait"] = round($commission_wait, 2);
            $member["commission_fail"] = round($commission_fail, 2);
            $member["level1"] = $level1;
            $member["level1_agentids"] = $level1_agentids;
            $member["level2"] = $level2;
            $member["level2_agentids"] = $level2_agentids;
            $member["level3"] = $level3;
            $member["level3_agentids"] = $level3_agentids;
            $member["agenttime"] = 0 < $member["agenttime"] ? date("Y-m-d H:i", $member["agenttime"]) : 0;
            $this->getInfo = $member;
            return $this->getInfo;
        }
        /**
         * 获取订单的分销员情况
         */
        public function getAgents($orderid = 0)
        {
            global $_W;
            global $_GPC;
            $agents = array();
            $order = pdo_fetch("select id,agentid,openid from " . tablename("ewei_shop_order") . " where id=:id and uniacid=:uniacid limit 1", array(":id" => $orderid, ":uniacid" => $_W["uniacid"]));
            if (empty($order)) {
                return $agents;
            }
            $set = $this->getSet();
            $m1 = m("member")->getMember($order["agentid"]);
            if (!empty($m1) && $m1["isagent"] == 1 && $m1["status"] == 1 && 0 < $set["level"]) {
                $agents[] = $m1;
                if (!empty($m1["agentid"]) && 1 < $set["level"]) {
                    $m2 = m("member")->getMember($m1["agentid"]);
                    if (!empty($m2) && $m2["isagent"] == 1 && $m2["status"] == 1) {
                        $agents[] = $m2;
                        if (!empty($m2["agentid"]) && 2 < $set["level"]) {
                            $m3 = m("member")->getMember($m2["agentid"]);
                            if (!empty($m3) && $m3["isagent"] == 1 && $m3["status"] == 1) {
                                $agents[] = $m3;
                            }
                        }
                    }
                }
            }
            return $agents;
        }
        /**
         * 获取他的三级上级
         */
        public function getAgentsByMember($openid = "", $num = 3)
        {
            global $_W;
            global $_GPC;
            $agents = array();
            $m = m("member")->getMember($openid);
            if (!empty($m["agentid"])) {
                $m1 = m("member")->getMember($m["agentid"]);
                if (!empty($m1) && $m1["isagent"] == 1 && $m1["status"] == 1 && 0 < $num) {
                    $agents[0] = $m1;
                    if (!empty($m1["agentid"])) {
                        $m2 = m("member")->getMember($m1["agentid"]);
                        if (!empty($m2) && $m2["isagent"] == 1 && $m2["status"] == 1 && 1 < $num) {
                            $agents[1] = $m2;
                            if (!empty($m2["agentid"])) {
                                $m3 = m("member")->getMember($m2["agentid"]);
                                if (!empty($m3) && $m3["isagent"] == 1 && $m3["status"] == 1 && 2 < $num) {
                                    $agents[2] = $m3;
                                }
                            }
                        }
                    }
                }
            }
            return $agents;
        }
        public function getAgentsDownNum($openid = NULL)
        {
            global $_W;
            $openid = isset($openid) ? $openid : $_W["openid"];
            $set = $this->getSet();
            $member = $this->getInfo($openid);
            $levelcount1 = $member["level1"];
            $levelcount2 = $member["level2"];
            $levelcount3 = $member["level3"];
            $level1 = $level2 = $level3 = 0;
            $level1 = (int) pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_member") . " where agentid=:agentid and uniacid=:uniacid limit 1", array(":agentid" => $member["id"], ":uniacid" => $_W["uniacid"]));
            if (2 <= $set["level"] && 0 < $levelcount1) {
                $level2 = (int) pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_member") . " where agentid in( " . implode(",", array_keys($member["level1_agentids"])) . ") and uniacid=:uniacid limit 1", array(":uniacid" => $_W["uniacid"]));
            }
            if (3 <= $set["level"] && 0 < $levelcount2) {
                $level3 = (int) pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_member") . " where agentid in( " . implode(",", array_keys($member["level2_agentids"])) . ") and uniacid=:uniacid limit 1", array(":uniacid" => $_W["uniacid"]));
            }
            $total = $level1 + $level2 + $level3;
            return array("level1" => $level1, "level2" => $level2, "level3" => $level3, "total" => $total);
        }
        /**
         * 是否是分销商
         * @param type $openid
         * @return type
         */
        public function isAgent($openid)
        {
            if (empty($openid)) {
                return false;
            }
            if (is_array($openid)) {
                return $openid["isagent"] == 1 && $openid["status"] == 1;
            }
            $member = m("member")->getMember($openid);
            return $member["isagent"] == 1 && $member["status"] == 1;
        }
        /**
         * 计算出此商品的佣金
         * @param type $goodsid
         * @return type
         */
        public function getCommission($goods)
        {
            global $_W;
            $set = $this->getSet();
            $commission = 0;
            if ($goods["hascommission"] == 1) {
                $price = $goods["maxprice"];
                $level = $this->getLevel($_W["openid"]);
                $levelid = "default";
                if ($level) {
                    $levelid = "level" . $level["id"];
                }
                $goods_commission = !empty($goods["commission"]) ? json_decode($goods["commission"], true) : array();
                if ($goods_commission["type"] == 0) {
                    $commission = 1 <= $set["level"] ? 0 < $goods["commission1_rate"] ? $goods["commission1_rate"] * $goods["marketprice"] / 100 : $goods["commission1_pay"] : 0;
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
                    $commission = max($price_all);
                }
            } else {
                $openid = m("user")->getOpenid();
                $level = $this->getLevel($openid);
                if (!empty($level)) {
                    $commission = 1 <= $set["level"] ? round($level["commission1"] * $goods["marketprice"] / 100, 2) : 0;
                } else {
                    $commission = 1 <= $set["level"] ? round($set["commission1"] * $goods["marketprice"] / 100, 2) : 0;
                }
            }
            return $commission;
        }
        /**
         * 店中店二维码
         * @global type $_W
         * @param type $openid
         * @return string
         */
        public function createMyShopQrcode($mid = 0, $posterid = 0)
        {
            global $_W;
            $path = IA_ROOT . "/addons/ewei_shopv2/data/qrcode/" . $_W["uniacid"];
            if (!is_dir($path)) {
                load()->func("file");
                mkdirs($path);
            }
            $url = mobileUrl("commission/myshop", array("mid" => $mid), true);
            if (!empty($posterid)) {
                $url .= "&posterid=" . $posterid;
            }
            $file = "myshop_" . $posterid . "_" . $mid . ".png";
            $qr_file = $path . "/" . $file;
            if (!is_file($qr_file)) {
                require IA_ROOT . "/framework/library/qrcode/phpqrcode.php";
                QRcode::png($url, $qr_file, QR_ECLEVEL_H, 4);
            }
            return $_W["siteroot"] . "addons/ewei_shopv2/data/qrcode/" . $_W["uniacid"] . "/" . $file;
        }
        private function createImage($url)
        {
            load()->func("communication");
            $resp = ihttp_request($url);
            return imagecreatefromstring($resp["content"]);
        }
        /**
         * 创建商品海报
         * @param type $goodsid
         */
        public function createGoodsImage($goods)
        {
            global $_W;
            global $_GPC;
            $goods = set_medias($goods, "thumb");
            $shop_set = $_W["shopset"]["shop"];
            $openid = $_W["openid"];
            $me = m("member")->getMember($openid);
            if ($me["isagent"] == 1 && $me["status"] == 1) {
                $userinfo = $me;
            } else {
                $mid = intval($_GPC["mid"]);
                if (!empty($mid)) {
                    $userinfo = m("member")->getMember($mid);
                }
            }
            $path = IA_ROOT . "/addons/ewei_shopv2/data/poster/" . $_W["uniacid"] . "/";
            if (!is_dir($path)) {
                load()->func("file");
                mkdirs($path);
            }
            $img = empty($goods["commission_thumb"]) ? $goods["thumb"] : tomedia($goods["commission_thumb"]);
            $md5 = md5(json_encode(array("id" => $goods["id"], "marketprice" => $goods["marketprice"], "productprice" => $goods["productprice"], "img" => $img, "shopset" => $shop_set, "openid" => $openid, "version" => 4)));
            $file = $md5 . ".jpg";
            if (!is_file($path . $file)) {
                set_time_limit(0);
                $font = IA_ROOT . "/addons/ewei_shopv2/static/fonts/msyh.ttf";
                $target = imagecreatetruecolor(640, 1225);
                $bg = imagecreatefromjpeg(IA_ROOT . "/addons/ewei_shopv2/plugin/commission/static/images/poster.jpg");
                imagecopy($target, $bg, 0, 0, 0, 0, 640, 1225);
                imagedestroy($bg);
                if (!empty($userinfo["avatar"])) {
                    $avatar = preg_replace("/\\/0\$/i", "/96", $userinfo["avatar"]);
                    $head = $this->createImage($avatar);
                    $w = imagesx($head);
                    $h = imagesy($head);
                    imagecopyresized($target, $head, 24, 32, 0, 0, 88, 88, $w, $h);
                    imagedestroy($head);
                }
                if (!empty($img)) {
                    $thumb = $this->createImage($img);
                    $w = imagesx($thumb);
                    $h = imagesy($thumb);
                    imagecopyresized($target, $thumb, 0, 160, 0, 0, 640, 640, $w, $h);
                    imagedestroy($thumb);
                }
                $black = imagecreatetruecolor(640, 127);
                imagealphablending($black, false);
                imagesavealpha($black, true);
                $blackcolor = imagecolorallocatealpha($black, 0, 0, 0, 25);
                imagefill($black, 0, 0, $blackcolor);
                imagecopy($target, $black, 0, 678, 0, 0, 640, 127);
                imagedestroy($black);
                $goods_qrcode_file = tomedia(m("qrcode")->createGoodsQrcode($userinfo["id"], $goods["id"])) . "?" . time();
                $qrcode = $this->createImage($goods_qrcode_file);
                $w = imagesx($qrcode);
                $h = imagesy($qrcode);
                imagecopyresized($target, $qrcode, 50, 835, 0, 0, 250, 250, $w, $h);
                imagedestroy($qrcode);
                $bc = imagecolorallocate($target, 0, 3, 51);
                $cc = imagecolorallocate($target, 240, 102, 0);
                $wc = imagecolorallocate($target, 255, 255, 255);
                $yc = imagecolorallocate($target, 255, 255, 0);
                $str1 = "我是";
                imagettftext($target, 20, 0, 150, 70, $bc, $font, $str1);
                imagettftext($target, 20, 0, 210, 70, $cc, $font, $userinfo["nickname"]);
                $str2 = "我要为";
                imagettftext($target, 20, 0, 150, 105, $bc, $font, $str2);
                $str3 = $shop_set["name"];
                imagettftext($target, 20, 0, 240, 105, $cc, $font, $str3);
                $box = imagettfbbox(20, 0, $font, $str3);
                $width = $box[4] - $box[6];
                $str4 = "代言";
                imagettftext($target, 20, 0, 240 + $width + 10, 105, $bc, $font, $str4);
                $str5 = mb_substr($goods["title"], 0, 50, "utf-8");
                imagettftext($target, 20, 0, 30, 730, $wc, $font, $str5);
                $str6 = "￥" . number_format($goods["marketprice"], 2);
                imagettftext($target, 25, 0, 25, 780, $yc, $font, $str6);
                $box = imagettfbbox(26, 0, $font, $str6);
                $width = $box[4] - $box[6];
                if (0 < $goods["productprice"]) {
                    $str7 = "￥" . number_format($goods["productprice"], 2);
                    imagettftext($target, 22, 0, 25 + $width + 10, 780, $wc, $font, $str7);
                    $end = 25 + $width + 10;
                    $box = imagettfbbox(22, 0, $font, $str7);
                    $width = $box[4] - $box[6];
                    imageline($target, $end, 770, $end + $width + 20, 770, $wc);
                    imageline($target, $end, 771.5, $end + $width + 20, 771, $wc);
                }
                imagejpeg($target, $path . $file);
                imagedestroy($target);
            }
            return $_W["siteroot"] . "addons/ewei_shopv2/data/poster/" . $_W["uniacid"] . "/" . $file;
        }
        /**
         * 常见店铺海报
         * @return string
         */
        public function createShopImage()
        {
            global $_W;
            global $_GPC;
            $shop_set = set_medias($_W["shopset"]["shop"], "signimg");
            $path = IA_ROOT . "/addons/ewei_shopv2/data/poster/" . $_W["uniacid"] . "/";
            if (!is_dir($path)) {
                load()->func("file");
                mkdirs($path);
            }
            $mid = intval($_GPC["mid"]);
            $openid = $_W["openid"];
            $me = m("member")->getMember($openid);
            if ($me["isagent"] == 1 && $me["status"] == 1) {
                $userinfo = $me;
            } else {
                $mid = intval($_GPC["mid"]);
                if (!empty($mid)) {
                    $userinfo = m("member")->getMember($mid);
                }
            }
            $md5 = md5(json_encode(array("openid" => $openid, "signimg" => $shop_set["signimg"], "shopset" => $shop_set, "version" => 4)));
            $file = $md5 . ".jpg";
            if (!is_file($path . $file)) {
                set_time_limit(0);
                @ini_set("memory_limit", "256M");
                $font = IA_ROOT . "/addons/ewei_shopv2/static/fonts/msyh.ttf";
                $target = imagecreatetruecolor(640, 1225);
                $bc = imagecolorallocate($target, 0, 3, 51);
                $cc = imagecolorallocate($target, 240, 102, 0);
                $wc = imagecolorallocate($target, 255, 255, 255);
                $yc = imagecolorallocate($target, 255, 255, 0);
                $bg = imagecreatefromjpeg(IA_ROOT . "/addons/ewei_shopv2/plugin/commission/static/images/poster.jpg");
                imagecopy($target, $bg, 0, 0, 0, 0, 640, 1225);
                imagedestroy($bg);
                if (!empty($userinfo["avatar"])) {
                    $avatar = preg_replace("/\\/0\$/i", "/96", $userinfo["avatar"]);
                    $head = $this->createImage($avatar);
                    $w = imagesx($head);
                    $h = imagesy($head);
                    imagecopyresized($target, $head, 24, 32, 0, 0, 88, 88, $w, $h);
                    imagedestroy($head);
                }
                if (!empty($shop_set["signimg"])) {
                    $thumb = $this->createImage($shop_set["signimg"]);
                    $w = imagesx($thumb);
                    $h = imagesy($thumb);
                    imagecopyresized($target, $thumb, 0, 160, 0, 0, 640, 640, $w, $h);
                    imagedestroy($thumb);
                }
                $qrcode_file = tomedia($this->createMyShopQrcode($userinfo["id"]));
                $qrcode = $this->createImage($qrcode_file);
                $w = imagesx($qrcode);
                $h = imagesy($qrcode);
                imagecopyresized($target, $qrcode, 50, 835, 0, 0, 250, 250, $w, $h);
                imagedestroy($qrcode);
                $str1 = "我是";
                imagettftext($target, 20, 0, 150, 70, $bc, $font, $str1);
                imagettftext($target, 20, 0, 210, 70, $cc, $font, $userinfo["nickname"]);
                $str2 = "我要为";
                imagettftext($target, 20, 0, 150, 105, $bc, $font, $str2);
                $str3 = $shop_set["name"];
                imagettftext($target, 20, 0, 240, 105, $cc, $font, $str3);
                $box = imagettfbbox(20, 0, $font, $str3);
                $width = $box[4] - $box[6];
                $str4 = "代言";
                imagettftext($target, 20, 0, 240 + $width + 10, 105, $bc, $font, $str4);
                imagejpeg($target, $path . $file);
                imagedestroy($target);
            }
            return $_W["siteroot"] . "addons/ewei_shopv2/data/poster/" . $_W["uniacid"] . "/" . $file;
        }
        public function checkAgent($openid = "")
        {
            global $_W;
            global $_GPC;
            $set = $this->getSet();
            if (empty($set["level"])) {
                return NULL;
            }
            if (empty($openid)) {
                return NULL;
            }
            $member = m("member")->getMember($openid);
            if (empty($member)) {
                return NULL;
            }
            $parent = false;
            $mid = intval($_GPC["mid"]);
            if (!empty($mid)) {
                $parent = m("member")->getMember($mid);
            }
            $parent_is_agent = !empty($parent) && $parent["isagent"] == 1 && $parent["status"] == 1;
            if ($parent_is_agent && $parent["id"] != $member["agentid"] && $parent["openid"] != $openid) {
                $clickcount = pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_commission_clickcount") . " where uniacid=:uniacid and openid=:openid and from_openid=:from_openid limit 1", array(":uniacid" => $_W["uniacid"], ":openid" => $openid, ":from_openid" => $parent["openid"]));
                if ($clickcount <= 0) {
                    $click = array("uniacid" => $_W["uniacid"], "openid" => $openid, "from_openid" => $parent["openid"], "clicktime" => time());
                    pdo_insert("ewei_shop_commission_clickcount", $click);
                    pdo_update("ewei_shop_member", array("clickcount" => $parent["clickcount"] + 1), array("uniacid" => $_W["uniacid"], "id" => $parent["id"]));
                }
            }
            if ($member["isagent"] == 1) {
                return NULL;
            }
            $open_redis = function_exists("redis") && !is_error(redis());
            if ($open_redis) {
                $redis_key = "ewei_" . $_W["uniacid"] . "_member_commission_first";
                $first = m("member")->memberRadisCount($redis_key, false);
                if (!$first) {
                    $first = pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_member") . " where uniacid=:uniacid limit 1", array(":uniacid" => $_W["uniacid"]));
                    m("member")->memberRadisCount($redis_key, $first);
                }
            } else {
                $first = 0;
                $member1 = pdo_fetch("select id,openid from " . tablename("ewei_shop_member") . " where uniacid=:uniacid limit 1", array(":uniacid" => $_W["uniacid"]));
                if ($member1) {
                    $first = 1;
                    $member2 = pdo_fetch("select id,openid from " . tablename("ewei_shop_member") . " where uniacid=:uniacid and id<>:fid limit 1", array(":uniacid" => $_W["uniacid"], ":fid" => $member1["id"]));
                    if ($member2) {
                        $first = 2;
                    }
                }
            }
            if ($first <= 1) {
                pdo_update("ewei_shop_member", array("isagent" => 1, "status" => 1, "agenttime" => time(), "agentblack" => 0), array("uniacid" => $_W["uniacid"], "id" => $member["id"]));
            } else {
                $time = time();
                $become_child = intval($set["become_child"]);
                if ($parent_is_agent && empty($member["agentid"]) && $member["id"] != $parent["id"]) {
                    if (empty($become_child)) {
                        if (empty($member["fixagentid"])) {
                            $authorid = empty($parent["isauthor"]) ? $parent["authorid"] : $parent["id"];
                            $author = p("author");
                            if ($author) {
                                $author->upgradeLevelByAgent($parent["id"]);
                                pdo_update("ewei_shop_member", array("agentid" => $parent["id"], "childtime" => $time, "authorid" => $authorid), array("uniacid" => $_W["uniacid"], "id" => $member["id"]));
                            } else {
                                pdo_update("ewei_shop_member", array("agentid" => $parent["id"], "childtime" => $time), array("uniacid" => $_W["uniacid"], "id" => $member["id"]));
                            }
                            if (p("dividend")) {
                                $this->saveRelation($member["id"], $parent["id"], 1);
                                p("dividend")->update_headsid($member["id"], $parent["id"]);
                            }
                            if ($author) {
                                $author_set = $author->getSet();
                                if (!empty($author_set["become"]) && ($author_set["become"] == "2" || $author_set["become"] == "5")) {
                                    $can_author = false;
                                    $getAgentsDownNum = $this->getAgentsDownNum($parent["openid"]);
                                    if ($author_set["become"] == "2") {
                                        if ($author_set["become_down1"] <= $getAgentsDownNum["level1"]) {
                                            $can_author = true;
                                        } else {
                                            if ($author_set["become_down2"] <= $getAgentsDownNum["level2"]) {
                                                $can_author = true;
                                            } else {
                                                if ($author_set["become_down3"] <= $getAgentsDownNum["level3"]) {
                                                    $can_author = true;
                                                }
                                            }
                                        }
                                    } else {
                                        if ($author_set["become"] == "5") {
                                            if ($author_set["become_downcount"] <= $getAgentsDownNum["total"]) {
                                                $can_author = true;
                                            }
                                        } else {
                                            if ($author_set["become"] == "6") {
                                                $temp_parent = $parent["id"];
                                                do {
                                                    $res = $author->becomeType6($temp_parent);
                                                    $temp_parent = $res["agentid"];
                                                } while ($res["agentid"] != 0);
                                            }
                                        }
                                    }
                                    if ($can_author) {
                                        $become_check = intval($author_set["become_check"]);
                                        if (empty($member["authorblack"])) {
                                            pdo_update("ewei_shop_member", array("authorstatus" => $become_check, "isauthor" => 1, "authortime" => $time), array("uniacid" => $_W["uniacid"], "id" => $parent["id"]));
                                            if ($become_check == 1) {
                                                $this->sendMessage($parent["openid"], array("nickname" => $parent["nickname"], "authortime" => $time), TM_AUTHOR_BECOME);
                                            }
                                        }
                                    }
                                }
                            }
                            $this->sendMessage($parent["openid"], array("nickname" => $member["nickname"], "childtime" => $time, "openid" => $member["openid"]), TM_COMMISSION_AGENT_NEW);
                            $this->upgradeLevelByAgent($parent["id"]);
                            if (p("globonus")) {
                                p("globonus")->upgradeLevelByAgent($parent["id"]);
                            }
                            if (p("abonus")) {
                                p("abonus")->upgradeLevelByAgent($parent["id"]);
                            }
                            if (p("author")) {
                                p("author")->upgradeLevelByAgent($parent["id"]);
                            }
                        }
                    } else {
                        pdo_update("ewei_shop_member", array("inviter" => $parent["id"]), array("uniacid" => $_W["uniacid"], "id" => $member["id"]));
                    }
                }
                $order_status = intval($set["become_order"]) == 0 ? 1 : 3;
                $become_check = intval($set["become_check"]);
                $to_check_agent = false;
                if (empty($set["become"])) {
                    if (empty($member["agentblack"])) {
                        $to_check_agent = true;
                    }
                } else {
                    if ($set["become"] == 2) {
                        $ordercount = pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_order") . " where uniacid=:uniacid and openid=:openid and status>=" . $order_status . " limit 1", array(":uniacid" => $_W["uniacid"], ":openid" => $openid));
                        if (intval($set["become_ordercount"]) <= $ordercount) {
                            $to_check_agent = true;
                        }
                    } else {
                        if ($set["become"] == 3) {
                            $moneycount = pdo_fetchcolumn("select sum(price) from " . tablename("ewei_shop_order") . " where uniacid=:uniacid and openid=:openid and status>=" . $order_status . " limit 1", array(":uniacid" => $_W["uniacid"], ":openid" => $openid));
                            if (floatval($set["become_moneycount"]) <= $moneycount) {
                                $to_check_agent = true;
                            }
                        } else {
                            if ($set["become"] == 4) {
                                $time = empty($member["applyagenttime"]) ? time() : $member["applyagenttime"];
                                $goods = pdo_fetch("select id,title,thumb,marketprice from" . tablename("ewei_shop_goods") . " where id=:id and uniacid=:uniacid limit 1", array(":id" => $set["become_goodsid"], ":uniacid" => $_W["uniacid"]));
                                $goodscount = pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_order_goods") . " og " . "  left join " . tablename("ewei_shop_order") . " o on o.id = og.orderid" . " where og.goodsid=:goodsid and o.openid=:openid and o.status>=" . $order_status . " and og.createtime >= " . $time . " limit 1", array(":goodsid" => $set["become_goodsid"], ":openid" => $openid));
                                if (0 < $goodscount) {
                                    $to_check_agent = true;
                                }
                            }
                        }
                    }
                }
                if ($to_check_agent) {
                    pdo_update("ewei_shop_member", array("isagent" => 1, "status" => $become_check, "agenttime" => $become_check == 1 ? $time : 0, "applyagenttime" => 0), array("uniacid" => $_W["uniacid"], "id" => $member["id"]));
                    if ($become_check == 1) {
                        $this->sendMessage($openid, array("nickname" => $member["nickname"], "agenttime" => $time), TM_COMMISSION_BECOME);
                        if ($parent_is_agent) {
                            $this->upgradeLevelByAgent($parent["id"]);
                            if (p("globonus")) {
                                p("globonus")->upgradeLevelByAgent($parent["id"]);
                            }
                            if (p("abonus")) {
                                p("abonus")->upgradeLevelByAgent($parent["id"]);
                            }
                            if (p("author")) {
                                p("author")->upgradeLevelByAgent($parent["id"]);
                            }
                        }
                    }
                }
            }
        }
        public function checkOrderConfirm($orderid = "0")
        {
            global $_W;
            global $_GPC;
            if (empty($orderid)) {
                return NULL;
            }
            $set = $this->getSet();
            if (empty($set["level"])) {
                return NULL;
            }
            $order = pdo_fetch("select id,openid,ordersn,goodsprice,agentid,paytime,officcode from " . tablename("ewei_shop_order") . " where id=:id and status>=0 and uniacid=:uniacid limit 1", array(":id" => $orderid, ":uniacid" => $_W["uniacid"]));
            if (empty($order)) {
                return NULL;
            }
            $openid = $order["openid"];
            $member = m("member")->getMember($openid);
            if (empty($member)) {
                return NULL;
            }
            $become_child = intval($set["become_child"]);
            $parent = false;
            if (empty($become_child)) {
                $parent = m("member")->getMember($member["agentid"]);
            } else {
                if (!empty($order["officcode"]) && p("offic")) {
                    $parent = pdo_fetch("select * from " . tablename("ewei_shop_member") . " where mobile = :mobile and uniacid = :uniacid limit 1 ", array(":mobile" => trim($order["officcode"]), ":uniacid" => intval($_W["uniacid"])));
                } else {
                    $parent = m("member")->getMember($member["inviter"]);
                }
            }
            $parent_is_agent = !empty($parent) && $parent["isagent"] == 1 && $parent["status"] == 1;
            $time = time();
            $become_child = intval($set["become_child"]);
            if ($parent_is_agent && $become_child == 1 && empty($member["agentid"]) && $member["id"] != $parent["id"] && empty($member["fixagentid"])) {
                $member["agentid"] = $parent["id"];
                $authorid = empty($parent["isauthor"]) ? $parent["authorid"] : $parent["id"];
                $author = p("author");
                if ($author) {
                    $author->upgradeLevelByAgent($parent["id"]);
                    pdo_update("ewei_shop_member", array("agentid" => $parent["id"], "childtime" => $time, "authorid" => $authorid), array("uniacid" => $_W["uniacid"], "id" => $member["id"]));
                } else {
                    pdo_update("ewei_shop_member", array("agentid" => $parent["id"], "childtime" => $time), array("uniacid" => $_W["uniacid"], "id" => $member["id"]));
                }
                if (p("dividend")) {
                    $this->saveRelation($member["id"], $parent["id"], 1);
                    p("dividend")->update_headsid($member["id"], $parent["id"]);
                }
                if ($author) {
                    $author_set = $author->getSet();
                    if (!empty($author_set["become"]) && ($author_set["become"] == "2" || $author_set["become"] == "5")) {
                        $can_author = false;
                        $getAgentsDownNum = $this->getAgentsDownNum($parent["openid"]);
                        if ($author_set["become"] == "2") {
                            if ($author_set["become_down1"] <= $getAgentsDownNum["level1"]) {
                                $can_author = true;
                            } else {
                                if ($author_set["become_down2"] <= $getAgentsDownNum["level2"]) {
                                    $can_author = true;
                                } else {
                                    if ($author_set["become_down3"] <= $getAgentsDownNum["level3"]) {
                                        $can_author = true;
                                    }
                                }
                            }
                        } else {
                            if ($author_set["become"] == "5") {
                                if ($author_set["become_downcount"] <= $getAgentsDownNum["total"]) {
                                    $can_author = true;
                                }
                            } else {
                                if ($author_set["become"] == "6") {
                                    $temp_parent = $parent["id"];
                                    do {
                                        $res = $author->becomeType6($temp_parent);
                                        $temp_parent = $res["agentid"];
                                    } while ($res["agentid"] != 0);
                                }
                            }
                        }
                        if ($can_author) {
                            $become_check = intval($author_set["become_check"]);
                            if (empty($member["authorblack"])) {
                                pdo_update("ewei_shop_member", array("authorstatus" => $become_check, "isauthor" => 1, "authortime" => $time), array("uniacid" => $_W["uniacid"], "id" => $parent["id"]));
                                if ($become_check == 1) {
                                    $this->sendMessage($parent["openid"], array("nickname" => $parent["nickname"], "authortime" => $time), TM_AUTHOR_BECOME);
                                }
                            }
                        }
                    }
                }
                $this->sendMessage($parent["openid"], array("nickname" => $member["nickname"], "openid" => $member["openid"], "childtime" => $time), TM_COMMISSION_AGENT_NEW);
                $this->upgradeLevelByAgent($parent["id"]);
                if (p("globonus")) {
                    p("globonus")->upgradeLevelByAgent($parent["id"]);
                }
                if (p("abonus")) {
                    p("abonus")->upgradeLevelByAgent($parent["id"]);
                }
                if (p("author")) {
                    p("author")->upgradeLevelByAgent($parent["id"]);
                }
            }
            $agentid = $member["agentid"];
            if ($member["isagent"] == 1 && $member["status"] == 1 && !empty($set["selfbuy"])) {
                $agentid = $member["id"];
            }
            if (p("offic") && !empty($order["officcode"])) {
                $agentid = $parent["id"];
                pdo_update("ewei_shop_member", array("agentid" => $parent["id"]), array("id" => $member["id"]));
            }
            if (!empty($agentid)) {
                $res = pdo_update("ewei_shop_order", array("agentid" => $agentid), array("id" => $orderid));
                $this->calculate($orderid, true, $res ? $agentid : NULL);
            } else {
                $this->calculate($orderid);
            }
        }
        public function checkOrderPay($orderid = "0")
        {
            global $_W;
            global $_GPC;
            if (empty($orderid)) {
                return NULL;
            }
            $set = $this->getSet();
            if (empty($set["level"])) {
                return NULL;
            }
            $order = pdo_fetch("select id,isparent,parentid,openid,ordersn,goodsprice,agentid,paytime,uniacid from " . tablename("ewei_shop_order") . " where id=:id and status>=1 and uniacid=:uniacid limit 1", array(":id" => $orderid, ":uniacid" => $_W["uniacid"]));
            if (empty($order)) {
                return NULL;
            }
            $openid = $order["openid"];
            $member = m("member")->getMember($openid);
            if (empty($member)) {
                return NULL;
            }
            $become_check = intval($set["become_check"]);
            $become_child = intval($set["become_child"]);
            $parent = false;
            if (empty($become_child)) {
                $parent = m("member")->getMember($member["agentid"]);
            } else {
                $parent = m("member")->getMember($member["inviter"]);
            }
            $parent_is_agent = !empty($parent) && $parent["isagent"] == 1 && $parent["status"] == 1;
            $time = time();
            $become_child = intval($set["become_child"]);
            if ($parent_is_agent && $become_child == 2 && empty($member["agentid"]) && $member["id"] != $parent["id"] && empty($member["fixagentid"])) {
                $member["agentid"] = $parent["id"];
                $authorid = empty($parent["isauthor"]) ? $parent["authorid"] : $parent["id"];
                $author = p("author");
                if ($author) {
                    $author->upgradeLevelByAgent($parent["id"]);
                    pdo_update("ewei_shop_member", array("agentid" => $parent["id"], "childtime" => $time, "authorid" => $authorid), array("uniacid" => $_W["uniacid"], "id" => $member["id"]));
                } else {
                    pdo_update("ewei_shop_member", array("agentid" => $parent["id"], "childtime" => $time), array("uniacid" => $_W["uniacid"], "id" => $member["id"]));
                }
                if (p("dividend")) {
                    $this->saveRelation($member["id"], $parent["id"], 1);
                    p("dividend")->update_headsid($member["id"], $parent["id"]);
                }
                if ($author) {
                    $author_set = $author->getSet();
                    if (!empty($author_set["become"]) && ($author_set["become"] == "2" || $author_set["become"] == "5")) {
                        $can_author = false;
                        $getAgentsDownNum = $this->getAgentsDownNum($parent["openid"]);
                        if ($author_set["become"] == "2") {
                            if ($author_set["become_down1"] <= $getAgentsDownNum["level1"]) {
                                $can_author = true;
                            } else {
                                if ($author_set["become_down2"] <= $getAgentsDownNum["level2"]) {
                                    $can_author = true;
                                } else {
                                    if ($author_set["become_down3"] <= $getAgentsDownNum["level3"]) {
                                        $can_author = true;
                                    }
                                }
                            }
                        } else {
                            if ($author_set["become"] == "5") {
                                if ($author_set["become_downcount"] <= $getAgentsDownNum["total"]) {
                                    $can_author = true;
                                }
                            } else {
                                if ($author_set["become"] == "5") {
                                    $temp_parent = $parent["id"];
                                    do {
                                        $res = $author->becomeType6($temp_parent);
                                        $temp_parent = $res["agentid"];
                                    } while ($res["agentid"] != 0);
                                }
                            }
                        }
                        if ($can_author) {
                            $become_check = intval($author_set["become_check"]);
                            if (empty($member["authorblack"])) {
                                pdo_update("ewei_shop_member", array("authorstatus" => $become_check, "isauthor" => 1, "authortime" => $time), array("uniacid" => $_W["uniacid"], "id" => $parent["id"]));
                                if ($become_check == 1) {
                                    $this->sendMessage($parent["openid"], array("nickname" => $parent["nickname"], "authortime" => $time), TM_AUTHOR_BECOME);
                                }
                            }
                        }
                    }
                }
                $this->sendMessage($parent["openid"], array("nickname" => $member["nickname"], "openid" => $member["openid"], "childtime" => $time), TM_COMMISSION_AGENT_NEW);
                $this->upgradeLevelByAgent($parent["id"]);
                if (p("globonus")) {
                    p("globonus")->upgradeLevelByAgent($parent["id"]);
                }
                if (p("abonus")) {
                    p("abonus")->upgradeLevelByAgent($parent["id"]);
                }
                if (p("author")) {
                    p("author")->upgradeLevelByAgent($parent["id"]);
                }
                if (empty($order["agentid"])) {
                    $order["agentid"] = $parent["id"];
                    if ($order["isparent"] && $order["parentid"] == 0) {
                        $merchSql = "SELECT id,merchid FROM " . tablename("ewei_shop_order") . " WHERE uniacid = " . intval($order["uniacid"]) . " AND parentid = " . intval($orderid);
                        $merchData = pdo_fetchall($merchSql);
                        foreach ($merchData as $mk => $mv) {
                            pdo_update("ewei_shop_order", array("agentid" => $parent["id"]), array("id" => $mv["id"]));
                        }
                    }
                    pdo_update("ewei_shop_order", array("agentid" => $parent["id"]), array("id" => $orderid));
                    $order_agent_id = !empty($parent["id"]) ? $parent["id"] : NULL;
                    $this->calculate($orderid, true, $order_agent_id);
                }
            }
            $isagent = $member["isagent"] == 1 && $member["status"] == 1;
            if (!$isagent) {
                if (intval($set["become"]) == 4 && !empty($set["become_goodsid"])) {
                    if (empty($set["become_order"])) {
                        $order_goods = pdo_fetchall("select goodsid from " . tablename("ewei_shop_order_goods") . " where orderid=:orderid and uniacid=:uniacid  ", array(":uniacid" => $_W["uniacid"], ":orderid" => $order["id"]), "goodsid");
                        if (in_array($set["become_goodsid"], array_keys($order_goods)) && empty($member["agentblack"])) {
                            pdo_update("ewei_shop_member", array("status" => $become_check, "isagent" => 1, "agenttime" => $become_check == 1 ? $time : 0, "applyagenttime" => 0), array("uniacid" => $_W["uniacid"], "id" => $member["id"]));
                            if ($become_check == 1) {
                                $this->sendMessage($openid, array("nickname" => $member["nickname"], "agenttime" => $time), TM_COMMISSION_BECOME);
                                if (!empty($parent)) {
                                    $this->upgradeLevelByAgent($parent["id"]);
                                    if (p("globonus")) {
                                        p("globonus")->upgradeLevelByAgent($parent["id"]);
                                    }
                                    if (p("abonus")) {
                                        p("abonus")->upgradeLevelByAgent($parent["id"]);
                                    }
                                    if (p("author")) {
                                        p("author")->upgradeLevelByAgent($parent["id"]);
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if (($set["become"] == 2 || $set["become"] == 3) && empty($set["become_order"])) {
                        $time = time();
                        $parentisagent = true;
                        if (!empty($member["agentid"])) {
                            $parent = m("member")->getMember($member["agentid"]);
                            if (empty($parent) || $parent["isagent"] != 1 || $parent["status"] != 1) {
                                $parentisagent = false;
                            }
                        }
                        $can = false;
                        if ($set["become"] == "2") {
                            $ordercount = pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_order") . " where openid=:openid and status>=1 and uniacid=:uniacid limit 1", array(":uniacid" => $_W["uniacid"], ":openid" => $openid));
                            $can = intval($set["become_ordercount"]) <= $ordercount;
                        } else {
                            if ($set["become"] == "3") {
                                $moneycount = pdo_fetchcolumn("select sum(og.realprice) from " . tablename("ewei_shop_order_goods") . " og left join " . tablename("ewei_shop_order") . " o on og.orderid=o.id  where o.openid=:openid and o.status>=1 and o.uniacid=:uniacid limit 1", array(":uniacid" => $_W["uniacid"], ":openid" => $openid));
                                $can = floatval($set["become_moneycount"]) <= $moneycount;
                            }
                        }
                        if ($can && empty($member["agentblack"])) {
                            pdo_update("ewei_shop_member", array("status" => $become_check, "isagent" => 1, "agenttime" => $time), array("uniacid" => $_W["uniacid"], "id" => $member["id"]));
                            if ($become_check == 1) {
                                $this->sendMessage($openid, array("nickname" => $member["nickname"], "agenttime" => $time), TM_COMMISSION_BECOME);
                                if ($parentisagent) {
                                    $this->upgradeLevelByAgent($parent["id"]);
                                    if (p("globonus")) {
                                        p("globonus")->upgradeLevelByAgent($parent["id"]);
                                    }
                                    if (p("abonus")) {
                                        p("abonus")->upgradeLevelByAgent($parent["id"]);
                                    }
                                    if (p("author")) {
                                        p("author")->upgradeLevelByAgent($parent["id"]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if (!empty($member["agentid"])) {
                $parent = m("member")->getMember($member["agentid"]);
                if (!empty($parent) && $parent["isagent"] == 1 && $parent["status"] == 1) {
                    $order_goods = pdo_fetchall("select g.id,g.title,og.total,og.price,og.realprice, og.optionname as optiontitle,g.noticeopenid,g.noticetype,og.commission1,og.commissions  from " . tablename("ewei_shop_order_goods") . " og " . " left join " . tablename("ewei_shop_goods") . " g on g.id=og.goodsid " . " where og.uniacid=:uniacid and og.orderid=:orderid ", array(":uniacid" => $_W["uniacid"], ":orderid" => $order["id"]));
                    $goods = "";
                    $commission_total1 = 0;
                    $commission_total2 = 0;
                    $commission_total3 = 0;
                    $pricetotal = 0;
                    foreach ($order_goods as $og) {
                        $goods .= "" . $og["title"] . "( ";
                        if (!empty($og["optiontitle"])) {
                            $goods .= " 规格: " . $og["optiontitle"];
                        }
                        $goods .= " 单价: " . $og["realprice"] / $og["total"] . " 数量: " . $og["total"] . " 总价: " . $og["realprice"] . "); ";
                        $commissions = iunserializer($og["commissions"]);
                        $commission_total1 += isset($commissions["level1"]) ? floatval($commissions["level1"]) : 0;
                        $commission_total2 += isset($commissions["level2"]) ? floatval($commissions["level2"]) : 0;
                        $commission_total3 += isset($commissions["level3"]) ? floatval($commissions["level3"]) : 0;
                        $pricetotal += $og["realprice"];
                    }
                    if ($order["agentid"] == $member["id"]) {
                        $this->sendMessage($member["openid"], array("nickname" => $member["nickname"], "ordersn" => $order["ordersn"], "orderopenid" => $order["openid"], "price" => $pricetotal, "goods" => $goods, "commission1" => $commission_total1, "commission2" => $commission_total2, "commission3" => $commission_total3, "paytime" => $order["paytime"]), TM_COMMISSION_ORDER_PAY);
                    } else {
                        if ($order["agentid"] == $parent["id"]) {
                            $this->sendMessage($parent["openid"], array("nickname" => $member["nickname"], "ordersn" => $order["ordersn"], "orderopenid" => $order["openid"], "price" => $pricetotal, "goods" => $goods, "commission1" => $commission_total1, "commission2" => $commission_total2, "commission3" => $commission_total3, "paytime" => $order["paytime"]), TM_COMMISSION_ORDER_PAY);
                        }
                    }
                    if (p("author") && !empty($member["authorid"])) {
                        $author = m("member")->getMember($member["authorid"]);
                        if (!empty($author["isauthor"]) && $author["authorstatus"]) {
                            p("author")->sendMessage($author["openid"], array("nickname" => $member["nickname"], "ordersn" => $order["ordersn"], "price" => $pricetotal, "goods" => $goods, "paytime" => $order["paytime"]), TM_AUTHOR_DOWN_PAY);
                        }
                    }
                }
            }
            if ($isagent) {
                $plugin_globonus = p("globonus");
                if (!$plugin_globonus) {
                    return NULL;
                }
                $set = $plugin_globonus->getSet();
                if (empty($set["open"])) {
                    return NULL;
                }
                if ($member["ispartner"]) {
                    return NULL;
                }
                if (strpos($member["openid"], "sns_wa_") === true) {
                    return NULL;
                }
                $become_check = intval($set["become_check"]);
                if (intval($set["become"]) == 4 && !empty($set["become_goodsid"])) {
                    if (empty($set["become_order"])) {
                        $order_goods = pdo_fetchall("select goodsid from " . tablename("ewei_shop_order_goods") . " where orderid=:orderid and uniacid=:uniacid  ", array(":uniacid" => $_W["uniacid"], ":orderid" => $order["id"]), "goodsid");
                        if (in_array($set["become_goodsid"], array_keys($order_goods)) && empty($member["partnerblack"])) {
                            pdo_update("ewei_shop_member", array("partnerstatus" => $become_check, "ispartner" => 1, "partnertime" => $become_check == 1 ? $time : 0), array("uniacid" => $_W["uniacid"], "id" => $member["id"]));
                            if ($become_check == 1) {
                                $plugin_globonus->sendMessage($openid, array("nickname" => $member["nickname"], "partnertime" => $time), TM_GLOBONUS_BECOME);
                            }
                        }
                    }
                } else {
                    if (($set["become"] == 2 || $set["become"] == 3) && empty($set["become_order"])) {
                        $time = time();
                        $can = false;
                        if ($set["become"] == "2") {
                            $ordercount = pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_order") . " where openid=:openid and status>=1 and uniacid=:uniacid limit 1", array(":uniacid" => $_W["uniacid"], ":openid" => $openid));
                            $can = intval($set["become_ordercount"]) <= $ordercount;
                        } else {
                            if ($set["become"] == "3") {
                                $moneycount = pdo_fetchcolumn("select sum(og.realprice) from " . tablename("ewei_shop_order_goods") . " og left join " . tablename("ewei_shop_order") . " o on og.orderid=o.id  where o.openid=:openid and o.status>=1 and o.uniacid=:uniacid limit 1", array(":uniacid" => $_W["uniacid"], ":openid" => $openid));
                                $can = floatval($set["become_moneycount"]) <= $moneycount;
                            }
                        }
                        if ($can && empty($member["partnerblack"])) {
                            pdo_update("ewei_shop_member", array("partnerstatus" => $become_check, "ispartner" => 1, "partnertime" => $time), array("uniacid" => $_W["uniacid"], "id" => $member["id"]));
                            if ($become_check == 1) {
                                $plugin_globonus->sendMessage($openid, array("nickname" => $member["nickname"], "partnertime" => $time), TM_GLOBONUS_BECOME);
                            }
                        }
                    }
                }
            }
        }
        public function checkOrderFinish($orderid = "")
        {
            global $_W;
            global $_GPC;
            if (empty($orderid)) {
                return NULL;
            }
            $order = pdo_fetch("select id,openid, ordersn,goodsprice,agentid,finishtime from " . tablename("ewei_shop_order") . " where id=:id and status>=3 and uniacid=:uniacid limit 1", array(":id" => $orderid, ":uniacid" => $_W["uniacid"]));
            if (empty($order)) {
                return NULL;
            }
            $set = $this->getSet();
            if (empty($set["level"])) {
                return NULL;
            }
            $openid = $order["openid"];
            $member = m("member")->getMember($openid);
            if (empty($member)) {
                return NULL;
            }
            $this->orderFinishTask($order, $set["selfbuy"] ? true : false, $member);
            $time = time();
            $become_check = intval($set["become_check"]);
            $isagent = $member["isagent"] == 1 && $member["status"] == 1;
            $parentisagent = true;
            if (!empty($member["agentid"])) {
                $parent = m("member")->getMember($member["agentid"]);
                if (empty($parent) || $parent["isagent"] != 1 || $parent["status"] != 1) {
                    $parentisagent = false;
                }
            }
            if (!$isagent && $set["become_order"] == "1") {
                if ($set["become"] == "4" && !empty($set["become_goodsid"])) {
                    $order_goods = pdo_fetchall("select goodsid from " . tablename("ewei_shop_order_goods") . " where orderid=:orderid and uniacid=:uniacid  ", array(":uniacid" => $_W["uniacid"], ":orderid" => $order["id"]), "goodsid");
                    if (in_array($set["become_goodsid"], array_keys($order_goods)) && empty($member["agentblack"])) {
                        pdo_update("ewei_shop_member", array("status" => $become_check, "isagent" => 1, "agenttime" => $become_check == 1 ? $time : 0), array("uniacid" => $_W["uniacid"], "id" => $member["id"]));
                        if ($become_check == 1) {
                            $this->sendMessage($openid, array("nickname" => $member["nickname"], "agenttime" => $time), TM_COMMISSION_BECOME);
                            if ($parentisagent) {
                                $this->upgradeLevelByAgent($parent["id"]);
                                if (p("globonus")) {
                                    p("globonus")->upgradeLevelByAgent($parent["id"]);
                                }
                                if (p("abonus")) {
                                    p("abonus")->upgradeLevelByAgent($parent["id"]);
                                }
                                if (p("author")) {
                                    p("author")->upgradeLevelByAgent($parent["id"]);
                                }
                            }
                        }
                    }
                } else {
                    if ($set["become"] == 2 || $set["become"] == 3) {
                        $can = false;
                        if ($set["become"] == "2") {
                            $ordercount = pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_order") . " where openid=:openid and status>=3 and uniacid=:uniacid limit 1", array(":uniacid" => $_W["uniacid"], ":openid" => $openid));
                            $can = intval($set["become_ordercount"]) <= $ordercount;
                        } else {
                            if ($set["become"] == "3") {
                                $moneycount = pdo_fetchcolumn("select sum(goodsprice) from " . tablename("ewei_shop_order") . " where openid=:openid and status>=3 and uniacid=:uniacid limit 1", array(":uniacid" => $_W["uniacid"], ":openid" => $openid));
                                $can = floatval($set["become_moneycount"]) <= $moneycount;
                            }
                        }
                        if ($can && empty($member["agentblack"])) {
                            pdo_update("ewei_shop_member", array("status" => $become_check, "isagent" => 1, "agenttime" => $time), array("uniacid" => $_W["uniacid"], "id" => $member["id"]));
                            if ($become_check == 1) {
                                $this->sendMessage($member["openid"], array("nickname" => $member["nickname"], "agenttime" => $time), TM_COMMISSION_BECOME);
                            }
                        }
                    }
                }
            }
            if (!empty($member["agentid"])) {
                $parent = m("member")->getMember($member["agentid"]);
                if (!empty($parent) && $parent["isagent"] == 1 && $parent["status"] == 1) {
                    $order_goods = pdo_fetchall("select g.id,g.title,og.total,og.realprice,og.price,og.optionname as optiontitle,g.noticeopenid,g.noticetype,og.commission1,og.commissions from " . tablename("ewei_shop_order_goods") . " og " . " left join " . tablename("ewei_shop_goods") . " g on g.id=og.goodsid " . " where og.uniacid=:uniacid and og.orderid=:orderid ", array(":uniacid" => $_W["uniacid"], ":orderid" => $order["id"]));
                    $goods = "";
                    $commission_total1 = 0;
                    $commission_total2 = 0;
                    $commission_total3 = 0;
                    $pricetotal = 0;
                    foreach ($order_goods as $og) {
                        $goods .= "" . $og["title"] . "( ";
                        if (!empty($og["optiontitle"])) {
                            $goods .= " 规格: " . $og["optiontitle"];
                        }
                        $goods .= " 单价: " . $og["realprice"] / $og["total"] . " 数量: " . $og["total"] . " 总价: " . $og["realprice"] . "); ";
                        $commissions = iunserializer($og["commissions"]);
                        $commission_total1 += isset($commissions["level1"]) ? floatval($commissions["level1"]) : 0;
                        $commission_total2 += isset($commissions["level2"]) ? floatval($commissions["level2"]) : 0;
                        $commission_total3 += isset($commissions["level3"]) ? floatval($commissions["level3"]) : 0;
                        $pricetotal += $og["realprice"];
                    }
                    if ($order["agentid"] == $member["id"]) {
                        $this->sendMessage($member["openid"], array("nickname" => $member["nickname"], "ordersn" => $order["ordersn"], "orderopenid" => $order["openid"], "price" => $pricetotal, "goods" => $goods, "commission1" => $commission_total1, "commission2" => $commission_total2, "commission3" => $commission_total3, "finishtime" => $order["finishtime"]), TM_COMMISSION_ORDER_FINISH);
                    } else {
                        if ($order["agentid"] == $parent["id"]) {
                            $this->sendMessage($parent["openid"], array("nickname" => $member["nickname"], "ordersn" => $order["ordersn"], "orderopenid" => $order["openid"], "price" => $pricetotal, "goods" => $goods, "commission1" => $commission_total1, "commission2" => $commission_total2, "commission3" => $commission_total3, "finishtime" => $order["finishtime"]), TM_COMMISSION_ORDER_FINISH);
                        }
                    }
                }
            }
            $abonus_plugin = p("abonus");
            if ($abonus_plugin) {
                $abonus_plugin->upgradeLevelByOrder($openid);
            }
            $this->upgradeLevelByOrder($openid);
            $this->upgradeLevelByGoods($openid, $orderid);
            if ($isagent) {
                $plugin_author = p("author");
                if ($plugin_author) {
                    $set = $plugin_author->getSet();
                    if (!empty($set["open"])) {
                        $isauthor = $member["isauthor"] && $member["authorstatus"];
                        if ($isauthor) {
                            $plugin_author->upgradeLevelByOrder($openid);
                        } else {
                            $become_check = intval($set["become_check"]);
                            if ($set["become_order"] == "1") {
                                $info = $this->getInfo($member["id"], array("ordercount3", "ordermoney3", "order13money", "order13"));
                                $can = false;
                                if ($set["become"] == "3") {
                                    $can = floatval($set["become_moneycount"]) <= floatval($info["ordermoney3"]);
                                } else {
                                    if ($set["become"] == "4") {
                                        $moneycount = pdo_fetchcolumn("select sum(goodsprice) from " . tablename("ewei_shop_order") . " where openid=:openid and status>=3 and uniacid=:uniacid limit 1", array(":uniacid" => $_W["uniacid"], ":openid" => $openid));
                                        $can = floatval($set["become_selfmoneycount"]) <= floatval($moneycount);
                                    }
                                }
                                if ($can && empty($member["authorblack"])) {
                                    pdo_update("ewei_shop_member", array("authorstatus" => $become_check, "isauthor" => 1, "authortime" => $time), array("uniacid" => $_W["uniacid"], "id" => $member["id"]));
                                    if ($become_check == 1) {
                                        $plugin_author->sendMessage($member["openid"], array("nickname" => $member["nickname"], "authortime" => $time), TM_AUTHOR_BECOME);
                                    }
                                }
                            }
                        }
                    }
                }
                $plugin_globonus = p("globonus");
                if (!$plugin_globonus) {
                    return NULL;
                }
                $set = $plugin_globonus->getSet();
                if (empty($set["open"])) {
                    return NULL;
                }
                $ispartner = $member["ispartner"] && $member["partnerstatus"];
                if ($ispartner) {
                    $plugin_globonus->upgradeLevelByOrder($openid);
                    return NULL;
                }
                $become_check = intval($set["become_check"]);
                if ($set["become_order"] == "1") {
                    if ($set["become"] == "4" && !empty($set["become_goodsid"])) {
                        $order_goods = pdo_fetchall("select goodsid from " . tablename("ewei_shop_order_goods") . " where orderid=:orderid and uniacid=:uniacid  ", array(":uniacid" => $_W["uniacid"], ":orderid" => $order["id"]), "goodsid");
                        if (in_array($set["become_goodsid"], array_keys($order_goods)) && empty($member["partnerblack"])) {
                            pdo_update("ewei_shop_member", array("partnerstatus" => $become_check, "ispartner" => 1, "partnertime" => $become_check == 1 ? $time : 0), array("uniacid" => $_W["uniacid"], "id" => $member["id"]));
                            if ($become_check == 1) {
                                $plugin_globonus->sendMessage($openid, array("nickname" => $member["nickname"], "partnertime" => $time), TM_GLOBONUS_BECOME);
                            }
                        }
                    } else {
                        if ($set["become"] == 2 || $set["become"] == 3) {
                            $can = false;
                            if ($set["become"] == "2") {
                                $ordercount = pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_order") . " where openid=:openid and status>=3 and uniacid=:uniacid limit 1", array(":uniacid" => $_W["uniacid"], ":openid" => $openid));
                                $can = intval($set["become_ordercount"]) <= $ordercount;
                            } else {
                                if ($set["become"] == "3") {
                                    $moneycount = pdo_fetchcolumn("select sum(goodsprice) from " . tablename("ewei_shop_order") . " where openid=:openid and status>=3 and uniacid=:uniacid limit 1", array(":uniacid" => $_W["uniacid"], ":openid" => $openid));
                                    $can = floatval($set["become_moneycount"]) <= $moneycount;
                                }
                            }
                            if ($can && empty($member["partnerblack"])) {
                                pdo_update("ewei_shop_member", array("partnerstatus" => $become_check, "ispartner" => 1, "partnertime" => $time), array("uniacid" => $_W["uniacid"], "id" => $member["id"]));
                                if ($become_check == 1) {
                                    $plugin_globonus->sendMessage($member["openid"], array("nickname" => $member["nickname"], "partnertime" => $time), TM_GLOBONUS_BECOME);
                                }
                            }
                        }
                    }
                }
            }
        }
        public function orderFinishTask($order, $self_buy = false, $member)
        {
            global $_W;
            if (!p("task")) {
                return NULL;
            }
            if (empty($order["agentid"])) {
                return NULL;
            }
            $order_id = $order["id"];
            $level_price_1 = $level_price_2 = $level_price_3 = 0;
            $order_goods_list = pdo_fetchall("SELECT commissions FROM " . tablename("ewei_shop_order_goods") . " WHERE orderid = :order_id AND uniacid = :uniacid AND nocommission = 0", array(":order_id" => $order_id, ":uniacid" => $_W["uniacid"]));
            if (empty($order_goods_list)) {
                return NULL;
            }
            foreach ((array) $order_goods_list as $one_order_goods) {
                $commissions = unserialize((string) $one_order_goods["commissions"]);
                if (!empty($commissions)) {
                    $level_price_1 += round((double) $commissions["level1"], 2);
                    $level_price_2 += round((double) $commissions["level2"], 2);
                    $level_price_3 += round((double) $commissions["level3"], 2);
                }
            }
            $openid1 = $openid2 = $openid3 = "";
            if (0 < $level_price_1) {
                if ($self_buy && $member["status"] == 1) {
                    $openid1 = $member["openid"];
                } else {
                    $member = m("member")->getMember($member["agentid"]);
                    $openid1 = $member["openid"];
                }
                p("task")->checkTaskReward("commission_money", $level_price_1, $openid1);
                p("task")->checkTaskProgress((int) $level_price_1, "pyramid_money", 0, $openid1);
                if (0 < $level_price_2) {
                    $member = m("member")->getMember($member["agentid"]);
                    if (empty($member)) {
                        return NULL;
                    }
                    $openid2 = $member["openid"];
                    p("task")->checkTaskReward("commission_money", $level_price_2, $openid2);
                    p("task")->checkTaskProgress((int) $level_price_2, "pyramid_money", 0, $openid2);
                    if (0 < $level_price_3) {
                        $member = m("member")->getMember($member["agentid"]);
                        if (empty($member)) {
                            return NULL;
                        }
                        $openid3 = $member["openid"];
                        p("task")->checkTaskReward("commission_money", $level_price_3, $openid3);
                        p("task")->checkTaskProgress((int) $level_price_3, "pyramid_money", 0, $openid3);
                    }
                }
            }
        }
        public function getShop($m)
        {
            global $_W;
            $member = m("member")->getMember($m);
            $shop = pdo_fetch("select * from " . tablename("ewei_shop_commission_shop") . " where uniacid=:uniacid and mid=:mid limit 1", array(":uniacid" => $_W["uniacid"], ":mid" => $member["id"]));
            $sysset = m("common")->getSysset(array("shop", "share"));
            $set = $sysset["shop"];
            $share = $sysset["share"];
            $desc = $share["desc"];
            if (empty($desc)) {
                $desc = $set["description"];
            }
            if (empty($desc)) {
                $desc = $set["name"];
            }
            $thisset = $this->getSet();
            if (empty($shop)) {
                $shop = array("name" => $member["nickname"] . "的" . $thisset["texts"]["shop"], "logo" => $member["avatar"], "desc" => $desc, "img" => tomedia($set["img"]));
            } else {
                if (empty($shop["name"])) {
                    $shop["name"] = $member["nickname"] . "的" . $thisset["texts"]["shop"];
                }
                if (empty($shop["logo"])) {
                    $shop["logo"] = tomedia($member["avatar"]);
                }
                if (empty($shop["img"])) {
                    $shop["img"] = tomedia($set["img"]);
                }
                if (empty($shop["desc"])) {
                    $shop["desc"] = $desc;
                }
            }
            return $shop;
        }
        /**
         * 获取所有分销商等级
         * @global type $_W
         * @return type
         */
        public function getLevels($all = true, $default = false)
        {
            global $_W;
            global $_S;
            if ($all) {
                $levels = pdo_fetchall("select * from " . tablename("ewei_shop_commission_level") . " where uniacid=:uniacid order by commission1 asc", array(":uniacid" => $_W["uniacid"]));
            } else {
                $levels = pdo_fetchall("select * from " . tablename("ewei_shop_commission_level") . " where uniacid=:uniacid and (ordermoney>0 or commissionmoney>0) order by commission1 asc", array(":uniacid" => $_W["uniacid"]));
            }
            if ($default) {
                $default = array("id" => "0", "levelname" => empty($_S["commission"]["levelname"]) ? "默认等级" : $_S["commission"]["levelname"], "commission1" => $_S["commission"]["commission1"], "commission2" => $_S["commission"]["commission2"], "commission3" => $_S["commission"]["commission3"], "withdraw" => (double) $_S["commission"]["withdraw_default"], "repurchase" => (double) $_S["commission"]["repurchase_default"]);
                $levels = array_merge(array($default), $levels);
            }
            return $levels;
        }
        public function getLevel($openid)
        {
            global $_W;
            if (empty($openid)) {
                return false;
            }
            $member = m("member")->getMember($openid);
            if (empty($member["agentlevel"])) {
                return false;
            }
            $level = pdo_fetch("select * from " . tablename("ewei_shop_commission_level") . " where uniacid=:uniacid and id=:id limit 1", array(":uniacid" => $_W["uniacid"], ":id" => $member["agentlevel"]));
            return $level;
        }
        /**
         * 分销商升级(根据分销订单)
         * @param type $mid
         */
        public function upgradeLevelByOrder($openid)
        {
            global $_W;
            if (empty($openid)) {
                return false;
            }
            $set = $this->getSet();
            if (empty($set["level"])) {
                return false;
            }
            $m = m("member")->getMember($openid);
            if (empty($m)) {
                return NULL;
            }
            $leveltype = intval($set["leveltype"]);
            if ($leveltype == 4 || $leveltype == 5) {
                if (!empty($m["agentnotupgrade"])) {
                    return NULL;
                }
                $oldlevel = $this->getLevel($m["openid"]);
                if (empty($oldlevel["id"])) {
                    $oldlevel = array("levelname" => empty($set["levelname"]) ? "普通等级" : $set["levelname"], "commission1" => $set["commission1"], "commission2" => $set["commission2"], "commission3" => $set["commission3"]);
                }
                $orders = pdo_fetch("select sum(og.realprice) as ordermoney,count(distinct og.orderid) as ordercount from " . tablename("ewei_shop_order") . " o " . " left join  " . tablename("ewei_shop_order_goods") . " og on og.orderid=o.id " . " where o.openid=:openid and o.status>=3 and o.uniacid=:uniacid limit 1", array(":uniacid" => $_W["uniacid"], ":openid" => $openid));
                $ordermoney = $orders["ordermoney"];
                $ordercount = $orders["ordercount"];
                if ($leveltype == 4) {
                    $newlevel = pdo_fetch("select * from " . tablename("ewei_shop_commission_level") . " where uniacid=:uniacid  and " . $ordermoney . " >= ordermoney and ordermoney>0  order by ordermoney desc limit 1", array(":uniacid" => $_W["uniacid"]));
                    if (empty($newlevel)) {
                        return NULL;
                    }
                    if (!empty($oldlevel["id"])) {
                        if ($oldlevel["id"] == $newlevel["id"]) {
                            return NULL;
                        }
                        if ($newlevel["ordermoney"] < $oldlevel["ordermoney"]) {
                            return NULL;
                        }
                    }
                } else {
                    if ($leveltype == 5) {
                        $newlevel = pdo_fetch("select * from " . tablename("ewei_shop_commission_level") . " where uniacid=:uniacid  and " . $ordercount . " >= ordercount and ordercount>0  order by ordercount desc limit 1", array(":uniacid" => $_W["uniacid"]));
                        if (empty($newlevel)) {
                            return NULL;
                        }
                        if (!empty($oldlevel["id"])) {
                            if ($oldlevel["id"] == $newlevel["id"]) {
                                return NULL;
                            }
                            if ($newlevel["ordercount"] < $oldlevel["ordercount"]) {
                                return NULL;
                            }
                        }
                    }
                }
                pdo_update("ewei_shop_member", array("agentlevel" => $newlevel["id"]), array("id" => $m["id"]));
                $this->sendMessage($m["openid"], array("nickname" => $m["nickname"], "oldlevel" => $oldlevel, "newlevel" => $newlevel), TM_COMMISSION_UPGRADE);
            } else {
                if (0 <= $leveltype && $leveltype <= 3) {
                    $agents = array();
                    if (!empty($set["selfbuy"])) {
                        $agents[] = $m;
                    }
                    if (!empty($m["agentid"])) {
                        $m1 = m("member")->getMember($m["agentid"]);
                        if (!empty($m1)) {
                            $agents[] = $m1;
                            if (!empty($m1["agentid"]) && $m1["isagent"] == 1 && $m1["status"] == 1) {
                                $m2 = m("member")->getMember($m1["agentid"]);
                                if (!empty($m2) && $m2["isagent"] == 1 && $m2["status"] == 1) {
                                    $agents[] = $m2;
                                    if (empty($set["selfbuy"]) && !empty($m2["agentid"]) && $m2["isagent"] == 1 && $m2["status"] == 1) {
                                        $m3 = m("member")->getMember($m2["agentid"]);
                                        if (!empty($m3) && $m3["isagent"] == 1 && $m3["status"] == 1) {
                                            $agents[] = $m3;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if (empty($agents)) {
                        return NULL;
                    }
                    foreach ($agents as $agent) {
                        $info = $this->getInfo($agent["id"], array("ordercount3", "ordermoney3", "order13money", "order13"));
                        if (!empty($info["agentnotupgrade"])) {
                            continue;
                        }
                        $oldlevel = $this->getLevel($agent["openid"]);
                        if (empty($oldlevel["id"])) {
                            $oldlevel = array("levelname" => empty($set["levelname"]) ? "普通等级" : $set["levelname"], "commission1" => $set["commission1"], "commission2" => $set["commission2"], "commission3" => $set["commission3"]);
                        }
                        if ($leveltype == 0) {
                            $ordermoney = $info["ordermoney3"];
                            $newlevel = pdo_fetch("select * from " . tablename("ewei_shop_commission_level") . " where uniacid=:uniacid and " . $ordermoney . " >= ordermoney and ordermoney>0  order by ordermoney desc limit 1", array(":uniacid" => $_W["uniacid"]));
                            if (empty($newlevel)) {
                                continue;
                            }
                            if (!empty($oldlevel["id"])) {
                                if ($oldlevel["id"] == $newlevel["id"]) {
                                    continue;
                                }
                                if ($newlevel["ordermoney"] < $oldlevel["ordermoney"]) {
                                    continue;
                                }
                            }
                        } else {
                            if ($leveltype == 1) {
                                $ordermoney = $info["order13money"];
                                $newlevel = pdo_fetch("select * from " . tablename("ewei_shop_commission_level") . " where uniacid=:uniacid and " . $ordermoney . " >= ordermoney and ordermoney>0  order by ordermoney desc limit 1", array(":uniacid" => $_W["uniacid"]));
                                if (empty($newlevel)) {
                                    continue;
                                }
                                if (!empty($oldlevel["id"])) {
                                    if ($oldlevel["id"] == $newlevel["id"]) {
                                        continue;
                                    }
                                    if ($newlevel["ordermoney"] < $oldlevel["ordermoney"]) {
                                        continue;
                                    }
                                }
                            } else {
                                if ($leveltype == 2) {
                                    $ordercount = $info["ordercount3"];
                                    $newlevel = pdo_fetch("select * from " . tablename("ewei_shop_commission_level") . " where uniacid=:uniacid  and " . $ordercount . " >= ordercount and ordercount>0  order by ordercount desc limit 1", array(":uniacid" => $_W["uniacid"]));
                                    if (empty($newlevel)) {
                                        continue;
                                    }
                                    if (!empty($oldlevel["id"])) {
                                        if ($oldlevel["id"] == $newlevel["id"]) {
                                            continue;
                                        }
                                        if ($newlevel["ordercount"] < $oldlevel["ordercount"]) {
                                            continue;
                                        }
                                    }
                                } else {
                                    if ($leveltype == 3) {
                                        $ordercount = $info["order13"];
                                        $newlevel = pdo_fetch("select * from " . tablename("ewei_shop_commission_level") . " where uniacid=:uniacid  and " . $ordercount . " >= ordercount and ordercount>0  order by ordercount desc limit 1", array(":uniacid" => $_W["uniacid"]));
                                        if (empty($newlevel)) {
                                            continue;
                                        }
                                        if (!empty($oldlevel["id"])) {
                                            if ($oldlevel["id"] == $newlevel["id"]) {
                                                continue;
                                            }
                                            if ($newlevel["ordercount"] < $oldlevel["ordercount"]) {
                                                continue;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        pdo_update("ewei_shop_member", array("agentlevel" => $newlevel["id"]), array("id" => $agent["id"]));
                        $this->sendMessage($agent["openid"], array("nickname" => $agent["nickname"], "oldlevel" => $oldlevel, "newlevel" => $newlevel), TM_COMMISSION_UPGRADE);
                    }
                }
            }
        }
        /**
         * 分销商升级(根据下级数)
         * @param type $mid
         */
        public function upgradeLevelByAgent($openid)
        {
            global $_W;
            if (empty($openid)) {
                return false;
            }
            $set = $this->getSet();
            if (empty($set["level"])) {
                return false;
            }
            $m = m("member")->getMember($openid);
            if (empty($m)) {
                return NULL;
            }
            $leveltype = intval($set["leveltype"]);
            if ($leveltype < 6 || 9 < $leveltype) {
                return NULL;
            }
            $info = $this->getInfo($m["id"], array());
            if ($leveltype == 6 || $leveltype == 8) {
                $agents = array($m);
                if (!empty($m["agentid"])) {
                    $m1 = m("member")->getMember($m["agentid"]);
                    if (!empty($m1)) {
                        $agents[] = $m1;
                        if (!empty($m1["agentid"]) && $m1["isagent"] == 1 && $m1["status"] == 1) {
                            $m2 = m("member")->getMember($m1["agentid"]);
                            if (!empty($m2) && $m2["isagent"] == 1 && $m2["status"] == 1) {
                                $agents[] = $m2;
                            }
                        }
                    }
                }
                if (empty($agents)) {
                    return NULL;
                }
                foreach ($agents as $agent) {
                    $info = $this->getInfo($agent["id"], array());
                    if (!empty($info["agentnotupgrade"])) {
                        continue;
                    }
                    $oldlevel = $this->getLevel($agent["openid"]);
                    if (empty($oldlevel["id"])) {
                        $oldlevel = array("levelname" => empty($set["levelname"]) ? "普通等级" : $set["levelname"], "commission1" => $set["commission1"], "commission2" => $set["commission2"], "commission3" => $set["commission3"]);
                    }
                    if ($leveltype == 6) {
                        $downs1 = pdo_fetchall("select id from " . tablename("ewei_shop_member") . " where agentid=:agentid and uniacid=:uniacid ", array(":agentid" => $m["id"], ":uniacid" => $_W["uniacid"]), "id");
                        $downcount += count($downs1);
                        if (!empty($downs1)) {
                            $downs2 = pdo_fetchall("select id from " . tablename("ewei_shop_member") . " where agentid in( " . implode(",", array_keys($downs1)) . ") and uniacid=:uniacid", array(":uniacid" => $_W["uniacid"]), "id");
                            $downcount += count($downs2);
                            if (!empty($downs2)) {
                                $downs3 = pdo_fetchall("select id from " . tablename("ewei_shop_member") . " where agentid in( " . implode(",", array_keys($downs2)) . ") and uniacid=:uniacid", array(":uniacid" => $_W["uniacid"]), "id");
                                $downcount += count($downs3);
                            }
                        }
                        $newlevel = pdo_fetch("select * from " . tablename("ewei_shop_commission_level") . " where uniacid=:uniacid  and " . $downcount . " >= downcount and downcount>0  order by downcount desc limit 1", array(":uniacid" => $_W["uniacid"]));
                    } else {
                        if ($leveltype == 8) {
                            $downcount = $info["level1"] + $info["level2"] + $info["level3"];
                            $newlevel = pdo_fetch("select * from " . tablename("ewei_shop_commission_level") . " where uniacid=:uniacid  and " . $downcount . " >= downcount and downcount>0  order by downcount desc limit 1", array(":uniacid" => $_W["uniacid"]));
                        }
                    }
                    if (empty($newlevel)) {
                        continue;
                    }
                    if ($newlevel["id"] == $oldlevel["id"]) {
                        continue;
                    }
                    if (!empty($oldlevel["id"]) && $newlevel["downcount"] < $oldlevel["downcount"]) {
                        continue;
                    }
                    pdo_update("ewei_shop_member", array("agentlevel" => $newlevel["id"]), array("id" => $agent["id"]));
                    $this->sendMessage($agent["openid"], array("nickname" => $agent["nickname"], "oldlevel" => $oldlevel, "newlevel" => $newlevel), TM_COMMISSION_UPGRADE);
                }
            } else {
                if (!empty($m["agentnotupgrade"])) {
                    return NULL;
                }
                $oldlevel = $this->getLevel($m["openid"]);
                if (empty($oldlevel["id"])) {
                    $oldlevel = array("levelname" => empty($set["levelname"]) ? "普通等级" : $set["levelname"], "commission1" => $set["commission1"], "commission2" => $set["commission2"], "commission3" => $set["commission3"]);
                }
                if ($leveltype == 7) {
                    $downcount = pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_member") . " where agentid=:agentid and uniacid=:uniacid ", array(":agentid" => $m["id"], ":uniacid" => $_W["uniacid"]));
                    $newlevel = pdo_fetch("select * from " . tablename("ewei_shop_commission_level") . " where uniacid=:uniacid  and " . $downcount . " >= downcount and downcount>0  order by downcount desc limit 1", array(":uniacid" => $_W["uniacid"]));
                } else {
                    if ($leveltype == 9) {
                        $downcount = $info["level1"];
                        $newlevel = pdo_fetch("select * from " . tablename("ewei_shop_commission_level") . " where uniacid=:uniacid  and " . $downcount . " >= downcount and downcount>0  order by downcount desc limit 1", array(":uniacid" => $_W["uniacid"]));
                    }
                }
                if (empty($newlevel)) {
                    return NULL;
                }
                if ($newlevel["id"] == $oldlevel["id"]) {
                    return NULL;
                }
                if (!empty($oldlevel["id"]) && $newlevel["downcount"] < $oldlevel["downcount"]) {
                    return NULL;
                }
                pdo_update("ewei_shop_member", array("agentlevel" => $newlevel["id"]), array("id" => $m["id"]));
                $this->sendMessage($m["openid"], array("nickname" => $m["nickname"], "oldlevel" => $oldlevel, "newlevel" => $newlevel), TM_COMMISSION_UPGRADE);
            }
        }
        /**
         * 分销商升级(根据佣金体现数)
         * @param type $mid
         */
        public function upgradeLevelByCommissionOK($openid)
        {
            global $_W;
            if (empty($openid)) {
                return false;
            }
            $set = $this->getSet();
            if (empty($set["level"])) {
                return false;
            }
            $m = m("member")->getMember($openid);
            if (empty($m)) {
                return NULL;
            }
            $leveltype = intval($set["leveltype"]);
            if ($leveltype != 10) {
                return NULL;
            }
            if (!empty($m["agentnotupgrade"])) {
                return NULL;
            }
            $oldlevel = $this->getLevel($m["openid"]);
            if (empty($oldlevel["id"])) {
                $oldlevel = array("levelname" => empty($set["levelname"]) ? "普通等级" : $set["levelname"], "commission1" => $set["commission1"], "commission2" => $set["commission2"], "commission3" => $set["commission3"]);
            }
            $info = $this->getInfo($m["id"], array("pay"));
            $commissionmoney = $info["commission_pay"];
            $newlevel = pdo_fetch("select * from " . tablename("ewei_shop_commission_level") . " where uniacid=:uniacid  and " . $commissionmoney . " >= commissionmoney and commissionmoney>0  order by commissionmoney desc limit 1", array(":uniacid" => $_W["uniacid"]));
            if (empty($newlevel)) {
                return NULL;
            }
            if ($oldlevel["id"] == $newlevel["id"]) {
                return NULL;
            }
            if (!empty($oldlevel["id"]) && $newlevel["commissionmoney"] < $oldlevel["commissionmoney"]) {
                return NULL;
            }
            pdo_update("ewei_shop_member", array("agentlevel" => $newlevel["id"]), array("id" => $m["id"]));
            $this->sendMessage($m["openid"], array("nickname" => $m["nickname"], "oldlevel" => $oldlevel, "newlevel" => $newlevel), TM_COMMISSION_UPGRADE);
        }
        /**
         * 分销商升级(根据佣金体现数)
         * @param type $mid
         */
        public function upgradeLevelByGoods($openid, $orderid)
        {
            global $_W;
            if (empty($orderid)) {
                return false;
            }
            if (empty($openid)) {
                return false;
            }
            $set = $this->getSet();
            if (empty($set["level"])) {
                return false;
            }
            $m = m("member")->getMember($openid);
            if (empty($m)) {
                return NULL;
            }
            if ($m["status"] == 0 || $m["agentblack"] == 1) {
                return NULL;
            }
            $leveltype = intval($set["leveltype"]);
            if (!empty($m["agentnotupgrade"])) {
                return NULL;
            }
            if ($leveltype != 11) {
                return NULL;
            }
            $oldlevel = $this->getLevel($m["openid"]);
            if (empty($oldlevel["id"])) {
                $oldlevel = array("levelname" => empty($set["levelname"]) ? "普通等级" : $set["levelname"], "commission1" => $set["commission1"], "commission2" => $set["commission2"], "commission3" => $set["commission3"], "level" => 0);
            }
            $orders = pdo_fetchall("select og.goodsid from " . tablename("ewei_shop_order") . " o " . " left join  " . tablename("ewei_shop_order_goods") . " og on og.orderid=o.id " . " where o.openid=:openid and o.status>=3 and o.uniacid=:uniacid and og.orderid=:orderid", array(":uniacid" => $_W["uniacid"], ":openid" => $openid, "orderid" => $orderid));
            if ($leveltype == 11) {
                $newlevel = pdo_fetchall("select * from " . tablename("ewei_shop_commission_level") . " where uniacid=:uniacid  ", array(":uniacid" => $_W["uniacid"]), "level");
                foreach ($newlevel as $key => $value) {
                    $newarray[$key] = iunserializer($value["goodsids"]);
                }
                $orders = array_column($orders, "goodsid", "goodsid");
                $leveldata = array();
                foreach ($newarray as $ke => $val) {
                    foreach ($val as $k => $v) {
                        foreach ($orders as $a => $b) {
                            if ($b == $v) {
                                array_push($leveldata, $ke);
                            }
                        }
                    }
                }
                if (empty($leveldata)) {
                    return NULL;
                }
                $biglevel = max($leveldata);
                if (empty($newlevel)) {
                    return NULL;
                }
                $newlevel = $newlevel[$biglevel];
                if (!empty($oldlevel["level"])) {
                    if ($oldlevel["level"] == $newlevel["level"]) {
                        return NULL;
                    }
                    if ($newlevel["level"] < $oldlevel["level"]) {
                        return NULL;
                    }
                }
            }
            pdo_update("ewei_shop_member", array("agentlevel" => $newlevel["id"]), array("id" => $m["id"]));
            $this->sendMessage($m["openid"], array("nickname" => $m["nickname"], "oldlevel" => $oldlevel, "newlevel" => $newlevel), TM_COMMISSION_UPGRADE);
        }
        /**
         * 消息通知
         * @param type $message_type
         * @param type $openid
         * @return type
         */
        public function sendMessage($openid = "", $data = array(), $message_type = "")
        {
            global $_W;
            global $_GPC;
            $set = $this->getSet();
            $tm = $set["tm"];
            $templateid = $tm["templateid"];
            $time = date("Y-m-d H:i:s", time());
            $member = m("member")->getMember($openid);
            $usernotice = unserialize($member["noticeset"]);
            if (!is_array($usernotice)) {
                $usernotice = array();
            }
            if ($message_type == TM_COMMISSION_AGENT_NEW && empty($usernotice["commission_agent_new"])) {
                if (p("task")) {
                    p("task")->checkTaskProgress(1, "pyramid_num", 0, $openid);
                    p("task")->checkTaskReward("commission_member", 1, $openid);
                }
                if ($tm["is_advanced"]) {
                    if ($tm["commission_agent_new_close_advanced"]) {
                        return false;
                    }
                    $tag = "commission_agent_new";
                    $text = "您新增了一个" . $set["texts"]["down"] . $data["nickname"] . "！\n" . date("Y-m-d H:i") . "\n";
                    $message = array("first" => array("value" => "亲爱的" . $member["nickname"] . "，您新增了一个" . $set["texts"]["down"] . $data["nickname"], "color" => "#ff0000"), "keyword1" => array("title" => "业务类型", "value" => "会员通知", "color" => "#000000"), "keyword2" => array("title" => "业务内容", "value" => "您新增了一个下级", "color" => "#000000"), "keyword3" => array("title" => "处理结果", "value" => "新增下级通知" . $data["nickname"], "color" => "#000000"), "keyword4" => array("title" => "操作时间", "value" => date("Y-m-d H:i:s", time()) . $data["nickname"], "color" => "#000000"), "remark" => array("value" => "\n感谢您的支持", "color" => "#000000"));
                    $toopenid = $openid;
                    $datas[] = array("name" => "昵称", "value" => $data["nickname"]);
                    $datas[] = array("name" => "下级昵称", "value" => $data["nickname"]);
                    $datas[] = array("name" => "时间", "value" => date("Y-m-d H:i:s", $data["childtime"]));
                } else {
                    $message = $tm["commission_agent_new"];
                    $message = str_replace("[昵称]", $data["nickname"], $message);
                    $message = str_replace("[下级昵称]", $data["nickname"], $message);
                    $message = str_replace("[时间]", date("Y-m-d H:i:s", $data["childtime"]), $message);
                    $msg = array("keyword1" => isset($tm["commission_agent_newtitle"]) && trim($tm["commission_agent_newtitle"]) == "新增下级通知" ? "" : array("value" => "新增下级通知", "color" => "#73a68d"), "keyword2" => array("value" => !empty($tm["commission_agent_newtitle"]) ? $tm["commission_agent_newtitle"] : "恭喜您新增下级成员", "color" => "#73a68d"), "keyword3" => array("value" => $message, "color" => "#73a68d"), "keyword4" => array("value" => date("Y-m-d H:i:s", time())));
                    return $this->sendNotice($openid, $tm, "commission_agent_new_advanced", $data, $member, $msg);
                }
            } else {
                if ($message_type == TM_COMMISSION_ORDER_PAY && empty($usernotice["commission_order_pay"])) {
                    if ($tm["is_advanced"]) {
                        if ($tm["commission_order_pay_close_advanced"]) {
                            return false;
                        }
                        $data["isagent"] = 0;
                        if ($data["orderopenid"] == $openid) {
                            $agent = $this->getAgentsByMember($openid, 1);
                            $openid = $agent[0]["openid"];
                            $data["isagent"] = 1;
                        }
                        $tag = "commission_order_pay";
                        $text = "您的" . $set["texts"]["down"] . $data["nickname"] . "已付款！\n" . date("Y-m-d H:i") . "\n";
                        $message = array("first" => array("value" => "亲爱的" . $member["nickname"] . "，您的" . $set["texts"]["down"] . $data["nickname"] . "已付款", "color" => "#ff0000"), "keyword1" => array("title" => "业务类型", "value" => "会员通知", "color" => "#000000"), "keyword2" => array("title" => "业务内容", "value" => "您的下级" . $data["nickname"] . "已经成功付款", "color" => "#000000"), "keyword3" => array("title" => "处理结果", "value" => $set["texts"]["down"] . "付款通知", "color" => "#000000"), "keyword4" => array("title" => "操作时间", "value" => date("Y-m-d H:i:s", time()), "color" => "#000000"), "remark" => array("value" => "\n感谢您的支持", "color" => "#000000"));
                        $toopenid = $openid;
                        $datas[] = array("name" => "昵称", "value" => $data["nickname"]);
                        $datas[] = array("name" => "下级昵称", "value" => $data["nickname"]);
                        $datas[] = array("name" => "时间", "value" => date("Y-m-d H:i:s", $data["paytime"]));
                        $datas[] = array("name" => "订单编号", "value" => $data["ordersn"]);
                        $datas[] = array("name" => "订单金额", "value" => $data["price"]);
                        $datas[] = array("name" => "商品详情", "value" => $data["goods"]);
                    } else {
                        $tag = "commission_order_pay";
                        $data["isagent"] = 0;
                        if ($data["orderopenid"] == $openid) {
                            $agent = $this->getAgentsByMember($openid, 1);
                            $openid = $agent[0]["openid"];
                            $data["isagent"] = 1;
                        }
                        $message = $tm["commission_order_pay"];
                        if (empty($message)) {
                            $message = $data["nickname"] . "," . date("Y-m-d H:i:s", $data["paytime"]);
                        } else {
                            $message = str_replace("[昵称]", $member["nickname"], $message);
                            $message = str_replace("[下级昵称]", $data["nickname"], $message);
                            $message = str_replace("[时间]", date("Y-m-d H:i:s", $data["paytime"]), $message);
                            $message = str_replace("[订单编号]", $data["ordersn"], $message);
                            $message = str_replace("[订单金额]", $data["price"], $message);
                            $message = str_replace("[商品详情]", $data["goods"], $message);
                        }
                        $message = mb_substr($message, 0, 160, "UTF-8") . "...";
                        $msg = array("keyword1" => isset($tm["commission_order_paytitle"]) && trim($tm["commission_order_paytitle"]) == $set["texts"]["down"] . "付款通知" ? "" : array("value" => $set["texts"]["down"] . "付款通知", "color" => "#73a68d"), "keyword2" => array("value" => !empty($tm["commission_order_paytitle"]) ? $tm["commission_order_paytitle"] : "您有下级付款了"), "keyword3" => array("value" => $message), "keyword4" => array("value" => date("Y-m-d H:i:s", time())));
                        return $this->sendNotice($openid, $tm, "commission_order_pay_advanced", $data, $member, $msg);
                    }
                } else {
                    if ($message_type == TM_COMMISSION_ORDER_FINISH && empty($usernotice["commission_order_finish"])) {
                        if ($tm["is_advanced"]) {
                            if ($tm["commission_order_finish_close_advanced"]) {
                                return false;
                            }
                            $data["isagent"] = 0;
                            if ($data["orderopenid"] == $openid) {
                                $agent = $this->getAgentsByMember($openid, 1);
                                $openid = $agent[0]["openid"];
                                $data["isagent"] = 1;
                            }
                            $tag = "commission_order_finish";
                            $text = "您的" . $set["texts"]["down"] . $data["nickname"] . "已确认收货！\n" . date("Y-m-d H:i") . "\n";
                            $message = array("first" => array("value" => "亲爱的" . $member["nickname"] . "，您的" . $set["texts"]["down"] . $data["nickname"] . "已确认收货", "color" => "#ff0000"), "keyword1" => array("title" => "业务类型", "value" => "会员通知", "color" => "#000000"), "keyword2" => array("title" => "业务内容", "value" => "您的下级" . $data["nickname"] . "已经确认收货", "color" => "#000000"), "keyword3" => array("title" => "处理结果", "value" => $set["texts"]["down"] . "收货通知", "color" => "#000000"), "keyword4" => array("title" => "操作时间", "value" => date("Y-m-d H:i:s", time()), "color" => "#000000"), "remark" => array("value" => "\n感谢您的支持", "color" => "#000000"));
                            $toopenid = $openid;
                            $datas[] = array("name" => "昵称", "value" => $member["nickname"]);
                            $datas[] = array("name" => "下级昵称", "value" => $data["nickname"]);
                            $datas[] = array("name" => "时间", "value" => date("Y-m-d H:i:s", $data["finishtime"]));
                            $datas[] = array("name" => "订单编号", "value" => $data["ordersn"]);
                            $datas[] = array("name" => "订单金额", "value" => $data["price"]);
                            $datas[] = array("name" => "商品详情", "value" => $data["goods"]);
                        } else {
                            $data["isagent"] = 0;
                            if ($data["orderopenid"] == $openid) {
                                $agent = $this->getAgentsByMember($openid, 1);
                                $openid = $agent[0]["openid"];
                                $data["isagent"] = 1;
                            }
                            $tag = "commission_order_finish";
                            $message = $tm["commission_order_finish"];
                            if (empty($message)) {
                                $message = $member["nickname"] . "," . date("Y-m-d H:i:s", $data["finishtime"]);
                            } else {
                                $message = str_replace("[昵称]", $member["nickname"], $message);
                                $message = str_replace("[下级昵称]", $data["nickname"], $message);
                                $message = str_replace("[时间]", date("Y-m-d H:i:s", $data["finishtime"]), $message);
                                $message = str_replace("[订单编号]", $data["ordersn"], $message);
                                $message = str_replace("[订单金额]", $data["price"], $message);
                                $message = str_replace("[商品详情]", $data["goods"], $message);
                            }
                            $msg = array("keyword1" => isset($tm["commission_order_finishtitle"]) && trim($tm["commission_order_finishtitle"]) == $set["texts"]["down"] . "确认收货通知" ? "" : array("value" => $set["texts"]["down"] . "确认收货通知", "color" => "#73a68d"), "keyword2" => array("value" => !empty($tm["commission_order_finishtitle"]) ? $tm["commission_order_finishtitle"] : "您有下级确认收货了", "color" => "#73a68d"), "keyword3" => array("value" => $message, "color" => "#73a68d"));
                            return $this->sendNotice($openid, $tm, "commission_order_finish_advanced", $data, $member, $msg);
                        }
                    } else {
                        if ($message_type == TM_COMMISSION_APPLY && empty($usernotice["commission_apply"])) {
                            if ($tm["is_advanced"]) {
                                if ($tm["commission_apply_close_advanced"]) {
                                    return false;
                                }
                                $tag = "commission_apply";
                                $text = "您的" . $set["texts"]["commission"] . "提现申请已提交！\n" . date("Y-m-d H:i") . "\n";
                                $message = array("first" => array("value" => "亲爱的" . $member["nickname"] . "，您的" . $set["texts"]["commission"] . "提现申请已提交", "color" => "#ff0000"), "keyword1" => array("title" => "业务类型", "value" => "会员通知", "color" => "#000000"), "keyword2" => array("title" => "业务内容", "value" => "您的佣金提现申请已提交", "color" => "#000000"), "keyword3" => array("title" => "处理结果", "value" => "提现申请提交通知", "color" => "#000000"), "keyword4" => array("title" => "操作时间", "value" => date("Y-m-d H:i:s", time()), "color" => "#000000"), "remark" => array("value" => "\n感谢您的支持", "color" => "#000000"));
                                $toopenid = $openid;
                                $datas[] = array("name" => "昵称", "value" => $member["nickname"]);
                                $datas[] = array("name" => "时间", "value" => $time);
                                $datas[] = array("name" => "金额", "value" => $data["commission"]);
                                $datas[] = array("name" => "提现方式", "value" => $data["type"]);
                            } else {
                                $message = $tm["commission_apply"];
                                if (empty($message)) {
                                    $message = $data["commission"] . "元," . date("Y-m-d H:i:s", time());
                                } else {
                                    $message = str_replace("[昵称]", $member["nickname"], $message);
                                    $message = str_replace("[时间]", date("Y-m-d H:i:s", time()), $message);
                                    $message = str_replace("[金额]", $data["commission"], $message);
                                    $message = str_replace("[提现方式]", $data["type"], $message);
                                }
                                $msg = array("keyword1" => isset($tm["commission_applytitle"]) && trim($tm["commission_applytitle"]) == "提现申请提交通知" ? "" : array("value" => "提现申请提交通知", "color" => "#73a68d"), "keyword2" => array("value" => !empty($tm["commission_applytitle"]) ? $tm["commission_applytitle"] : "您的提现申请已经提交", "color" => "#73a68d"), "keyword3" => array("value" => $message, "color" => "#73a68d"));
                                return $this->sendNotice($openid, $tm, "commission_apply_advanced", $data, $member, $msg);
                            }
                        } else {
                            if ($message_type == TM_COMMISSION_CHECK && empty($usernotice["commission_check"])) {
                                if ($tm["is_advanced"]) {
                                    if ($tm["commission_check_close_advanced"]) {
                                        return false;
                                    }
                                    $tag = "commission_check";
                                    $text = "您的" . $set["texts"]["commission"] . "提现申请已审核通过！\n" . date("Y-m-d H:i") . "\n";
                                    $message = array("first" => array("value" => "亲爱的" . $member["nickname"] . "，您的" . $set["texts"]["commission"] . "提现申请已审核通过", "color" => "#ff0000"), "keyword1" => array("title" => "业务类型", "value" => "会员通知", "color" => "#000000"), "keyword2" => array("title" => "业务内容", "value" => "您的佣金提现申请审核完成", "color" => "#000000"), "keyword3" => array("title" => "处理结果", "value" => "提现申请审核通知", "color" => "#000000"), "keyword4" => array("title" => "操作时间", "value" => date("Y-m-d H:i:s", time()), "color" => "#000000"), "remark" => array("value" => "\n感谢您的支持", "color" => "#000000"));
                                    $toopenid = $openid;
                                    $datas[] = array("name" => "昵称", "value" => $member["nickname"]);
                                    $datas[] = array("name" => "时间", "value" => $time);
                                    $datas[] = array("name" => "金额", "value" => $data["commission"]);
                                    $datas[] = array("name" => "提现方式", "value" => $data["type"]);
                                } else {
                                    $message = $tm["commission_check"];
                                    if (empty($message)) {
                                        $message = $data["commission"] . "元, " . date("Y-m-d H:i:s", time());
                                    } else {
                                        $message = str_replace("[昵称]", $member["nickname"], $message);
                                        $message = str_replace("[时间]", date("Y-m-d H:i:s", time()), $message);
                                        $message = str_replace("[金额]", $data["commission"], $message);
                                        $message = str_replace("[提现方式]", $data["type"], $message);
                                    }
                                    $msg = array("keyword1" => isset($tm["commission_checktitle"]) && trim($tm["commission_checktitle"]) == "提现申请审核完成通知" ? "" : array("value" => "提现申请审核完成通知", "color" => "#73a68d"), "keyword2" => array("value" => !empty($tm["commission_checktitle"]) ? $tm["commission_checktitle"] : "您的提现申请已完成审核", "color" => "#73a68d"), "keyword3" => array("value" => $message, "color" => "#73a68d"));
                                    return $this->sendNotice($openid, $tm, "commission_check_advanced", $data, $member, $msg);
                                }
                            } else {
                                if ($message_type == TM_COMMISSION_PAY && empty($usernotice["commission_pay"])) {
                                    if ($tm["is_advanced"]) {
                                        if ($tm["commission_pay_close_advanced"]) {
                                            return false;
                                        }
                                        $tag = "commission_pay";
                                        $text = "您的" . $set["texts"]["commission1"] . "打款成功！\n" . date("Y-m-d H:i") . "\n";
                                        $message = array("first" => array("value" => "亲爱的" . $member["nickname"] . "，您的" . $set["texts"]["commission1"] . "打款成功", "color" => "#ff0000"), "keyword1" => array("title" => "业务类型", "value" => "会员通知", "color" => "#000000"), "keyword2" => array("title" => "业务内容", "value" => "您的佣金提现已打款成功", "color" => "#000000"), "keyword3" => array("title" => "处理结果", "value" => $set["texts"]["commission1"] . "打款通知", "color" => "#000000"), "keyword4" => array("title" => "操作时间", "value" => date("Y-m-d H:i:s", time()), "color" => "#000000"), "remark" => array("value" => "\n感谢您的支持", "color" => "#000000"));
                                        $toopenid = $openid;
                                        $datas[] = array("name" => "昵称", "value" => $member["nickname"]);
                                        $datas[] = array("name" => "时间", "value" => $time);
                                        $datas[] = array("name" => "金额", "value" => $data["commission"]);
                                        $datas[] = array("name" => "提现方式", "value" => $data["type"]);
                                    } else {
                                        $message = $tm["commission_pay"];
                                        if (empty($message)) {
                                            $message = $data["commission"] . "元," . date("Y-m-d H:i:s", time());
                                        } else {
                                            $message = str_replace("[昵称]", $member["nickname"], $message);
                                            $message = str_replace("[时间]", date("Y-m-d H:i:s", time()), $message);
                                            $message = str_replace("[金额]", $data["commission"], $message);
                                            $message = str_replace("[提现方式]", $data["type"], $message);
                                        }
                                        $msg = array("keyword1" => isset($tm["commission_paytitle"]) && trim($tm["commission_paytitle"]) == "佣金打款通知" ? "" : array("value" => "佣金打款通知", "color" => "#73a68d"), "keyword2" => array("value" => !empty($tm["commission_paytitle"]) ? $tm["commission_paytitle"] : "您的佣金已打款", "color" => "#73a68d"), "keyword3" => array("value" => $message, "color" => "#73a68d"));
                                        return $this->sendNotice($openid, $tm, "commission_pay_advanced", $data, $member, $msg);
                                    }
                                } else {
                                    if ($message_type == TM_COMMISSION_UPGRADE && empty($usernotice["commission_upgrade"])) {
                                        if ($tm["is_advanced"]) {
                                            if ($tm["commission_upgrade_close_advanced"]) {
                                                return false;
                                            }
                                            $tag = "commission_upgrade";
                                            $text = "恭喜您成为" . $data["newlevel"]["levelname"] . $set["texts"]["agent"] . "！\n" . date("Y-m-d H:i") . "\n";
                                            $message = array("first" => array("value" => "亲爱的" . $member["nickname"] . "，恭喜您成为" . $data["newlevel"]["levelname"] . $set["texts"]["agent"], "color" => "#ff0000"), "keyword1" => array("title" => "业务类型", "value" => "会员通知", "color" => "#000000"), "keyword2" => array("title" => "业务内容", "value" => "您的" . $set["texts"]["agent"] . "等级从" . $data["oldlevel"]["levelname"] . "升级为" . $data["oldlevel"]["levelname"] . "特此通知!", "color" => "#000000"), "keyword3" => array("title" => "处理结果", "value" => $set["texts"]["agent"] . "等级升级通知", "color" => "#000000"), "keyword4" => array("title" => "操作时间", "value" => date("Y-m-d H:i:s", time()), "color" => "#000000"), "remark" => array("value" => "\n感谢您的支持", "color" => "#000000"));
                                            $toopenid = $openid;
                                            $datas[] = array("name" => "昵称", "value" => $member["nickname"]);
                                            $datas[] = array("name" => "时间", "value" => $time);
                                            $datas[] = array("name" => "旧等级", "value" => $data["oldlevel"]["levelname"]);
                                            $datas[] = array("name" => "旧一级分销比例", "value" => $data["oldlevel"]["commission1"] . "%");
                                            $datas[] = array("name" => "旧二级分销比例", "value" => $data["oldlevel"]["commission2"] . "%");
                                            $datas[] = array("name" => "旧三级分销比例", "value" => $data["oldlevel"]["commission3"] . "%");
                                            $datas[] = array("name" => "新等级", "value" => $data["newlevel"]["levelname"]);
                                            $datas[] = array("name" => "新一级分销比例", "value" => $data["newlevel"]["commission1"] . "%");
                                            $datas[] = array("name" => "新二级分销比例", "value" => $data["newlevel"]["commission2"] . "%");
                                            $datas[] = array("name" => "新三级分销比例", "value" => $data["newlevel"]["commission3"] . "%");
                                        } else {
                                            $message = $tm["commission_upgrade"];
                                            if (empty($message)) {
                                                $message = $data["oldlevel"]["levelname"] . "升级至" . $data["newlevel"]["levelname"] . "," . date("Y-m-d H:i:s", time());
                                            } else {
                                                $message = str_replace("[昵称]", $member["nickname"], $message);
                                                $message = str_replace("[时间]", date("Y-m-d H:i:s", time()), $message);
                                                $message = str_replace("[旧等级]", $data["oldlevel"]["levelname"], $message);
                                                $message = str_replace("[旧一级分销比例]", $data["oldlevel"]["commission1"] . "%", $message);
                                                $message = str_replace("[旧二级分销比例]", $data["oldlevel"]["commission2"] . "%", $message);
                                                $message = str_replace("[旧三级分销比例]", $data["oldlevel"]["commission3"] . "%", $message);
                                                $message = str_replace("[新等级]", $data["newlevel"]["levelname"], $message);
                                                $message = str_replace("[新一级分销比例]", $data["newlevel"]["commission1"] . "%", $message);
                                                $message = str_replace("[新二级分销比例]", $data["newlevel"]["commission2"] . "%", $message);
                                                $message = str_replace("[新三级分销比例]", $data["newlevel"]["commission3"] . "%", $message);
                                            }
                                            $msg = array("keyword1" => array("value" => $set["texts"]["agent"] . "等级升级通知", "color" => "#73a68d"), "keyword2" => array("value" => !empty($tm["commission_upgradetitle"]) ? $tm["commission_upgradetitle"] : "恭喜您升级了", "color" => "#73a68d"), "keyword3" => array("value" => $message, "color" => "#73a68d"));
                                            return $this->sendNotice($openid, $tm, "commission_upgrade_advanced", $data, $member, $msg);
                                        }
                                    } else {
                                        if ($message_type == TM_COMMISSION_BECOME && empty($usernotice["commission_become"])) {
                                            $agent = $this->getAgentsByMember($openid, 1);
                                            if (!empty($agent) && p("task")) {
                                                p("task")->checkTaskProgress(1, "child_agent", 0, $agent[0]["openid"]);
                                            }
                                            if ($tm["is_advanced"]) {
                                                if ($tm["commission_become_close_advanced"]) {
                                                    return false;
                                                }
                                                $tag = "commission_become";
                                                $text = "恭喜您" . $set["texts"]["become"] . "！\n" . date("Y-m-d H:i") . "\n";
                                                $message = array("first" => array("value" => "亲爱的" . $member["nickname"] . "，恭喜您" . $set["texts"]["become"], "color" => "#ff0000"), "keyword1" => array("title" => "业务类型", "value" => "会员通知", "color" => "#000000"), "keyword2" => array("title" => "业务内容", "value" => "成为" . $set["texts"]["agent"] . "通知", "color" => "#000000"), "keyword3" => array("title" => "处理结果", "value" => "成为" . $set["texts"]["agent"] . "通知", "color" => "#000000"), "keyword4" => array("title" => "操作时间", "value" => date("Y-m-d H:i:s", time()), "color" => "#000000"), "remark" => array("value" => "\n感谢您的支持", "color" => "#000000"));
                                                $toopenid = $openid;
                                                $datas[] = array("name" => "昵称", "value" => $data["nickname"]);
                                                $datas[] = array("name" => "时间", "value" => date("Y-m-d H:i:s", $data["agenttime"]));
                                            } else {
                                                $message = $tm["commission_become"];
                                                if (empty($message)) {
                                                    $message = $data["nickname"] . "," . date("Y-m-d H:i:s", $data["agenttime"]);
                                                } else {
                                                    $message = str_replace("[昵称]", $data["nickname"], $message);
                                                    $message = str_replace("[时间]", date("Y-m-d H:i:s", $data["agenttime"]), $message);
                                                }
                                                $msg = array("keyword1" => array("value" => "成为" . $set["texts"]["agent"] . "通知", "color" => "#73a68d"), "keyword2" => array("value" => !empty($tm["commission_becometitle"]) ? $tm["commission_becometitle"] : "恭喜您成为" . $set["texts"]["agent"], "color" => "#73a68d"), "keyword3" => array("value" => $message, "color" => "#73a68d"));
                                                return $this->sendNotice($openid, $tm, "commission_become_advanced", $data, $member, $msg);
                                            }
                                        } else {
                                            if ($message_type == TM_COMMISSION_APPLYMONEY && empty($usernotice["commission_applymoney"])) {
                                                if ($tm["is_advanced"]) {
                                                    if ($tm["commission_apply_close_notice"]) {
                                                        return false;
                                                    }
                                                    $tag = "commission_applymoney";
                                                    $text = "您有新的" . $set["texts"]["commission"] . "提现申请已提交！\n" . date("Y-m-d H:i:s") . "\n";
                                                    $message = array("first" => array("value" => "亲爱的管理员您有一条新的" . $set["texts"]["commission"] . "提现申请", "color" => "#ff0000"), "keyword1" => array("title" => "业务类型", "value" => "佣金提现", "color" => "#000000"), "keyword2" => array("title" => "业务内容", "value" => "佣金提现:" . $data["commission"] . "元", "color" => "#000000"), "keyword3" => array("title" => "处理结果", "value" => "商户名称:" . $member["nickname"], "color" => "#000000"), "keyword4" => array("title" => "操作时间", "value" => date("Y-m-d H:i:s", time()), "color" => "#000000"), "remark" => array("value" => "\n感谢您的支持", "color" => "#000000"));
                                                    $toopenid = $tm["openid"];
                                                    $datas[] = array("name" => "昵称", "value" => $member["nickname"]);
                                                    $datas[] = array("name" => "时间", "value" => $time);
                                                    $datas[] = array("name" => "金额", "value" => $data["commission"]);
                                                    $datas[] = array("name" => "提现方式", "value" => $data["type"]);
                                                } else {
                                                    $message = $tm["commission_applymoney"];
                                                    $data["commission"] = $data["commission"] . "元";
                                                    if (empty($message)) {
                                                        $message = $member["nickname"] . "," . $time;
                                                    } else {
                                                        $message = str_replace("[昵称]", $member["nickname"], $message);
                                                        $message = str_replace("[时间]", $time, $message);
                                                        $message = str_replace("[金额]", $data["commission"], $message);
                                                        $message = str_replace("[提现方式]", $data["type"], $message);
                                                    }
                                                    $msg = array("keyword1" => array("value" => $set["texts"]["agent"] . "提现通知", "color" => "#73a68d"), "keyword2" => array("value" => !empty($tm["commission_applymoneytitle"]) ? $tm["commission_applymoneytitle"] : "您有" . $set["texts"]["agent"] . "申请提现了", "color" => "#73a68d"), "keyword3" => array("value" => $message, "color" => "#000000"));
                                                    if (!empty($tm["openid2"])) {
                                                        $openids = explode(",", $tm["openid2"]);
                                                        foreach ($openids as $toopenid) {
                                                            if (empty($toopenid)) {
                                                                continue;
                                                            }
                                                            $this->sendNotice($toopenid, $tm, "commission_applymoney_advanced", $data, $member, $msg);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if ($tm["is_advanced"] && ($tag == "commission_agent_new" || $tag == "commission_order_pay" || $tag == "commission_order_finish")) {
                if (intval($tm[$tag . "_advanced_notice"]) == 0) {
                    $num = 1;
                } else {
                    if (intval($tm[$tag . "_advanced_notice"]) == 1) {
                        $num = 2;
                    } else {
                        if (intval($tm[$tag . "_advanced_notice"]) == 2) {
                            $num = 3;
                        }
                    }
                }
                $res = $this->getAgentsByMember($data["orderopenid"], $num);
                $selfbuy = $set["selfbuy"];
                if (empty($res) && $tag == "commission_agent_new") {
                    $res = $this->getAgentsByMember($data["openid"], $num);
                    $selfbuy = 0;
                }
                if ($selfbuy == 1) {
                    foreach ($res as $key => $value) {
                        if ($key == 0) {
                            foreach ($datas as $k => $v) {
                                if ($v["name"] == "佣金金额") {
                                    unset($datas[$k]);
                                }
                                if ($v["name"] == "下线层级") {
                                    unset($datas[$k]);
                                }
                            }
                            $datas[] = array("name" => $set["texts"]["down"], "value" => $set["texts"]["c2"] . $set["texts"]["down"]);
                            $datas[] = array("name" => "下线层级", "value" => $set["texts"]["c2"]);
                            if ($tag == "commission_order_finish" || $tag == "commission_order_pay") {
                                $datas[] = array("name" => "佣金金额", "value" => $data["commission2"]);
                            }
                            if ($tag == "commission_order_pay") {
                                $text = "您的二级下线" . $data["nickname"] . "已付款！";
                            } else {
                                if ($tag == "commission_order_finish") {
                                    $text = "您的二级下线" . $data["nickname"] . "已确认收货！";
                                }
                            }
                        }
                        if ($key == 1) {
                            foreach ($datas as $k => $v) {
                                if ($v["name"] == "佣金金额") {
                                    unset($datas[$k]);
                                }
                                if ($v["name"] == "下线层级") {
                                    unset($datas[$k]);
                                }
                            }
                            $datas[] = array("name" => $set["texts"]["down"], "value" => $set["texts"]["c3"] . $set["texts"]["down"]);
                            $datas[] = array("name" => "下线层级", "value" => $set["texts"]["c3"]);
                            if ($tag == "commission_order_finish" || $tag == "commission_order_pay") {
                                $datas[] = array("name" => "佣金金额", "value" => $data["commission3"]);
                            }
                            if ($tag == "commission_order_pay") {
                                $text = "您的三级下线" . $data["nickname"] . "已付款！";
                            } else {
                                if ($tag == "commission_order_finish") {
                                    $text = "您的三级下线" . $data["nickname"] . "已确认收货！";
                                }
                            }
                        }
                        m("notice")->sendNotice(array("openid" => $value["openid"], "tag" => $tag, "default" => $message, "cusdefault" => $text, "datas" => $datas, "plugin" => "commission"));
                    }
                } else {
                    if ($selfbuy == 0) {
                        foreach ($res as $key => $value) {
                            if ($key == 0) {
                                foreach ($datas as $k => $v) {
                                    if ($v["name"] == "佣金金额") {
                                        unset($datas[$k]);
                                    }
                                    if ($v["name"] == "下线层级") {
                                        unset($datas[$k]);
                                    }
                                }
                                $datas[] = array("name" => $set["texts"]["down"], "value" => $set["texts"]["c1"] . $set["texts"]["down"]);
                                $datas[] = array("name" => "下线层级", "value" => $set["texts"]["c1"]);
                                if ($tag == "commission_order_finish" || $tag == "commission_order_pay") {
                                    $datas[] = array("name" => "佣金金额", "value" => $data["commission1"]);
                                }
                                if ($tag == "commission_order_pay") {
                                    $text = "您的一级下线" . $data["nickname"] . "已付款！";
                                } else {
                                    if ($tag == "commission_order_finish") {
                                        $text = "您的一级下线" . $data["nickname"] . "已确认收货！";
                                    }
                                }
                            }
                            if ($key == 1) {
                                foreach ($datas as $k => $v) {
                                    if ($v["name"] == "佣金金额") {
                                        unset($datas[$k]);
                                    }
                                    if ($v["name"] == "下线层级") {
                                        unset($datas[$k]);
                                    }
                                }
                                $datas[] = array("name" => $set["texts"]["down"], "value" => $set["texts"]["c2"] . $set["texts"]["down"]);
                                $datas[] = array("name" => "下线层级", "value" => $set["texts"]["c2"]);
                                if ($tag == "commission_order_finish" || $tag == "commission_order_pay") {
                                    $datas[] = array("name" => "佣金金额", "value" => $data["commission2"]);
                                }
                                if ($tag == "commission_order_pay") {
                                    $text = "您的二级下线" . $data["nickname"] . "已付款！";
                                } else {
                                    if ($tag == "commission_order_finish") {
                                        $text = "您的二级下线" . $data["nickname"] . "已确认收货！";
                                    }
                                }
                            }
                            if ($key == 2) {
                                foreach ($datas as $k => $v) {
                                    if ($v["name"] == "佣金金额") {
                                        unset($datas[$k]);
                                    }
                                    if ($v["name"] == "下线层级") {
                                        unset($datas[$k]);
                                    }
                                }
                                $datas[] = array("name" => $set["texts"]["down"], "value" => $set["texts"]["c3"] . $set["texts"]["down"]);
                                $datas[] = array("name" => "下线层级", "value" => $set["texts"]["c3"]);
                                if ($tag == "commission_order_finish" || $tag == "commission_order_pay") {
                                    $datas[] = array("name" => "佣金金额", "value" => $data["commission3"]);
                                }
                                if ($tag == "commission_order_pay") {
                                    $text = "您的三级下线" . $data["nickname"] . "已付款！";
                                } else {
                                    if ($tag == "commission_order_finish") {
                                        $text = "您的三级下线" . $data["nickname"] . "已确认收货！";
                                    }
                                }
                            }
                            m("notice")->sendNotice(array("openid" => $value["openid"], "tag" => $tag, "default" => $message, "cusdefault" => $text, "datas" => $datas, "plugin" => "commission"));
                        }
                    }
                }
                return true;
            } else {
                if (!empty($tm["openid"]) && $message_type == TM_COMMISSION_APPLYMONEY) {
                    $openids = explode(",", $tm["openid"]);
                    foreach ($openids as $tmopenid) {
                        if (empty($tmopenid)) {
                            continue;
                        }
                        m("notice")->sendNotice(array("openid" => $tmopenid, "tag" => $tag, "default" => $message, "cusdefault" => $text, "datas" => $datas, "plugin" => "commission"));
                    }
                } else {
                    m("notice")->sendNotice(array("openid" => $toopenid, "tag" => $tag, "default" => $message, "cusdefault" => $text, "datas" => $datas, "plugin" => "commission"));
                }
            }
        }
        public function getTotals()
        {
            global $_W;
            return array("total1" => pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_commission_apply") . " where status=1 and uniacid=:uniacid limit 1", array(":uniacid" => $_W["uniacid"])), "total2" => pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_commission_apply") . " where status=2 and uniacid=:uniacid limit 1", array(":uniacid" => $_W["uniacid"])), "total3" => pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_commission_apply") . " where status=3 and uniacid=:uniacid limit 1", array(":uniacid" => $_W["uniacid"])), "total_1" => pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_commission_apply") . " where status=-1 and uniacid=:uniacid limit 1", array(":uniacid" => $_W["uniacid"])));
        }
        protected function sendNotice($touser, $tm, $tag, $datas, $member, $msg)
        {
            global $_W;
            if (!empty($tm["is_advanced"]) && !empty($tm[$tag])) {
                $advanced_template = pdo_fetch("select * from " . tablename("ewei_shop_member_message_template") . " where id=:id and uniacid=:uniacid limit 1", array(":id" => $tm[$tag], ":uniacid" => $_W["uniacid"]));
                if (!empty($advanced_template)) {
                    $url = !empty($advanced_template["url"]) ? $this->replaceTemplate($advanced_template["url"], $tag, $datas, $member) : "";
                    $advanced_message = array("first" => array("value" => $this->replaceTemplate($advanced_template["first"], $tag, $datas, $member), "color" => $advanced_template["firstcolor"]), "remark" => array("value" => $this->replaceTemplate($advanced_template["remark"], $tag, $datas, $member), "color" => $advanced_template["remarkcolor"]));
                    $data = iunserializer($advanced_template["data"]);
                    foreach ($data as $d) {
                        $advanced_message[$d["keywords"]] = array("value" => $this->replaceTemplate($d["value"], $tag, $datas, $member), "color" => $d["color"]);
                    }
                    $tm["templateid"] = $advanced_template["template_id"];
                    $this->sendMoreAdvanced($touser, $tm, $tag, $advanced_message, $url, $datas);
                }
            } else {
                if (empty($msg["keyword2"]["value"])) {
                    return true;
                }
                $tag = str_replace("_advanced", "", $tag);
                $this->sendMore($touser, $tm, $tag, $msg, $datas);
            }
            return true;
        }
        protected function sendMore($touser, $tm, $tag, $msg, $datas)
        {
            $res = $this->getAgentsByMember($touser, intval($tm[$tag . "_notice"]));
            $set = $this->getSet();
            $msgbk = $msg;
            $msgbk["keyword3"]["value"] = str_replace("[下线层级]", $set["texts"]["c1"], $msgbk["keyword3"]["value"]);
            $msgbk["keyword3"]["value"] = str_replace("[下线]", $set["texts"]["down"], $msgbk["keyword3"]["value"]);
            if ($tag == "commission_order_finish" || $tag == "commission_order_pay") {
                if ($datas["isagent"]) {
                    $msgbk["keyword3"]["value"] = str_replace("[佣金金额]", $datas["commission2"], $msgbk["keyword3"]["value"]);
                } else {
                    $msgbk["keyword3"]["value"] = str_replace("[佣金金额]", $datas["commission1"], $msgbk["keyword3"]["value"]);
                }
            }
            if (!empty($tm[$tag]) && !empty($tm["templateid"])) {
                m("message")->sendTplNotice($touser, $tm["templateid"], $msgbk);
            } else {
                m("message")->sendCustomNotice($touser, $msgbk);
            }
            foreach ($res as $key => $value) {
                $msgbk = $msg;
                if ($key == 0) {
                    $msgbk["keyword3"]["value"] = str_replace("[下线层级]", $set["texts"]["c2"], $msgbk["keyword3"]["value"]);
                    $msgbk["keyword3"]["value"] = str_replace("[下线]", $set["texts"]["c2"] . $set["texts"]["down"], $msgbk["keyword3"]["value"]);
                    if ($tag == "commission_order_finish" || $tag == "commission_order_pay") {
                        if ($datas["isagent"]) {
                            $msgbk["keyword3"]["value"] = str_replace("[佣金金额]", $datas["commission3"], $msgbk["keyword3"]["value"]);
                        } else {
                            $msgbk["keyword3"]["value"] = str_replace("[佣金金额]", $datas["commission2"], $msgbk["keyword3"]["value"]);
                        }
                    }
                }
                if ($key == 1) {
                    $msgbk["keyword3"]["value"] = str_replace("[下线层级]", $set["texts"]["c3"], $msgbk["keyword3"]["value"]);
                    $msgbk["keyword3"]["value"] = str_replace("[下线]", $set["texts"]["c3"] . $set["texts"]["down"], $msgbk["keyword3"]["value"]);
                    if ($tag == "commission_order_finish" || $tag == "commission_order_pay") {
                        if ($datas["isagent"]) {
                            $msgbk["keyword3"]["value"] = str_replace("[佣金金额]", 0, $msgbk["keyword3"]["value"]);
                        } else {
                            $msgbk["keyword3"]["value"] = str_replace("[佣金金额]", $datas["commission3"], $msgbk["keyword3"]["value"]);
                        }
                    }
                }
                if (!empty($tm[$tag]) && !empty($tm["templateid"])) {
                    m("message")->sendTplNotice($value["openid"], $tm["templateid"], $msgbk);
                } else {
                    m("message")->sendCustomNotice($value["openid"], $msgbk);
                }
            }
        }
        protected function sendMoreAdvanced($touser, $tm, $tag, $msg, $url, $datas)
        {
            $res = $this->getAgentsByMember($touser, intval($tm[$tag . "_notice"]));
            $set = $this->getSet();
            $msgbk = $msg;
            $msgbk = $this->replaceArray($msgbk, "[" . $set["texts"]["down"] . "]", $set["texts"]["c1"] . $set["texts"]["down"]);
            $msgbk = $this->replaceArray($msgbk, "[下线层级]", $set["texts"]["c1"]);
            if ($tag == "commission_order_finish_advanced" || $tag == "commission_order_pay_advanced") {
                $msgbk = $this->replaceArray($msgbk, "[佣金金额]", $datas["commission1"]);
            }
            if (!empty($tm[$tag]) && !empty($tm["templateid"])) {
                m("message")->sendTplNotice($touser, $tm["templateid"], $msgbk, $url);
            } else {
                m("message")->sendCustomNotice($touser, $msgbk, $url);
            }
            foreach ($res as $key => $value) {
                if ($key == 0) {
                    $msgbk = $msg;
                    $msgbk = $this->replaceArray($msgbk, "[" . $set["texts"]["down"] . "]", $set["texts"]["c2"] . $set["texts"]["down"]);
                    $msgbk = $this->replaceArray($msgbk, "[下线层级]", $set["texts"]["c2"]);
                    if ($tag == "commission_order_finish_advanced" || $tag == "commission_order_pay_advanced") {
                        $msgbk = $this->replaceArray($msgbk, "[佣金金额]", $datas["commission2"]);
                    }
                }
                if ($key == 1) {
                    $msgbk = $msg;
                    $msgbk = $this->replaceArray($msgbk, "[" . $set["texts"]["down"] . "]", $set["texts"]["c3"] . $set["texts"]["down"]);
                    $msgbk = $this->replaceArray($msgbk, "[下线层级]", $set["texts"]["c3"]);
                    if ($tag == "commission_order_finish_advanced" || $tag == "commission_order_pay_advanced") {
                        $msgbk = $this->replaceArray($msgbk, "[佣金金额]", $datas["commission3"]);
                    }
                }
                if (!empty($tm[$tag]) && !empty($tm["templateid"])) {
                    m("message")->sendTplNotice($value["openid"], $tm["templateid"], $msgbk, $url);
                } else {
                    m("message")->sendCustomNotice($value["openid"], $msgbk, $url);
                }
            }
        }
        protected function replaceArray(array $array, $str, $replace_str)
        {
            foreach ($array as $key => &$value) {
                foreach ($value as $k => &$v) {
                    $v = str_replace($str, $replace_str, $v);
                }
                unset($v);
            }
            unset($value);
            return $array;
        }
        protected function replaceTemplate($str, $tag, $data, $member)
        {
            $arr = $this->templateValue($member, $data);
            switch ($tag) {
                case "commission_become_advanced":
                    $arr["[时间]"] = date("Y-m-d H:i:s", $data["agenttime"]);
                    $arr["[下级昵称]"] = $data["nickname"];
                    $arr["[昵称]"] = $data["nickname"];
                    break;
                case "commission_agent_new_advanced":
                    $arr["[时间]"] = date("Y-m-d H:i:s", $data["childtime"]);
                    $arr["[下级昵称]"] = $data["nickname"];
                    $arr["[昵称]"] = $data["nickname"];
                    break;
                case "commission_order_pay_advanced":
                    $arr["[时间]"] = date("Y-m-d H:i:s", $data["paytime"]);
                    $arr["[下级昵称]"] = $data["nickname"];
                    $arr["[昵称]"] = $data["nickname"];
                    break;
                case "commission_order_finish_advanced":
                    $arr["[时间]"] = date("Y-m-d H:i:s", $data["finishtime"]);
                    $arr["[下级昵称]"] = $data["nickname"];
                    $arr["[昵称]"] = $data["nickname"];
                    break;
            }
            foreach ($arr as $key => $value) {
                $str = str_replace($key, $value, $str);
            }
            return $str;
        }
        protected function templateValue($member, $data)
        {
            $set = $this->getSet();
            return array("[昵称]" => $member["nickname"], "[时间]" => date("Y-m-d H:i:s", time()), "[金额]" => !empty($data["commission"]) ? $data["commission"] : "", "[提现方式]" => !empty($data["type"]) ? $data["type"] : "", "[订单编号]" => !empty($data["ordersn"]) ? $data["ordersn"] : "", "[订单金额]" => !empty($data["price"]) ? $data["price"] : "", "[商品详情]" => !empty($data["goods"]) ? $data["goods"] : "", "[旧等级]" => !empty($data["oldlevel"]["levelname"]) ? $data["oldlevel"]["levelname"] : "", "[旧一级分销比例]" => !empty($data["oldlevel"]["commission1"]) ? $data["oldlevel"]["commission1"] . "%" : "", "[旧二级分销比例]" => !empty($data["oldlevel"]["commission2"]) ? $data["oldlevel"]["commission2"] . "%" : "", "[旧三级分销比例]" => !empty($data["oldlevel"]["commission3"]) ? $data["oldlevel"]["commission3"] . "%" : "", "[新等级]" => !empty($data["newlevel"]["levelname"]) ? $data["newlevel"]["levelname"] : "", "[新一级分销比例]" => !empty($data["newlevel"]["commission1"]) ? $data["newlevel"]["commission1"] . "%" : "", "[新二级分销比例]" => !empty($data["newlevel"]["commission2"]) ? $data["newlevel"]["commission2"] . "%" : "", "[新三级分销比例]" => !empty($data["newlevel"]["commission3"]) ? $data["newlevel"]["commission3"] . "%" : "", "[下线]" => "[" . $set["texts"]["down"] . "]");
        }
        public function getLastApply($mid, $type = -1)
        {
            global $_W;
            $params = array(":uniacid" => $_W["uniacid"], ":mid" => $mid);
            $sql = "select type,alipay,bankname,bankcard,realname from " . tablename("ewei_shop_commission_apply") . " where mid=:mid and uniacid=:uniacid";
            if (-1 < $type) {
                $sql .= " and type=:type";
                $params[":type"] = $type;
            }
            $sql .= " order by id desc Limit 1";
            $data = pdo_fetch($sql, $params);
            return $data;
        }
        public function getRepurchase($openid, array $time)
        {
            global $_W;
            if (empty($openid) || empty($time)) {
                return NULL;
            }
            $set = $this->getSet();
            $agentLevel = $this->getLevel($openid);
            if ($agentLevel) {
                $repurchase_price = (double) $agentLevel["repurchase"];
            } else {
                $repurchase_price = (double) $set["repurchase_default"];
            }
            $residue = 0;
            $month_array = array();
            foreach ($time as $value) {
                $time1 = strtotime(date($value . "-1"));
                $time2 = strtotime("+1 months", $time1);
                if (!empty($repurchase_price)) {
                    $order_price = (double) pdo_fetchcolumn("SELECT SUM(price) as price FROM " . tablename("ewei_shop_order") . " WHERE `uniacid`=:uniacid AND `openid`=:openid AND `status`>2 AND `createtime` BETWEEN :time1 AND :time2", array(":uniacid" => $_W["uniacid"], ":openid" => $openid, ":time1" => $time1, ":time2" => $time2));
                    $year_month = explode("-", $value);
                    $year_month[0] = (int) $year_month[0];
                    $year_month[1] = (int) $year_month[1];
                    $residue_price = (double) pdo_fetchcolumn("SELECT SUM(repurchase) FROM " . tablename("ewei_shop_commission_repurchase") . " WHERE `uniacid`=:uniacid AND `openid`=:openid AND `year`=:year AND `month`=:month", array(":uniacid" => $_W["uniacid"], ":openid" => $openid, ":year" => $year_month[0], ":month" => $year_month[1]));
                    $month_array[$value] = max($repurchase_price - ($order_price + $residue_price), 0);
                }
            }
            return $month_array;
        }
        /**
         * @param array $level 数组中有两个参数 一个是等级,一个是新等级
         * @param array $levels 分销商等级数组
         * @return bool 如果新等级大于 原等级 则返回true 否则 false
         */
        public function compareLevel(array $level, array $levels = array())
        {
            global $_W;
            $old_key = -1;
            $new_key = -1;
            $levels = !empty($levels) ? $levels : $this->getLevels();
            foreach ($levels as $kk => $vv) {
                if ($vv["id"] == $level[0]) {
                    $old_key = $kk;
                }
                if ($vv["id"] == $level[1]) {
                    $new_key = $kk;
                }
            }
            return $old_key < $new_key;
        }
        public function getAgentLevel($member, $mid)
        {
            global $_W;
            $level1_agentids = $member["level1_agentids"];
            $level2_agentids = $member["level2_agentids"];
            $level3_agentids = $member["level3_agentids"];
            if (!empty($level1_agentids) && array_key_exists($mid, $level1_agentids)) {
                return 1;
            }
            if (!empty($level2_agentids) && array_key_exists($mid, $level2_agentids)) {
                return 2;
            }
            if (!empty($level3_agentids) && array_key_exists($mid, $level3_agentids)) {
                return 3;
            }
            return 0;
        }
        public function getAllDown($openid)
        {
            global $_W;
            if (empty($openid)) {
                return false;
            }
            $uid = (int) $openid;
            if ($uid == 0) {
                $info = pdo_fetch("select id,openid,uniacid,agentid,isagent,status from " . tablename("ewei_shop_member") . " where  openid=:openid and uniacid=:uniacid limit 1", array(":uniacid" => $_W["uniacid"], ":openid" => $openid));
                if (empty($info)) {
                    return false;
                }
                $uid = $info["id"];
            }
            $agents = pdo_fetchall("select id,openid,uniacid,agentid,isagent,nickname,agenttime,createtime,avatar,status,realname,mobile,weixin from " . tablename("ewei_shop_member") . " where uniacid=:uniacid and agentid=:agentid", array(":uniacid" => $_W["uniacid"], ":agentid" => $uid));
            $ids = array();
            $openids = array();
            $users = array();
            foreach ($agents as $val) {
                $ids[] = $val["id"];
                $openids[] = $val["openid"];
                $users[$val["id"]] = $val;
                if ($val["isagent"] && $val["status"]) {
                    $arr = $this->getAllDown($val["id"]);
                    if ($arr) {
                        $ids = array_merge($ids, $arr["ids"]);
                        $openids = array_merge($openids, $arr["openids"]);
                        $users = array_merge($users, $arr["users"]);
                    }
                }
            }
            return array("ids" => $ids, "openids" => $openids, "users" => $users);
        }
        public function getAllDownOrder($openid, $start = 0, $end = 0)
        {
            global $_W;
            $down = $this->getAllDown($openid);
            if (!is_numeric($start)) {
                $start = strtotime($start);
            }
            if (!is_numeric($end)) {
                $end = strtotime($end);
            }
            if (!empty($down["openids"])) {
                $order = pdo_fetchall("SELECT * FROM " . tablename("ewei_shop_order") . " WHERE uniacid=:uniacid AND openid IN ('" . implode("','", $down["openids"]) . "') AND createtime BETWEEN :time1 AND :time2 AND ccard>0", array(":uniacid" => $_W["uniacid"], ":time1" => $start, ":time2" => $end));
                if ($order) {
                    return array("openids" => $down["openids"], "order" => $order);
                }
            }
            return false;
        }
        public static function inArray($item, $array)
        {
            $flipArray = array_flip($array);
            return isset($flipArray[$item]);
        }
        public function saveRelation($id, $pid, $level = 1, $later = array())
        {
            if ($id == $pid) {
                return false;
            }
            if (!empty($later)) {
                if (self::inArray($pid, $later)) {
                    $member = pdo_fetch("select * from " . tablename("ewei_shop_member") . " where id = :id", array(":id" => $pid));
                    return $member;
                }
            } else {
                $later[] = $id;
            }
            $later[] = $pid;
            $level = max($level, 1);
            if ($level == 1 && 0 < $pid) {
                pdo_insert("ewei_shop_commission_relation", array("id" => $id, "pid" => $pid, "level" => $level), true);
            }
            $childs = pdo_fetchall("select id,`level` from " . tablename("ewei_shop_commission_relation") . " where pid = :pid", array(":pid" => $id));
            if (!empty($childs)) {
                foreach ($childs as $child) {
                    if (0 < $pid) {
                        pdo_insert("ewei_shop_commission_relation", array("id" => $child["id"], "pid" => $pid, "level" => ++$child["level"]), true);
                    } else {
                        pdo_query("delete from  `ims_ewei_shop_commission_relation` where id = :id and `level` > :level", array("id" => $child["id"], ":level" => $child["level"]));
                    }
                }
            }
            $parent = pdo_fetch("select id,uniacid,agentid from " . tablename("ewei_shop_member") . " where id = :id", array(":id" => $pid));
            if (!empty($parent)) {
                if (empty($parent["agentid"]) || $parent["agentid"] == $parent["id"]) {
                    return false;
                }
                if ($id == $parent["agentid"]) {
                    $member = pdo_fetch("select * from " . tablename("ewei_shop_member") . " where id = :id", array(":id" => $id));
                    return $member;
                }
                pdo_insert("ewei_shop_commission_relation", array("id" => $id, "pid" => $parent["agentid"], "level" => ++$level), true);
                return $this->saveRelation($id, $parent["agentid"], $level, $later);
            }
            return true;
        }
        /**
         * 删除会员关系树
         * @author Young
         * @param $id
         */
        public function delRelation($id = 0)
        {
            $parent = pdo_fetchall("select * from " . tablename("ewei_shop_commission_relation") . " where id =:id", array(":id" => $id));
            if (!empty($parent)) {
                foreach ($parent as $p) {
                    pdo_query("DELETE FROM " . tablename("ewei_shop_commission_relation") . " WHERE id = " . $p["id"] . " and level >=" . $p["level"]);
                }
            }
            pdo_delete("ewei_shop_commission_relation", array("id" => $id));
        }
        /**
         * 上级修改为别的上级
         * @author Young
         * @param string $id 要修改的ID
         * @param null $pid 上级ID 可为空
         */
        public function modify($id, $pid = NULL)
        {
            pdo_delete("ewei_shop_commission_relation", array("id" => $id));
            if (!empty($pid)) {
                $this->saveRelation($id, $pid);
            }
            $parent = pdo_fetchall("select * from " . tablename("ewei_shop_commission_relation") . " where pid =:pid", array(":pid" => $id));
            foreach ($parent as $item) {
                pdo_query("DELETE FROM " . tablename("ewei_shop_commission_relation") . " WHERE id = " . $item["id"] . " and level >" . $item["level"]);
                $this->saveRelation($item["id"], $item["pid"], $item["level"]);
            }
        }
    }
}

?>