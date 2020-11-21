<?php

if (!defined("IN_IA")) {
    exit("Access Denied");
}
class Picker_EweiShopV2Page extends PluginMobilePage
{
    public $year = NULL;
    public $month = NULL;
    public $day = NULL;
    public $weekday = NULL;
    public function date_list()
    {
        global $_W;
        global $_GPC;
        $tmonth = $_GPC["tmonth"];
        $tdate = $_GPC["tdate"];
        $from = trim($_GPC["from"]);
        if (!empty($from) && $from == "create") {
            $cycelbuy_sys = m("common")->getSysset("cycelbuy");
            $ahead_goods = intval($cycelbuy_sys["ahead_goods"]);
            $days = intval($cycelbuy_sys["days"]);
            if (empty($ahead_goods)) {
                $ahead_goods = 3;
            }
            if (empty($days)) {
                $days = 7;
            }
            $ttime = time() + 86400 * $ahead_goods;
            $endtimes = $ttime + $days * 86400;
        } else {
            if (!empty($from) && $from == "update") {
                $receipttime = trim($_GPC["receipttime"]);
                $period_index = intval($_GPC["period_index"]);
                $select_receipttime = trim($_GPC["select_receipttime"]);
                $cycelbuy_periodic = trim($_GPC["cycelbuy_periodic"]);
                if (!empty($cycelbuy_periodic)) {
                    $cycelbuy_periodic = explode(",", $cycelbuy_periodic);
                }
                $cycelbuy_sys = m("common")->getSysset("cycelbuy");
                $max_day = intval($cycelbuy_sys["max_day"]);
                if (empty($max_day)) {
                    $max_day = 15;
                }
                $isall = intval($_GPC["isall"]);
                if (empty($isall)) {
                    $ttime = strtotime($receipttime);
                    $endtimes = $ttime + $max_day * 86400;
                } else {
                    $ttime = strtotime($receipttime);
                    $endtimes = $ttime + $max_day * 86400;
                    $unit_time = array(1, 7, 30);
                    $node_time = array();
                    if (empty($select_receipttime)) {
                        $select_receipttime = $receipttime;
                    }
                    $select_time = strtotime($select_receipttime);
                    array_push($node_time, date("Ymd", $select_time));
                    for ($i = 1; $i < intval($cycelbuy_periodic[2]) - $period_index; $i++) {
                        array_push($node_time, date("Ymd", $select_time + $unit_time[intval($cycelbuy_periodic[1])] * intval($cycelbuy_periodic[0]) * $i * 86400));
                    }
                }
            } else {
                $ttime = time();
            }
        }
        $month = "";
        if (0 < $tmonth) {
            $month = "+" . $tmonth . " month";
        } else {
            if ($tmonth < 0) {
                $month = $tmonth . " month";
            }
        }
        $firstday = date("Y-m-01", $ttime);
        $ftime = strtotime((string) $firstday . " " . $month);
        $this->year = intval(date("Y", $ftime));
        $this->month = intval(date("m", $ftime));
        $this->day = intval(date("d", $ftime));
        $this->weekday = intval(date("w", $ftime));
        $rangesize = 1;
        for ($calendar = array(); 0 < $rangesize; $rangesize--) {
            $month_first_weekday = date("w", strtotime($this->year . "-" . $this->month . "-01"));
            if ($month_first_weekday == 0) {
                $emptydays = 6;
            } else {
                $emptydays = $month_first_weekday - 1;
            }
            $total = $this->how_many_days($this->month, $this->year);
            $calendar[$this->year . "-" . $this->month] = array($this->year, $this->month++, $total, $emptydays);
            if (12 < $this->month) {
                $this->month = 1;
                $this->year++;
            }
        }
        $weekarray = array("日", "一", "二", "三", "四", "五", "六");
        if (!empty($tdate)) {
            $year = date("Y", $ttime);
            if (intval($this->month - 1) < 10) {
                $tmonth = "0" . intval($this->month - 1);
            }
            if (intval($tdate) < 10) {
                $tdate = "0" . intval($tdate);
            }
            $nowtime = $year . $tmonth . $tdate;
        } else {
            $nowtime = date("Ymd", $ttime);
        }
        include $this->template();
    }
    public function is_leap_year($year)
    {
        global $_W;
        if ($year % 400 === 0) {
            return true;
        }
        if ($year % 100 !== 0 && $year % 4 === 0) {
            return true;
        }
        return false;
    }
    public function how_many_days($month, $year)
    {
        if ($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12) {
            for ($i = 0; $i < 31; $i++) {
                $return[$i] = 1;
            }
            return $return;
        }
        if ($month == 2) {
            if ($this->is_leap_year($year)) {
                for ($i = 0; $i < 29; $i++) {
                    $return[$i] = 1;
                }
                return $return;
            }
            for ($i = 0; $i < 28; $i++) {
                $return[$i] = 1;
            }
            return $return;
        }
        for ($i = 0; $i < 30; $i++) {
            $return[$i] = 1;
        }
        return $return;
    }
    public function getDayNum()
    {
        global $_GPC;
        global $_W;
        $res = $this->how_many_days($_GPC["month"] + 1, $_GPC["year"]);
        $arr["num"] = count($res);
        echo json_encode($arr);
        exit;
    }
}

?>