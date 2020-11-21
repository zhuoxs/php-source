<?php
global $_GPC, $_W;
$weid = $this->_weid;
$action = 'printsetting';
$title = $this->actions_titles[$action];

$storeid = intval($_GPC['storeid']);
$this->checkStore($storeid);
$returnid = $this->checkPermission($storeid);
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu($storeid,$action);

$store = $cur_store;
if (empty($store)) {
    message('非法操作！门店不存在.');
}
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_print_setting) . " WHERE weid = :weid AND storeid=:storeid", array(':weid' => $_W['uniacid'], ':storeid' => $storeid));
    $print_order_count = pdo_fetchall("SELECT print_usr,COUNT(1) as count FROM " . tablename($this->table_print_order) . "  GROUP BY print_usr,weid having weid = :weid", array(':weid' => $_W['uniacid']), 'print_usr');
} else if ($operation == 'post') {
    $id = intval($_GPC['id']);
    $setting = pdo_fetch("SELECT * FROM " . tablename($this->table_print_setting) . " WHERE weid = :weid AND storeid=:storeid AND id=:id", array(':weid' => $_W['uniacid'], ':storeid' => $storeid, ':id' => $id));

    if (!empty($setting['print_label'])) {
        $print_label = explode(',', $setting['print_label']);
    }

    if (empty($id)) {
        $setting = array(
            'yilian_type' => 1,
            'is_print_all' => 1,
            'type' => '365',
            'print_type' => 0,
            'print_status' => 1,
            'is_meal' => 1,
            'is_delivery' => 1,
            'is_snack' => 1,
            'is_reservation' => 1,
            'is_nums' => 0,
            'position_type' => 1,
            'api_type' => 0
        );
    }

    $lables = pdo_fetchall("SELECT * FROM " . tablename($this->table_print_label) . " WHERE storeid=:storeid ORDER BY
    displayorder DESC,id DESC", array(':storeid' => $storeid), 'id');

    if (checksubmit('submit')) {

        $print_label = implode(',', $_GPC['print_label']);

        $num = intval($_GPC['print_nums']);
        if ($num == 0) $num = 1;
        if ($num > 5) {
            message('打印联数不能大于5。');
        }

        $data = array(
            'weid' => $_W['uniacid'],
            'storeid' => $storeid,
            'weid' => $_W['uniacid'],
            'title' => trim($_GPC['title']),
            'type' => trim($_GPC['type']),
            'member_code' => trim($_GPC['member_code']),
            'api_key' => trim($_GPC['api_key']),
            'feyin_key' => trim($_GPC['feyin_key']),
            'print_status' => trim($_GPC['print_status']),
            'print_type' => trim($_GPC['print_type']),
            'print_usr' => trim($_GPC['print_usr']),
            'print_nums' => $num,
            'print_top' => trim($_GPC['print_top']),
            'print_bottom' => trim($_GPC['print_bottom']),
            'qrcode_status' => intval($_GPC['qrcode_status']),
            'qrcode_url' => trim($_GPC['qrcode_url']),
            'is_print_all' => intval($_GPC['is_print_all']),
            'yilian_type' => intval($_GPC['yilian_type']),
            'is_nums' => intval($_GPC['is_nums']),
            'print_label' => $print_label,
            'is_meal' => intval($_GPC['is_meal']),
            'is_delivery' => intval($_GPC['is_delivery']),
            'is_snack' => intval($_GPC['is_snack']),
            'is_shouyin' => intval($_GPC['is_shouyin']),
            'is_reservation' => intval($_GPC['is_reservation']),
            'position_type' => intval($_GPC['position_type']),
            'api_type' => intval($_GPC['api_type']),
            'dateline' => TIMESTAMP
        );
        if (empty($id)) {
            pdo_insert($this->table_print_setting, $data);
        } else {
            unset($data['dateline']);
            pdo_update($this->table_print_setting, $data, array('weid' => $_W['uniacid'], 'storeid' => $storeid, 'id' => $id));
        }
        message('操作成功', $this->createWebUrl('printsetting', array('storeid' => $storeid)), 'success');
    }
} else if ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $print = pdo_fetch("SELECT id FROM " . tablename($this->table_print_setting) . " WHERE id = :id",array(':id' => $id));
    if (empty($print)) {
        message('抱歉，不存在或是已经被删除！', $this->createWebUrl('printsetting', array('op' => 'display', 'storeid' => $storeid)), 'error');
    }

    pdo_delete($this->table_print_setting, array('id' => $id, 'weid' => $_W['uniacid']));
    message('删除成功！', $this->createWebUrl('printsetting', array('op' => 'display', 'storeid' => $storeid)), 'success');
}
include $this->template('web/print_setting');