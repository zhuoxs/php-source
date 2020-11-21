<?php

if (!defined("IN_IA")) {
    exit("Access Denied");
}
require EWEI_SHOPV2_PLUGIN . "merch/core/inc/page_merch.php";
class Member_increase_EweiShopV2Page extends MerchWebPage
{
    public function main()
    {
        global $_W;
        global $_GPC;
        $days = intval($_GPC["days"]);
        if (empty($_GPC["search"])) {
            $days = 7;
        }
        $years = array();
        $current_year = date("Y");
        $year = $_GPC["year"];
        for ($i = $current_year - 10; $i <= $current_year; $i++) {
            $years[] = array("data" => $i, "selected" => $i == $year);
        }
        $months = array();
        $current_month = date("m");
        $month = $_GPC["month"];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = array("data" => $i, "selected" => $i == $month);
        }
        $timefield = empty($isagent) ? "createtime" : "agenttime";
        $datas = array();
        $title = "";
        if (!empty($days)) {
            $charttitle = "最近" . $days . "天增长趋势图";
            for ($i = $days; 0 <= $i; $i--) {
                $time = date("Y-m-d", strtotime("-" . $i . " day"));
                $condition = " and uniacid=:uniacid and " . $timefield . ">=:starttime and " . $timefield . "<=:endtime and  openid in ( SELECT distinct openid from " . tablename("ewei_shop_order") . "   WHERE uniacid =:uniacid and merchid=:merchid )";
                $params = array(":uniacid" => $_W["uniacid"], ":merchid" => $_W["merchid"], ":starttime" => strtotime((string) $time . " 00:00:00"), ":endtime" => strtotime((string) $time . " 23:59:59"));
                $datas[] = array("date" => $time, "mcount" => pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_member") . " where isagent=0  " . $condition, $params), "acount" => pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_member") . " where isagent=1  " . $condition, $params));
            }
        } else {
            if (!empty($year) && !empty($month)) {
                $charttitle = (string) $year . "年" . $month . "月增长趋势图";
                $lastday = get_last_day($year, $month);
                for ($d = 1; $d <= $lastday; $d++) {
                    $condition = " and uniacid=:uniacid and " . $timefield . ">=:starttime and " . $timefield . "<=:endtime and  openid in ( SELECT distinct openid from " . tablename("ewei_shop_order") . "   WHERE uniacid =:uniacid and merchid=:merchid )";
                    $params = array(":uniacid" => $_W["uniacid"], ":merchid" => $_W["merchid"], ":starttime" => strtotime((string) $year . "-" . $month . "-" . $d . " 00:00:00"), ":endtime" => strtotime((string) $year . "-" . $month . "-" . $d . " 23:59:59"));
                    $datas[] = array("date" => (string) $d . "日", "mcount" => pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_member") . " where isagent=0  " . $condition, $params), "acount" => pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_member") . " where isagent=1  " . $condition, $params));
                }
            } else {
                if (!empty($year)) {
                    $charttitle = (string) $year . "年增长趋势图";
                    foreach ($months as $m) {
                        $lastday = get_last_day($year, $m["data"]);
                        $condition = " and uniacid=:uniacid and " . $timefield . ">=:starttime and " . $timefield . "<=:endtime and  openid in ( SELECT distinct openid from " . tablename("ewei_shop_order") . "   WHERE uniacid =:uniacid and merchid=:merchid )";
                        $params = array(":uniacid" => $_W["uniacid"], ":merchid" => $_W["merchid"], ":starttime" => strtotime((string) $year . "-" . $m["data"] . "-01 00:00:00"), ":endtime" => strtotime((string) $year . "-" . $m["data"] . "-" . $lastday . " 23:59:59"));
                        $datas[] = array("date" => $m["data"] . "月", "mcount" => pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_member") . " where isagent=0  " . $condition, $params), "acount" => pdo_fetchcolumn("select count(*) from " . tablename("ewei_shop_member") . " where isagent=1  " . $condition, $params));
                    }
                }
            }
        }
        load()->func("tpl");
        include $this->template("statistics/member_increase");
    }
}

?>