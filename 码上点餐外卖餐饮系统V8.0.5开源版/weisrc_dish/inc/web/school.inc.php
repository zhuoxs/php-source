<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    if (!empty($_GPC['displayorder'])) {
        foreach ($_GPC['displayorder'] as $id => $displayorder) {
            pdo_update("weisrc_dish_school", array('displayorder' => $displayorder), array('id' => $id));
        }
        message('区域排序更新成功！', $this->createWebUrl('area', array('op' => 'display')), 'success');
    }
    $list = pdo_fetchall("SELECT * FROM " . tablename("weisrc_dish_school") . " WHERE weid = :weid  ORDER BY displayorder DESC,id DESC", array(':weid' => $_W['uniacid']));

} elseif ($operation == 'post') {
    load()->func('tpl');
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $school = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_school") . " WHERE id = :id", array(':id' => $id));
    } else {
        $school = array(
            'displayorder' => 0,
        );
    }

    if (checksubmit('submit')) {
        if (empty($_GPC['title'])) {
            message('抱歉，请输入区域名称！');
        }

        $data = array(
            'weid' => $_W['uniacid'],
            'title' => $_GPC['title'],
            'lng' => trim($_GPC['baidumap']['lng']),
            'lat' => trim($_GPC['baidumap']['lat']),
            'displayorder' => intval($_GPC['displayorder']),

        );

        if (!empty($id)) {
            pdo_update("weisrc_dish_school", $data, array('id' => $id));
        } else {
            pdo_insert("weisrc_dish_school", $data);
            $id = pdo_insertid();
        }
        message('更新区域成功！', $this->createWebUrl('school', array('op' => 'display')), 'success');
    }
} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $area = pdo_fetch("SELECT id FROM " . tablename("weisrc_dish_school") . " WHERE id = {$id}");
    if (empty($area)) {
        message('抱歉，区域不存在或是已经被删除！', $this->createWebUrl('school', array('op' => 'display')), 'error');
    }
    pdo_delete("weisrc_dish_school", array('id' => $id));
    message('区域删除成功！', $this->createWebUrl('school', array('op' => 'display')), 'success');
}
include $this->template('web/school');