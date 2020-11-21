<?php
global $_GPC, $_W;
$weid = $this->_weid;
$action = 'coreuser';

$storeid = intval($_GPC['storeid']);
$this->checkStore($storeid);
$title = $this->actions_titles[$action];
$returnid = $this->checkPermission($storeid);
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu($storeid,$action);

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $strwhere = " AND storeid={$storeid} ";

    if (!empty($_GPC['role'])) {
        $role = intval($_GPC['role']);
        $strwhere .= " AND role={$role} ";
    }
    if (!empty($_GPC['keyword'])) {
        $strwhere .= " AND (username LIKE '%{$_GPC['keyword']}%' OR mobile LIKE '%{$_GPC['keyword']}%') ";
    }

    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_account) . "  WHERE weid = :weid AND role<>1 $strwhere ORDER BY id DESC LIMIT
" . ($pindex - 1) * $psize . ',' . $psize, array(':weid' => $this->_weid));

    foreach($list as $key => $value) {
        $fans = $this->getFansByOpenid($value['from_user']);
        $list[$key]['headimgurl'] = $fans['headimgurl'];
    }

    if (!empty($list)) {
        $total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename($this->table_account) . " WHERE weid = :weid $strwhere", array(':weid' => $this->_weid));
        $pager = pagination($total, $pindex, $psize);
    }
} else if ($operation == 'post') {
    $id = intval($_GPC['id']);
    $account = pdo_fetch("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND id=:id AND storeid=:storeid ORDER BY id DESC", array(':weid' => $this->_weid, ':id' => $id, ':storeid' => $storeid));
    if ($account) {
        $fans = $this->getFansByOpenid($account['from_user']);
    } else {
        $account = array(
            'role' => 2,
            'is_admin_order' => 1,
            'is_notice_order' => 1,
            'is_notice_service' => 1,
        );
    }

    if (checksubmit('submit')) {
        $role = intval($_GPC['role']);
        if ($role < 2 || $role > 5) {
            message('操作有问题！');
        }

        $data = array(
            'weid' => $this->_weid,
            'storeid' => intval($_GPC['storeid']),
            'from_user' => trim($_GPC['from_user']),
            'username' => trim($_GPC['username']),
            'mobile' => trim($_GPC['mobile']),
//            'email' => trim($_GPC['email']),
            'role' => $role,
            'is_admin_order' => intval($_GPC['is_admin_order']),
            'is_notice_order' => intval($_GPC['is_notice_order']),
            'is_notice_service' => intval($_GPC['is_notice_service']),
            'is_notice_boss' => intval($_GPC['is_notice_boss']),
            'is_notice_queue' => intval($_GPC['is_notice_queue']),
            'status' => intval($_GPC['status']),
            'remark' => trim($_GPC['remark']),
            'dateline' => TIMESTAMP,
        );

        if (empty($id)) {
            pdo_insert($this->table_account, $data);
        } else {
            pdo_update($this->table_account, $data, array('id' => $id));
        }
        message('操作成功！', $this->createWebUrl('coreuser', array('op' => 'display', 'storeid' => $storeid), true));
    }
} else if ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT id FROM " . tablename($this->table_account) . " WHERE id = :id AND weid=:weid ", array(':id' => $id, ':weid' => $_W['uniacid']));
    if (empty($item)) {
        message('抱歉，不存在或是已经被删除！', $this->createWebUrl('account', array('op' => 'display')), 'error');
    }
    pdo_delete($this->table_account, array('id' => $id, 'weid' => $_W['uniacid']));
    message('删除成功！', $this->createWebUrl('coreuser', array('op' => 'display', 'storeid' => $storeid)), 'success');
}
include $this->template('web/coreuser');