<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$id = intval($_GPC['orderid']);
$setting = $this->getSetting();

$order = pdo_fetch("SELECT a.* FROM " . tablename($this->table_savewine_log) . " AS a LEFT JOIN " . tablename($this->table_stores) . " AS b ON a.storeid=b.id  WHERE a.id ={$id} AND a.from_user='{$from_user}' ORDER BY a.id DESC LIMIT 20");
if (empty($order)) {
    message('订单不存在');
}

$order['goods'] = pdo_fetchall("SELECT a.*,b.title,b.unitname FROM " . tablename('weisrc_dish_savewine_goods') . " as a
left join
" . tablename($this->table_goods) . " as b
 on a.goodsid=b.id WHERE a.weid = '{$weid}' and a.savewineid={$order['id']}");

$tablesid = intval($order['tablesid']);
$table = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $tablesid));
$table_title = $table['title'];

$store = pdo_fetch("SELECT * FROM " . tablename($this->table_stores) . " where weid = :weid AND id=:id ORDER BY displayorder DESC", array(':weid' => $weid, ':id' => $order['storeid']));

$loglist = pdo_fetchall("SELECT a.*,b.title AS title FROM " . tablename("weisrc_dish_savewine_record") . " a LEFT JOIN
" . tablename("weisrc_dish_goods") . " b
ON a
.goodsid=b.id WHERE a.savewineid=:savewineid ORDER BY a.id
desc", array(':savewineid' => $id));


include $this->template($this->cur_tpl . '/savewinedetail');