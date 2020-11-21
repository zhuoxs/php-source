<?php
defined("IN_IA") or exit("Access Denied");
class Crad_qrcode_redModuleReceiver extends WeModuleReceiver
{
    public function receive()
    {
        global $_W;
        load()->model("mc");
        $uniacid = $_W["uniacid"];
        $openid = $this->message["fromusername"];
        if ($this->message["event"] == "unsubscribe") {
            pdo_update($this->modulename . "_user", array("subscribe" => 0, "subscribe_time" => ''), array("openid" => $openid, "uniacid" => $uniacid));
            pdo_update($this->modulename . "_user", array("subscribe" => 0, "subscribe_time" => ''), array("from_openid" => $openid, "uniacid" => $uniacid));
        } else {
            if ($this->message["event"] == "subscribe" || ($this->message["msgtype"] == "event" and $this->message["event"] == "CLICK")) {
                pdo_update($this->modulename . "_user", array("subscribe" => 1, "subscribe_time" => time()), array("openid" => $openid, "uniacid" => $uniacid));
                pdo_update($this->modulename . "_user", array("subscribe" => 1, "subscribe_time" => time()), array("from_openid" => $openid, "uniacid" => $uniacid));
            } else {
                if ($this->message["event"] == "user_get_card") {
                    if (empty($this->message["isgivebyfriend"])) {
                        $coupon_record = pdo_get($this->modulename . "_coupon", array("card_id" => trim($this->message["cardid"]), "openid" => trim($this->message["fromusername"]), "status" => 1, "code" => ''), array("id"));
                        if ($coupon_record) {
                            pdo_update($this->modulename . "_coupon", array("code" => trim($this->message["usercardcode"])), array("id" => $coupon_record["id"]));
                        }
                    } else {
                        $old_record = pdo_get($this->modulename . "_coupon", array("openid" => trim($this->message["friendusername"]), "card_id" => trim($this->message["cardid"]), "code" => trim($this->message["oldusercardcode"])));
                        pdo_update($this->modulename . "_coupon", array("createtime" => TIMESTAMP, "openid" => trim($this->message["fromusername"]), "code" => trim($this->message["usercardcode"]), "status" => 1), array("id" => $old_record["id"]));
                    }
                    return;
                } else {
                    if ($this->message["event"] == "user_del_card") {
                        $card_id = trim($this->message["cardid"]);
                        $openid = trim($this->message["fromusername"]);
                        $code = trim($this->message["usercardcode"]);
                        pdo_update($this->modulename . "_coupon", array("status" => 2), array("card_id" => $card_id, "openid" => $openid, "code" => $code));
                        return;
                    } else {
                        if ($this->message["event"] == "user_consume_card") {
                            $card_id = trim($this->message["cardid"]);
                            $openid = trim($this->message["fromusername"]);
                            $code = trim($this->message["usercardcode"]);
                            pdo_update($this->modulename . "_coupon", array("status" => 3), array("card_id" => $card_id, "openid" => $openid, "code" => $code));
                            return;
                        }
                    }
                }
            }
        }
        $scene_str = $this->message["scene"];
        if ($scene_str) {
            $uuid = substr($scene_str, 0, 32);
            $type = substr($scene_str, 32, 3);
            $aid = substr($scene_str, 35);
            if ($aid && $type == "red") {
                $activity = pdo_fetch("SELECT * FROM " . tablename($this->modulename . "_activity") . " WHERE  uniacid ='{$uniacid}' AND id='{$aid}' ");
                if ($activity["subscribe"] == 2) {
                    if ($this->message["event"] == "SCAN" || $this->message["type"] == "qr" || $this->message["event"] == "subscribe") {
                        if ($uuid == "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa") {
                            $info["url"] = $_W["siteroot"] . "app/" . substr($this->createMobileUrl("index", array("aid" => $aid, "from_user" => base64_encode($openid)), true), 2);
                        } else {
                            if ($uuid == "bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb") {
                                $superqrcode = pdo_fetch("SELECT uuid,scan_title,scan_descriotion,scan_image FROM " . tablename($this->modulename . "_superqrcode") . " WHERE  uniacid ='{$uniacid}' AND id='{$aid}' ");
                                $activity["scan_title"] = trim($superqrcode["scan_title"]);
                                $activity["scan_descriotion"] = trim($superqrcode["scan_descriotion"]);
                                $activity["scan_image"] = tomedia($superqrcode["scan_image"]);
                                $info["url"] = $_W["siteroot"] . "app/" . substr($this->createMobileUrl("q", array("u" => $superqrcode["uuid"], "from_user" => base64_encode($openid)), true), 2);
                            } else {
                                $info["url"] = $_W["siteroot"] . "app/" . substr($this->createMobileUrl("index", array("uuid" => $uuid, "aid" => $aid, "from_user" => base64_encode($openid)), true), 2);
                            }
                        }
                        $info["title"] = $activity["scan_title"] ? trim($activity["scan_title"]) : $activity["name"];
                        $info["descriotion"] = $activity["scan_descriotion"] ? trim($activity["scan_descriotion"]) : $activity["descriotion"];
                        $info["pic"] = $activity["scan_image"] ? tomedia($activity["scan_image"]) : tomedia($activity["image_logo"]);
                        $this->sendMessage($openid, $info);
                    }
                }
            }
        }
        return null;
    }
    public function postRes($access_token, $data)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
        load()->func("communication");
        $ret = ihttp_request($url, $data);
        $content = @json_decode($ret["content"], true);
        return $content["errcode"];
    }
    public function sendMessage($openid, $info)
    {
        global $_W;
        $title = strip_tags($info["title"]);
        $desc = strip_tags($info["descriotion"]);
        $pic = $info["pic"];
        $url = $info["url"];
        global $_W;
        load()->classs("weixin.account");
        if ($_W["account"]["level"] > 3) {
            $accObj = WeiXinAccount::create($_W["account"]);
        } else {
            if ($_W["oauth_account"]["level"] > 3) {
                $accObj = WeiXinAccount::create($_W["oauth_account"]);
            } else {
                $accObj = WeiXinAccount::create($_W["account"]);
            }
        }
        $token = $accObj->fetch_available_token();
        $data = "{\r\n    \"touser\":\"" . $openid . "\",\r\n    \"msgtype\":\"news\",\r\n    \"news\":{\r\n        \"articles\": [\r\n         {\r\n             \"title\":\"" . $title . "\",\r\n             \"description\":\"" . $desc . "\",\r\n             \"url\":\"" . $url . "\",\r\n             \"picurl\":\"" . $pic . "\"\r\n         }\r\n         ]\r\n    }\r\n}";
        return $this->postRes($token, $data);
    }
}