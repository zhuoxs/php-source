<?php
global $_W, $_GPC;
$weid = $this->_weid;
$setting = $this->getSetting();
load()->func('tpl');
$action = 'order';
$title = $this->actions_titles[$action];
$storeid = intval($_GPC['storeid']);
$GLOBALS['frames'] = '';
$this->checkPermission($storeid);
$store = $this->getStoreById($storeid);
if (empty($store)) {
    message('门店不存在!');
}

$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_category) . " WHERE weid = :weid And storeid=:storeid ORDER BY parentid ASC, displayorder DESC", array(':weid' => $weid, ':storeid' => $storeid), 'id');

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {

    $pindex = max(1, intval($_GPC['page']));
    $psize = 30;
    $condition = "  weid = '{$weid}' AND storeid ={$storeid} AND deleted=0 ";
    if (!empty($_GPC['keyword'])) {
        $condition .= " AND title LIKE '%{$_GPC['keyword']}%'";
    }

    if (!empty($_GPC['category_id'])) {
        $cid = intval($_GPC['category_id']);
        $condition .= " AND pcate = '{$cid}'";
    }

    if (isset($_GPC['status'])) {
        $condition .= " AND status = '" . intval($_GPC['status']) . "'";
    }

    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . " WHERE $condition ORDER BY status DESC, displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);

    $total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename($this->table_goods) . " WHERE $condition");

    $pager = pagination($total, $pindex, $psize);
}

$cart = pdo_fetchall("SELECT * FROM " . tablename($this->table_cart) . " WHERE  storeid=:storeid AND from_user=:from_user AND weid=:weid", array(':storeid' => $storeid, ':from_user' => 'admin', ':weid' => $weid));
$totalcount = 0;
$totalprice = 0;
foreach ($cart as $key => $value) {
    $goods_t = pdo_fetch("SELECT * FROM " . tablename($this->table_goods) . " WHERE id = :id LIMIT 1 ", array(':id' => $value['goodsid']));
    $cart[$key]['goodstitle'] = $goods_t['title'];
    $totalcount = $totalcount + $value['total'];
    $totalprice = $totalprice + $value['total'] * $value['price'];
}

$tables = pdo_fetchall("SELECT * FROM " . tablename($this->table_tables) . " WHERE storeid =:storeid ORDER BY id DESC", array(':storeid' => $storeid), 'id');

foreach ($tables as $key => $value) {
    $tables[$key]['title'] = $value['title'] . '(' . $value['user_count'] . '人桌)';
}

for ($i = 0; $i < 10; $i++) {
    $date_title = '';
    if ($i == 0) {
        $date_value = date("Y-m-d", TIMESTAMP);
        $date_title = '今日';
    } elseif ($i == 1) {
        $date_value = date("Y-m-d", strtotime("+{$i} day"));
        $date_title = '明日';
    } else {
        $date_value = date("Y-m-d", strtotime("+{$i} day"));
        $date_title = date("Y-m-d", strtotime("+{$i} day"));
    }

    $select_mealdate .= "<option value='{$date_value}'>{$date_title}</option>";
}

$mealtimes = pdo_fetchall("SELECT * FROM " . tablename($this->table_mealtime) . " WHERE weid=:weid AND storeid=:storeid ORDER BY id ASC", array(':weid' => $weid, ':storeid' => $storeid));
foreach ($mealtimes as $key => $value) {
    $select_mealtime .= '<option value="' . $value['begintime'] . '~' . $value['endtime'] . '">' . $value['begintime'] . '~' . $value['endtime'] . '</option>';
}

include $this->template('web/cash');