<?php
global $_W, $_GPC;
load()->func('tpl');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == 'display') { 
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $con = " WHERE tab.uniacid=:uniacid AND tab.branchid IN (".$lbrancharrid.") ";
    $par[':uniacid'] = $_W['uniacid'];
    $branchid = intval($_GPC['branchid']);
    if ($branchid!=0) {
        $con .= " AND tab.branchid=:branchid ";
        $par[':branchid'] = $branchid;
        $branch = pdo_get($this->table_branch,array('id'=>$branchid,'uniacid'=>$_W['uniacid']));
    }

    $list = pdo_fetchall('SELECT tab.*, b.name as branchname FROM '.tablename($this->table_bbscate).' tab LEFT JOIN '.tablename($this->table_branch).' b ON tab.branchid=b.id '.$con.' ORDER BY tab.ishot ASC, tab.priority DESC, tab.id DESC LIMIT '.($pindex-1) * $psize.','.$psize, $par, "id");
    $total = pdo_fetchcolumn('SELECT count(tab.id) FROM '.tablename($this->table_bbscate).' tab LEFT JOIN '.tablename($this->table_branch).' b ON tab.branchid=b.id '.$con, $par);
    $pager = pagination($total, $pindex, $psize);

    if (!empty($list)) {
        $idstr = implode(",", array_keys($list));
        $topictol = pdo_fetchall("SELECT count(id) as tol, cateid FROM ".tablename($this->table_bbstopic)." WHERE cateid IN (".$idstr.") AND uniacid=:uniacid GROUP BY cateid ", array(':uniacid'=>$_W['uniacid']), "cateid");
    }

}elseif ($op == 'post') {
    $id = intval($_GPC['id']);
    if (checksubmit('submit')) {
        $branchid = intval($_GPC['branchid']);
        if ( $branchid==0 ) {
            message_tip('所属组织不能为空！', referer(), 'error');
        }
        $data = array(
            'uniacid'  => $_W['uniacid'],
            'branchid' => $branchid,
            'name'     => trim($_GPC['name']),
            'cicon'    => trim($_GPC['cicon']),
            'ishot'    => intval($_GPC['ishot']),
            'isshow'   => intval($_GPC['isshow']),
            'priority' => intval($_GPC['priority']),
        );

        if (!empty($id)) {
            pdo_update($this->table_bbscate, $data, array('id' => $id));
        } else {
            pdo_insert($this->table_bbscate, $data);
        }
        message_tip('信息更新成功！', referer(), 'success');
    }
    $bbscate = pdo_fetch("SELECT * FROM ".tablename($this->table_bbscate)." WHERE id=:id AND uniacid=:uniacid LIMIT 1 ", array(':id'=>$id,':uniacid'=>$_W['uniacid']));
    if (empty($bbscate)) {
        $bbscate = array(
            'ishot'    => 2,
            'isshow'   => 1,
            'priority' => 0,
        );
    }else{
        $branch = pdo_get($this->table_branch,array('id'=>$bbscate['branchid'],'uniacid'=>$_W['uniacid']));
    }

} elseif ($op == 'delete') {
    $id = intval($_GPC['id']);
    $bbscate = pdo_fetch("SELECT * FROM ".tablename($this->table_bbscate)." WHERE id=:id AND branchid IN (".$lbrancharrid.") AND uniacid=:uniacid ",array(':id'=>$id,':uniacid'=>$_W['uniacid']));
    if (empty($bbscate)) {
        message_tip('要删除的分类不存在或是已经被删除！', referer(), 'error');
    }
    $bbstopic = pdo_getall($this->table_bbstopic, array('cateid'=>$id,'uniacid'=>$_W['uniacid']));
    if (!empty($bbstopic)) {
        message_tip('要删除的分类下有话题，请先处理分类下话题再做删除操作！', referer(), 'error');
    }
    pdo_delete($this->table_bbscate, array('id' => $id));
    message_tip('分类信息删除成功！', referer(), 'success');


}
include $this->template('admin/bbscate');
?>