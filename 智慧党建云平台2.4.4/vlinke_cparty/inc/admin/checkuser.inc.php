<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
if ($op=='display') {

    $userrealname = trim($_GPC['userrealname']);
    $userlist = pdo_fetchall("SELECT * FROM ".tablename($this->table_user)." WHERE uniacid=:uniacid AND branchid IN (".$lbrancharrid.") AND recycle=0 AND realname LIKE :realname ORDER BY id ASC ", array(':uniacid'=>$_W['uniacid'],':realname'=>"%".$userrealname."%"), "id");
    
}
include $this->template('admin/checkuser');
?>
