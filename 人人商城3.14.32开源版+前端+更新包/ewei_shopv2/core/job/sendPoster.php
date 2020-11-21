<?php

namespace core\job;

class sendPoster
{
    public $openid = NULL;
    public $acid = NULL;
    public $uniacid = NULL;
    public $content = NULL;
    public function __construct($config = array())
    {
        if (!empty($config)) {
            foreach ($config as $name => $value) {
                $this->{$name} = $value;
            }
        }
    }
    public function execute($queue)
    {
        global $_W;
        $_W["uniacid"] = $this->uniacid;
        $_W["acid"] = $this->acid;
        $openid = $this->openid;
        $content = $this->content;
        if (empty($openid)) {
            return NULL;
        }
        $member = m("member")->getMember($openid);
        if (empty($member)) {
            return NULL;
        }
        if (strexists($content, "+")) {
            $msg = explode("+", $content);
            $poster = pdo_fetch("select * from " . tablename("ewei_shop_poster") . " where keyword2=:keyword and type=3 and isdefault=1 and uniacid=:uniacid limit 1", array(":keyword" => $msg[0], ":uniacid" => $_W["uniacid"]));
            if (empty($poster)) {
                m("message")->sendCustomNotice($openid, "未找到商品海报类型!");
                return NULL;
            }
            $goodsid = intval($msg[1]);
            if (empty($goodsid)) {
                m("message")->sendCustomNotice($openid, "未找到商品, 无法生成海报 !");
                return NULL;
            }
        } else {
            $poster = pdo_fetch("select * from " . tablename("ewei_shop_poster") . " where keyword2=:keyword and isdefault=1 and uniacid=:uniacid limit 1", array(":keyword" => $content, ":uniacid" => $_W["uniacid"]));
            if (empty($poster)) {
                m("message")->sendCustomNotice($openid, "未找到海报类型!");
                return NULL;
            }
        }
        if ($member["isagent"] != 1 || $member["status"] != 1) {
            $set = array();
            if (p("commission")) {
                $set = p("commission")->getSet();
            }
            if (empty($poster["isopen"])) {
                $opentext = !empty($poster["opentext"]) ? $poster["opentext"] : "您还不是我们" . $set["texts"]["agent"] . "，去努力成为" . $set["texts"]["agent"] . "，拥有你的专属海报吧!";
                m("message")->sendCustomNotice($openid, $opentext, trim($poster["openurl"]));
                return NULL;
            }
        }
        $waittext = !empty($poster["waittext"]) ? htmlspecialchars_decode($poster["waittext"], ENT_QUOTES) : "您的专属海报正在拼命生成中，请等待片刻...";
        $waittext = str_replace("\"", "\\\"", $waittext);
        m("message")->sendCustomNotice($openid, $waittext);
        $qr = p("poster")->getQR($poster, $member, $goodsid);
        if (is_error($qr)) {
            m("message")->sendCustomNotice($openid, "生成二维码出错: " . $qr["message"]);
        } else {
            $img = p("poster")->createPoster($poster, $member, $qr);
            $mediaid = $img["mediaid"];
            if (!empty($mediaid)) {
                m("message")->sendImage($openid, $mediaid);
            } else {
                $oktext = "<a href='" . $img["img"] . "'>点击查看您的专属海报</a>";
                m("message")->sendCustomNotice($openid, $oktext);
            }
        }
    }
}

?>