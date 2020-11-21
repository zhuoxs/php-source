<?php

if (!defined("IN_IA")) {
    exit("Access Denied");
}
class Goods_rank_detail_EweiShopV2Page extends WebPage
{
    public function main()
    {
        global $_W;
        global $_GPC;
        $pindex = max(1, intval($_GPC["page"]));
        $psize = 20;
        $params = array();
        $goodsid = $_GPC["id"];
        if (empty($id)) {
        }
        $condition = " and og.uniacid=" . $_W["uniacid"] . " ";
        if (empty($starttime) || empty($endtime)) {
            $starttime = strtotime("-1 month");
            $endtime = time();
        }
        if (!empty($_GPC["datetime"])) {
            $starttime = strtotime($_GPC["datetime"]["start"]);
            $endtime = strtotime($_GPC["datetime"]["end"]);
            if (!empty($starttime)) {
                $condition .= " AND o.createtime >= " . $starttime;
            }
            if (!empty($endtime)) {
                $condition .= " AND o.createtime <= " . $endtime . " ";
            }
        }
        $condition1 = " and g.uniacid=:uniacid";
        $params1 = array(":uniacid" => $_W["uniacid"]);
        $orderby = !isset($_GPC["orderby"]) ? "ordercount" : (empty($_GPC["orderby"]) ? "money" : "ordercount");
        $sql = "SELECT g.id,g.title,g.thumb,og.optionname,sum( og.total ) ordercount ,sum( og.price ) money,count( re.id ) refundcount ,ifnull(sum( re.price ), 0 )refundprice ";
        $sql .= "FROM " . tablename("ewei_shop_order_goods") . " og ";
        $sql .= "LEFT JOIN " . tablename("ewei_shop_order") . " o ON og.orderid = o.id ";
        $sql .= "LEFT JOIN " . tablename("ewei_shop_order_refund") . " re ON o.id = re.orderid AND re.STATUS = 1 ";
        $sql .= "LEFT JOIN " . tablename("ewei_shop_goods") . " g ON g.id = og.goodsid ";
        $sql .= "WHERE og.goodsid = " . $goodsid . " " . $condition1 . " " . $condition . "  and (o.status>=1 or o.refundid > 0) ";
        $sql .= "GROUP BY og.optionname,g.id,g.title,g.thumb ";
        $sql .= "order by " . $orderby . " desc,og.optionname desc ";
        if (empty($_GPC["export"])) {
            $sql .= "LIMIT " . ($pindex - 1) * $psize . "," . $psize;
        }
        $list = pdo_fetchall($sql, $params1);
        if (empty($list)) {
            $sql = "SELECT g.id,g.title,g.thumb,sum( og.total ) ordercount,";
            $sql .= "sum( og.price ) money,count( re.id ) refundcount,ifnull( sum( re.price ), 0 ) refundprice ";
            $sql .= "FROM " . tablename("ewei_shop_order_goods") . " og ";
            $sql .= "LEFT JOIN " . tablename("ewei_shop_order") . " o ON og.orderid = o.id  ";
            $sql .= "LEFT JOIN " . tablename("ewei_shop_order_refund") . " re ON og.orderid = re.orderid AND re.STATUS = 1 ";
            $sql .= "LEFT JOIN " . tablename("ewei_shop_goods") . " g ON g.id = og.goodsid ";
            $sql .= "WHERE og.goodsid = " . $goodsid . "  " . $condition1 . " " . $condition . " AND og.uniacid = " . $_W["uniacid"] . " and (o.status>=1 or o.refundid > 0) ";
            $sql .= "group by g.id,g.title,g.thumb ";
            $sql .= "order by " . $orderby . " desc ";
            if (empty($_GPC["export"])) {
                $sql .= "LIMIT " . ($pindex - 1) * $psize . "," . $psize;
            }
            $list = pdo_fetchall($sql, $params1);
        }
        $total_sql = explode("LIMIT", $sql);
        $total_list = pdo_fetchall($total_sql[0], $params1);
        $total = count($total_list);
        $pager = pagination2($total, $pindex, $psize);
        if ($_GPC["export"] == 1) {
            ca("statistics.goods_rank.export");
            $list[] = array("data" => "商品销售排行", "count" => $total);
            foreach ($list as &$row) {
                $row["createtime"] = date("Y-m-d H:i", $row["createtime"]);
            }
            unset($row);
            m("excel")->export($list, array("title" => "商品销售报告-" . date("Y-m-d-H-i", time()), "columns" => array(array("title" => "商品名称", "field" => "title", "width" => 36), array("title" => "销售数量", "field" => "ordercount", "width" => 12), array("title" => "维权量", "field" => "refundcount", "width" => 12), array("title" => "销售金额", "field" => "money", "width" => 12), array("title" => "维权金额", "field" => "refundprice", "width" => 12))));
            plog("statistics.goods_rank.export", "导出商品销售排行");
        }
        $categorys = m("shop")->getFullCategory(true);
        $category = array();
        foreach ($categorys as $cate) {
            $category[$cate["id"]] = $cate;
        }
        $con = " and uniacid=:uniacid and merchid=0";
        $params_g = array(":uniacid" => $_W["uniacid"]);
        $groups = pdo_fetchall("SELECT id,name,goodsids FROM " . tablename("ewei_shop_goods_group") . " WHERE 1 " . $con . "  ORDER BY id DESC", $params_g);
        load()->func("tpl");
        include $this->template("statistics/goods_rank_detail");
    }
}

?>