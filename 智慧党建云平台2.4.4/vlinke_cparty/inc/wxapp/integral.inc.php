<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {


}elseif ($op=="getmore") {

    $pindex = max(1, intval($_GPC['pindex']));
    $psize = max(1, intval($_GPC['psize']));    
    $userid = intval($_GPC['userid']);

    $list = pdo_fetchall("SELECT * FROM ".tablename($this->table_integral)." WHERE userid=:userid AND uniacid=:uniacid ORDER BY id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':userid'=>$userid,':uniacid'=>$_W['uniacid']));

    if (!empty($list)) {
        foreach ($list as $k => $v) {
            $list[$k]['createtime'] = date("Y-m-d H:i", $v['createtime']);
            $list[$k]['integral'] = $v['integral']>=0 ? "+".$v['integral'] : $v['integral'] ;
        }
    }

    $this->result(0, '', $list);
    
}
?>