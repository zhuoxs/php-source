<?php
global $_W, $_GPC;
$weid = $this->_weid;
$action = 'printorder';
$title = $this->actions_titles[$action];

$storeid = intval($_GPC['storeid']);
if ($storeid > 0) {
    $this->checkStore($storeid);
    $GLOBALS['frames'] = $this->getNaveMenu($storeid,$action);
} else {
    $GLOBALS['frames'] = $this->getMainMenu();
}
$returnid = $this->checkPermission($storeid);


$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {

    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    if ($storeid > 0) {
        $condition = " AND storeid={$storeid} ";
    }
    $list = pdo_fetchall("SELECT * FROM " . tablename("weisrc_dish_service_log") . " WHERE weid = :weid {$condition} ORDER BY id DESC LIMIT
" . ($pindex - 1) * $psize . ",{$psize}", array(':weid' => $weid));

    if (!empty($list)) {
        $total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename("weisrc_dish_service_log") . " WHERE weid = :weid {$condition}", array(':weid' => $weid));
        $pager = pagination($total, $pindex, $psize);
    }
} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);
    pdo_delete("weisrc_dish_service_log", array('id' => $id, 'weid' => $weid));
    message('删除成功！', $this->createWebUrl('servicelog', array('op' => 'display', 'storeid' => $storeid)), 'success');
} elseif ($operation == 'check') {
    $id = intval($_GPC['id']);
    pdo_update("weisrc_dish_service_log", array('status' => 1), array('id' => $id, 'weid' => $weid));
    message('操作成功！', $this->createWebUrl('servicelog', array('op' => 'display', 'storeid' => $storeid)), 'success');
} elseif ($operation == 'checkall') {
    if ($storeid > 0) {
        pdo_update("weisrc_dish_service_log", array('status' => 1), array('weid' => $weid, 'storeid' => $storeid));
    } else {
        pdo_update("weisrc_dish_service_log", array('status' => 1), array('weid' => $weid));
    }
    message('操作成功！', $this->createWebUrl('servicelog', array('op' => 'display', 'storeid' => $storeid)), 'success');
}

include $this->template('web/service_log');