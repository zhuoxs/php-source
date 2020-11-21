<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$storeid = intval($_GPC['storeid']);

$mode = $_GPC['mode'];
$type = $_GPC['type'];

if ($type == 'ajax') {
    pdo_delete('weisrc_dish_cart', array('weid' => $weid, 'from_user' => $from_user, 'storeid' => $storeid));
    $result['code'] = 0;
    message($result, '', 'ajax');
} else {
    if (empty($from_user)) {
        message('会话已过期，请重新发送关键字!');
    }

    $storeid = intval($_GPC['storeid']);
    if (empty($storeid)) {
        message('请先选择门店');
    }

    pdo_delete('weisrc_dish_cart', array('weid' => $weid, 'from_user' => $from_user, 'storeid' => $storeid));
    $url = $this->createMobileUrl('waplist', array('storeid' => $storeid, 'mode' => $mode), true);
    message('操作成功', $url, 'success');
}

