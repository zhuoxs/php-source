<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}
class Index_EweiShopV2Page extends PluginMobilePage
{
    public function main()
    {
        global $_W;
        global $_GPC;
        $mid = intval($_GPC["mid"]);
        $openid = $_W["openid"];
        $member = m("member")->getMember($openid);
        $set = $this->set;
        $uniacid = $_W["uniacid"];
        if (!empty($mid)) {
            if (!empty($set["closemyshop"])) {
                $shopurl = mobileUrl("", array("mid" => $mid));
                header("location: " . $shopurl);
                exit;
            }
            if (!$this->model->isAgent($mid)) {
                header("location:" . mobileUrl("commission/register"));
                exit;
            }
        } else {
            if ($member["isagent"] == 1 && $member["status"] == 1) {
                $mid = $member["id"];
                if (!empty($set["closemyshop"])) {
                    $shopurl = mobileUrl();
                    header("location: " . $shopurl);
                    exit;
                }
            } else {
                header("location: " . mobileUrl());
                exit;
            }
        }
        $shop = set_medias($this->model->getShop($mid), array("img", "logo"));
        if (empty($shop["img"])) {
            $shop["img"] = $_W["shopset"]["shop"]["img"];
        }
        if (empty($shop["selectgoods"])) {
            $goodscount = pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_goods") . " where uniacid=:uniacid and status=1 and deleted=0", array(":uniacid" => $_W["uniacid"]));
        } else {
            $goodscount = count(explode(",", $shop["goodsids"]));
        }
        $cubes = $_W["shopset"]["shop"]["cubes"];
        $banners = pdo_fetchall("select id,bannername,link,thumb from " . tablename("ewei_shop_banner") . " where uniacid=:uniacid and enabled=1 and iswxapp=0 order by displayorder desc", array(":uniacid" => $uniacid));
        $bannerswipe = $_W["shopset"]["shop"]["bannerswipe"];
        if (!empty($_W["shopset"]["shop"]["indexrecommands"])) {
            $goodids = implode(",", $_W["shopset"]["shop"]["indexrecommands"]);
            if (!empty($goodids)) {
                $indexrecommands = pdo_fetchall("select id, title, thumb, marketprice, productprice ,minprice, total from " . tablename("ewei_shop_goods") . " where id in( " . $goodids . " ) and uniacid=:uniacid and status=1 order by displayorder desc", array(":uniacid" => $uniacid));
            }
        }
        $goodsstyle = $_W["shopset"]["shop"]["goodsstyle"];
        $notices = pdo_fetchall("select id, title, link, thumb from " . tablename("ewei_shop_notice") . " where uniacid=:uniacid and status=1 order by displayorder desc limit 5", array(":uniacid" => $uniacid));
        $shareid = $mid;
        if ($member["isagent"] == 1 && $member["status"] == 1) {
            $shareid = $member["id"];
        }
        $_W["shopshare"] = array("title" => $shop["name"], "imgUrl" => $shop["logo"], "desc" => $shop["desc"], "link" => mobileUrl("commission/myshop", array("mid" => $shareid), true));
        $frommyshop = 1;
        include $this->template();
    }
    public function get_goods()
    {
        global $_W;
        global $_GPC;
        $mid = intval($_GPC["mid"]);
        if (empty($mid)) {
            $mid = m("member")->getMid();
        }
        $shop = $this->model->getShop($mid);
        $args = array("page" => $_GPC["page"], "pagesize" => 10, "nocommission" => 0, "order" => "displayorder desc,createtime desc", "by" => "");
        if (!empty($shop["selectgoods"])) {
            $goodsids = explode(",", $shop["goodsids"]);
            if (!empty($goodsids)) {
                $args["ids"] = trim($shop["goodsids"]);
            } else {
                $args["isrecommand"] = 1;
            }
        } else {
            $args["isrecommand"] = 1;
        }
        $list = m("goods")->getList($args);
        show_json(1, array("list" => $list["list"], "total" => $list["total"], "pagesize" => $args["pagesize"]));
    }
    public function set()
    {
        global $_W;
        global $_GPC;
        $member = m("member")->getMember($_W["openid"]);
        $shop = pdo_fetch("select * from " . tablename("ewei_shop_commission_shop") . " where uniacid=:uniacid and mid=:mid limit 1", array(":uniacid" => $_W["uniacid"], ":mid" => $member["id"]));
        if ($_W["ispost"]) {
            $shopdata = is_array($_GPC["shopdata"]) ? $_GPC["shopdata"] : array();
            $shopdata["uniacid"] = $_W["uniacid"];
            $shopdata["mid"] = $member["id"];
            if (empty($shop["id"])) {
                pdo_insert("ewei_shop_commission_shop", $shopdata);
            } else {
                pdo_update("ewei_shop_commission_shop", $shopdata, array("id" => $shop["id"]));
            }
            show_json(1);
        }
        $shop = set_medias($shop, array("img", "logo"));
        $openselect = false;
        if ($this->set["select_goods"] == "1") {
            if (empty($member["agentselectgoods"]) || $member["agentselectgoods"] == 2) {
                $openselect = true;
            }
        } else {
            if ($member["agentselectgoods"] == 2) {
                $openselect = true;
            }
        }
        $shop["openselect"] = $openselect;
        include $this->template("commission/myshop/set");
    }
    public function select()
    {
        global $_W;
        global $_GPC;
        $member = m("member")->getMember($_W["openid"]);
        if ($member["agentselectgoods"] == 1) {
            $err = "您无权自选商品，请和运营商联系!";
            if ($_W["ispost"]) {
                show_json(-1, $err);
            }
            $this->message($err, "", "error");
        }
        if (empty($this->set["select_goods"]) && $member["agentselectgoods"] != 2) {
            $err = "系统未开启自选商品!";
            if ($_W["ispost"]) {
                show_json(-1, $err);
            }
            $this->message($err, "", "error");
        }
        $shop = pdo_fetch("select * from " . tablename("ewei_shop_commission_shop") . " where uniacid=:uniacid and mid=:mid limit 1", array(":uniacid" => $_W["uniacid"], ":mid" => $member["id"]));
        if ($_W["ispost"]) {
            $shopdata["selectgoods"] = intval($_GPC["selectgoods"]);
            $shopdata["selectcategory"] = intval($_GPC["selectcategory"]);
            $shopdata["uniacid"] = $_W["uniacid"];
            $shopdata["mid"] = $member["id"];
            if (is_array($_GPC["goodsids"])) {
                $shopdata["goodsids"] = implode(",", $_GPC["goodsids"]);
            }
            if (!empty($shopdata["selectgoods"]) && !is_array($_GPC["goodsids"])) {
                show_json(0, "请选择商品!");
            }
            if (empty($shop["id"])) {
                pdo_insert("ewei_shop_commission_shop", $shopdata);
            } else {
                pdo_update("ewei_shop_commission_shop", $shopdata, array("id" => $shop["id"]));
            }
            show_json(1);
        }
        $goods = array();
        if (!empty($shop["selectgoods"])) {
            $goodsids = explode(",", $shop["goodsids"]);
            if (!empty($goodsids)) {
                $goods = pdo_fetchall("select id,title,marketprice,thumb from " . tablename("ewei_shop_goods") . " where uniacid=:uniacid and id in ( " . trim($shop["goodsids"]) . ")", array(":uniacid" => $_W["uniacid"]));
                $goods = set_medias($goods, "thumb");
            }
        }
        $set = m("common")->getSysset("shop");
        if ($_W["shopset"]["category"]["level"] != -1) {
            $category = m("shop")->getCategory();
        }
        include $this->template();
    }
}

?>