<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$orderid = intval($_GPC['orderid']);
$setting = $this->getSetting();

$order = pdo_fetch("SELECT a.* FROM " . tablename($this->table_order) . " AS a LEFT JOIN " . tablename($this->table_stores) . " AS b ON a.storeid=b.id  WHERE a.id =:id AND a.from_user=:from_user ORDER BY a.id DESC LIMIT 1", array(':id' => $orderid, ':from_user' => $from_user));
if (empty($order)) {
    message('订单不存在');
}

if ($order['isfeedback'] == 1) {
    message('订单已经评论过');
}

include $this->template($this->cur_tpl . '/feedback');