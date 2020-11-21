<?php

if (!defined("IN_IA")) {
    exit("Access Denied");
}
class Index_EweiShopV2Page extends WebPage
{
    public function main()
    {
        global $_W;
        global $_GPC;
        $category = m("plugin")->getList(1);
        $wxapp_array = array('commission', 'creditshop', 'diyform', 'bargain', 'quick', 'cycelbuy', 'seckill', 'groups', 'dividend', 'membercard', 'merch', 'sign', 'friendcoupon', 'app', 'goodscircle');
        $apps = false;
        if ($_W["role"] == "founder" || empty($_W["role"])) {
            $apps = true;
        }
        $filename = "../addons/ewei_shopv2/core/model/grant.php";
        if (file_exists($filename)) {
            $setting = pdo_fetch("select * from " . tablename("ewei_shop_system_grant_setting") . " where id = 1 limit 1 ");
            $permPlugin = false;
            if ($setting["condition_type"] == 0) {
                $permPlugin = true;
            } else {
                if ($setting["condition_type"] == 1) {
                    $total = m("goods")->getTotals();
                    if ($setting["total"] <= $total["sale"]) {
                        $permPlugin = true;
                    }
                } else {
                    if ($setting["condition_type"] == 2) {
                        $price = pdo_fetch("select sum(price) as price from " . tablename("ewei_shop_order") . " where uniacid = " . $_W["uniacid"] . " and status = 3 ");
                        if ($setting["price"] <= $price["price"]) {
                            $permPlugin = true;
                        }
                    } else {
                        if ($setting["condition_type"] == 3) {
                            $time = floor((time() - $_W["user"]["joindate"]) / 86400);
                            if ($setting["day"] <= $time) {
                                $permPlugin = true;
                            }
                        }
                    }
                }
            }
        }
        if (p("grant")) {
            $pluginsetting = pdo_fetch("select adv from " . tablename("ewei_shop_system_plugingrant_setting") . " where 1 = 1 limit 1 ");
        }
        include $this->template();
    }
}

?>