<?php
global $_GPC, $_W;
$weid = $this->_weid;
$action = 'dispatcharea';
$title = $this->actions_titles[$action];

$storeid = intval($_GPC['storeid']);
$this->checkStore($storeid);
$title = $this->actions_titles[$action];
$returnid = $this->checkPermission($storeid);
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu($storeid,$action);


$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    if (!empty($_GPC['displayorder'])) {
        foreach ($_GPC['displayorder'] as $id => $displayorder) {
            pdo_update($this->table_dispatcharea, array('displayorder' => $displayorder), array('id' => $id));
        }
        foreach ($_GPC['goodsname'] as $id => $goodsname) {
            pdo_update($this->table_dispatcharea, array('title' => $goodsname), array('id' => $id));
        }
        message('保存设置成功！', $this->createWebUrl('dispatcharea', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }
    $children = array();
    $dispatcharea = pdo_fetchall("SELECT * FROM " . tablename($this->table_dispatcharea) . " WHERE weid = '$weid'  AND storeid ={$storeid} ORDER BY displayorder DESC, id DESC");
} elseif ($operation == 'post') {
    $parentid = intval($_GPC['parentid']);
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $dispatcharea = pdo_fetch("SELECT * FROM " . tablename($this->table_dispatcharea) . " WHERE id = '$id'");
    } else {
        $dispatcharea = array(
            'displayorder' => 0,
        );
    }

    if (checksubmit('submit')) {
        if (empty($_GPC['title'])) {
            message('抱歉，请输入配送区域名称！');
        }

        $data = array(
            'weid' => $weid,
            'storeid' => $_GPC['storeid'],
            'title' => $_GPC['title'],
            'displayorder' => intval($_GPC['displayorder']),
        );

        if (empty($data['storeid'])) {
            message('非法参数');
        }

        if (!empty($id)) {
            unset($data['parentid']);
            pdo_update($this->table_dispatcharea, $data, array('id' => $id));
        } else {
            pdo_insert($this->table_dispatcharea, $data);
            $id = pdo_insertid();
        }
        message('更新配送区域成功！', $this->createWebUrl('dispatcharea', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }
} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $dispatcharea = pdo_fetch("SELECT id FROM " . tablename($this->table_dispatcharea) . " WHERE id = '$id'");
    if (empty($dispatcharea)) {
        message('抱歉，配送区域不存在或是已经被删除！', $this->createWebUrl('dispatcharea', array('op' => 'display', 'storeid' => $storeid)), 'error');
    }
    pdo_delete($this->table_dispatcharea, array('id' => $id));
    message('配送区域删除成功！', $this->createWebUrl('dispatcharea', array('op' => 'display', 'storeid' => $storeid)), 'success');
} elseif ($operation == 'deleteall') {
    $rowcount = 0;
    $notrowcount = 0;
    foreach ($_GPC['idArr'] as $k => $id) {
        $id = intval($id);
        if (!empty($id)) {
            $dispatcharea = pdo_fetch("SELECT * FROM " . tablename($this->table_dispatcharea) . " WHERE id = :id", array(':id' => $id));
            if (empty($dispatcharea)) {
                $notrowcount++;
                continue;
            }
            pdo_delete($this->table_dispatcharea, array('id' => $id, 'weid' => $weid));
            $rowcount++;
        }
    }
    $this->message("操作成功！共删除{$rowcount}条数据,{$notrowcount}条数据不能删除!!", '', 0);
}
include $this->template('web/dispatcharea');