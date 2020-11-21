<?php
global $_GPC, $_W;
load()->func('tpl');
$setting = $this->getSetting();

$GLOBALS['frames'] = $this->getMainMenu();

$url = $this->createWebUrl('ad', array('op' => 'display'));
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

$school = pdo_fetchall("SELECT * FROM " . tablename("weisrc_dish_school") . " WHERE weid = :weid  ORDER BY displayorder DESC,id DESC", array(':weid' => $this->_weid));

if ($operation == 'post') {
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_ad) . " WHERE id = :id", array(':id' => $id));
        if (empty($item)) {
            message('抱歉，广告不存在或是已经删除！', '', 'error');
        }
    }

    if (!empty($item)) {
        $thumb = tomedia($item['thumb']);
    } else {
        $item = array(
            "status" => 1,
            "position" => 1,
            "starttime" => TIMESTAMP,
            "endtime" => strtotime(date("Y-m-d H:i", TIMESTAMP + 30 * 86400))
        );
    }

    if (checksubmit('submit')) {
        $data = array(
            'uniacid' => intval($this->_weid),
            'title' => trim($_GPC['title']),
            'thumb' => $_GPC['thumb'],
            'url' => $_GPC['url'],
            'position' => intval($_GPC['position']),
            'starttime' => strtotime($_GPC['datelimit']['start']),
            'endtime' => strtotime($_GPC['datelimit']['end']),
            'status' => intval($_GPC['status']),
            'displayorder' => intval($_GPC['displayorder']),
            'dateline' => TIMESTAMP,
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

        if (empty($id)) {
            pdo_insert($this->table_ad, $data);
        } else {
            unset($data['dateline']);
            pdo_update($this->table_ad, $data, array('id' => $id));
        }
        message('数据更新成功！', $url, 'success');
    }
} elseif ($operation == 'display') {
    if (!empty($_GPC['displayorder'])) {
        foreach ($_GPC['displayorder'] as $id => $displayorder) {
            pdo_update($this->table_ad, array('displayorder' => $displayorder), array('id' => $id));
        }
        message('排序更新成功！', $url, 'success');
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

    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_ad) . " WHERE uniacid = :uniacid $strwhere ORDER BY status DESC, displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, array(':uniacid' => $this->_weid));

    if (!empty($list)) {
        $total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename($this->table_ad) . " WHERE uniacid = :uniacid $strwhere", array(':uniacid' => $this->_weid));
        $pager = pagination($total, $pindex, $psize);
    }
} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $row = pdo_fetch("SELECT * FROM " . tablename($this->table_ad) . " WHERE id = :id", array(':id' => $id));
    if (empty($row)) {
        message('抱歉，数据不存在或是已经被删除！');
    }

    pdo_delete($this->table_ad, array('id' => $id));
    message('删除成功！', $this->createWebUrl('ad', array('op' => 'display')), 'success');
}
include $this->template('web/ad');