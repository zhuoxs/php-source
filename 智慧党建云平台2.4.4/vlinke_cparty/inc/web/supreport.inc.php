<?php
global $_W, $_GPC;
load()->func('tpl');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == 'display') { 
    $con = " WHERE uniacid=:uniacid ";
    $par[':uniacid'] = $_W['uniacid'];
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall('SELECT * FROM '.tablename($this->table_supreport).$con.' ORDER BY id DESC LIMIT '.($pindex-1) * $psize.','.$psize, $par);
    $total = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_supreport).$con, $par);
    $pager = pagination($total, $pindex, $psize);


} elseif ($op == 'post') {
    $id = intval($_GPC['id']);
    if (checksubmit('submit')) {
        $data = array(
            'reply'  => trim($_GPC['reply']),
            'status' => intval($_GPC['status']),
        );
        if (!empty($id)) {
            pdo_update($this->table_supreport, $data, array('id' => $id));
        }
        message('信息更新成功！', $this->createWebUrl('supreport', array('op'=>'display')), 'success');
    }
    $supreport = pdo_get($this->table_supreport, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    $supreport['picall'] = iunserializer($supreport['picall']);

} elseif ($op == 'delete') {
    $id = intval($_GPC['id']);
    $result = pdo_delete($this->table_supreport, array('id' => $id));
    if (!empty($result)) {
        message("数据删除成功！",referer(),'success');
    }
    message("数据删除失败，请刷新页面重试！",referer(),'error');

} elseif ($op=='deleteall') {
    $idstr = implode(",", $_GPC['idArr']);
    $result = pdo_query("delete from ".tablename($this->table_supreport)." WHERE id IN (".$idstr.")");
    if (!empty($result)) {
        exit("success");
    }
    exit("error");

}
include $this->template('supreport');
?>