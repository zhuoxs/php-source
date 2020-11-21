<?php
global $_W, $_GPC, $code;
$action = 'creditsetting';
$weid = $this->_weid;

$returnid = $this->checkPermission();

$setting = $this->getSetting();
$title = '提现设置';
$url = $this->createWebUrl($action, array('op' => 'display'));
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

$GLOBALS['frames'] = $this->getMainMenu();
if ($operation == 'display') {
    $shoptypeid = intval($_GPC['shoptypeid']);
    $areaid = intval($_GPC['areaid']);
    $keyword = trim($_GPC['keyword']);

    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $where = "WHERE weid = {$weid}";

    if (!empty($keyword)) {
        $where .= " AND title LIKE '%{$keyword}%'";
    }
    if ($returnid != 0) {
        $where .= " AND id={$returnid} ";
    }

    $types = pdo_fetchall("SELECT * FROM " . tablename($this->table_type) . " WHERE weid = :weid ORDER BY id DESC, displayorder DESC", array(':weid' => $weid), 'id');

    $storeslist = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " {$where} order by displayorder desc,id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");

    if (!empty($storeslist)) {
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_stores) . " $where");
        $pager = pagination($total, $pindex, $psize);
    }
} elseif ($operation == 'post') {
    load()->func('tpl');
    $id = intval($_GPC['id']);
    $store = pdo_fetch("select * from " . tablename($this->table_stores) . " where id=:id and weid =:weid", array(':id' => $id, ':weid' => $weid));
    if (checksubmit('submit')) {
        $data = array(
            'is_default_givecredit' => 2,
            'givecredit' => intval($_GPC['givecredit'])
        );

        if (!empty($id)) {
            pdo_update($this->table_stores, $data, array('id' => $id, 'weid' => $weid));
        }
        message('操作成功!', $url);
    }
}

include $this->template('web/creditsetting');