<?php
global $_W,$_GPC;
session_start();
$_SESSION['cparty']['exadayicon'] = 1;
$op = $_GPC['op']?$_GPC['op']:'display';
if ($op=="display") {


}elseif ($op=="getmore") {
    $pindex = max(1, intval($_GPC['pindex']));
    $psize = max(1, intval($_GPC['psize']));
    $userid = intval($_GPC['userid']);
    $list = pdo_fetchall("SELECT * FROM ".tablename($this->table_exaday)." WHERE userid=:userid AND uniacid=:uniacid ORDER BY id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':userid'=>$userid,':uniacid'=>$_W['uniacid']));

    $this->result(0, '', $list);

}
?>