<?php
load()->func('tpl');
if ($op == 'display') { 
    $con = " WHERE uniacid=:uniacid AND branchid IN (".$lbrancharrid.") ";
    $par[':uniacid'] = $_W['uniacid'];
    $keywords = trim($_GPC['keywords']);
    if (!empty($keywords)) {
        $con .= " AND title LIKE :keywords ";
        $par[':keywords'] = '%'.$keywords.'%';
    }
    $branchid = intval($_GPC['branchid']);
    if ($branchid!=0) {
        $con .= " AND branchid=:branchid ";
        $par[':branchid'] = $branchid;
        $branch = $lbranchall[$branchid];
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall('SELECT * FROM '.tablename($this->table_notice).$con.' ORDER BY priority DESC, id DESC LIMIT '.($pindex-1) * $psize.','.$psize, $par);
    $total = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_notice).$con, $par);
    $pager = pagination($total, $pindex, $psize);


} elseif ($op == 'post') {
    $id = intval($_GPC['id']);
    if (checksubmit('submit')) {
        $branchname = trim($_GPC['branchname']);
        if (empty($branchname)) {
            $branchid = 0;
        }else{
            $branchid = intval($_GPC['branchid']);
        }
        $data = array(
            'uniacid'  => $_W['uniacid'],
            'branchid' => $branchid,
            'title'    => $_GPC['title'],
            'details'  => $_GPC['details'],
            'priority' => 0,
        );
        if (!empty($id)) {
            pdo_update($this->table_notice, $data, array('id' => $id));
        } else {
            $data['createtime'] = time();
            pdo_insert($this->table_notice, $data);
            $id = pdo_insertid();
        }
        message_tip('信息更新成功！', $this->createWebUrl('admin',array('r'=>'notice','op'=>'display')), 'success');
    }
    $notice = pdo_get($this->table_notice, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($notice)) {
        $notice['priority'] = 0;
    }else{
        $branch = $lbranchall[$notice['branchid']];
        if (empty($branch)) {
            message_tip("你无权限管理该通知公告信息！", $this->createWebUrl('admin',array('r'=>'notice')), 'error');
        }
    }

} elseif ($op == 'delete') {
    $id = intval($_GPC['id']);
    $notice = pdo_fetch("SELECT * FROM ".tablename($this->table_notice)." WHERE id=:id AND branchid IN (".$lbrancharrid.") AND uniacid=:uniacid LIMIT 1 ", array(':id'=>$id,':uniacid'=>$_W['uniacid']));
    if (empty($notice)) {
        message_tip("你无权限删除该公告通知信息！", $this->createWebUrl('admin', array('r'=>'notice')), 'error');
    }

    $result = pdo_delete($this->table_notice, array('id' => $id));
    if (!empty($result)) {
        message_tip("数据删除成功！",referer(),'success');
    }
    message_tip("数据删除失败，请刷新页面重试！",referer(),'error');

} elseif ($op=='deleteall') {
    $idstr = implode(",", $_GPC['idArr']);
    $result = pdo_query("delete from ".tablename($this->table_notice)." WHERE id IN (".$idstr.") AND branchid IN (".$lbrancharrid.") ");
    if (!empty($result)) {
        exit("success");
    }
    exit("error");

}
include $this->template('admin/notice');
?>