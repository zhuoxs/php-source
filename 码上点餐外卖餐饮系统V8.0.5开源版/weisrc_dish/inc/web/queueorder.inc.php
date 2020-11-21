<?php
global $_GPC, $_W;
$weid = $this->_weid;
$action = 'queueorder';
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

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$queueid = intval($_GPC['queueid']);
if ($operation == 'detail') {
    $itemid = intval($_GPC['itemid']);
    $item = pdo_fetch("SELECT * FROM " . tablename($this->table_queue_order) . " WHERE id = :id AND status=2", array(':id' => $itemid));
    if (empty($queueid)) {
        message('请先选择队列');
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 8;
    $condition = '';
    if (isset($_GPC['status'])) {
        $condition .= " AND status = '" . intval($_GPC['status']) . "'";
    } else {
        $condition .= " AND status = 1 ";
    }
    $condition .= " AND queueid = {$queueid} ";
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_queue_order) . " WHERE weid = :weid AND storeid =:storeid $condition ORDER BY id ASC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, array(':weid' => $this->_weid, ':storeid' => $storeid));

    foreach ($list as $key => $value) {
        $fans = $this->getFansByOpenid($value['from_user']);
        $list[$key]['fans'] = $fans;
    }

    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_queue_order) . " WHERE weid = :weid AND storeid =:storeid $condition", array(':weid' => $this->_weid, ':storeid' => $storeid));
    $pager = pagination($total, $pindex, $psize);

} else if ($operation == 'display') {
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_queue_setting) . " WHERE weid = :weid AND storeid =:storeid ORDER BY displayorder DESC", array(':weid' => $this->_weid, ':storeid' => $storeid));
    $queue_count = pdo_fetchall("SELECT queueid,COUNT(1) as count FROM " . tablename($this->table_queue_order) . " where storeid=:storeid AND status=1 AND  weid = :weid GROUP BY queueid", array(':weid' => $this->_weid, ':storeid' => $storeid), 'queueid');



} else if ($operation == 'post') {
    if (empty($queueid)) {
        message('请先选择队列');
    }
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_queue_order) . " WHERE id = :id ", array(':id' => $id));
        if (empty($item)) {
            message('抱歉，队列不存在或是已经删除！', '', 'error');
        }
    }

    if (checksubmit('submit')) {
        $data = array(
            'weid' => intval($weid),
            'storeid' => $storeid,
            'num' => trim($_GPC['num']),
            'mobile' => trim($_GPC['mobile']),
            'usercount' => trim($_GPC['usercount'])
        );

        pdo_update($this->table_queue_order, $data, array('id' => $id));
        message('操作成功！', $this->createWebUrl('queueorder', array('op' => 'detail', 'storeid' => $storeid, 'queueid' => $queueid)), 'success');
    }
} else if ($operation == 'setstatus') {
    $id = intval($_GPC['id']);
    $status = intval($_GPC['status']);
    pdo_update($this->table_queue_order, array('status' => $status), array('id' => $id, 'weid' => $this->_weid));
    $this->sendQueueNotice($id, $status);
    pdo_update($this->table_queue_order, array('isnotify' => 1), array('id' => $id));

    $queue_setting = pdo_fetch("SELECT * FROM " . tablename($this->table_queue_setting) . " WHERE id = :id", array(':id' => $queueid));
    if (!empty($queue_setting) && $queue_setting['notify_number'] > 0) {
        $queues = pdo_fetchall("SELECT * FROM " . tablename($this->table_queue_order) . " WHERE status=1 AND storeid=:storeid AND  queueid=:queueid ORDER
BY id LIMIT " . $queue_setting['notify_number'], array(':storeid' => $storeid, ':queueid' => $queueid));
        foreach ($queues as $key => $value) {
            $this->sendQueueNotice($value['id'], 1);
            pdo_update($this->table_queue_order, array('isnotify' => 1), array('id' => $value['id']));
        }
    }
    message('操作成功！', $this->createWebUrl('queueorder', array('op' => 'detail', 'storeid' => $storeid, 'queueid' => $queueid, 'itemid' => $id)), 'success');
} else if ($operation == 'notice') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT * FROM " . tablename($this->table_queue_order) . " WHERE id = :id", array(':id' => $id));
    $this->sendQueueNotice($id, $item['status']);
    pdo_update($this->table_queue_order, array('isnotify' => 1), array('id' => $id));
    message('操作成功！', $this->createWebUrl('queueorder', array('op' => 'detail', 'storeid' => $storeid, 'queueid' => $queueid)), 'success');
}
include $this->template('web/queueorder');