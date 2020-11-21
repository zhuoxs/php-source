<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {
    $cateid = intval($_GPC['cateid']);
    $sercatelist = pdo_fetchall("SELECT * FROM ".tablename($this->table_sercate)." WHERE uniacid=:uniacid ORDER BY priority DESC, id DESC", array(':uniacid'=>$_W['uniacid']),'id');
    $sercate = $sercatelist[$cateid];

}elseif ($op=="getmore") {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $branch = $this->getBranch($user['branchid']);
    $con = " WHERE branchid in ( ".$branch['scort']." ) AND status IN (2,3) AND uniacid=:uniacid ";
    $par = array(':uniacid'=>$_W['uniacid']);

    $cateid = intval($_GPC['cateid']);
    if ($cateid!=0) {
        $con .= " AND cateid=:cateid ";
        $par['cateid'] = $cateid;
    }
    $list = pdo_fetchall("SELECT * FROM ".tablename($this->table_seritem).$con." ORDER BY status ASC, priority DESC, id DESC LIMIT ".($pindex-1) * $psize.','.$psize, $par);
    if (empty($list)) {
        exit("NOTHAVE");
    }

    $branchidarr = array_column($list,'branchid');
    $branch = pdo_getall($this->table_branch, array('id'=>$branchidarr,'uniacid'=>$_W['uniacid']), '', 'id');

}
include $this->template('sercate');
?>