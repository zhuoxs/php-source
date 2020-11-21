<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {


}elseif ($op=="getmore") {

    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall("SELECT l.*,i.title FROM ".tablename($this->table_serlog)." l LEFT JOIN ".tablename($this->table_seritem)." i ON l.itemid=i.id WHERE l.userid=:userid AND l.uniacid=:uniacid ORDER BY l.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':userid'=>$user['id'],':uniacid'=>$_W['uniacid']));
    if (empty($list)) {
        exit("NOTHAVE");
    }
    
}
include $this->template('serlog');
?>