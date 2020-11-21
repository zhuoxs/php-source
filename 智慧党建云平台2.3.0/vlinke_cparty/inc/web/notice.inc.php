<?php
global $_W, $_GPC;
load()->func('tpl');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == 'display') { 
    $con = " WHERE uniacid=:uniacid ";
    $par[':uniacid'] = $_W['uniacid'];
    $keywords = trim($_GPC['keywords']);
    if (!empty($keywords)) {
        $con .= " AND title LIKE :keywords ";
        $par[':keywords'] = '%'.$keywords.'%';
    }
    if (isset($_GPC['branchid'])) {
        $con .= " AND branchid=:branchid ";
        $par[':branchid'] = intval($_GPC['branchid']);
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall('SELECT * FROM '.tablename($this->table_notice).$con.' ORDER BY priority DESC, id DESC LIMIT '.($pindex-1) * $psize.','.$psize, $par);
    $total = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_notice).$con, $par);
    $pager = pagination($total, $pindex, $psize);

    $branchidarr = array_column($list,'branchid');
    $branch = pdo_getall($this->table_branch, array('id'=>$branchidarr,'uniacid'=>$_W['uniacid']), '', 'id');


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
            'priority' => intval($_GPC['priority']),
        );
        if (!empty($id)) {
            pdo_update($this->table_notice, $data, array('id' => $id));
        } else {
            $data['createtime'] = time();
            pdo_insert($this->table_notice, $data);
            $id = pdo_insertid();
        }
        message('信息更新成功！', $this->createWebUrl('notice', array('op'=>'display')), 'success');
    }
    $notice = pdo_get($this->table_notice, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($notice)) {
        $notice['priority'] = 0;
    }else{
        $branch = pdo_get($this->table_branch,array('id'=>$notice['branchid'],'uniacid'=>$_W['uniacid']));
    }

} elseif ($op == 'delete') {
    $id = intval($_GPC['id']);
    $result = pdo_delete($this->table_notice, array('id' => $id));
    if (!empty($result)) {
        message("数据删除成功！",referer(),'success');
    }
    message("数据删除失败，请刷新页面重试！",referer(),'error');

} elseif ($op=='deleteall') {
    $idstr = implode(",", $_GPC['idArr']);
    $result = pdo_query("delete from ".tablename($this->table_notice)." WHERE id IN (".$idstr.")");
    if (!empty($result)) {
        exit("success");
    }
    exit("error");

}
include $this->template('notice', TEMPLATE_INCLUDEPATH, true);
?>