<?php
global $_GPC, $_W;
load()->func('tpl');
$weid = $this->_weid;
$action = 'tpllog';
$GLOBALS['frames'] = $this->getMainMenu();
$title = $this->actions_titles[$action];
$storeid = intval($_GPC['storeid']);
$returnid = $this->checkPermission($storeid);

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $condition = '';
    $pindex = max(1, intval($_GPC['page']));
    $psize = 15;

    $start = ($pindex - 1) * $psize;
    $limit = "";
    $limit .= " LIMIT {$start},{$psize}";
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_tpl_log) . " WHERE weid = :weid {$condition} ORDER BY id DESC " . $limit, array(':weid' => $weid));
    $total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_tpl_log) . " WHERE weid = :weid {$condition} ", array(':weid' => $weid));

    $fans = array();
    foreach ($list as $key => $value) {
        $fans[$value['from_user']] = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE weid = :weid AND from_user=:from_user LIMIT 1;", array(':weid' => $weid, ':from_user' => $value['from_user']));
    }
    
    $pager = pagination($total, $pindex, $psize);
} else if ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT id FROM " . tablename($this->table_tpl_log) . " WHERE id = :id AND weid=:weid", array(':id' => $id, ':weid' => $weid));
    if (empty($item)) {
        message('抱歉，不存在或是已经被删除！', $this->createWebUrl('tpllog', array('op' => 'display', 'storeid' => $storeid)), 'error');
    }
    pdo_delete($this->table_tpl_log, array('id' => $id, 'weid' => $weid));
    message('删除成功！', $this->createWebUrl('tpllog', array('op' => 'display', 'storeid' => $storeid)), 'success');
}

include $this->template('web/tpllog');