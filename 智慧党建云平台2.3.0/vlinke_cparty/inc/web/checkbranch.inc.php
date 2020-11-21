<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
if ($op=='display') {

    $branchname = trim($_GPC['branchname']);
    $branchlist = pdo_fetchall("SELECT * FROM ".tablename($this->table_branch)." WHERE uniacid=:uniacid AND name LIKE :name ORDER BY id ASC ", array(':uniacid'=>$_W['uniacid'],':name'=>"%".$branchname."%"), "id");
    $blevelarr = array(1=>"党支部",2=>"党总支",3=>"党委",4=>"单位");
}
include $this->template('checkbranch');
?>
