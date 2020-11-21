<?php
if (!defined("IN_IA")) {
    exit("Access Denied");
}
require_once IA_ROOT . "/addons/ewei_shopv2/defines.php";
require_once EWEI_SHOPV2_INC . "plugin_processor.php";
require_once EWEI_SHOPV2_INC . "receiver.php";
class PosterProcessor extends PluginProcessor
{
    public function __construct()
    {
        parent::__construct("poster");
    }
    public function respond($obj = NULL)
    {
        global $_W;
        $message = $obj->message;
        $msgtype = strtolower($message["msgtype"]);
        $event = strtolower($message["event"]);
        $obj->member = $this->model->checkMember($message["from"]);
        if ($msgtype == "text" || $event == "click") {
            return $this->responseText($obj);
        }
        if ($msgtype == "event") {
            if ($event == "scan") {
                return $this->responseScan($obj);
            }
            if ($event == "subscribe") {
                return $this->responseSubscribe($obj);
            }
        }
    }
    private function responseText($obj)
    {
        global $_W;
        $timeout = 4;
        load()->func("communication");
        $url = mobileUrl("poster/build", array("openid" => $obj->message["from"], "content" => urlencode($obj->message["content"]), "timestamp" => TIMESTAMP), true);
        $resp = ihttp_request($url, array(), array(), $timeout);
        if ($resp["code"] == 301) {
            $url = $resp["headers"]["Location"];
            $resp = ihttp_request($url, array("openid" => $obj->message["from"], "content" => urlencode($obj->message["content"])), array(), $timeout);
            if ($resp["code"] == 301) {
                $resp = ihttp_request($url, array("openid" => $obj->message["from"], "content" => urlencode($obj->message["content"])), array(), $timeout);
            }
        }
        return $this->responseEmpty();
    }
    private function responseEmpty()
    {
        ob_clean();
        ob_start();
        echo "";
        ob_flush();
        ob_end_flush();
        exit(0);
    }
    private function responseDefault($obj)
    {
        global $_W;
        return $obj->respText("感谢您的关注!");
    }
    private function responseScan($obj)
    {
        global $_W;
        $openid = $obj->message["from"];
        $sceneid = $obj->message["eventkey"];
        $ticket = $obj->message["ticket"];
        if (empty($ticket)) {
            return $this->responseDefault($obj);
        }
        $qr = $this->model->getQRByTicket($ticket);
        if (empty($qr)) {
            return $this->responseDefault($obj);
        }
        $poster = pdo_fetch("select * from " . tablename("ewei_shop_poster") . " where type=4 and isdefault=1 and uniacid=:uniacid limit 1", array(":uniacid" => $_W["uniacid"]));
        if (empty($poster)) {
            return $this->responseDefault($obj);
        }
        $this->model->scanTime($openid, $qr["openid"], $poster);
        $qrmember = m("member")->getMember($qr["openid"]);
        $this->commission($poster, $obj->member, $qrmember);
        $member = $obj->member;
        if (0 < $poster["ismembergroup"] && empty($member["groupid"]) && 0 < $poster["membergroupid"]) {
            pdo_update("ewei_shop_member", array("groupid" => $poster["membergroupid"]), array("openid" => $openid, "uniacid" => $_W["uniacid"]));
        }
        $url = trim($poster["respurl"]);
        if (empty($url)) {
            if ($qrmember["isagent"] == 1 && $qrmember["status"] == 1) {
                $url = mobileUrl("commission/myshop", array("mid" => $qrmember["id"]));
            } else {
                $url = mobileUrl("", array("mid" => $qrmember["id"]));
            }
        }
        if ($poster["resptype"] == "0" && !empty($poster["resptitle"])) {
            $news = array(array("title" => $poster["resptitle"], "description" => $poster["respdesc"], "picurl" => tomedia($poster["respthumb"]), "url" => $url));
            return $obj->respNews($news);
        }
        if ($poster["resptype"] == "1" && !empty($poster["resptext"])) {
            return $obj->respText($poster["resptext"]);
        }
        return $this->responseEmpty();
    }
    private function responseSubscribe($obj)
    {
        global $_W;
        $openid = $obj->message["from"];
        $keys = explode("_", $obj->message["eventkey"]);
        $sceneid = isset($keys[1]) ? $keys[1] : "";
        $ticket = $obj->message["ticket"];
        $member = $obj->member;
        if (empty($ticket)) {
            return $this->responseDefault($obj);
        }
        $qr = $this->model->getQRByTicket($ticket);
        if (empty($qr)) {
            return $this->responseDefault($obj);
        }
        $poster = pdo_fetch("select * from " . tablename("ewei_shop_poster") . " where `type`=4 and isdefault=1 and uniacid=:uniacid limit 1", array(":uniacid" => $_W["uniacid"]));
        if (empty($poster)) {
            return $this->responseDefault($obj);
        }
        if ($member["isnew"]) {
            pdo_update("ewei_shop_poster", array("follows" => $poster["follows"] + 1), array("id" => $poster["id"]));
        }
        $qrmember = m("member")->getMember($qr["openid"]);
        $log = pdo_fetch("select * from " . tablename("ewei_shop_poster_log") . " where openid=:openid and posterid=:posterid and uniacid=:uniacid limit 1", array(":openid" => $openid, ":posterid" => $poster["id"], ":uniacid" => $_W["uniacid"]));
        if (empty($log) && $openid != $qr["openid"]) {
            $log = array("uniacid" => $_W["uniacid"], "posterid" => $poster["id"], "openid" => $openid, "from_openid" => $qr["openid"], "subcredit" => $poster["subcredit"], "submoney" => $poster["submoney"], "reccredit" => $poster["reccredit"], "recmoney" => $poster["recmoney"], "createtime" => time());
            pdo_insert("ewei_shop_poster_log", $log);
            $log["id"] = pdo_insertid();
            if (0 < $poster["ismembergroup"] && empty($member["groupid"]) && 0 < $poster["membergroupid"]) {
                pdo_update("ewei_shop_member", array("groupid" => $poster["membergroupid"]), array("openid" => $openid, "uniacid" => $_W["uniacid"]));
            }
            $subpaycontent = $poster["subpaycontent"];
            if (empty($subpaycontent)) {
                $subpaycontent = "您通过 [nickname] 的推广二维码扫码关注的奖励";
            }
            $subpaycontent = str_replace("[nickname]", $qrmember["nickname"], $subpaycontent);
            $recpaycontent = $poster["recpaycontent"];
            if (empty($recpaycontent)) {
                $recpaycontent = "推荐 [nickname] 扫码关注的奖励";
            }
            $recpaycontent = str_replace("[nickname]", $member["nickname"], $subpaycontent);
            if (0 < $poster["subcredit"]) {
                m("member")->setCredit($openid, "credit1", $poster["subcredit"], array(0, "扫码关注积分+" . $poster["subcredit"]));
            }
            if (0 < $poster["submoney"]) {
                $pay = $poster["submoney"];
                if ($poster["paytype"] == 1) {
                    $pay *= 100;
                    $res = m("finance")->payRedPack($openid, $pay, date("YmdHis") . random(6, true), array(), $subpaycontent, array());
                } else {
                    $res = m("finance")->pay($openid, $poster["paytype"], $pay, "", $subpaycontent, false);
                }
            }
            $reward_totle = !empty($poster["reward_totle"]) ? json_decode($poster["reward_totle"], true) : array();
            $reward_real = pdo_fetch("select sum(reccredit) as reccredit_totle,sum(recmoney) as recmoney_totle,sum(reccouponnum) as reccouponnum_totle  from " . tablename("ewei_shop_poster_log") . " where from_openid=:fromopenid and posterid=:posterid and uniacid=:uniacid and createtime between :time1 and :time2 limit 1", array(":fromopenid" => $qr["openid"], ":posterid" => $poster["id"], ":uniacid" => $log["uniacid"], ":time1" => strtotime(date("Y-m", time()) . "-1"), ":time2" => time()));
            if ((empty($reward_totle["reccredit_totle"]) || intval($reward_real["reccredit_totle"]) <= intval($reward_totle["reccredit_totle"])) && 0 < $poster["reccredit"]) {
                m("member")->setCredit($qr["openid"], "credit1", $poster["reccredit"], array(0, "推荐扫码关注积分+" . $poster["reccredit"]));
            }
            if ((empty($reward_totle["recmoney_totle"]) || floatval($reward_real["recmoney_totle"]) <= floatval($reward_totle["recmoney_totle"])) && 0 < $poster["recmoney"]) {
                $pay = $poster["recmoney"];
                if ($poster["paytype"] == 1) {
                    $pay *= 100;
                    $res = m("finance")->payRedPack($qr["openid"], $pay, date("YmdHis") . random(6, true), array(), $recpaycontent, array());
                } else {
                    $res = m("finance")->pay($qr["openid"], $poster["paytype"], $pay, "", $recpaycontent, false);
                }
            }
            $cansendreccoupon = false;
            $cansendsubcoupon = false;
            $plugin_coupon = com("coupon");
            if ($plugin_coupon) {
                if ((empty($reward_totle["reccouponnum_totle"]) || intval($reward_real["reccouponnum_totle"]) <= intval($reward_totle["reccouponnum_totle"])) && !empty($poster["reccouponid"]) && 0 < $poster["reccouponnum"]) {
                    $reccoupon = $plugin_coupon->getCoupon($poster["reccouponid"]);
                    if (!empty($reccoupon)) {
                        $cansendreccoupon = true;
                    }
                }
                if (!empty($poster["subcouponid"]) && 0 < $poster["subcouponnum"]) {
                    $subcoupon = $plugin_coupon->getCoupon($poster["subcouponid"]);
                    if (!empty($subcoupon)) {
                        $cansendsubcoupon = true;
                    }
                }
            }
            if (!empty($poster["subtext"])) {
                $subtext = $poster["subtext"];
                $subtext = str_replace("[nickname]", $member["nickname"], $subtext);
                $subtext = str_replace("[credit]", $poster["reccredit"], $subtext);
                $subtext = str_replace("[money]", $poster["recmoney"], $subtext);
                if ($reccoupon) {
                    $subtext = str_replace("[couponname]", $reccoupon["couponname"], $subtext);
                    $subtext = str_replace("[couponnum]", $poster["reccouponnum"], $subtext);
                }
                if (!empty($poster["templateid"])) {
                    m("message")->sendTplNotice($qr["openid"], $poster["templateid"], array("first" => array("value" => "推荐关注奖励到账通知", "color" => "#4a5077"), "keyword1" => array("value" => "推荐奖励", "color" => "#4a5077"), "keyword2" => array("value" => $subtext, "color" => "#4a5077"), "keyword3" => array("value" => "成功", "color" => "#4a5077"), "keyword4" => array("value" => date("Y-m-d H:i:s"), "color" => "#4a5077"), "remark" => array("value" => "\r\n谢谢您对我们的支持！", "color" => "#4a5077")), "");
                } else {
                    m("message")->sendCustomNotice($qr["openid"], $subtext);
                }
            }
            if (!empty($poster["entrytext"])) {
                $entrytext = $poster["entrytext"];
                $entrytext = str_replace("[nickname]", $qrmember["nickname"], $entrytext);
                $entrytext = str_replace("[credit]", $poster["subcredit"], $entrytext);
                $entrytext = str_replace("[money]", $poster["submoney"], $entrytext);
                if ($subcoupon) {
                    $entrytext = str_replace("[couponname]", $subcoupon["couponname"], $entrytext);
                    $entrytext = str_replace("[couponnum]", $poster["subcouponnum"], $entrytext);
                }
                if (!empty($poster["templateid"])) {
                    m("message")->sendTplNotice($openid, $poster["templateid"], array("first" => array("value" => "关注奖励到账通知", "color" => "#4a5077"), "keyword1" => array("value" => "关注奖励", "color" => "#4a5077"), "keyword2" => array("value" => $entrytext, "color" => "#4a5077"), "keyword3" => array("value" => "成功", "color" => "#4a5077"), "keyword4" => array("value" => date("Y-m-d H:i:s"), "color" => "#4a5077"), "remark" => array("value" => "\r\n谢谢您对我们的支持！", "color" => "#4a5077")), "");
                } else {
                    m("message")->sendCustomNotice($openid, $entrytext);
                }
            }
            $upgrade = array();
            if ($cansendreccoupon) {
                $upgrade["reccouponid"] = $poster["reccouponid"];
                $upgrade["reccouponnum"] = $poster["reccouponnum"];
                $plugin_coupon->poster($qrmember, $poster["reccouponid"], $poster["reccouponnum"], 4);
            }
            if ($cansendsubcoupon) {
                $upgrade["subcouponid"] = $poster["subcouponid"];
                $upgrade["subcouponnum"] = $poster["subcouponnum"];
                $plugin_coupon->poster($member, $poster["subcouponid"], $poster["subcouponnum"], 4);
            }
            if (!empty($upgrade)) {
                pdo_update("ewei_shop_poster_log", $upgrade, array("id" => $log["id"]));
            }
        }
        $this->commission($poster, $member, $qrmember);
        $url = trim($poster["respurl"]);
        if (empty($url)) {
            if ($qrmember["isagent"] == 1 && $qrmember["status"] == 1) {
                $url = mobileUrl("commission/myshop", array("mid" => $qrmember["id"]));
            } else {
                $url = mobileUrl("", array("mid" => $qrmember["id"]));
            }
        }
        if ($poster["resptype"] == "0") {
            if (!empty($poster["resptitle"])) {
                $news = array(array("title" => $poster["resptitle"], "description" => $poster["respdesc"], "picurl" => tomedia($poster["respthumb"]), "url" => $url));
                return $obj->respNews($news);
            }
            $receiver = new Receiver();
            $receiver->saleVirtual($obj);
        }
        if ($poster["resptype"] == "1" && !empty($poster["resptext"])) {
            return $obj->respText($poster["resptext"]);
        }
        return $this->responseEmpty();
    }
    private function commission($poster, $member, $qrmember)
    {
        global $_W;
        $time = time();
        $p = p("commission");
        if ($p) {
            $cset = $p->getSet();
            if (!empty($cset) && $member["isagent"] != 1 && $qrmember["isagent"] == 1 && $qrmember["status"] == 1) {
                if (!empty($poster["bedown"]) && empty($member["agentid"]) && empty($member["fixagentid"])) {
                    $member["agentid"] = $qrmember["id"];
                    $authorid = empty($qrmember["isauthor"]) ? $qrmember["authorid"] : $qrmember["id"];
                    $author = p("author");
                    if ($author) {
                        $p->upgradeLevelByAgent($qrmember["id"]);
                        pdo_update("ewei_shop_member", array("agentid" => $qrmember["id"], "childtime" => $time, "authorid" => $authorid), array("id" => $member["id"]));
                    } else {
                        pdo_update("ewei_shop_member", array("agentid" => $qrmember["id"], "childtime" => $time), array("id" => $member["id"]));
                    }
                    if (p("dividend")) {
                        $this->saveRelation($member["id"], $qrmember["id"], 1);
                        p("dividend")->update_headsid($member["id"], $qrmember["id"]);
                    }
                    if ($author) {
                        $author_set = $author->getSet();
                        if (!empty($author_set["become"]) && ($author_set["become"] == "2" || $author_set["become"] == "5")) {
                            $can_author = false;
                            $getAgentsDownNum = $p->getAgentsDownNum($qrmember["openid"]);
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
                                if ($author_set["become"] == "5" && $author_set["become_downcount"] <= $getAgentsDownNum["total"]) {
                                    $can_author = true;
                                }
                            }
                            if ($can_author) {
                                $become_check = intval($author_set["become_check"]);
                                if (empty($member["authorblack"])) {
                                    pdo_update("ewei_shop_member", array("authorstatus" => $become_check, "isauthor" => 1, "authortime" => $time), array("uniacid" => $_W["uniacid"], "id" => $qrmember["id"]));
                                    if ($become_check == 1) {
                                        $p->sendMessage($qrmember["openid"], array("nickname" => $qrmember["nickname"], "authortime" => $time), TM_AUTHOR_BECOME);
                                    }
                                }
                            }
                        }
                    }
                    $p->sendMessage($qrmember["openid"], array("nickname" => $member["nickname"], "openid" => $member["openid"], "childtime" => $time), TM_COMMISSION_AGENT_NEW);
                    $p->upgradeLevelByAgent($qrmember["id"]);
                    if (p("globonus")) {
                        p("globonus")->upgradeLevelByAgent($qrmember["id"]);
                    }
                    if (p("abonus")) {
                        p("abonus")->upgradeLevelByAgent($qrmember["id"]);
                    }
                    if (p("author")) {
                        p("author")->upgradeLevelByAgent($qrmember["id"]);
                    }
                }
                if (!empty($poster["beagent"])) {
                    $become_check = intval($cset["become_check"]);
                    pdo_update("ewei_shop_member", array("isagent" => 1, "status" => $become_check, "agenttime" => $time), array("id" => $member["id"]));
                    if ($become_check == 1) {
                        $p->sendMessage($member["openid"], array("nickname" => $member["nickname"], "agenttime" => $time), TM_COMMISSION_BECOME);
                        $p->upgradeLevelByAgent($qrmember["id"]);
                        if (p("globonus")) {
                            p("globonus")->upgradeLevelByAgent($qrmember["id"]);
                        }
                        if (p("abonus")) {
                            p("abonus")->upgradeLevelByAgent($qrmember["id"]);
                        }
                        if (p("author")) {
                            p("author")->upgradeLevelByAgent($qrmember["id"]);
                        }
                    }
                }
            }
        }
    }
}

?>