<?php
if (!defined("IN_IA")) {
    exit("Access Denied");
}
class Setticket_EweiShopV2Page extends WebPage
{
    public function main()
    {
        global $_W;
        global $_GPC;
        if ($_W["ispost"]) {
            $id = intval($_GPC["id"]);
            if (empty($id)) {
                if (is_array($_GPC["couponid"])) {
                    $count = count($_GPC["couponid"]);
                    if ($count < 1) {
                        show_json(0, "请选择优惠券！");
                    }
                    if ($count == 2 && $_GPC["couponid"][0] == $_GPC["couponid"][1]) {
                        show_json(0, "同一张优惠券不能重复选择！");
                    }
                    if ($count == 3 && ($_GPC["couponid"][0] == $_GPC["couponid"][1] || $_GPC["couponid"][0] == $_GPC["couponid"][2] || $_GPC["couponid"][1] == $_GPC["couponid"][2])) {
                        show_json(0, "同一张优惠券不能重复选择！");
                    }
                    if (3 < $count) {
                        show_json(0, "最多只能选择三张优惠券！");
                    }
                    $expcoupon = array();
                    foreach ($_GPC["couponid"] as $cpk => $cpv) {
                        $where = " WHERE uniacid = :uniacid AND id = :id";
                        $params = array(":uniacid" => $_W["uniacid"], ":id" => intval($cpv));
                        $sql = "SELECT * FROM " . tablename("ewei_shop_coupon") . $where;
                        $list = pdo_fetch($sql, $params, "id");
                        if ($list["timelimit"] == 1 && $list["timeend"] < TIMESTAMP) {
                            $expcoupon[$cpk] = $list["couponname"];
                        }
                    }
                    if (!empty($expcoupon) && is_array($expcoupon)) {
                        foreach ($expcoupon as $exk => $exv) {
                            show_json(0, "优惠券" . $expcoupon[$exk] . ",请选择其他优惠券！");
                        }
                    }
                    $cpids = implode(",", $_GPC["couponid"]);
                }
            } else {
                if (empty($_GPC["couponid"])) {
                    $cpid = explode(",", trim($_GPC["cpids"]));
                } else {
                    if (is_array($_GPC["couponid"])) {
                        $count = count($_GPC["couponid"]);
                        if ($count < 1) {
                            show_json(0, "请选择优惠券！");
                        }
                        if ($count == 2 && $_GPC["couponid"][0] == $_GPC["couponid"][1]) {
                            show_json(0, "不能选择相同优惠券！");
                        }
                        if ($count == 3 && ($_GPC["couponid"][0] == $_GPC["couponid"][1] || $_GPC["couponid"][0] == $_GPC["couponid"][2] || $_GPC["couponid"][1] == $_GPC["couponid"][2])) {
                            show_json(0, "不能选择相同优惠券！");
                        }
                        if (3 < $count) {
                            show_json(0, "最多只能选择三张优惠券！");
                        }
                        $cpid = $_GPC["couponid"];
                    }
                }
                $expcoupon = array();
                foreach ($cpid as $cpk => $cpv) {
                    $where = " WHERE uniacid = :uniacid AND id = :id";
                    $params = array(":uniacid" => $_W["uniacid"], ":id" => intval($cpv));
                    $sql = "SELECT * FROM " . tablename("ewei_shop_coupon") . $where;
                    $list = pdo_fetch($sql, $params, "id");
                    if ($list["timelimit"] == 1 && $list["timeend"] < TIMESTAMP) {
                        $expcoupon[$cpk] = $list["couponname"];
                    }
                }
                if (!empty($expcoupon) && is_array($expcoupon)) {
                    foreach ($expcoupon as $exk => $exv) {
                        show_json(0, "优惠券" . $expcoupon[$exk] . ",请选择其他优惠券！");
                    }
                }
                $cpids = implode(",", $cpid);
            }
            $data = array("uniacid" => intval($_W["uniacid"]), "cpid" => trim($cpids), "expiration" => intval($_GPC["expiration"]), "status" => intval($_GPC["status"]), "createtime" => TIMESTAMP);
            if (!empty($_GPC["expiration"]) && intval($_GPC["expiration"]) == 1) {
                $data["starttime"] = strtotime($_GPC["starttime"]);
                $data["endtime"] = strtotime($_GPC["endtime"]);
            }
            if (empty($id)) {
                $result = pdo_insert("ewei_shop_sendticket", $data);
                plog("sendticket.set", "设置发券内容");
            } else {
                $params = array("id" => $id);
                $result = pdo_update("ewei_shop_sendticket", $data, $params);
            }
            if (!$result) {
                show_json(0, "保存失败,请重试！");
            }
            show_json(1);
        }
        $sql = "SELECT * FROM " . tablename("ewei_shop_sendticket") . " WHERE uniacid = " . intval($_W["uniacid"]);
        $item = pdo_fetch($sql);
        if (!empty($item)) {
            $cpids = explode(",", $item["cpid"]);
            $coupon = array();
            $cpname = array();
            foreach ($cpids as $cpidk => $cpidv) {
                $cpsql = "SELECT * FROM " . tablename("ewei_shop_coupon") . " WHERE uniacid = " . intval($_W["uniacid"]) . " AND id = " . intval($cpidv);
                $list = pdo_fetch($cpsql);
                $cpname[$cpidk] = $list["couponname"];
                $coupon[$cpidk] = $list;
            }
            $coupons = $coupon;
            $item["cpname"] = implode(";", $cpname);
        }
        include $this->template();
    }
}

?>