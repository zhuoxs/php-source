<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$star = intval($_GPC['star']);
$orderid = intval($_GPC['orderid']);
$content = trim($_GPC['content']);

if ($orderid == 0) {
    $this->showMsg('订单不存在');
}

$order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE weid = :weid  AND from_user=:from_user AND id=:id ORDER BY `id`
DESC limit 1", array(':weid' => $weid, ':from_user' => $from_user, ':id' => $orderid));
if (empty($order)) {
    $this->showMsg('订单不存在');
}
if ($order['isfeedback'] == 1) {
    $this->showMsg('订单已经评论过');
}

$data = array(
    'weid' => $weid,
    'orderid' => $orderid,
    'from_user' => $from_user,
    'storeid' => $order['storeid'],
    'star' => $star,
    'content' => $content,
    'status' => 1,
    'dateline' => TIMESTAMP
);
pdo_insert($this->table_feedback, $data);
pdo_update($this->table_order, array('isfeedback' => 1), array('id' => $orderid));
$this->showMsg('评论成功!', 1);