<?php
if ($op=='display') {

    $userid = intval($luser['id']);

    $user = pdo_get($this->table_user, array("uniacid"=>$_W['uniacid'],"id"=>$userid,"recycle"=>0,"status"=>2));
    if (empty($user)) {
        message_tip('管理者党员账号不存在或账号在非正常状态，请先核查该党员账号！', referer(), 'error');
    }
    $leader = pdo_fetchall("SELECT l.*,b.name FROM ".tablename($this->table_leader)." l LEFT JOIN ".tablename($this->table_branch)." b ON l.branchid=b.id WHERE l.userid=:userid AND l.uniacid=:uniacid ORDER BY l.priority DESC, l.id DESC ", array(':userid'=>$userid,':uniacid'=>$_W['uniacid']));
    if (empty($leader)) {
        message_tip('未有管理组织权限，不必设置管理登录信息！', referer(), 'error');
    }

    if (checksubmit('submit')) {
        $loginname = trim($_GPC['loginname']);
        if (empty($loginname)) {
            message_tip('管理者登录名不能为空！', referer(), 'error');
        }
        $haveuser = pdo_fetch("SELECT * FROM ".tablename($this->table_user)." WHERE loginname=:loginname AND id<>:userid AND uniacid=:uniacid ", array(':loginname'=>$loginname,':userid'=>$userid,':uniacid'=>$_W['uniacid']));
        if (!empty($haveuser)) {
            message_tip('登录用户名已存在！', referer(), 'error');
        }
        $data['loginname'] = $loginname; 
        $loginpass = trim($_GPC['loginpass']);
        $newloginpass = trim($_GPC['newloginpass']);
        if ($loginpass!==$newloginpass) {
            message_tip('两次输入的登录密码不一致！', referer(), 'error');
        }
        if (!empty($loginpass)) {
            $data['loginpass'] = md5($loginpass); 
        }
        pdo_update($this->table_user, $data, array('id'=>$userid));
        message_tip('管理者登录信息修改成功！', referer(), 'success');
    }

}
include $this->template('admin/myinfo');