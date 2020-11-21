<?php
global $_W, $_GPC;
load()->func('tpl');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == 'display') { 
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall('SELECT * FROM '.tablename($this->table_exacate).' WHERE uniacid=:uniacid ORDER BY priority DESC, id DESC LIMIT '.($pindex-1) * $psize.','.$psize, array(':uniacid'=>$_W['uniacid']), "id");
    $total = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_exacate).' WHERE uniacid=:uniacid', array(':uniacid'=>$_W['uniacid']));
    $keys = implode(",", array_keys($list));
    $tolarr = pdo_fetchall("SELECT count(id) as tol FROM ".tablename($this->table_exabank)." WHERE uniacid=:uniacid GROUP BY cateid", array(':uniacid'=>$_W['uniacid']), "cateid");
    $pager = pagination($total, $pindex, $psize);

}elseif ($op == 'post') {
    $id = intval($_GPC['id']);
    if (checksubmit('submit')) {
        $data = array(
            'uniacid'   => $_W['uniacid'],
            'name'      => trim($_GPC['name']),
            'priority'  => intval($_GPC['priority']),
        );
        if (!empty($id)) {
            pdo_update($this->table_exacate, $data, array('id' => $id));
        } else {
            pdo_insert($this->table_exacate, $data);
        }
        message('信息更新成功！', $this->createWebUrl('exacate'), 'success');
    }
    $exacate = pdo_get($this->table_exacate, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($exacate)) {
        $exacate = array(
            'priority'  => 0,
        );
    }


} elseif ($op == 'delete') {
    $id = intval($_GPC['id']);
    $exacate = pdo_get($this->table_exacate,array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($exacate)) {
        message('要删除的信息不存在或是已经被删除！', referer(), 'error');
    }
    $exabank = pdo_getall($this->table_exabank, array('cateid'=>$id,'uniacid'=>$_W['uniacid']));
    if (!empty($exabank)) {
        message('要删除的类目信息下有题库记录，请先处理类目信息下记录再做删除操作！', referer(), 'error');
    }
    pdo_delete($this->table_exacate, array('id' => $id));
    message('信息删除成功！', referer(), 'success');


}
include $this->template('exacate');
?>