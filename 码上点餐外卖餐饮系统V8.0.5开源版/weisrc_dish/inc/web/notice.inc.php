<?php
global $_GPC, $_W;
$weid = $this->_weid;
$setting = $this->getSetting();
$GLOBALS['frames'] = $this->getMainMenu();

$school = pdo_fetchall("SELECT * FROM " . tablename("weisrc_dish_school") . " WHERE weid = :weid  ORDER BY displayorder DESC,id DESC", array(':weid' => $this->_weid));

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    if (!empty($_GPC['displayorder'])) {
        foreach ($_GPC['displayorder'] as $id => $displayorder) {
            pdo_update("weisrc_dish_notice", array('displayorder' => $displayorder), array('id' => $id));
        }
        foreach ($_GPC['url'] as $id => $url) {
            pdo_update("weisrc_dish_notice", array('url' => $url), array('id' => $id));
        }
        message('排序更新成功！', $this->createWebUrl('notice', array('op' => 'display')), 'success');
    }

    $strwhere = '';
    $schoolid = 0;
    if ($_W['role'] == 'operator') {
        $curadmin = $this->getCurAdmin();
        if ($curadmin['role'] == 3) {
            $schoolid = intval($curadmin['schoolid']);
            if ($schoolid > 0) {
                $strwhere .= " AND schoolid={$schoolid} ";
            }
        }
    }

    $list = pdo_fetchall("SELECT * FROM " . tablename("weisrc_dish_notice") . " WHERE weid = :weid {$strwhere} ORDER BY displayorder DESC,id DESC", array(':weid' => $weid));

} elseif ($operation == 'post') {
    load()->func('tpl');
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $type = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_notice") . " WHERE id = '$id'");
    } else {
        $type = array(
            'displayorder' => 0,
        );
    }

    if (checksubmit('submit')) {
        if (empty($_GPC['title'])) {
            message('抱歉，请输入通知名称！');
        }


        $data = array(
            'weid' => $weid,
            'title' => $_GPC['title'],
            'content' => $_GPC['content'],
            'url' => $_GPC['url'],
            'displayorder' => intval($_GPC['displayorder']),
            'status' => intval($_GPC['status']),
        );

        if ($setting['is_school'] == 1) {
            if ($_W['role'] == 'operator') { //操作员
                $curadmin = $this->getCurAdmin();
                if ($curadmin['role'] == 3) { //分站站长 固定分站id
                    $schoolid = intval($curadmin['schoolid']);
                    if ($schoolid > 0) {
                        $data['schoolid'] = $schoolid;
                    }
                }
            } else {  //站长，管理员
                $data['schoolid'] = intval($_GPC['schoolid']);
            }
        }

        if (!empty($id)) {
            pdo_update("weisrc_dish_notice", $data, array('id' => $id));
        } else {
            pdo_insert("weisrc_dish_notice", $data);
        }
        message('操作成功！', $this->createWebUrl('notice', array('op' => 'display')), 'success');
    }
} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $type = pdo_fetch("SELECT id FROM " . tablename("weisrc_dish_notice") . " WHERE id = '$id'");
    if (empty($type)) {
        message('抱歉，数据不存在或是已经被删除！', $this->createWebUrl('notice', array('op' => 'display')), 'error');
    }
    pdo_delete("weisrc_dish_notice", array('id' => $id, 'weid' => $weid));
    message('删除成功！', $this->createWebUrl('notice', array('op' => 'display')), 'success');
}
include $this->template('web/notice');