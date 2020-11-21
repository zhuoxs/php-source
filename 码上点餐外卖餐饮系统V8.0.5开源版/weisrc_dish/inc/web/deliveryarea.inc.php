<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    if (!empty($_GPC['displayorder'])) {
        foreach ($_GPC['displayorder'] as $id => $displayorder) {
            pdo_update($this->table_deliveryarea, array('displayorder' => $displayorder), array('id' => $id));
        }
        message('区域排序更新成功！', $this->createWebUrl('deliveryarea', array('op' => 'display')), 'success');
    }
    $children = array();
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_deliveryarea) . " WHERE weid = '{$_W['uniacid']}'  ORDER BY displayorder DESC,
id DESC");

} elseif ($operation == 'post') {
    load()->func('tpl');
    $parentid = intval($_GPC['parentid']);
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $area = pdo_fetch("SELECT * FROM " . tablename($this->table_deliveryarea) . " WHERE id = '$id'");
    } else {
        $area = array(
            'displayorder' => 0,
        );
    }

    if (checksubmit('submit')) {
        if (empty($_GPC['title'])) {
            message('抱歉，请输入配送点名称！');
        }

        $data = array(
            'weid' => $_W['uniacid'],
            'title' => $_GPC['title'],
            'lng' => trim($_GPC['baidumap']['lng']),
            'lat' => trim($_GPC['baidumap']['lat']),
            'displayorder' => intval($_GPC['displayorder']),
            'dateline' => TIMESTAMP
        );

        if (!empty($id)) {
            pdo_update($this->table_deliveryarea, $data, array('id' => $id, 'weid' => $weid));
        } else {
            pdo_insert($this->table_deliveryarea, $data);
            $id = pdo_insertid();
        }
        message('更新区域成功！', $this->createWebUrl('deliveryarea', array('op' => 'display')), 'success');
    }
} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $area = pdo_fetch("SELECT id FROM " . tablename($this->table_deliveryarea) . " WHERE id = '$id'");
    if (empty($area)) {
        message('抱歉，数据不存在或是已经被删除！', $this->createWebUrl('deliveryarea', array('op' => 'display')), 'error');
    }
    pdo_delete($this->table_deliveryarea, array('id' => $id, 'weid' => $_W['uniacid']));
    message('删除成功！', $this->createWebUrl('deliveryarea', array('op' => 'display')), 'success');
}

include $this->template('web/deliveryarea');