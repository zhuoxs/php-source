<?php

if (!defined("IN_IA")) {
    exit("Access Denied");
}
class Util_EweiShopV2Page extends PluginWebPage
{
    public function totals()
    {
        global $_W;
        global $_GPC;
        $totals = $this->model->getUserTotals();
        $clear_totals = $this->model->getMerchApplyTotals();
        $totals = array_merge($totals, $clear_totals);
        show_json(1, $totals);
    }
    public function autonum()
    {
        global $_W;
        global $_GPC;
        $num = $_GPC["num"];
        $len = intval($_GPC["len"]);
        $len == 0 and $arr = array($num);
        $maxlen = strlen($num);
        for ($i = 1; $i <= $len; $i++) {
            $add = bcadd($num, $i) . "";
            $addlen = strlen($add);
            if ($maxlen < $addlen) {
                $maxlen = $addlen;
            }
            $arr[] = $add;
        }
        $len = count($arr);
        for ($i = 0; $i < $len; $i++) {
            $zerocount = $maxlen - strlen($arr[$i]);
            if (0 < $zerocount) {
                $arr[$i] = str_pad($arr[$i], $maxlen, "0", STR_PAD_LEFT);
            }
        }
        exit(json_encode($arr));
    }
    public function days()
    {
        global $_W;
        global $_GPC;
        $year = intval($_GPC["year"]);
        $month = intval($_GPC["month"]);
        exit(get_last_day($year, $month));
    }
    public function express()
    {
        global $_W;
        global $_GPC;
        $express = trim($_GPC["express"]);
        $expresssn = trim($_GPC["expresssn"]);
        $list = m("util")->getExpressList($express, $expresssn);
        include $this->template();
    }
}

?>