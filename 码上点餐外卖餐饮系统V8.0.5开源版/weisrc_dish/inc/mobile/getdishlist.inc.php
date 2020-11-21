<?php
global $_W, $_GPC;
$weid = $this->_weid;
$sid = intval($_GPC['sid']);

$week = date("w");
$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . " WHERE weid = :weid AND status = 1 AND deleted=0 AND storeid=:storeid AND find_in_set(".$week.",week) ORDER by displayorder DESC,subcount DESC,id DESC", array(':weid' => $weid, ':storeid' => $sid));

$dishcount = $this->getDishCountInCart($sid);

foreach ($list as $key => $row) {
    $category = pdo_fetch("SELECT * FROM " . tablename($this->table_category) . " WHERE id = :id LIMIT 1", array(':id' => $row['pcate']));

    $subcount = intval($row['subcount']);
    $data[$key] = array(
        'id' => $row['id'],
        'title' => $row['title'],
        'dSpecialPrice' => $row['marketprice'],
        'dmemberprice' => $row['memberprice'],
        'dPrice' => $row['productprice'],
        'pcate' =>  $row['pcate'],
        'pcatename' => $category['name'],
        'dDescribe' => $row['description'], //描述
        'dTaste' => $row['taste'], //口味
        'credit' => $row['credit'],
        'thumb' => empty($row['thumb']) ? tomedia('./addons/weisrc_dish/icon.jpg') : tomedia($row['thumb']),
        'unitname' => $row['unitname'],
        'dIsSpecial' => $row['isspecial'],
        'dIsHot' => $subcount > 20 ? 2 : 0,
        'total' => empty($dishcount) ? 0 : intval($dishcount[$row['id']]) //商品数量
    );
}
exit(json_encode($data));