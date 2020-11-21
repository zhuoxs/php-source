<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {


}elseif ($op=="getmore") {

    $pindex = max(1, intval($_GPC['pindex']));
    $psize = max(1, intval($_GPC['psize'])); 
    $userid = intval($_GPC['userid']);
    $list = pdo_fetchall("SELECT l.*,i.title,i.status FROM ".tablename($this->table_serlog)." l LEFT JOIN ".tablename($this->table_seritem)." i ON l.itemid=i.id WHERE l.userid=:userid AND l.uniacid=:uniacid ORDER BY l.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':userid'=>$userid,':uniacid'=>$_W['uniacid']));
    
    if (!empty($list)) {
        foreach ($list as $k => $v) {
            $list[$k]['createtime'] = date("Y-m-d H:i", $v['createtime']);
        }
    }

    $this->result(0, '', $list); 
    
}
?>