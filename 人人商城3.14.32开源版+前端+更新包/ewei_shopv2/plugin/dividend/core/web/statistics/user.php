<?php

if (!defined("IN_IA")) {
    exit("Access Denied");
}
require EWEI_SHOPV2_PLUGIN . "dividend/core/dividend_page_web.php";
class User_EweiShopV2Page extends DividendWebPage
{
    public function main()
    {
        global $_W;
        global $_GPC;
        $params = array();
        $searchstart = intval($_GPC["searchstart"]);
        $keyword = trim($_GPC["keyword"]);
        $headsid = intval($_GPC["id"]);
        $params[":headsid"] = $headsid;
        $params[":uniacid"] = $_W["uniacid"];
        $pindex = max(1, intval($_GPC["page"]));
        $psize = 100;
        $sql = "select * from " . tablename("ewei_shop_member") . " where headsid = :headsid and uniacid = :uniacid ORDER BY headstime desc";
        $sql .= " LIMIT " . ($pindex - 1) * $psize . "," . $psize;
        dump(456);
        exit;
    }
    public function query()
    {
        global $_W;
        global $_GPC;
        $kwd = trim($_GPC["keyword"]);
        $wechatid = intval($_GPC["wechatid"]);
        if (empty($wechatid)) {
            $wechatid = $_W["uniacid"];
        }
        $params = array();
        $params[":uniacid"] = $wechatid;
        $condition = " and uniacid=:uniacid and isagent=1 and status=1";
        if (!empty($kwd)) {
            $condition .= " AND ( `nickname` LIKE :keyword or `realname` LIKE :keyword or `mobile` LIKE :keyword )";
            $params[":keyword"] = "%" . $kwd . "%";
        }
        if (!empty($_GPC["selfid"])) {
            $condition .= " and id<>" . intval($_GPC["selfid"]);
        }
        $ds = pdo_fetchall("SELECT id,avatar,nickname,openid,realname,mobile FROM " . tablename("ewei_shop_member") . " WHERE 1 " . $condition . " order by createtime desc", $params);
        include $this->template("commission/query");
    }
    public function check()
    {
        global $_W;
        global $_GPC;
        $id = intval($_GPC["id"]);
        if (empty($id)) {
            $id = is_array($_GPC["ids"]) ? implode(",", $_GPC["ids"]) : 0;
        }
        $status = intval($_GPC["status"]);
        $members = pdo_fetchall("SELECT id,openid,nickname,realname,mobile,status FROM " . tablename("ewei_shop_member") . " WHERE id in( " . $id . " ) AND uniacid=" . $_W["uniacid"]);
        $time = time();
        foreach ($members as $member) {
            if ($member["status"] === $status) {
                continue;
            }
            if ($status == 1) {
                pdo_update("ewei_shop_member", array("status" => 1, "agenttime" => $time), array("id" => $member["id"], "uniacid" => $_W["uniacid"]));
                plog("commission.agent.check", "审核分销商 <br/>分销商信息:  ID: " . $member["id"] . " /  " . $member["openid"] . "/" . $member["nickname"] . "/" . $member["realname"] . "/" . $member["mobile"]);
                $this->model->sendMessage($member["openid"], array("nickname" => $member["nickname"], "agenttime" => $time), TM_COMMISSION_BECOME);
                if (!empty($member["agentid"])) {
                    $this->model->upgradeLevelByAgent($member["agentid"]);
                    if (p("globonus")) {
                        p("globonus")->upgradeLevelByAgent($member["agentid"]);
                    }
                    if (p("author")) {
                        p("author")->upgradeLevelByAgent($member["agentid"]);
                    }
                }
            } else {
                pdo_update("ewei_shop_member", array("status" => 0, "agenttime" => 0), array("id" => $member["id"], "uniacid" => $_W["uniacid"]));
                plog("commission.agent.check", "取消审核 <br/>分销商信息:  ID: " . $member["id"] . " /  " . $member["openid"] . "/" . $member["nickname"] . "/" . $member["realname"] . "/" . $member["mobile"]);
            }
        }
        show_json(1, array("url" => referer()));
    }
    public function agentblack()
    {
        global $_W;
        global $_GPC;
        $id = intval($_GPC["id"]);
        if (empty($id)) {
            $id = is_array($_GPC["ids"]) ? implode(",", $_GPC["ids"]) : 0;
        }
        $agentblack = intval($_GPC["agentblack"]);
        $members = pdo_fetchall("SELECT id,openid,nickname,realname,mobile,agentblack FROM " . tablename("ewei_shop_member") . " WHERE id in( " . $id . " ) AND uniacid=" . $_W["uniacid"]);
        foreach ($members as $member) {
            if ($member["agentblack"] === $agentblack) {
                continue;
            }
            if ($agentblack == 1) {
                pdo_update("ewei_shop_member", array("isagent" => 1, "status" => 0, "agentblack" => 1), array("id" => $member["id"]));
                plog("commission.agent.agentblack", "设置黑名单 <br/>分销商信息:  ID: " . $member["id"] . " /  " . $member["openid"] . "/" . $member["nickname"] . "/" . $member["realname"] . "/" . $member["mobile"]);
            } else {
                pdo_update("ewei_shop_member", array("isagent" => 1, "status" => 1, "agentblack" => 0), array("id" => $member["id"]));
                plog("commission.agent.agentblack", "取消黑名单 <br/>分销商信息:  ID: " . $member["id"] . " /  " . $member["openid"] . "/" . $member["nickname"] . "/" . $member["realname"] . "/" . $member["mobile"]);
            }
        }
        show_json(1, array("url" => referer()));
    }
}

?>