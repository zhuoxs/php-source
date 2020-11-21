<?php
global $_GPC, $_W;
$returnid = $this->checkPermission();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$stores = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " WHERE weid = :weid ORDER BY id DESC", array(':weid' => $this->_weid), 'id');
$GLOBALS['frames'] = $this->getMainMenu();

if ($operation == 'post') {
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $account = pdo_fetch("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $this->_weid, ':id' => $id));
        $fans = $this->getFansByOpenid($account['from_user']);
    }

    if (checksubmit('submit')) {
        load()->model('user');

        $data = array(
            'uid' => $uid,
            'weid' => $this->_weid,
            'storeid' => intval($_GPC['storeid']),
            'from_user' => trim($_GPC['from_user']),
            'accountname' => trim($_GPC['username']),
            'email' => trim($_GPC['email']),
            'mobile' => trim($_GPC['mobile']),
            'pay_account' => trim($_GPC['pay_account']),
            'status' => intval($_GPC['status']),
            'username' => trim($_GPC['truename']),
            'is_admin_order' => intval($_GPC['is_admin_order']),
            'is_notice_order' => intval($_GPC['is_notice_order']),
            'is_notice_service' => intval($_GPC['is_notice_service']),
            'is_notice_boss' => intval($_GPC['is_notice_boss']),
            'is_notice_queue' => intval($_GPC['is_notice_queue']),
            'role' => 1,
            'remark' => trim($_GPC['remark']),
            'dateline' => TIMESTAMP,
        );

        if (!preg_match(REGULAR_USERNAME, $data['accountname'])) {
            message('必须输入用户名，格式为 3-15 位字符，可以包括汉字、字母（不区分大小写）、数字、下划线和句点。');
        }

        if ($id == 0) { //新增
            $data['password'] = $_GPC['password'];
            if (istrlen($data['password']) < 8) {
                message('必须输入密码，且密码长度不得低于8位。');
            }
        }
        if (!empty($_GPC['password'])) {
            $data['password'] = $_GPC['password'];
            if (istrlen($data['password']) < 8) {
                message('必须输入密码，且密码长度不得低于8位。');
            }
        }

        if (!empty($_GPC['password'])) {
            if ($id == 0) {
                $data['salt'] = random(8);
            } else {
                $data['salt'] = $account['salt'];
            }
            $data['password'] = user_hash($_GPC['password'], $data['salt']);
        }

        $strwhere = " WHERE accountname=:accountname ";
        $params = array(":accountname" => $data['accountname']);
        if ($id > 0) {
            $strwhere .= " AND id<>:id ";
            $params[':id'] = $id;
        }

        $sql = 'SELECT * FROM ' . tablename($this->table_account) . " {$strwhere} LIMIT 1";
        $record = pdo_fetch($sql, $params);
        if (!empty($record)) {
            message('非常抱歉，此用户名已经被注册，你需要更换注册名称！');
        }

        if ($id > 0) {
            pdo_update($this->table_account, $data, array('id' => $id));
        } else {
            pdo_insert($this->table_account, $data);
        }
        message('操作成功！', $this->createWebUrl('account', array(), true));
    }
} else if ($operation == 'display') {
    $strwhere = '';
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND role=1 $strwhere ORDER BY id DESC LIMIT
" . ($pindex - 1) * $psize . ',' . $psize, array(':weid' => $this->_weid));

    if (!empty($list)) {
        $total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename($this->table_account) . " WHERE weid = :weid $strwhere", array(':weid' => $this->_weid));
        $pager = pagination($total, $pindex, $psize);
    }
} else if ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT id FROM " . tablename($this->table_account) . " WHERE id = '$id'");
    if (empty($item)) {
        message('抱歉，不存在或是已经被删除！', $this->createWebUrl('account', array('op' => 'display')), 'error');
    }
    pdo_delete($this->table_account, array('id' => $id, 'weid' => $_W['uniacid']));
    message('删除成功！', $this->createWebUrl('account', array('op' => 'display')), 'success');
}
include $this->template('web/account');