<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {
    $cateid = intval($_GPC['cateid']);
    $cate = pdo_get($this->table_sercate, array('id'=>$cateid));
    if (empty($cate)) {
        $this->result(1, '分类不存在');
    }
    $this->result(0, '', array(
        'cate' => $cate
        ));


}elseif ($op=="getmore") {

    $cateid = intval($_GPC['cateid']);
    $branchid = intval($_GPC['branchid']); 
    $branch = pdo_get($this->table_branch,array('id'=>$branchid,'uniacid'=>$_W['uniacid']));
    $par = " tab.status IN (2,3) AND ";
    if (!empty($branch)) {
        $par .= " tab.branchid in ( ".$branch['scort']." ) AND ";
    }

    $pindex = max(1, intval($_GPC['pindex']));
    $psize = max(1, intval($_GPC['psize']));    
    $list = pdo_fetchall("SELECT tab.*,b.name FROM ".tablename($this->table_seritem)." tab LEFT JOIN ".tablename($this->table_branch)." b ON tab.branchid=b.id WHERE ".$par." tab.cateid=:cateid AND tab.uniacid=:uniacid ORDER BY tab.priority DESC, tab.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':cateid'=>$cateid,':uniacid'=>$_W['uniacid']));
    if (!empty($list)) {
        foreach ($list as $k => $v) {
            $list[$k]['tilpic'] = tomedia($v['tilpic']);
            $list[$k]['createtime'] = date("Y-m-d H:i", $v['createtime']);
        }
    }

    $this->result(0, '', $list);

}
include $this->template('sercate');
?>