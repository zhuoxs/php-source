<?php
if (!defined("IN_IA")) {
    exit("Access Denied");
}
require_once EWEI_SHOPV2_PLUGIN . "app/core/page_mobile.php";
class Detail_EweiShopV2Page extends AppMobilePage
{
    public function main()
    {
        global $_W;
        global $_GPC;
        $openid = $_W["openid"];
        $uniacid = $_W["uniacid"];
        $id = intval($_GPC["id"]);
        $merch_plugin = p("merch");
        $merch_data = m("common")->getPluginset("merch");
        if ($merch_plugin && $merch_data["is_openmerch"]) {
            $is_openmerch = 1;
        } else {
            $is_openmerch = 0;
        }
        $merchid = intval($_GPC["merchid"]);
        $_W["merchid"] = $merchid;
        if (!$id) {
            return app_error(AppError::$ParamsError, "参数错误");
        }
        $shop = m("common")->getSysset("shop");
        $member = m("member")->getMember($openid);
        $goods = p("creditshop")->getGoods($id, $member);
        if (empty($goods)) {
            return app_error(AppError::$GoodsNotFound, "商品未找到");
        }
        $showgoods = m("goods")->visit($goods, $member);
        if (empty($showgoods)) {
            return app_error(AppError::$GoodsNotFound, "您没有权限浏览此商品");
        }
        $pay = m("common")->getSysset("pay");
        $set = m("common")->getPluginset("creditshop");
        $goods["subdetail"] = m("common")->html_to_images($goods["subdetail"]);
        $goods["noticedetail"] = m("common")->html_to_images($goods["noticedetail"]);
        $goods["usedetail"] = m("common")->html_to_images($goods["usedetail"]);
        $goods["goodsdetail"] = m("common")->html_to_images($goods["goodsdetail"]);
        $credit = $member["credit1"];
        $money = $member["credit2"];
        if (!empty($goods)) {
            pdo_update("ewei_shop_creditshop_goods", array("views" => $goods["views"] + 1), array("id" => $id));
            $goods["followed"] = m("user")->followed($openid);
            if (is_array($goods["dispatch"])) {
                $goods["dispatchprice"] = number_format($goods["dispatch"]["min"], 2) . "~" . number_format($goods["dispatch"]["max"], 2) . "元";
            } else {
                $goods["dispatchprice"] = 0 < $goods["dispatch"] ? price_format($goods["dispatch"], 2) . "元" : "包邮";
            }
            $log = array();
            $log = pdo_fetchall("select openid,createtime from " . tablename("ewei_shop_creditshop_log") . "\r\n                where uniacid = " . $uniacid . " and goodsid = " . $id . " and status > 0 order by createtime desc limit 5 ");
            foreach ($log as $key => $value) {
                $mem = m("member")->getMember($value["openid"]);
                $log[$key]["avatar"] = tomedia($mem["avatar"]);
                $log[$key]["nickname"] = $mem["nickname"];
                $log[$key]["createtime_str"] = date("Y/m/d H:i", $value["createtime"]);
                unset($mem);
            }
            $logtotal = 0;
            $logtotal = pdo_fetchcolumn("select count(1) from " . tablename("ewei_shop_creditshop_log") . " where uniacid = " . $uniacid . " and goodsid = " . $id . " and status > 0 ");
            $logmore = 1 < ceil($logtotal / 5);
            $replys = array();
            $replys = pdo_fetchall("select * from " . tablename("ewei_shop_creditshop_comment") . "\r\n                where uniacid = " . $uniacid . " and goodsid = " . $id . " and checked = 1 and deleted = 0 order by `time` desc limit 5 ");
            $replykeywords = explode(",", $set["desckeyword"]);
            $replykeystr = trim($set["replykeyword"]);
            if (empty($replykeystr)) {
                $replykeystr = "**";
            }
            foreach ($replys as $key => $value) {
                foreach ($replykeywords as $k => $val) {
                    if (!empty($value["content"]) && !strstr($val, $value["content"])) {
                        $value["content"] = str_replace($val, $replykeystr, $value["content"]);
                    }
                    if (!empty($value["reply_content"]) && !strstr($val, $value["reply_content"])) {
                        $value["reply_content"] = str_replace($val, $replykeystr, $value["reply_content"]);
                    }
                    if (!empty($value["append_content"]) && !strstr($val, $value["append_content"])) {
                        $value["append_content"] = str_replace($val, $replykeystr, $value["append_content"]);
                    }
                    if (!empty($value["append_reply_content"]) && !strstr($val, $value["append_reply_content"])) {
                        $value["append_reply_content"] = str_replace($val, $replykeystr, $value["append_reply_content"]);
                    }
                }
                $replys[$key]["content"] = $value["content"];
                $replys[$key]["reply_content"] = $value["reply_content"];
                $replys[$key]["append_content"] = $value["append_content"];
                $replys[$key]["append_reply_content"] = $value["append_reply_content"];
                $replys[$key]["time_str"] = date("Y/m/d", $value["time"]);
                $replys[$key]["images"] = set_medias(iunserializer($value["images"]));
                $replys[$key]["reply_images"] = set_medias(iunserializer($value["reply_images"]));
                $replys[$key]["append_images"] = set_medias(iunserializer($value["append_images"]));
                $replys[$key]["append_reply_images"] = set_medias(iunserializer($value["append_reply_images"]));
                $replys[$key]["nickname"] = cut_str($value["nickname"], 1, 0) . "**" . cut_str($value["nickname"], 1, -1);
                $replys[$key]["content"] = str_replace("=", "**", $value["content"]);
                $replys[$key]["append_time_str"] = date("Y/m/d", $value["append_time"]);
            }
            $replytotal = 0;
            $replytotal = pdo_fetchcolumn("select count(1) from " . tablename("ewei_shop_creditshop_comment") . "\r\n                where uniacid = " . $uniacid . " and goodsid = " . $id . " and checked = 1 and deleted = 0 order by `time` desc ");
            $replymore = 1 < ceil($replytotal / 5);
            $stores = array();
            if ($goods["goodstype"] == 0 && !empty($goods["isverify"])) {
                $storeids = array();
                if (!empty($goods["storeids"])) {
                    $storeids = array_merge(explode(",", $goods["storeids"]), $storeids);
                }
                if (empty($storeids)) {
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
            }
            $goodsrec = pdo_fetchall("select id,thumb,title,credit,money,mincredit,minmoney from " . tablename("ewei_shop_creditshop_goods") . "\r\n                    where goodstype = :goodstype and `type` = :gtype and uniacid = :uniacid and status = 1 and deleted = 0 ORDER BY rand() limit 3 ", array(":goodstype" => $goods["goodstype"], ":gtype" => $goods["type"], ":uniacid" => $uniacid));
            foreach ($goodsrec as $key => $value) {
                $goodsrec[$key]["credit"] = intval($value["credit"]);
                $goodsrec[$key]["thumb"] = tomedia($value["thumb"]);
                if (intval($value["money"]) - $value["money"] == 0) {
                    $goodsrec[$key]["money"] = intval($value["money"]);
                }
                $goodsrec[$key]["mincredit"] = intval($value["mincredit"]);
                if (intval($value["minmoney"]) - $value["minmoney"] == 0) {
                    $goodsrec[$key]["minmoney"] = intval($value["minmoney"]);
                }
            }
            return app_json(array("goods" => $goods, "log" => $log, "logmore" => $logmore, "stores" => $stores, "replys" => $replys, "replymore" => $replymore, "goodsrec" => $goodsrec));
        } else {
            return app_error(AppError::$GoodsNotFound, "商品已下架或被删除");
        }
    }
    public function getlistlog()
    {
        global $_W;
        global $_GPC;
        $uniacid = $_W["uniacid"];
        $goodsid = intval($_GPC["id"]);
        $pindex = max(1, intval($_GPC["page"]));
        $psize = 5;
        $log = array();
        $log = pdo_fetchall("select openid,createtime from " . tablename("ewei_shop_creditshop_log") . "\r\n                where uniacid = " . $uniacid . " and goodsid = " . $goodsid . " order by createtime desc LIMIT " . ($pindex - 1) * $psize . " , " . $psize);
        foreach ($log as $key => $value) {
            $mem = m("member")->getMember($value["openid"]);
            $log[$key]["avatar"] = $mem["avatar"];
            $log[$key]["nickname"] = $mem["nickname"];
            $log[$key]["createtime_str"] = date("Y/m/d H:i", $value["createtime"]);
            unset($mem);
        }
        $logtotal = 0;
        $logtotal = pdo_fetchcolumn("select count(1) from " . tablename("ewei_shop_creditshop_log") . " where uniacid = " . $uniacid . " and goodsid = " . $goodsid . " and status > 0 ");
        $more = $pindex < ceil($logtotal / $psize);
        return app_json(array("list" => $log, "pagesize" => $psize, "total" => $logtotal, "more" => $more));
    }
    public function getlistreply()
    {
        global $_W;
        global $_GPC;
        $uniacid = $_W["uniacid"];
        $goodsid = intval($_GPC["id"]);
        $pindex = max(1, intval($_GPC["page"]));
        $psize = 5;
        $replys = array();
        $replys = pdo_fetchall("select * from " . tablename("ewei_shop_creditshop_comment") . "\r\n                where uniacid = " . $uniacid . " and goodsid = " . $goodsid . " and checked = 1 and deleted = 0 order by `time` desc LIMIT " . ($pindex - 1) * $psize . " , " . $psize);
        foreach ($replys as $key => $value) {
            $replys[$key]["time_str"] = date("Y/m/d", $value["time"]);
            $replys[$key]["images"] = set_medias(iunserializer($value["images"]));
            $replys[$key]["reply_images"] = set_medias(iunserializer($value["reply_images"]));
            $replys[$key]["append_images"] = set_medias(iunserializer($value["append_images"]));
            $replys[$key]["append_reply_images"] = set_medias(iunserializer($value["append_reply_images"]));
            $replys[$key]["nickname"] = cut_str($value["nickname"], 1, 0) . "**" . cut_str($value["nickname"], 1, -1);
        }
        $replytotal = 0;
        $replytotal = pdo_fetchcolumn("select count(1) from " . tablename("ewei_shop_creditshop_comment") . "\r\n                where uniacid = " . $uniacid . " and goodsid = " . $goodsid . " and checked = 1 and deleted = 0 ");
        $more = $pindex < ceil($replytotal / $psize);
        return app_json(array("list" => $replys, "pagesize" => $psize, "total" => $replytotal, "more" => $more));
    }
    public function option()
    {
        global $_W;
        global $_GPC;
        $id = intval($_GPC["id"]);
        $uniacid = intval($_W["uniacid"]);
        $goods = pdo_fetch("select id,thumb,credit,money,total,title from " . tablename("ewei_shop_creditshop_goods") . " where id= :id and uniacid = :uniacid ", array(":id" => $id, ":uniacid" => $uniacid));
        $goods = set_medias($goods, "thumb");
        $specs = false;
        $options = false;
        $specs = pdo_fetchall("select * from " . tablename("ewei_shop_creditshop_spec") . " where goodsid=:goodsid and uniacid=:uniacid order by displayorder asc", array(":goodsid" => $id, ":uniacid" => $_W["uniacid"]));
        foreach ($specs as &$spec) {
            $spec["items"] = pdo_fetchall("select * from " . tablename("ewei_shop_creditshop_spec_item") . " where specid=:specid and `show`=1 order by displayorder asc", array(":specid" => $spec["id"]));
        }
        unset($spec);
        $options = pdo_fetchall("select * from " . tablename("ewei_shop_creditshop_option") . " where goodsid=:goodsid and uniacid=:uniacid order by displayorder asc", array(":goodsid" => $id, ":uniacid" => $uniacid));
        if (!empty($specs)) {
            foreach ($specs as $key => $value) {
                foreach ($specs[$key]["items"] as $k => &$v) {
                    $v["thumb"] = tomedia($v["thumb"]);
                }
            }
        }
        if (!$options) {
            return app_error(AppError::$GoodsNotFound, "商品规格不存在");
        }
        return app_json(array("specs" => $specs, "options" => $options, "goods" => $goods));
    }
    public function pay($a = array(), $b = array())
    {
        global $_W;
        global $_GPC;
        $openid = $_W["openid"];
        $uniacid = $_W["uniacid"];
        $num = max(1, $_GPC["num"]);
        $id = intval($_GPC["id"]);
        $shop = m("common")->getSysset("shop");
        $member = m("member")->getMember($openid);
        $optionid = intval($_GPC["optionid"]);
        $goods = p("creditshop")->getGoods($id, $member, $optionid, $num);
        $credit = $member["credit1"];
        $money = $member["credit2"];
        $paytype = $_GPC["paytype"];
        $addressid = intval($_GPC["addressid"]);
        $storeid = intval($_GPC["storeid"]);
        $paystatus = 0;
        $dispatch = 0;
        if ($goods["hasoption"] && $optionid) {
            $option = pdo_fetch("select total from " . tablename("ewei_shop_creditshop_option") . " where uniacid = " . $uniacid . " and id = " . $optionid . " and goodsid = " . $id . " ");
            if ($option["total"] <= 0) {
                return app_error(AppError::$CanBuy, $goods["buymsg"]);
            }
        }
        if ($addressid) {
            $dispatch = p("creditshop")->dispatchPrice($id, $addressid, $optionid, $num);
        }
        $goods["dispatch"] = $dispatch;
        if (empty($goods["canbuy"])) {
            return app_error(AppError::$CanBuy, $goods["buymsg"]);
        }
        $needpay = false;
        if (0 < $goods["money"] || 0 < floatval($goods["dispatch"])) {
            pdo_delete("ewei_shop_creditshop_log", array("goodsid" => $id, "openid" => $openid, "status" => 0, "paystatus" => 0));
            $needpay = true;
            $lastlog = pdo_fetch("select * from " . tablename("ewei_shop_creditshop_log") . " where goodsid=:goodsid and openid=:openid  and status=0 and paystatus=1 and uniacid=:uniacid limit 1", array(":goodsid" => $id, ":openid" => $openid, ":uniacid" => $uniacid));
            if (!empty($lastlog)) {
                return app_json(array("logid" => $lastlog["id"]));
            }
        } else {
            pdo_delete("ewei_shop_creditshop_log", array("goodsid" => $id, "openid" => $openid, "status" => 0));
        }
        $dispatchstatus = 0;
        if ($goods["isverify"] == 1 || 0 < $goods["goodstype"] || $goods["dispatch"] == 0 || $goods["type"] == 1) {
            $dispatchstatus = -1;
        }
        $address = false;
        if (!empty($addressid)) {
            $address = pdo_fetch("select id,realname,mobile,address,province,city,area from " . tablename("ewei_shop_member_address") . "\r\n            where id=:id and uniacid=:uniacid limit 1", array(":id" => $addressid, ":uniacid" => $_W["uniacid"]));
            if (empty($address)) {
                return app_error(AppError::$NotFoundAddress, "未找到地址");
            }
        }
        $log = array("uniacid" => $uniacid, "merchid" => intval($goods["merchid"]), "openid" => $openid, "logno" => m("common")->createNO("creditshop_log", "logno", $goods["type"] == 0 ? "EE" : "EL"), "goodsid" => $id, "storeid" => $storeid, "optionid" => $optionid, "addressid" => $addressid, "address" => iserializer($address), "status" => 0, "paystatus" => 0 < $goods["money"] ? 0 : -1, "dispatchstatus" => $dispatchstatus, "createtime" => time(), "realname" => trim($_GPC["realname"]), "mobile" => trim($_GPC["mobile"]), "goods_num" => $num, "paytype" => 0);
        pdo_insert("ewei_shop_creditshop_log", $log);
        $logid = pdo_insertid();
        if (!empty($log["realname"]) && !empty($log["mobile"])) {
            $up = array("realname" => $log["realname"], "carrier_mobile" => $log["mobile"]);
            pdo_update("ewei_shop_member", $up, array("id" => $member["id"], "uniacid" => $_W["uniacid"]));
            if (!empty($member["uid"])) {
                mc_update($member["uid"], array("realname" => $log["realname"]));
            }
        }
        $set = m("common")->getSysset();
        if ($needpay) {
            if ($paytype == "credit") {
                if ($goods["money"] + $goods["dispatch"] < $money) {
                    $paystatus = 0;
                    pdo_update("ewei_shop_creditshop_log", array("paytype" => $paystatus), array("id" => $logid));
                } else {
                    return app_error(AppError::$MoneyInsufficient, "余额不足");
                }
            } else {
                if ($paytype == "wechat") {
                    $paystatus = 1;
                    pdo_update("ewei_shop_creditshop_log", array("paytype" => $paystatus), array("id" => $logid));
                    $set["pay"]["weixin"] = !empty($set["pay"]["weixin_sub"]) ? 1 : $set["pay"]["weixin"];
                    if (empty($set["pay"]["wxapp"]) && $this->iswxapp) {
                        return app_error(AppError::$OrderPayFail, "未开启微信支付");
                    }
                    $wechat = array("success" => false);
                    $payinfo = array("openid" => $_W["openid_wa"], "title" => $set["shop"]["name"] . (empty($goods["type"]) ? "积分兑换" : "积分抽奖") . " 单号:" . $log["logno"], "tid" => $log["logno"], "fee" => $goods["money"] * $num + $goods["dispatch"]);
                    $res = $this->model->wxpay($payinfo, 3);
                    if (!is_error($res)) {
                        $wechat = array("success" => true, "payinfo" => $res);
                    } else {
                        $wechat["payinfo"] = $res;
                    }
                    if (!$wechat["success"]) {
                        return app_error(AppError::$ParamsError, "微信支付参数错误");
                    }
                    return app_json(array("logid" => $logid, "wechat" => $wechat));
                }
            }
        }
        return app_json(array("logid" => $logid));
    }
    public function lottery()
    {
        global $_W;
        global $_GPC;
        $number = max(1, $_GPC["num"]);
        $openid = $_W["openid"];
        $uniacid = $_W["uniacid"];
        $open_redis = function_exists("redis") && !is_error(redis());
        if ($open_redis) {
            $redis_key = (string) $_W["setting"]["site"]["key"] . "_" . $_W["account"]["key"] . "_" . $uniacid . "_creditshop_lottery_" . $openid;
            $redis = redis();
            if (!is_error($redis)) {
                if ($redis->setnx($redis_key, time())) {
                    $redis->expireAt($redis_key, time() + 2);
                } else {
                    return app_error(AppError::$ParamsError, "操作频繁，请稍后再试");
                }
            }
        }
        $id = intval($_GPC["id"]);
        $logid = intval($_GPC["logid"]);
        if (!$logid) {
            $logid = $id;
        }
        $shop = m("common")->getSysset("shop");
        $member = m("member")->getMember($openid);
        $goodsid = intval($_GPC["goodsid"]);
        $log = pdo_fetch("select * from " . tablename("ewei_shop_creditshop_log") . " where id=:id and uniacid=:uniacid limit 1", array(":id" => $logid, ":uniacid" => $uniacid));
        if (empty($log)) {
            $logno = $_GPC["logno"];
            $log = pdo_fetch("select * from " . tablename("ewei_shop_creditshop_log") . " where logno=:logno and uniacid=:uniacid limit 1", array(":logno" => $logno, ":uniacid" => $uniacid));
        }
        $number = empty($log["goods_num"]) ? $number : $log["goods_num"];
        $optionid = $log["optionid"];
        $goods = p("creditshop")->getGoods($log["goodsid"], $member, $log["optionid"], $number);
        $goods["money"] *= $number;
        $goods["credit"] *= $number;
        $goods["dispatch"] = p("creditshop")->dispatchPrice($log["goodsid"], $log["addressid"], $log["optionid"], $number);
        $credit = $member["credit1"];
        $money = $member["credit2"];
        if (empty($log)) {
            return app_error(AppError::$ParamsError, "服务器错误");
        }
        if (empty($goods["canbuy"])) {
            return app_error(AppError::$ParamsError, $goods["buymsg"]);
        }
        $update = array("couponid" => $goods["couponid"]);
        if (empty($log["paystatus"])) {
            if (0 < $goods["credit"] && $credit < $goods["credit"]) {
                return app_error(AppError::$ParamsError, "积分不足");
            }
            if (0 < $goods["money"] && $money < $goods["money"] && $log["paytype"] == 0) {
                return app_error(AppError::$ParamsError, "余额不足");
            }
        }
        $update["money"] = $goods["money"];
        if (0 < $goods["money"] + $goods["dispatch"] && $log["paystatus"] < 1) {
            if ($log["paytype"] == 0) {
                m("member")->setCredit($openid, "credit2", 0 - ($goods["money"] + $goods["dispatch"]), "积分商城扣除余额度 " . $goods["money"] . ",编号:" . $log["logno"]);
                $update["paystatus"] = 1;
            }
            if ($log["paytype"] == 1) {
                $payquery = m("finance")->isWeixinPay($log["logno"], $goods["money"] + $goods["dispatch"], is_h5app() ? true : false);
                $payqueryBorrow = m("finance")->isWeixinPayBorrow($log["logno"], $goods["money"] + $goods["dispatch"]);
                if (!is_error($payquery) || !is_error($payqueryBorrow)) {
                    p("creditshop")->payResult($log["logno"], "wechat", $goods["money"] + $goods["dispatch"], is_h5app() ? true : false);
                } else {
                    return app_error(AppError::$ParamsError, "支付出错,请重试(1)");
                }
            }
            if ($log["paytype"] == 2 && $log["paystatus"] < 1) {
                return app_error(AppError::$ParamsError, "未支付成功");
            }
        }
        if ($log["paytype"] == 0 && 0 < $goods["credit"] && empty($log["creditpay"])) {
            m("member")->setCredit($openid, "credit1", 0 - $goods["credit"], "积分商城扣除积分 " . $goods["credit"] . ",编号:" . $log["logno"]);
            $update["creditpay"] = 1;
            pdo_query("update " . tablename("ewei_shop_creditshop_goods") . " set joins=joins+1 where id=" . $log["goodsid"]);
        }
        $status = 1;
        if ($goods["type"] == 1) {
            if (0 < $goods["rate1"] && 0 < $goods["rate2"]) {
                if ($goods["rate1"] == $goods["rate2"]) {
                    $status = 2;
                } else {
                    $rand = rand(0, intval($goods["rate2"]));
                    if ($rand <= intval($goods["rate1"])) {
                        $status = 2;
                    }
                }
            }
        } else {
            $status = 2;
        }
        if ($status == 2 && $goods["isverify"] == 1) {
            $update["eno"] = p("creditshop")->createENO();
        }
        if ($goods["isverify"] == 1) {
            $update["verifynum"] = 0 < $goods["verifynum"] ? $goods["verifynum"] : 1;
            if ($goods["isendtime"] == 0) {
                if (0 < $goods["usetime"]) {
                    $update["verifytime"] = time() + 3600 * 24 * intval($goods["usetime"]);
                } else {
                    $update["verifytime"] = 0;
                }
            } else {
                $update["verifytime"] = intval($goods["endtime"]);
            }
        }
        $update["credit"] = $goods["credit"];
        $update["status"] = $status;
        if (0 < $goods["dispatch"] && $goods["goodstype"] == 0 && $goods["type"] == 0) {
            $update["dispatchstatus"] = "1";
            $update["dispatch"] = $goods["dispatch"];
        }
        pdo_update("ewei_shop_creditshop_log", $update, array("id" => $log["id"]));
        $log = pdo_fetch("select * from " . tablename("ewei_shop_creditshop_log") . " where id=:id and uniacid=:uniacid limit 1", array(":id" => $logid, ":uniacid" => $uniacid));
        if ($status == 2 && $update["creditpay"] == 1) {
            if ($goods["goodstype"] == 1) {
                if (com("coupon")) {
                    com("coupon")->creditshop($logid);
                    $status = 3;
                }
                $update["time_finish"] = time();
            } else {
                if ($goods["goodstype"] == 2) {
                    $credittype = "credit2";
                    $creditstr = "积分商城兑换余额,编号:" . $log["logno"];
                    $num = abs($goods["grant1"]) * intval($log["goods_num"]);
                    $member = m("member")->getMember($openid);
                    $credit2 = floatval($member["credit2"]) + $num;
                    m("member")->setCredit($openid, $credittype, $num, array($_W["uid"], $creditstr));
                    $set = m("common")->getSysset("shop");
                    $logno = m("common")->createNO("member_log", "logno", "RC");
                    $data = array("openid" => $openid, "logno" => $logno, "uniacid" => $_W["uniacid"], "type" => "0", "createtime" => TIMESTAMP, "status" => "1", "title" => $set["name"] . "积分商城兑换余额", "money" => $num, "remark" => $creditstr, "rechargetype" => "creditshop");
                    pdo_insert("ewei_shop_member_log", $data);
                    $mlogid = pdo_insertid();
                    m("notice")->sendMemberLogMessage($mlogid);
                    plog("finance.recharge." . $credittype, "充值" . $creditstr . ": " . $num . " <br/>会员信息: ID: " . $member["id"] . " /  " . $member["openid"] . "/" . $member["nickname"] . "/" . $member["realname"] . "/" . $member["mobile"]);
                    $status = 3;
                    $update["time_finish"] = time();
                } else {
                    if ($goods["goodstype"] == 3) {
                    }
                }
            }
            $update["status"] = $status;
            pdo_update("ewei_shop_creditshop_log", $update, array("id" => $logid));
            p("creditshop")->sendMessage($logid);
            if ($status == 3) {
                pdo_query("update " . tablename("ewei_shop_creditshop_goods") . " set total=total-" . $number . " where id=" . $log["goodsid"]);
            }
            if ($goods["goodstype"] == 0 && $status == 2) {
                pdo_query("update " . tablename("ewei_shop_creditshop_goods") . " set total=total-" . $number . " where id=" . $log["goodsid"]);
            }
            if ($goods["goodstype"] == 3 && $status == 2) {
                pdo_query("update " . tablename("ewei_shop_creditshop_goods") . " set packetsurplus=packetsurplus-" . $number . " where id=" . $log["goodsid"]);
            }
            if ($goods["hasoption"] && $log["optionid"]) {
                pdo_query("update " . tablename("ewei_shop_creditshop_option") . " set total=total-" . $number . " where id=" . $log["optionid"]);
            }
        }
        return app_json(array("status" => $status, "goodstype" => $goods["goodstype"]));
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
        $order = pdo_fetch("select expresscom,expresssn,addressid,status,express from " . tablename("ewei_shop_creditshop_order") . " where id=:id and uniacid=:uniacid and openid=:openid limit 1", array(":id" => $orderid, ":uniacid" => $uniacid, ":openid" => $openid));
        if (empty($order)) {
            return app_error(AppError::$OrderNotFound);
        }
        if (empty($order["addressid"])) {
            return app_error(AppError::$OrderNoExpress);
        }
        if ($order["status"] < 2) {
            return app_error(AppError::$OrderNoExpress);
        }
        $goods = pdo_fetchall("select og.goodsid,og.price,g.title,g.thumb,og.total,g.credit,og.optionid,og.optionname as optiontitle,g.isverify,g.storeids  from " . tablename("ewei_shop_order_goods") . " og " . " left join " . tablename("ewei_shop_creditshop_order") . " g on g.id=og.goodsid " . " where og.orderid=:orderid and og.uniacid=:uniacid ", array(":uniacid" => $uniacid, ":orderid" => $orderid));
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