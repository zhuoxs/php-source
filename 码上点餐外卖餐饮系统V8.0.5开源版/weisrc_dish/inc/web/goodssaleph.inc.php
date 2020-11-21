<?php
global $_W, $_GPC;
$weid = $this->_weid;
load()->func('tpl');
$action = 'goodssaleph';
$GLOBALS['frames'] = $this->getMainMenu();
$title = $this->actions_titles[$action];
$storeid = intval($_GPC['storeid']);
$returnid = $this->checkPermission($storeid);
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$params = array();
$pindex = max(1, intval($_GPC['page']));
$psize = 10;
if ($operation == 'display') {
    //门店列表
    $storelist = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " WHERE weid = :weid ORDER BY id DESC", array(':weid' => $weid), 'id');

    $category = pdo_fetchall("SELECT * FROM " . tablename($this->table_category) . " WHERE weid = :weid ORDER BY parentid ASC, displayorder DESC", array(':weid' => $weid), 'id');

    $commoncondition = " a.weid = '{$_W['uniacid']}' ";
    if (!empty($_GPC['time'])) {
        $starttime = strtotime($_GPC['time']['start']);
        $endtime = strtotime($_GPC['time']['end']) + 86399;
        $commoncondition .= " AND c.dateline >= " . $starttime . " AND c.dateline <= " . $endtime . " ";
    }

    if ($storeid != 0) {
        $commoncondition .= " AND a.storeid = {$storeid} ";
    }

    if (empty($starttime) || empty($endtime)) {
        $starttime = strtotime('-1 month');
        $endtime = time();
    }

    if (!empty($_GPC['title'])) {
        $commoncondition .= " AND b.title LIKE '%{$_GPC['title']}%' ";
    }

    if (!empty($_GPC['category_id'])) {
        $cid = intval($_GPC['category_id']);
        $commoncondition .= " AND b.pcate = '{$cid}'";
    }

    $orderby = !isset($_GPC['orderby']) ? 'price' : (empty($_GPC['orderby']) ? 'price' : 'sl');

    if ($_GPC['out_put'] == 'output') {
        $list = pdo_fetchall("SELECT sum(a.total) sl,sum(a.price*a.total) price,a.title,a.thumb FROM (SELECT b.thumb,b.title, a.price,a.total FROM
" . tablename($this->table_order_goods) . " as a left join " . tablename($this->table_goods) . " as b on a.goodsid=b.id , " . tablename($this->table_order) . " c left join " . tablename($this->table_tables) . " d on c.tables = d.id WHERE $commoncondition and a.orderid=c.id AND c.status=3 AND c.ispay=1 AND c.ismerge = 0)a group by a.title order by {$orderby} desc", $paras);
        $i = 0;
        foreach ($list as $key => $value) {
            $arr[$i]['title'] = $value['title'];
            $arr[$i]['price'] = $value['price'];
            $arr[$i]['sl'] = $value['sl'];
            $i++;
        }
        $this->exportexcel($arr, array('商品', '销售额', '销售量'), time());
        exit();
    }

    $list = pdo_fetchall("SELECT sum(a.total) sl,sum(a.price*a.total) price,a.title,a.thumb FROM (SELECT b.thumb,b.title, a.price,a.total FROM " . tablename($this->table_order_goods) . " as a left join " . tablename($this->table_goods) . " as b on a.goodsid=b.id , " . tablename($this->table_order) . " c left join " . tablename($this->table_tables) . " d on c.tables = d.id WHERE $commoncondition and a.orderid=c.id AND c.status=3 AND c.ispay=1 AND c.ismerge = 0 )a group by a.title order by {$orderby} desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize);

    $sql = "SELECT count(*) from (select a.title FROM (SELECT b.title, a.price,a.total FROM " . tablename($this->table_order_goods) . " as a left join " . tablename($this->table_goods) . " as b on a.goodsid=b.id , " . tablename($this->table_order) . " c left join " . tablename($this->table_tables) . " d on c.tables = d.id WHERE $commoncondition and a.orderid=c.id AND c.status=3 AND c.ispay=1 AND c.ismerge = 0)a group by a.title )a";

    $total = pdo_fetchcolumn($sql);
    $pager = pagination($total, $pindex, $psize);
}
include $this->template('web/goodssaleph');