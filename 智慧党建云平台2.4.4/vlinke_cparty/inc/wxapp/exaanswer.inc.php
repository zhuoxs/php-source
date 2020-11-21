<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
if ($op=="display") {

    
}elseif ($op=="getmore") {
    $pindex = max(1, intval($_GPC['pindex']));
    $psize = max(1, intval($_GPC['psize']));
    $userid = intval($_GPC['userid']);

    $list = pdo_fetchall("SELECT a.*,p.title FROM ".tablename($this->table_exaanswer)." a LEFT JOIN ".tablename($this->table_exapaper)." p ON a.paperid=p.id WHERE a.status=2 AND a.userid=:userid AND a.uniacid=:uniacid ORDER BY a.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':userid'=>$userid,':uniacid'=>$_W['uniacid']));

    if (!empty($list)) {
        foreach ($list as $k => $v) {
            $usertime = $v['finishtime']-$v['stime'];
            if ($usertime<=0) {
                $list[$k]['usertime'] = "未完成";
            }else{
                $list[$k]['usertime'] = floor($usertime/60)."分". $usertime%60 ."秒";
            }
            $list[$k]['stime'] = date("Y-m-d H:i",$v['stime']);
        }
    }

    $this->result(0, '', $list);

}
?>