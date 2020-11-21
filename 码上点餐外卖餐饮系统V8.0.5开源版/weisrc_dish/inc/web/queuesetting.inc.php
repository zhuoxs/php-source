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
if ($operation == 'post') {
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_queue_setting) . " WHERE id = :id", array(':id' => $id));
        if (empty($item)) {
            message('抱歉，队列不存在或是已经删除！', '', 'error');
        }
    }
    if (checksubmit('submit')) {
        $data = array(
            'weid' => intval($weid),
            'storeid' => $storeid,
            'title' => trim($_GPC['title']),
            'limit_num' => intval($_GPC['limit_num']),
            'notify_number' => intval($_GPC['notify_number']),
            'prefix' => trim($_GPC['prefix']),
            'starttime' => trim($_GPC['starttime']),
            'endtime' => trim($_GPC['endtime']),
            'status' => intval($_GPC['status']),
            'displayorder' => intval($_GPC['displayorder']),
            'dateline' => TIMESTAMP,
        );

        if (empty($data['title'])) {
            message('队列名称！');
        }

        if (empty($id)) {
            pdo_insert($this->table_queue_setting, $data);
        } else {
            unset($data['dateline']);
            pdo_update($this->table_queue_setting, $data, array('id' => $id));
        }
        message('操作成功！', $this->createWebUrl('queuesetting', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }
} else if ($operation == 'display') {
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_queue_setting) . " WHERE weid = :weid AND storeid =:storeid ORDER BY displayorder DESC", array(':weid' => $this->_weid, ':storeid' => $storeid));
} else if ($operation == 'setting') {
    if (empty($cur_store['screen_title'])) {
        $cur_store['screen_title'] = $cur_store['title'];
    }
    if (empty($cur_store['screen_bg'])) {
        $cur_store['screen_bg'] = 'https://15595755.kf5.com/attachments/download/3056299/001584a6bdcc076a25d0e43a1f03c9f/';
    }
    if (empty($cur_store['screen_bottom'])) {
        $cur_store['screen_bottom'] = '取号，微信扫一扫';
    }

    if (checksubmit('submit')) {
        $data = array(
            'screen_mode' => intval($_GPC['screen_mode']),
            'screen_title' => trim($_GPC['screen_title']),
            'screen_bg' => trim($_GPC['screen_bg']),
            'screen_bottom' => trim($_GPC['screen_bottom']),
        );
        pdo_update($this->table_stores, $data, array('id' => $cur_store['id'], 'weid' => $weid));
        message('更新成功！', $this->createWebUrl('queuesetting', array('op' => 'setting', 'storeid' => $storeid)), 'success');
    }
} else if ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $row = pdo_fetch("SELECT id FROM " . tablename($this->table_queue_setting) . " WHERE id = :id", array(':id' => $id));
    if (empty($row)) {
        message('抱歉，数据不存在或是已经被删除！');
    }

    pdo_delete($this->table_queue_setting, array('id' => $id, 'weid' => $weid));
    message('操作成功！', $this->createWebUrl('queuesetting', array('op' => 'display', 'storeid' => $storeid)), 'success');
}
include $this->template('web/queuesetting');