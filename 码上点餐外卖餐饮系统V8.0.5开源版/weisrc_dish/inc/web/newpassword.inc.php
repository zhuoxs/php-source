<?php
global $_GPC, $_W;
$weid = $this->_weid;
$action = 'goods';
$storeid = intval($_GPC['storeid']);
//检查门店
$this->checkStore($storeid);
$title = $this->actions_titles[$action];
$returnid = $this->checkPermission($storeid);
$cur_store = $this->getStoreById($storeid);
//设置菜单
$GLOBALS['frames'] = $this->getNaveMenu($storeid,$action);

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'newpassword';
if ($operation == 'newpassword') {
    $users = user_single($_W['uid']);
    if (empty($users)) {
        message('您没有权限访问！');
    }

    if (checksubmit('submit')) {
        load()->model('user');
        $user = array();
        $user['password'] = $_GPC['password'];
        $user['uid'] = $_W['uid'];
        $user['salt'] = $users['salt'];

        if (istrlen($user['password']) < 8) {
            message('必须输入密码，且密码长度不得低于8位。');
        }

        user_update($user);
        message('更新成功！', referer(), 'success');
    }
}
include $this->template('web/account');