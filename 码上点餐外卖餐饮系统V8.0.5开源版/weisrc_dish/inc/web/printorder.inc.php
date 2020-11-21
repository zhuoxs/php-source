<?php
global $_W, $_GPC;
$weid = $this->_weid;
$action = 'printorder';
$title = $this->actions_titles[$action];

$storeid = intval($_GPC['storeid']);
$this->checkStore($storeid);
$returnid = $this->checkPermission($storeid);
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu($storeid,$action);

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;

    if (!empty($_GPC['usr'])) {
        $condition = " AND print_usr='{$_GPC['usr']}' ";
    }

    if (!empty($_GPC['ordersn'])) {
        $condition .= " AND ordersn LIKE '%{$_GPC['ordersn']}%' ";
    }

    if (!empty($_GPC['selusr'])) {
        $condition .= " AND print_usr LIKE '%{$_GPC['selusr']}%' ";
    }

    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " a INNER JOIN " . tablename($this->table_print_order) . " b ON a.id=b.orderid WHERE a.weid = :weid AND a.storeid=:storeid {$condition} ORDER BY b.id DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}", array(':weid' => $_W['uniacid'], ':storeid' => $storeid));

    if (!empty($list)) {
        $total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_order) . " a INNER JOIN " . tablename($this->table_print_order) . " b ON a.id=b.orderid WHERE a.weid = :weid AND a.storeid=:storeid  $condition", array(':weid' => $_W['uniacid'], ':storeid' => $storeid));
        $pager = pagination($total, $pindex, $psize);
    }
} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);
    pdo_delete($this->table_print_order, array('id' => $id, 'weid' => $_W['uniacid']));
    message('删除成功！', $this->createWebUrl('printorder', array('op' => 'display', 'storeid' => $storeid)), 'success');
} elseif ($operation == 'deleteprintorder') {
    //删除未打印订单
    pdo_delete($this->table_print_order, array('weid' => $_W['uniacid'], 'print_status' => -1));
    message('删除成功！', $this->createWebUrl('printorder', array('op' => 'display', 'storeid' => $storeid)), 'success');
}

include $this->template('web/print_order');