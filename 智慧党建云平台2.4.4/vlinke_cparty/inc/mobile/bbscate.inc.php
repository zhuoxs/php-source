<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {

    $branch = $this->getBranch($user['branchid']);
    
    $cate1 = pdo_fetchall("SELECT * FROM ".tablename($this->table_bbscate)." WHERE ishot=1 AND isshow=1 AND branchid IN (".$branch['scort'].") AND uniacid=:uniacid ORDER BY priority DESC, id DESC ", array(':uniacid'=>$_W['uniacid']));


    $cate2 = pdo_fetchall("SELECT * FROM ".tablename($this->table_bbscate)." WHERE ishot=2 AND isshow=1 AND branchid IN (".$branch['scort'].")  AND uniacid=:uniacid ORDER BY priority DESC, id DESC ", array(':uniacid'=>$_W['uniacid']));


}

include $this->template('bbscate');

?>