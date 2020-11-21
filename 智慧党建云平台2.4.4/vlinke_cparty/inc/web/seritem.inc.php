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
    $status = intval($_GPC['status']);
    if ($status!=0) {
        $con .= " AND status=:status ";
        $par[':status'] = $status;
    }
    $cateid = intval($_GPC['cateid']);
    if ($cateid!=0) {
        $con .= " AND cateid=:cateid ";
        $par[':cateid'] = $cateid;
    }
    if (isset($_GPC['branchid'])) {
        $con .= " AND branchid=:branchid ";
        $par[':branchid'] = intval($_GPC['branchid']);
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall('SELECT * FROM '.tablename($this->table_seritem).$con.' ORDER BY priority DESC, id DESC LIMIT '.($pindex-1) * $psize.','.$psize, $par);
    $total = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_seritem).$con, $par);
    $pager = pagination($total, $pindex, $psize);

    $cateidarr = array_column($list,'cateid');
    $branchidarr = array_column($list,'branchid');

    $sercate = pdo_getall($this->table_sercate, array('uniacid'=>$_W['uniacid']), '', 'id');
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
        $cateid = intval($_GPC['cateid']);
        $data = array(
            'uniacid'   => $_W['uniacid'],
            'cateid'    => $cateid,
            'branchid'  => $branchid,
            'title'     => trim($_GPC['title']),
            'tilpic'    => trim($_GPC['tilpic']),
            'realname'  => trim($_GPC['realname']),
            'mobile'    => trim($_GPC['mobile']),
            'starttime' => strtotime($_GPC['datelimit']['start']),
            'endtime'   => strtotime($_GPC['datelimit']['end']),
            'address'   => trim($_GPC['address']),
            'unumber'   => intval($_GPC['unumber']),
            'getval'    => intval($_GPC['getval']),
            'status'    => intval($_GPC['status']),
            'priority'  => intval($_GPC['priority']),
            'details'   => $_GPC['details'],
        );
        if (!empty($id)) {
            pdo_update($this->table_seritem, $data, array('id' => $id));
        } else {
            $data['createtime'] = time();
            pdo_insert($this->table_seritem, $data);
            $id = pdo_insertid();
        }
        message('信息更新成功！', $this->createWebUrl('seritem', array('op'=>'display')), 'success');
    }
    $sercate = pdo_getall($this->table_sercate, array('uniacid'=>$_W['uniacid']));
    $seritem = pdo_fetch("SELECT * FROM ".tablename($this->table_seritem)." WHERE id=:id AND uniacid=:uniacid LIMIT 1 ", array(':id'=>$id,':uniacid'=>$_W['uniacid']));
    if (empty($seritem)) {
        $seritem = array(
            'getval'    => 0, 
            'starttime' => time(),
            'endtime'   => time() + 86400*7,
            'unumber'   => 1,
            'status'    => 2,
            'priority'  => 0,
        );
    }else{
        $branch = pdo_get($this->table_branch,array('id'=>$seritem['branchid'],'uniacid'=>$_W['uniacid']));
    }
} elseif ($op == 'delete') {
    $id = intval($_GPC['id']);
    $seritem = pdo_get($this->table_seritem, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($seritem)) {
        message('要删除的项目不存在或是已经被删除！', referer(), 'error');
    }
    pdo_delete($this->table_serlog, array('itemid'=>$id,'uniacid'=>$_W['uniacid']));
    pdo_delete($this->table_sermessage, array('itemid'=>$id,'uniacid'=>$_W['uniacid']));
    $result = pdo_delete($this->table_seritem, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (!empty($result)) {
        message("数据删除成功！",referer(),'success');
    }
    message("数据删除失败，请刷新页面重试！",referer(),'error');

}
include $this->template('seritem');
?>