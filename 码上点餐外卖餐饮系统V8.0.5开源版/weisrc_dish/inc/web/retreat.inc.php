<?php
global $_W, $_GPC;
$storeid = intval($_GPC['storeid']);
$this->checkPermission($storeid);

$orderid = intval($_GPC['orderid']);
$goodsid = intval($_GPC['goodsid']);
$goodsnum = intval($_GPC['goodsnum']);//商品数量

if ($goodsnum == 0) {
    message('商品删除数量不能为0!');
}

$order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE weid=:weid AND id=:orderid
        ORDER by id
DESC LIMIT 1", array(':weid' => $this->_weid, ':orderid' => $orderid));
if (empty($order)) {
    message('订单不存在!');
}

$item = pdo_fetch("SELECT * FROM " . tablename($this->table_order_goods) . " WHERE weid=:weid AND goodsid=:goodsid AND orderid=:orderid ORDER by id
DESC LIMIT 1", array(':weid' => $this->_weid, ':goodsid' => $goodsid, ':orderid' => $orderid));

if (empty($item)) {
    message('商品不存在!');
}

$price = floatval($item['price']);
$goodsprice = $price * $goodsnum;
$total = intval($item['total']);

if ($goodsnum > $total) {
    message('退货数量大于商品数量!');
}

if ($total == $goodsnum) {
    pdo_delete($this->table_order_goods, array('id' => $item['id']));
} else {
    $total = $total - $goodsnum;
    pdo_update($this->table_order_goods, array('total' => $total), array('id' => $item['id']));
}

$goods = pdo_fetch("SELECT * FROM " . tablename($this->table_goods) . " WHERE weid=:weid AND id=:goodsid ORDER by id
DESC LIMIT 1", array(':weid' => $this->_weid, ':goodsid' => $item['goodsid']));

$touser = $_W['user']['username'] . '&nbsp;退菜：' . $goods['title'] . "*" . $goodsnum . ",";
$this->addOrderLog($orderid, $touser, 2, 2, 1);

$totalprice = floatval($order['totalprice']) - $goodsprice;
$goodsprice = floatval($order['goodsprice']) - $goodsprice;

//更新订单金额
pdo_update($this->table_order, array('totalprice' => $totalprice, 'goodsprice' => $goodsprice), array('weid' =>
    $this->_weid, 'id' => $orderid));
$paylog = pdo_fetch("SELECT * FROM " . tablename('core_paylog') . " WHERE tid=:tid AND uniacid=:uniacid AND status=0 AND module='weisrc_dish'
ORDER BY plid
DESC LIMIT 1", array(':tid' => $orderid, ':uniacid' => $this->_weid));
if (!empty($paylog)) {
    pdo_update('core_paylog', array('fee' => $totalprice, 'card_fee' => $totalprice), array('plid' => $paylog['plid']));
}
if ($storeid == 0) {
    message('操作成功！', $this->createWebUrl('allorder', array('op' => 'detail', 'storeid' => $storeid, 'id' => $orderid)), 'success');
} else {
    message('操作成功！', $this->createWebUrl('order', array('op' => 'detail', 'id' => $orderid, 'storeid' => $storeid)), 'success');
}