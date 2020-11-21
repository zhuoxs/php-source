<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$storeid = intval($_GPC['storeid']);
$tablesid = intval($_GPC['tablesid']);
$setting = $this->getSetting();

if ($storeid == 0) {
    message('门店不存在！');
}

$table = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $tablesid));

if (empty($table)) {
    message('餐桌不存在！');
}

$param = array(':weid' => $weid, ':storeid' => $storeid);
$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_category) . " WHERE weid = :weid AND storeid=:storeid {$condition} ORDER BY
displayorder DESC,id DESC", $param);

$cid = intval($category[0]['id']);
$week = date("w");
$goodslist = array();
foreach ($category as $key => $value) {
    $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . " WHERE weid = '{$weid}' AND  storeid={$storeid} AND status = '1'
AND deleted=0 AND pcate=:pcate AND find_in_set(".$week.",week) ORDER BY displayorder DESC, subcount DESC, id DESC ", array(':pcate' => $value['id']));
    foreach ($goods as $k => $v) {
        if ($v['istime'] == 1) {
            if ($v['begindate'] > TIMESTAMP || TIMESTAMP > $v['enddate']) {
                unset($goods[$k]);
            }
            $goodsstate = $this->check_hourtime($v['begintime'], $v['endtime']);
            if ($goodsstate == 0) {
                unset($goods[$k]);
            }
        }
    }
    if ($goods) {
        $goodslist[$value['id']]['goods'] = $goods;
    } else {
        unset($category[$key]);
    }
}


include $this->template($this->cur_tpl . '/savewine_form');