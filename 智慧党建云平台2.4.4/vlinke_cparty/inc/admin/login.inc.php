<?php

if ($op == "display") {
    $uniacid = intval($_GPC['uniacid']);
    if ($uniacid==0) {
        exit("登录网址不正确，请核对后重新访问......");
    }
    if (function_exists('uni_account_save_switch')) {
        uni_account_save_switch($uniacid);
    }


    $param = pdo_get($this->table_param, array('uniacid'=>$_W['uniacid']), array('title','pclogo','pcfoot') );
    if (empty($param)) {
        message('请先进行系统参数配置！');
        die();
    }
    $_SESSION['cparty']['param'] = $param;


    $_SESSION['cparty']['uniacid'] = $_W['uniacid'];


} elseif ($op=="submit") {
    $loginname = trim($_GPC['loginname']);
    $loginpass = trim($_GPC['loginpass']);
    $user = pdo_fetch("SELECT * FROM ".tablename($this->table_user)." WHERE loginname=:loginname AND uniacid=:uniacid LIMIT 1 ", array(':loginname'=>$loginname,':uniacid'=>$_W['uniacid']));
    if (empty($user)) {
        message_tip("登录用户名不存在！", referer(), "warning");
    }
    if ($user['loginpass']!=md5($loginpass)) {
        message_tip("登录密码不正确！", referer(), "error");
    }

    $leader = pdo_fetchall("SELECT l.*,b.scort,b.name FROM ".tablename($this->table_leader)." l LEFT JOIN ".tablename($this->table_branch)." b ON l.branchid=b.id WHERE l.userid=:userid AND l.isadmin=1 AND l.uniacid=:uniacid ", array(':userid'=>$user['id'],':uniacid'=>$_W['uniacid']), "branchid");
    if (empty($leader)) {
        message_tip("你没有组织管理权限！", referer(), "error");
    }

    $regexp = "("; 
    foreach ($leader as $k => $v) {
    	$regexp .= "(^(".$v['scort']."){1}$)|(^(".$v['scort'].")+[^0-9])";
    }
    $regexp = rtrim($regexp,'|');
    $regexp .= ")";


    $branchall = pdo_fetchall("SELECT * FROM ".tablename($this->table_branch)." WHERE scort REGEXP '".$regexp."' AND uniacid=:uniacid ORDER BY priority DESC ", array(':uniacid'=>$_W['uniacid']), 'id');
    $leader_branch_idstr = implode(',', array_keys($branchall));

    $_SESSION['cparty']['luser']        = $user;
    $_SESSION['cparty']['lbranchall']   = $branchall;
    $_SESSION['cparty']['lbranchallid'] = $leader_branch_idstr;
    $_SESSION['cparty']['lbrancharr']   = $branchall;
    $_SESSION['cparty']['lbranch']      = array();
    $_SESSION['cparty']['lbrancharrid'] = $leader_branch_idstr;

    header('location:' . $this->createWebUrl('admin',array('r'=>'home')));


} elseif ($op=="logout") {
    unset($_SESSION['cparty']);
    header('location:' . $this->createWebUrl('admin',array('r'=>'login','uniacid'=>$_W['uniacid'])));
    die;

}
include $this->template("admin/login");
?>