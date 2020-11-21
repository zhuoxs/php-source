<?php
global $_W, $_GPC;
load()->func('tpl');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == "display") {

    $branchtol = count($lbranchall);
    
    $usertol = pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->table_user)." WHERE uniacid=:uniacid AND recycle=0 AND branchid IN (".$lbrancharrid.") ", array(':uniacid'=>$_W['uniacid']));
    $leadertol = pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->table_leader)." WHERE uniacid=:uniacid AND branchid IN (".$lbrancharrid.") ", array(':uniacid'=>$_W['uniacid']));
    
}elseif ($op == "getmore"){

    $parentid = intval($_GPC['parentid']);
    $plevel = intval($_GPC['plevel']);
    $list = array();
    if ($parentid==0) {
        foreach ($lbranchall as $k => $v) {
            if (empty($lbranchall[$v['parentid']])) {
                $list[$k] = $v;
            }
        }
    }else{
        foreach ($lbranchall as $k => $v) {
            if ($v['parentid']==$parentid) {
                $list[$k] = $v;
            }
        }
    }
    $tolarr = array();
    foreach($lbranchall as $item) {
        $tolarr[$item['parentid']][$item['id']] = $item;
    }

    $total = count($list);
    if ($total==0) {
        exit("over");
    }
    $keys = implode(",", array_keys($list));
    $usertol = pdo_fetchall("SELECT count(*) as tol, branchid FROM ".tablename($this->table_user)." WHERE branchid IN (".$keys.") AND recycle=0 AND uniacid=:uniacid GROUP BY branchid ", array(':uniacid'=>$_W['uniacid']), "branchid");
    $leadertol = pdo_fetchall("SELECT count(*) as tol, branchid FROM ".tablename($this->table_leader)." WHERE branchid IN (".$keys.") AND uniacid=:uniacid GROUP BY branchid ", array(':uniacid'=>$_W['uniacid']), "branchid");
    $cbranchtol = pdo_fetchall("SELECT count(*) as tol, parentid FROM ".tablename($this->table_branch)." WHERE parentid IN (".$keys.") AND uniacid=:uniacid GROUP BY parentid ", array(':uniacid'=>$_W['uniacid']), "parentid");
    include $this->template('admin/branch_ajax');
    die();

}elseif ($op == "post"){
    $id = intval($_GPC['id']);
    $branch = pdo_get($this->table_branch,array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($branch)) {
        message_tip('要编辑的组织信息不存在！', referer(), 'success');
    }
    if (checksubmit('submit')) {
        $data = array(
            'telephone' => trim($_GPC['telephone']),
            'address'   => trim($_GPC['address']),
            'lat'       => floatval($_GPC['position']['lat']),
            'lng'       => floatval($_GPC['position']['lng']),
            'details'   => trim($_GPC['details']),
            );
        pdo_update($this->table_branch, $data, array('id'=>$id));
        message_tip('数据更新成功', $this->createWebUrl('admin',array('r'=>'branch')), 'success');
    }    
    $pbranch = pdo_get($this->table_branch,array('id'=>$branch['parentid'],'uniacid'=>$_W['uniacid']));


}
include $this->template('admin/branch');
?>
