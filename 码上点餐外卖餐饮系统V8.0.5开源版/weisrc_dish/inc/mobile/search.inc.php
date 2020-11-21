<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$setting = $this->getSetting();
$cur_nave = 'search';

$lat = trim($_GPC['lat']);
$lng = trim($_GPC['lng']);

if (!empty($lat) && !empty($lng)) {
    $isposition = 1;
    setcookie($this->_lat, $lat, TIMESTAMP + 1800);
    setcookie($this->_lng, $lng, TIMESTAMP + 1800);
} else {
    if (isset($_COOKIE[$this->_lat])) {
        $isposition = 1;//0的时候才跳转
        $lat = $_COOKIE[$this->_lat];
        $lng = $_COOKIE[$this->_lng];
    }
}

$searchword = trim($_GPC['searchword']);
if ($searchword) {

    $childsql = " SELECT distinct(storeid) FROM " . tablename($this->table_goods) . " WHERE weid = :weid AND title like '%" . $searchword . "%' ";
    $strwhere = " AND (title like '%" . $searchword . "%' OR id in({$childsql})) ";
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " where weid = :weid AND is_show=1 AND deleted=0 {$strwhere} ORDER BY
displayorder DESC,id DESC", array(':weid' => $weid), 'storeid');

    $childlist = pdo_fetchall($childsql, array(':weid' => $weid));

    foreach ($list as $key => $value) {
        $goodslist = array();
        foreach ($childlist as $k => $v) {
            $sid = intval($v['storeid']);
            if ($value['id'] == $sid) {
                $goodslist = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . " WHERE title like '%" . $searchword . "%' AND storeid={$sid}");
            }
        }
        $list[$key]['goods'] = $goodslist;
    }
//    print_r($list);
//    exit;
}
//else {
//    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " where weid = :weid AND is_hot=1 AND is_show=1 AND deleted=0 ORDER BY displayorder
//DESC,id DESC", array(':weid' => $weid));
//}

include $this->template($this->cur_tpl . '/search');