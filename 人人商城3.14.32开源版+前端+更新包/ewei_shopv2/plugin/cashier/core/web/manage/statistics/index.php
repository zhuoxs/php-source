<?php

if (!defined("IN_IA")) {
    exit("Access Denied");
}
require EWEI_SHOPV2_PLUGIN . "cashier/core/inc/page_cashier.php";
class Index_EweiShopV2Page extends CashierWebPage
{
    public function main()
    {
        global $_W;
        global $_GPC;
        $operation = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
        $years = array();
        $current_year = date("Y");
        $year = empty($_GPC["year"]) ? $current_year : $_GPC["year"];
        for ($i = $current_year - 10; $i <= $current_year; $i++) {
            $years[] = array("data" => $i, "selected" => $i == $year);
        }
        $months = array();
        $current_month = date("m");
        $month = $_GPC["month"];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = array("data" => $i, "selected" => $i == $month);
        }
        $day = intval($_GPC["day"]);
        $type = intval($_GPC["type"]);
        $list = array();
        $totalcount = 0;
        $maxcount = 0;
        $maxcount_date = "";
        $maxdate = "";
        $countfield = empty($type) ? "sum(money+deduction)" : "count(*)";
        $typename = empty($type) ? "交易额" : "交易量";
        $dataname = !empty($year) && !empty($month) ? "月份" : "日期";
        if (!empty($year) && !empty($month) && !empty($day)) {
            for ($hour = 0; $hour < 24; $hour++) {
                $nexthour = $hour + 1;
                $dr = array("data" => $hour . "点 - " . $nexthour . "点", "count" => pdo_fetchcolumn("SELECT ifnull(" . $countfield . ",0) as cnt FROM " . tablename("ewei_shop_cashier_pay_log") . " WHERE cashierid=:cashierid AND uniacid=:uniacid AND status>=1 AND paytime >=:starttime AND paytime <=:endtime", array(":cashierid" => $_W["cashierid"], ":uniacid" => $_W["uniacid"], ":starttime" => strtotime((string) $year . "-" . $month . "-" . $day . " " . $hour . ":00:00"), ":endtime" => strtotime((string) $year . "-" . $month . "-" . $day . " " . $hour . ":59:59"))));
                $totalcount += $dr["count"];
                if ($maxcount < $dr["count"]) {
                    $maxcount = $dr["count"];
                    $maxcount_date = (string) $year . "年" . $month . "月" . $day . "日 " . $hour . "点 - " . $nexthour . "点";
                }
                $list[] = $dr;
            }
        } else {
            if (!empty($year) && !empty($month)) {
                $lastday = get_last_day($year, $month);
                for ($d = 1; $d <= $lastday; $d++) {
                    $dr = array("data" => $d, "count" => pdo_fetchcolumn("SELECT ifnull(" . $countfield . ",0) as cnt FROM " . tablename("ewei_shop_cashier_pay_log") . " WHERE cashierid=:cashierid AND uniacid=:uniacid AND status>=1 AND paytime >=:starttime AND paytime <=:endtime", array(":cashierid" => $_W["cashierid"], ":uniacid" => $_W["uniacid"], ":starttime" => strtotime((string) $year . "-" . $month . "-" . $d . " 00:00:00"), ":endtime" => strtotime((string) $year . "-" . $month . "-" . $d . " 23:59:59"))));
                    $totalcount += $dr["count"];
                    if ($maxcount < $dr["count"]) {
                        $maxcount = $dr["count"];
                        $maxcount_date = (string) $year . "年" . $month . "月" . $d . "日";
                    }
                    $list[] = $dr;
                }
            } else {
                if (!empty($year)) {
                    foreach ($months as $m) {
                        $lastday = get_last_day($year, $m);
                        $dr = array("data" => $m["data"], "count" => pdo_fetchcolumn("SELECT ifnull(" . $countfield . ",0) as cnt FROM " . tablename("ewei_shop_cashier_pay_log") . " WHERE cashierid=:cashierid AND uniacid=:uniacid AND status>=1 AND paytime >=:starttime AND paytime <:endtime", array(":cashierid" => $_W["cashierid"], ":uniacid" => $_W["uniacid"], ":starttime" => strtotime((string) $year . "-" . $m["data"] . "-01"), ":endtime" => strtotime((string) $year . "-" . $m["data"] . "-" . $lastday))));
                        $totalcount += $dr["count"];
                        if ($maxcount < $dr["count"]) {
                            $maxcount = $dr["count"];
                            $maxcount_date = (string) $year . "年" . $m["data"] . "月";
                        }
                        $list[] = $dr;
                    }
                }
            }
        }
        foreach ($list as $key => &$row) {
            $list[$key]["percent"] = number_format($row["count"] / (empty($totalcount) ? 1 : $totalcount) * 100, 2);
        }
        unset($row);
        if ($_GPC["export"] == 1) {
            $list[] = array("data" => $typename . "总数", "count" => $totalcount);
            $list[] = array("data" => "最高" . $typename, "count" => $maxcount);
            $list[] = array("data" => "发生在", "count" => $maxcount_date);
            m("excel")->export($list, array("title" => "交易报告-" . (!empty($year) && !empty($month) ? (string) $year . "年" . $month . "月" : (string) $year . "年"), "columns" => array(array("title" => $dataname, "field" => "data", "width" => 12), array("title" => $typename, "field" => "count", "width" => 12), array("title" => "所占比例(%)", "field" => "percent", "width" => 24))));
        }
        include $this->template("statistics/index");
    }
    public function days()
    {
        global $_W;
        global $_GPC;
        $year = intval($_GPC["year"]);
        $month = intval($_GPC["month"]);
        exit(get_last_day($year, $month));
    }
}

?>