<?php
global $_GPC, $_W;
$weid = $this->_weid;

$action = 'feedback';
$title = $this->actions_titles[$action];

$storeid = intval($_GPC['storeid']);
$this->checkStore($storeid);
$returnid = $this->checkPermission($storeid);
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu($storeid,$action);

$url = $this->createWebUrl($action, array('storeid' => $storeid));
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $cur_store = pdo_fetch("SELECT * FROM " . tablename($this->table_stores) . " WHERE id=:id AND weid=:weid LIMIT 1", array(':id' => $storeid, ':weid' => $weid));

    $pindex = max(1, intval($_GPC['page']));
    $psize = 15;
    $where = "WHERE a.weid = '{$weid}' and a.storeid = {$storeid}";

    $list = pdo_fetchall("SELECT a.*,b.nickname as nickname,b.headimgurl  FROM " . tablename($this->table_feedback) . "
        a LEFT JOIN " . tablename($this->table_fans) . " b ON a.from_user=b.from_user and a.weid=b.weid {$where} order by
        a.id
 desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");

    if (!empty($list)) {
        $total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_feedback) . " a INNER JOIN " . tablename($this->table_fans) . " b ON a.from_user=b.from_user {$where} order by a.id desc");
        $pager = pagination($total, $pindex, $psize);
    }
} else if ($operation == 'delete') {
    $id = $_GPC['id'];
    pdo_delete($this->table_feedback, array('id' => $id, 'weid' => $weid));
    message('删除成功！', $this->createWebUrl('feedback', array('op' => 'display', 'storeid' => $storeid)), 'success');
} else if ($operation == 'post') {
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_feedback) . " WHERE id = :id", array(':id' => $id));
        if (empty($item)) {
            message('抱歉，数据不存在或是已经删除！', '', 'error');
        }
    }

    if (checksubmit('submit')) {
        $data = array(
            'content' => trim($_GPC['content']),
            'replycontent' => trim($_GPC['replycontent']),
            'status' => intval($_GPC['status']),
            'displayorder' => intval($_GPC['displayorder']),
            'dateline' => TIMESTAMP,
        );

        if (empty($id)) {
            pdo_insert($this->table_feedback, $data);
        } else {
            unset($data['dateline']);
            pdo_update($this->table_feedback, $data, array('id' => $id));
        }
        message('数据更新成功！', $url, 'success');
    }
}

include $this->template('web/feedback');