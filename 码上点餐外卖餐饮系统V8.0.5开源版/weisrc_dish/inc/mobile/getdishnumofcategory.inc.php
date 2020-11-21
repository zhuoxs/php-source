<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $_GPC['from_user'];
$this->_fromuser = $from_user;

$storeid = intval($_GPC['storeid']);

if (empty($from_user)) {
    message('会话已过期，请重新发送关键字!');
}

$data = array();
$category_in_cart = pdo_fetchall("SELECT goodstype,count(1) as 'goodscount' FROM " . tablename($this->table_cart) . " GROUP BY weid,storeid,goodstype,from_user  having weid = '{$weid}' AND storeid='{$storeid}' AND from_user='{$from_user}'");
$category_arr = array();
foreach ($category_in_cart as $key => $value) {
    $category_arr[$value['goodstype']] = $value['goodscount'];
}

$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_cart) . " GROUP BY weid,storeid  having weid = :weid AND storeid=:storeid", array(':weid' => $weid, ':storeid' => $storeid));

foreach ($category as $index => $row) {
    $data[$row['id']] = intval($category_arr[$row['id']]);
}

$result['data'] = $data;
message($result, '', 'ajax');