<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {



}elseif ($op=="getmore") {
    $branch = $this->getBranch($user['branchid']);
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall("SELECT * FROM ".tablename($this->table_notice)." WHERE branchid in ( ".$branch['scort']." ) AND uniacid=:uniacid ORDER BY priority DESC, id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':uniacid'=>$_W['uniacid']));
    if (empty($list)) {
        exit("NOTHAVE");
    }
    $branchidarr = array_column($list,'branchid');
    $branch = pdo_getall($this->table_branch, array('id'=>$branchidarr,'uniacid'=>$_W['uniacid']), '', 'id');
    
}elseif ($op=="details") {
    $id = intval($_GPC['id']);
    $notice = pdo_get($this->table_notice, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($notice)) {
        message("要查看的通知公告不存在，请重新进入！", $this->createMobileUrl('notice'), "error");
    }

    $branch = pdo_get($this->table_branch,array('id'=>$notice['branchid'],'uniacid'=>$_W['uniacid']));

}
include $this->template('notice');
?>