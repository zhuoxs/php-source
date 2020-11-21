<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}
require_once EWEI_SHOPV2_PLUGIN . "app/core/page_mobile.php";
class Log_EweiShopV2Page extends AppMobilePage
{
    public function getlist()
    {
        global $_W;
        global $_GPC;
        $openid = $_W["openid"];
        $member = m("member")->getMember($openid);
        $shop = m("common")->getSysset("shop");
        $uniacid = $_W["uniacid"];
        $status = intval($_GPC["status"]);
        $set = m("common")->getPluginset("creditshop");
        $merchid = intval($_W["merchid"]);
        $pindex = max(1, intval($_GPC["page"]));
        $psize = 10;
        $condition = " and log.openid=:openid and  log.uniacid = :uniacid and log.status>0";
        if (0 < $merchid) {
            $condition .= " and log.merchid = " . $merchid . " ";
        }
        $params = array(":uniacid" => $_W["uniacid"], ":openid" => $openid);
        if ($status == 1) {
            $condition .= " and g.type = 0 ";
        } else {
            if ($status == 2) {
                $condition .= " and g.type = 1 ";
            }
        }
        $sql = "SELECT COUNT(*) FROM " . tablename("ewei_shop_creditshop_log") . " log\r\n                left join " . tablename("ewei_shop_creditshop_goods") . " g on log.goodsid = g.id\r\n                where 1 " . $condition;
        $total = pdo_fetchcolumn($sql, $params);
        $list = array();
        if (!empty($total)) {
            $sql = "SELECT log.id,log.logno,log.goodsid,log.goods_num,log.status,log.eno,log.paystatus,g.title,g.type,g.thumb,log.credit,log.money,log.dispatch,g.isverify,g.goodstype,log.addressid,log.storeid," . "g.goodstype,log.time_send,log.time_finish,log.iscomment,op.title as optiontitleg,g.merchid " . " FROM " . tablename("ewei_shop_creditshop_log") . " log " . " left join " . tablename("ewei_shop_creditshop_goods") . " g on log.goodsid = g.id " . " left join " . tablename("ewei_shop_creditshop_option") . " op on op.id = log.optionid " . " where 1 " . $condition . " ORDER BY log.createtime DESC LIMIT " . ($pindex - 1) * $psize . "," . $psize;
            $list = pdo_fetchall($sql, $params);
            $list = set_medias($list, "thumb");
            foreach ($list as &$row) {
                if (0 < $row["credit"] & 0 < $row["money"]) {
                    $row["acttype"] = 0;
                } else {
                    if (0 < $row["credit"]) {
                        $row["acttype"] = 1;
                    } else {
                        if (0 < $row["money"]) {
                            $row["acttype"] = 2;
                        } else {
                            $row["acttype"] = 3;
                        }
                    }
                }
                if ($row["money"] - intval($row["money"]) == 0) {
                    $row["money"] = intval($row["money"]);
                }
                $row["isreply"] = $set["isreply"];
                if ($row["type"] == 0) {
                    if ($row["goodstype"] == 0) {
                        if ($row["isverify"] == 1) {
                            if ($row["status"] == 2) {
                                $row["status_name"] = "待兑换";
                            }
                            if ($row["isreply"] == 1) {
                                if ($row["status"] == 3 && $row["iscomment"] == 0) {
                                    $row["status_name"] = "待评价";
                                }
                                if ($row["status"] == 3 && $row["iscomment"] == 1) {
                                    $row["status_name"] = "追加评价";
                                }
                                if ($row["status"] == 3 && $row["iscomment"] == 2) {
                                    $row["status_name"] = "已完成";
                                }
                            } else {
                                if ($row["status"] == 3) {
                                    $row["status_name"] = "已完成";
                                }
                            }
                        } else {
                            if ($row["status"] == 2 && $row["addressid"] == 0) {
                                $row["status_name"] = "已兑换";
                            }
                            if ($row["status"] == 2 && 0 < $row["addressid"] && $row["time_send"] == 0) {
                                $row["status_name"] = "待发货";
                            }
                            if ($row["status"] == 3 && 0 < $row["addressid"] && $row["time_send"] == 0) {
                                $row["status_name"] = "待发货";
                            }
                            if ($row["status"] == 3 && 0 < $row["time_send"] && $row["time_finish"] == 0) {
                                $row["status_name"] = "待收货";
                            }
                            if ($row["isreply"] == 1) {
                                if ($row["status"] == 3 && 0 < $row["time_finish"] && $row["iscomment"] == 0) {
                                    $row["status_name"] = "待评价";
                                }
                                if ($row["status"] == 3 && 0 < $row["time_finish"] && $row["iscomment"] == 1) {
                                    $row["status_name"] = "追加评价";
                                }
                                if ($row["status"] == 3 && 0 < $row["time_finish"] && $row["iscomment"] == 2) {
                                    $row["status_name"] = "已完成";
                                }
                            } else {
                                if ($row["status"] == 3) {
                                    $row["status_name"] = "已完成";
                                }
                            }
                        }
                    } else {
                        if ($row["goodstype"] == 1) {
                            if ($row["isreply"] == 1) {
                                if ($row["status"] == 3 && $row["iscomment"] == 0) {
                                    $row["status_name"] = "待评价";
                                }
                                if ($row["status"] == 3 && $row["iscomment"] == 1) {
                                    $row["status_name"] = "追加评价";
                                }
                                if ($row["status"] == 3 && $row["iscomment"] == 2) {
                                    $row["status_name"] = "已发放";
                                }
                            } else {
                                if ($row["status"] == 3) {
                                    $row["status_name"] = "已发放";
                                }
                            }
                        } else {
                            if ($row["goodstype"] == 2) {
                                if ($row["isreply"] == 1) {
                                    if ($row["status"] == 3 && $row["iscomment"] == 0) {
                                        $row["status_name"] = "待评价";
                                    }
                                    if ($row["status"] == 3 && $row["iscomment"] == 1) {
                                        $row["status_name"] = "追加评价";
                                    }
                                    if ($row["status"] == 3 && $row["iscomment"] == 2) {
                                        $row["status_name"] = "已发放";
                                    }
                                } else {
                                    if ($row["status"] == 3) {
                                        $row["status_name"] = "已发放";
                                    }
                                }
                            } else {
                                if ($row["goodstype"] == 3) {
                                    if ($row["status"] == 2) {
                                        $row["status_name"] = "待领取";
                                    }
                                    if ($row["isreply"] == 1) {
                                        if ($row["status"] == 3 && $row["iscomment"] == 0) {
                                            $row["status_name"] = "待评价";
                                        }
                                        if ($row["status"] == 3 && $row["iscomment"] == 1) {
                                            $row["status_name"] = "追加评价";
                                        }
                                        if ($row["status"] == 3 && $row["iscomment"] == 2) {
                                            $row["status_name"] = "已发放";
                                        }
                                    } else {
                                        if ($row["status"] == 3) {
                                            $row["status_name"] = "已发放";
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if ($row["goodstype"] == 0) {
                        if ($row["isverify"] == 1) {
                            if ($row["status"] == 2) {
                                $row["status_name"] = "待兑换";
                            }
                            if ($row["isreply"] == 1) {
                                if ($row["status"] == 3 && $row["iscomment"] == 0) {
                                    $row["status_name"] = "待评价";
                                }
                                if ($row["status"] == 3 && $row["iscomment"] == 1) {
                                    $row["status_name"] = "追加评价";
                                }
                                if ($row["status"] == 3 && $row["iscomment"] == 2) {
                                    $row["status_name"] = "已完成";
                                }
                            } else {
                                if ($row["status"] == 3) {
                                    $row["status_name"] = "已完成";
                                }
                            }
                        } else {
                            if ($row["status"] == 2 && $row["addressid"] == 0) {
                                $row["status_name"] = "已中奖";
                            }
                            if ($row["status"] == 2 && 0 < $row["addressid"]) {
                                $row["status_name"] = "待收货";
                            }
                            if ($row["status"] == 2 && 0 < $row["addressid"] && $row["time_send"] == 0) {
                                $row["status_name"] = "待发货";
                            }
                            if ($row["status"] == 3 && 0 < $row["addressid"] && $row["time_send"] == 0) {
                                $row["status_name"] = "待发货";
                            }
                            if ($row["status"] == 3 && 0 < $row["time_send"] && $row["time_finish"] == 0) {
                                $row["status_name"] = "待收货";
                            }
                            if ($row["isreply"] == 1) {
                                if ($row["status"] == 3 && 0 < $row["time_finish"] && $row["iscomment"] == 0) {
                                    $row["status_name"] = "待评价";
                                }
                                if ($row["status"] == 3 && 0 < $row["time_finish"] && $row["iscomment"] == 1) {
                                    $row["status_name"] = "追加评价";
                                }
                                if ($row["status"] == 3 && 0 < $row["time_finish"] && $row["iscomment"] == 2) {
                                    $row["status_name"] = "已完成";
                                }
                            } else {
                                if ($row["status"] == 3) {
                                    $row["status_name"] = "已完成";
                                }
                            }
                        }
                    } else {
                        if ($row["goodstype"] == 1) {
                            if ($row["isreply"] == 1) {
                                if ($row["status"] == 3 && $row["iscomment"] == 0) {
                                    $row["status_name"] = "待评价";
                                }
                                if ($row["status"] == 3 && $row["iscomment"] == 1) {
                                    $row["status_name"] = "追加评价";
                                }
                                if ($row["status"] == 3 && $row["iscomment"] == 2) {
                                    $row["status_name"] = "已发放";
                                }
                            } else {
                                if ($row["status"] == 3) {
                                    $row["status_name"] = "已发放";
                                }
                            }
                        } else {
                            if ($row["goodstype"] == 2) {
                                if ($row["isreply"] == 1) {
                                    if ($row["status"] == 3 && $row["iscomment"] == 0) {
                                        $row["status_name"] = "待评价";
                                    }
                                    if ($row["status"] == 3 && $row["iscomment"] == 1) {
                                        $row["status_name"] = "追加评价";
                                    }
                                    if ($row["status"] == 3 && $row["iscomment"] == 2) {
                                        $row["status_name"] = "已发放";
                                    }
                                } else {
                                    if ($row["status"] == 3) {
                                        $row["status_name"] = "已发放";
                                    }
                                }
                            } else {
                                if ($row["goodstype"] == 3) {
                                    if ($row["status"] == 2) {
                                        $row["status_name"] = "待领取";
                                    }
                                    if ($row["isreply"] == 1) {
                                        if ($row["status"] == 3 && $row["iscomment"] == 0) {
                                            $row["status_name"] = "待评价";
                                        }
                                        if ($row["status"] == 3 && $row["iscomment"] == 1) {
                                            $row["status_name"] = "追加评价";
                                        }
                                        if ($row["status"] == 3 && $row["iscomment"] == 2) {
                                            $row["status_name"] = "已发放";
                                        }
                                    } else {
                                        if ($row["status"] == 3) {
                                            $row["status_name"] = "已发放";
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if ($row["status"] == 1) {
                        $row["status_name"] = "暂未中奖";
                    }
                }
            }
            unset($row);
        }
        return app_json(array("list" => $list, "pagesize" => $psize, "total" => $total, "next_page" => ceil($total / $psize)));
    }
    public function detail()
    {
        global $_W;
        global $_GPC;
        $openid = trim($_W["openid"]);
        $merch_plugin = p("merch");
        $merch_data = m("common")->getPluginset("merch");
        if ($merch_plugin && $merch_data["is_openmerch"]) {
            $is_openmerch = 1;
        } else {
            $is_openmerch = 0;
        }
        $member = m("member")->getMember($openid);
        $shop = m("common")->getSysset("shop");
        $uniacid = $_W["uniacid"];
        $set = m("common")->getPluginset("creditshop");
        $pay = m("common")->getSysset("pay");
        $merchid = intval($_W["merchid"]);
        $condition = " and uniacid=:uniacid ";
        $id = intval($_GPC["id"]);
        $log = pdo_fetch("select * from " . tablename("ewei_shop_creditshop_log") . " where id=:id and openid=:openid " . $condition . " limit 1", array(":id" => $id, ":openid" => $openid, ":uniacid" => $uniacid));
        $log["goods_num"] = max(1, intval($log["goods_num"]));
        $log["createtimestr"] = date("Y-m-d H:i:s", $log["createtime"]);
        $log["time_sendstr"] = date("Y-m-d H:i:s", $log["time_send"]);
        $log["time_finishstr"] = date("Y-m-d H:i:s", $log["time_finish"]);
        if (empty($log)) {
            return app_error(AppError::$ExchangeRecordNotFound, "兑换记录不存在！");
        }
        $goods = p("creditshop")->getGoods($log["goodsid"], $member, $log["optionid"]);
        $ordermoney = price_format($goods["money"] * $log["goods_num"], 2);
        $ordercredit = $goods["credit"] * $log["goods_num"];
        if (empty($goods["id"])) {
            return app_error(AppError::$GoodsNotFound, "商品记录不存在！");
        }
        $address = false;
        if (!empty($log["addressid"])) {
            $address = pdo_fetch("select * from " . tablename("ewei_shop_member_address") . " where id=:id and openid=:openid and uniacid=:uniacid limit 1", array(":id" => $log["addressid"], ":uniacid" => $uniacid, ":openid" => $openid));
            $goods["dispatch"] = p("creditshop")->dispatchPrice($log["goodsid"], $log["addressid"], $log["optionid"], $log["goods_num"]);
        }
        if ($goods["type"] == 1 && $goods["goodstype"] == 0 && empty($log["addressid"]) && $goods["isverify"] == 0) {
            $address = pdo_fetch("select * from " . tablename("ewei_shop_member_address") . " where openid=:openid and deleted=0 and isdefault=1  and uniacid=:uniacid limit 1", array(":uniacid" => $uniacid, ":openid" => $openid));
        }
        $goods["currenttime"] = time();
        $stores = array();
        $store = false;
        if (!empty($goods["isverify"])) {
            $verifytotal = pdo_fetchcolumn("select count(1) from " . tablename("ewei_shop_creditshop_verify") . " where logid = :id and openid=:openid " . $condition . " and verifycode = :verifycode ", array(":id" => $id, ":openid" => $log["openid"], ":uniacid" => $log["uniacid"], ":verifycode" => $log["eno"]));
            if ($goods["verifytype"] == 0) {
                $verify = pdo_fetch("select isverify from " . tablename("ewei_shop_creditshop_verify") . " where logid = :id and openid=:openid " . $condition . " and verifycode = :verifycode ", array(":id" => $log["id"], ":openid" => $log["openid"], ":uniacid" => $log["uniacid"], ":verifycode" => $log["eno"]));
            }
            $verifynum = $log["verifynum"] - $verifytotal;
            if ($verifynum < 0) {
                $verifynum = 0;
            }
            $storeids = array();
            $storeids = array_merge(explode(",", $log["storeid"]), $storeids);
            if (empty($log["storeid"])) {
                if (0 < $merchid) {
                    $stores = pdo_fetchall("select * from " . tablename("ewei_shop_merch_store") . " where  uniacid=:uniacid and merchid=:merchid and status=1 and type in(2,3)", array(":uniacid" => $_W["uniacid"], ":merchid" => $merchid));
                } else {
                    $stores = pdo_fetchall("select * from " . tablename("ewei_shop_store") . " where  uniacid=:uniacid and status=1 and type in(2,3)", array(":uniacid" => $_W["uniacid"]));
                }
            } else {
                if (0 < $merchid) {
                    $stores = pdo_fetchall("select * from " . tablename("ewei_shop_merch_store") . " where id in (" . implode(",", $storeids) . ") and uniacid=:uniacid and merchid=:merchid and status=1 and type in(2,3)", array(":uniacid" => $_W["uniacid"], ":merchid" => $merchid));
                } else {
                    $stores = pdo_fetchall("select * from " . tablename("ewei_shop_store") . " where id in (" . implode(",", $storeids) . ") and uniacid=:uniacid and status=1 and type in(2,3)", array(":uniacid" => $_W["uniacid"]));
                }
            }
            $isverify = pdo_fetch("select * from " . tablename("ewei_shop_creditshop_verify") . "\r\n            where logid = " . $log["id"] . " " . $condition . " and isverify = 1 limit 1 ", array(":uniacid" => $log["uniacid"]));
            if (0 < $isverify["isverify"]) {
                $carrier = m("member")->getMember($isverify["verifier"]);
                if (!is_array($carrier) || empty($carrier)) {
                    $carrier = false;
                }
                $store = pdo_fetch("select * from " . tablename("ewei_shop_store") . "\r\n                    where id = " . $isverify["storeid"] . " and uniacid=:uniacid and status=1 and `type` in(2,3)", array(":uniacid" => $_W["uniacid"]));
            }
        }
        return app_json(array("store" => $store, "set" => $set, "stores" => $stores, "goods" => $goods, "verifynum" => $verifynum, "ordercredit" => $ordercredit, "ordermoney" => $ordermoney, "address" => $address, "carrier" => $carrier, "shop" => $_W["shopset"]["shop"], "verify" => $verify, "log" => $log));
    }
    public function Receivepacket()
    {
        global $_W;
        global $_GPC;
        $openid = $_W["openid"];
        $uniacid = $_W["uniacid"];
        $set = m("common")->getPluginset("creditshop");
        $merchid = intval($_W["merchid"]);
        $condition = " and uniacid = " . $uniacid . " ";
        if (0 < $merchid) {
            $condition .= " and merchid = " . $merchid . " ";
        }
        $logid = intval($_GPC["id"]);
        $log = pdo_fetch("select * from " . tablename("ewei_shop_creditshop_log") . " where id = " . $logid . " " . $condition . " ");
        if (!$log) {
            return app_error(AppError::$logNotFound, "该订单不存在或已删除！");
        }
        if (2 < $log["status"] && 0 < $log["time_finish"]) {
            return app_error(AppError::$PacketGet, "红包已领取！");
        }
        if ($log["status"] < 2) {
            return app_error(AppError::$PacketDissatisfyCondition, "红包为满足领取条件！");
        }
        $packet = p("creditshop")->packetmoney($log["goodsid"]);
        if (!$packet["status"]) {
            return app_error(array("message" => $packet["message"]));
        }
        $money = abs($packet["money"]);
        $params = array("openid" => $openid, "tid" => $log["logno"], "send_name" => $set["sendname"] ? $set["sendname"] : $_W["shopset"]["shop"]["name"], "money" => $money, "wishing" => $set["wishing"] ? $set["wishing"] : "红包领到手抽筋，别人加班你加薪!", "act_name" => "积分兑换红包", "remark" => "积分兑换红包");
        $goods = pdo_fetch("select surplusmoney from " . tablename("ewei_shop_creditshop_goods") . " where id = " . $log["goodsid"] . " " . $condition . " ");
        if ($goods["surplusmoney"] <= 0 || $goods["surplusmoney"] - $money < 0) {
            return app_error(AppError::$MoneyInsufficient, "剩余金额不足，请联系管理员！");
        }
        $err = m("common")->sendredpack($params);
        if (is_error($err)) {
            return app_error(AppError::$PacketError, "红包发放出错，请联系管理员！");
        }
        $update["time_finish"] = time();
        $update["status"] = 3;
        pdo_update("ewei_shop_creditshop_log", $update, array("id" => $logid));
        $updategoods["surplusmoney"] = $goods["surplusmoney"] - $money;
        pdo_update("ewei_shop_creditshop_goods", $updategoods, array("id" => $log["goodsid"]));
        return app_json();
    }
    public function finish()
    {
        global $_W;
        global $_GPC;
        $logid = intval($_GPC["id"]);
        $merchid = intval($_W["merchid"]);
        $condition = " and uniacid=:uniacid ";
        if (0 < $merchid) {
            $condition .= " and merchid = " . $merchid . " ";
        }
        $log = pdo_fetch("select * from " . tablename("ewei_shop_creditshop_log") . " where id=:id " . $condition . " and openid=:openid limit 1", array(":id" => $logid, ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"]));
        if (empty($log)) {
            return app_error(AppError::$ExchangeRecordNotFound, "订单未找到");
        }
        if ($log["status"] != 3 && empty($log["expresssn"])) {
            return app_error(AppError::$OrderNotTake, "订单不能确认收货");
        }
        pdo_update("ewei_shop_creditshop_log", array("time_finish" => time()), array("id" => $logid, "uniacid" => $_W["uniacid"]));
        return app_json();
    }
    public function paydispatch()
    {
        global $_W;
        global $_GPC;
        $openid = trim($_W["openid"]);
        $member = m("member")->getMember($openid);
        $shop = m("common")->getSysset("shop");
        $uniacid = $_W["uniacid"];
        $paytype = "wechat";
        $merchid = intval($_W["merchid"]);
        $dispatchprice = floatval($_GPC["dispatchprice"]);
        $condition = " and uniacid=:uniacid ";
        if (0 < $merchid) {
            $condition .= " and merchid = " . $merchid . " ";
        }
        $id = intval($_GPC["id"]);
        $addressid = intval($_GPC["addressid"]);
        $log = pdo_fetch("select * from " . tablename("ewei_shop_creditshop_log") . " where id=:id and openid=:openid " . $condition . " limit 1", array(":id" => $id, ":openid" => $openid, ":uniacid" => $uniacid));
        if (empty($log)) {
            return app_error(AppError::$ParamsError, "兑换记录不存在");
        }
        $goods = p("creditshop")->getGoods($log["goodsid"], $member);
        if (empty($goods["id"])) {
            return app_error(AppError::$ParamsError, "商品记录不存在");
        }
        if (!empty($goods["isendtime"]) && $goods["endtime"] < time()) {
            return app_error(AppError::$ParamsError, "商品已过期");
        }
        if ($goods["dispatch"] <= 0) {
            pdo_update("ewei_shop_creditshop_log", array("dispatchstatus" => 1, "addressid" => $addressid), array("id" => $log["id"]));
            return app_error(array("logid" => $log["id"]));
        }
        if (1 < $log["dispatchstatus"]) {
            return app_error(AppError::$ParamsError, "商品已支付运费");
        }
        $set = m("common")->getSysset(array("shop", "pay"));
        if ($paytype == "wechat") {
            if (empty($set["pay"]["wxapp"]) && $this->iswxapp) {
                return app_error(AppError::$OrderPayFail, "未开启微信支付");
            }
            $wechat = array("success" => false);
            $dispatchno = $log["dispatchno"];
            if (empty($dispatchno)) {
                if (empty($goods["type"])) {
                    $dispatchno = str_replace("EE", "EP", $log["logno"]);
                } else {
                    $dispatchno = str_replace("EL", "EP", $log["logno"]);
                }
                pdo_update("ewei_shop_creditshop_log", array("dispatchno" => $dispatchno, "addressid" => $addressid, "dispatch" => $dispatchprice), array("id" => $log["id"]));
            }
            $tid = $dispatchno;
            $payinfo = array("openid" => $_W["openid_wa"], "title" => $set["shop"]["name"] . (empty($goods["type"]) ? "积分兑换" : "积分抽奖") . " 支付运费单号:" . $dispatchno, "tid" => $tid, "fee" => $dispatchprice);
            $res = $this->model->wxpay($payinfo, 3);
            if (!is_error($res)) {
                $wechat = array("success" => true, "payinfo" => $res);
            } else {
                $wechat["payinfo"] = $res;
            }
            if (!$wechat["success"]) {
                return app_error(AppError::$ParamsError, "微信支付参数错误");
            }
        }
        return app_json(array("logid" => $log["id"], "wechat" => $wechat, "jssdkconfig" => json_encode($_W["account"]["jssdkconfig"])));
    }
    public function paydispatchresult()
    {
        global $_W;
        global $_GPC;
        $openid = trim($_W["openid"]);
        $member = m("member")->getMember($openid);
        $shop = m("common")->getSysset("shop");
        $uniacid = intval($_W["uniacid"]);
        $condition = " and uniacid=:uniacid ";
        $id = intval($_GPC["id"]);
        $log = pdo_fetch("select * from " . tablename("ewei_shop_creditshop_log") . " where id=:id and openid=:openid " . $condition . " limit 1", array(":id" => $id, ":openid" => $openid, ":uniacid" => $uniacid));
        if (empty($log)) {
            return app_error(AppError::$ParamsError, "兑换记录不存在");
        }
        pdo_update("ewei_shop_creditshop_log", array("dispatchstatus" => 1), array("id" => $log["id"]));
        return app_json();
    }
    public function express()
    {
        global $_W;
        global $_GPC;
        $openid = $_W["openid"];
        $uniacid = $_W["uniacid"];
        $orderid = intval($_GPC["id"]);
        if (empty($orderid)) {
            return app_error(AppError::$OrderNotFound);
        }
        $order = pdo_fetch("select expresscom,expresssn,addressid,status,express from " . tablename("ewei_shop_creditshop_log") . " where id=:id and uniacid=:uniacid and openid=:openid limit 1", array(":id" => $orderid, ":uniacid" => $uniacid, ":openid" => $openid));
        if (empty($order)) {
            return app_error(AppError::$OrderNotFound);
        }
        if (empty($order["addressid"])) {
            return app_error(AppError::$OrderNoExpress);
        }
        if ($order["status"] < 2) {
            return app_error(AppError::$OrderNoExpress);
        }
        $goods = pdo_fetchall("select og.goodsid,g.thumb  from " . tablename("ewei_shop_creditshop_log") . " og " . " left join " . tablename("ewei_shop_creditshop_goods") . " g on g.id=og.goodsid " . " where og.id=:orderid and og.uniacid=:uniacid ", array(":uniacid" => $uniacid, ":orderid" => $orderid));
        $expresslist = m("util")->getExpressList($order["express"], $order["expresssn"]);
        $status = "";
        if (!empty($expresslist)) {
            if (strexists($expresslist[0]["step"], "已签收")) {
                $status = "已签收";
            } else {
                if (count($expresslist) <= 2) {
                    $status = "备货中";
                } else {
                    $status = "配送中";
                }
            }
        }
        return app_json(array("com" => $order["expresscom"], "sn" => $order["expresssn"], "status" => $status, "count" => count($goods), "thumb" => tomedia($goods[0]["thumb"]), "expresslist" => $expresslist));
    }
}

?>