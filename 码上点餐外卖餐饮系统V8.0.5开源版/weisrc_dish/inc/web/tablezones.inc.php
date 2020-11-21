<?php
global $_GPC, $_W;
$weid = $this->_weid;
$action = 'tablezones';
$title = $this->actions_titles[$action];
$storeid = intval($_GPC['storeid']);
//检查门店
$this->checkStore($storeid);
$title = $this->actions_titles[$action];
$returnid = $this->checkPermission($storeid);
//当前门店
$cur_store = $this->getStoreById($storeid);
//设置菜单
$GLOBALS['frames'] = $this->getNaveMenu($storeid,$action);

$url = $this->createWebUrl('tablezones', array('op' => 'display', 'storeid' => $storeid));
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'post') {
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " WHERE id = :id", array(':id' => $id));
        if (empty($item)) {
            message('抱歉，队列不存在或是已经删除！', '', 'error');
        }
    }
    if (checksubmit('submit')) {
        $data = array(
            'weid' => intval($weid),
            'storeid' => $storeid,
            'title' => trim($_GPC['title']),
            'limit_price' => intval($_GPC['limit_price']),
            'service_rate' => floatval($_GPC['service_rate']),
            'reservation_price' => intval($_GPC['reservation_price']),
            'table_count' => intval($_GPC['table_count']),
            'displayorder' => intval($_GPC['displayorder']),
            'dateline' => TIMESTAMP,
        );

        if (empty($data['title'])) {
            message('请输入桌台类型！');
        }

        if (empty($id)) {
            pdo_insert($this->table_tablezones, $data);
        } else {
            unset($data['dateline']);
            pdo_update($this->table_tablezones, $data, array('id' => $id, 'weid' => $weid));
        }
        message('操作成功！', $this->createWebUrl('tablezones', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }
} else if ($operation == 'display') {
    if (checksubmit('submit')) { //排序
        if (is_array($_GPC['displayorder'])) {
            foreach ($_GPC['displayorder'] as $id => $val) {
                $data = array('displayorder' => intval($_GPC['displayorder'][$id]));
                pdo_update($this->table_tablezones, $data, array('id' => $id));
            }
        }
        message('操作成功!', $url);
    }

    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_tablezones) . " WHERE weid = :weid AND storeid =:storeid ORDER BY displayorder
DESC,id DESC", array(':weid' => $this->_weid, ':storeid' => $storeid));

    $stores = pdo_fetchall("SELECT id,title FROM " . tablename($this->table_stores) . " where weid = :weid ", array(':weid' => $this->_weid), 'id');
    $table_count = pdo_fetchall("SELECT tablezonesid,COUNT(1) as count FROM " . tablename($this->table_tables) . " where storeid=:storeid AND weid = :weid GROUP BY tablezonesid", array(':weid' => $this->_weid, ':storeid' => $storeid), 'tablezonesid');
} else if ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $row = pdo_fetch("SELECT id FROM " . tablename($this->table_tablezones) . " WHERE id = :id", array(':id' => $id));
    if (empty($row)) {
        message('抱歉，数据不存在或是已经被删除！');
    }

    pdo_delete($this->table_tablezones, array('id' => $id, 'weid' => $weid));
    message('操作成功！', $this->createWebUrl('tablezones', array('op' => 'display', 'storeid' => $storeid)), 'success');
}
include $this->template('web/table_zones');