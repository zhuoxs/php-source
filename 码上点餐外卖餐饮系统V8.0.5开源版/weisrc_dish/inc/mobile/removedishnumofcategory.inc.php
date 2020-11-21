<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $_GPC['from_user'];
$this->_fromuser = $from_user;

$storeid = intval($_GPC['storeid']); //门店id
$dishid = intval($_GPC['dishid']); //商品id
$action = $_GPC['action'];

if (empty($from_user)) {
    message('会话已过期，请重新发送关键字!');
}

if (empty($storeid)) {
    message('请先选择门店');
}

if ($action != 'remove') {
    $result['msg'] = '非法操作';
    message($result, '', 'ajax');
}

//查询购物车有没该商品
$cart = pdo_fetch("SELECT * FROM " . tablename($this->table_cart) . " WHERE goodsid=:goodsid AND weid=:weid AND storeid=:storeid AND from_user='" . $from_user . "'", array(':goodsid' => $dishid, ':weid' => $weid, ':storeid' => $storeid));

if (empty($cart)) {
    $result['msg'] = '购物车为空!';
    message($result, '', 'ajax');
} else {
    pdo_delete('weisrc_dish_cart', array('id' => $cart['id']));
}

$cart = pdo_fetchall("SELECT * FROM " . tablename($this->table_cart) . " WHERE  storeid=:storeid AND from_user=:from_user AND weid=:weid", array(':storeid' => $storeid, ':from_user' => $from_user, ':weid' => $weid));
$totalcount = 0;
$totalprice = 0;
foreach ($cart as $key => $value) {
    $totalcount = $totalcount + $value['total'];
    $totalprice = $totalprice + $value['total'] * $value['price'];
}
$result['totalprice'] = $totalprice;
$result['totalcount'] = $totalcount;
$result['code'] = 0;
message($result, '', 'ajax');