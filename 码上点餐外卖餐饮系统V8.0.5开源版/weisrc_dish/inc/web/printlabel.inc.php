<?php
global $_W, $_GPC;
$weid = $this->_weid;
$action = 'printlabel';
$title = $this->actions_titles[$action];
$storeid = intval($_GPC['storeid']);
$this->checkStore($storeid);
$returnid = $this->checkPermission($storeid);
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu($storeid,$action);

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    if (!empty($_GPC['displayorder'])) {
        foreach ($_GPC['displayorder'] as $id => $displayorder) {
            pdo_update($this->table_print_label, array('displayorder' => $displayorder), array('id' => $id));
        }
        foreach ($_GPC['title'] as $id => $goodsname) {
            pdo_update($this->table_print_label, array('title' => $goodsname), array('id' => $id));
        }
        message('保存设置成功！', $this->createWebUrl('printlabel', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }
    $printlabel = pdo_fetchall("SELECT * FROM " . tablename($this->table_print_label) . " WHERE weid = '$weid'  AND storeid ={$storeid} ORDER BY displayorder DESC");
} elseif ($operation == 'post') {
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $printlabel = pdo_fetch("SELECT * FROM " . tablename($this->table_print_label) . " WHERE id = '$id'");
    } else {
        $printlabel = array(
            'displayorder' => 0,
        );
    }
    
    if (checksubmit('submit')) {
        if (empty($_GPC['title'])) {
            message('抱歉，请输入标签名称！');
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
            pdo_update($this->table_print_label, $data, array('id' => $id));
        } else {
            pdo_insert($this->table_print_label, $data);
            $id = pdo_insertid();
        }
        message('更新成功！', $this->createWebUrl('printlabel', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }
} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $printlabel = pdo_fetch("SELECT id FROM " . tablename($this->table_print_label) . " WHERE id = '$id'");
    if (empty($printlabel)) {
        message('抱歉，数据不存在或是已经被删除！', $this->createWebUrl('printlabel', array('op' => 'display', 'storeid' => $storeid))
            , 'error');
    }
    pdo_delete($this->table_print_label, array('id' => $id, 'weid' => $weid));
    message('标签删除成功！', $this->createWebUrl('printlabel', array('op' => 'display', 'storeid' => $storeid)), 'success');
} elseif ($operation == 'deleteall') {
    $rowcount = 0;
    $notrowcount = 0;
    foreach ($_GPC['idArr'] as $k => $id) {
        $id = intval($id);
        if (!empty($id)) {
            $printlabel = pdo_fetch("SELECT * FROM " . tablename($this->table_print_label) . " WHERE id = :id", array(':id' => $id));
            if (empty($printlabel)) {
                $notrowcount++;
                continue;
            }
            pdo_delete($this->table_print_label, array('id' => $id, 'weid' => $weid));
            $rowcount++;
        }
    }
    $this->message("操作成功！共删除{$rowcount}条数据,{$notrowcount}条数据不能删除!!", '', 0);
}
include $this->template('web/print_label');