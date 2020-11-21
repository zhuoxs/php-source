<?php
global $_W, $_GPC;
load()->func('tpl');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == 'display') { 
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall('SELECT * FROM '.tablename($this->table_artcate).' WHERE uniacid=:uniacid ORDER BY priority DESC, id DESC LIMIT '.($pindex-1) * $psize.','.$psize, array(':uniacid'=>$_W['uniacid']));
    $total = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_artcate).' WHERE uniacid=:uniacid', array(':uniacid'=>$_W['uniacid']));
    $pager = pagination($total, $pindex, $psize);

}elseif ($op == 'post') {
    $id = intval($_GPC['id']);
    if (checksubmit('submit')) {
        $data = array(
            'uniacid'   => $_W['uniacid'],
            'name'      => trim($_GPC['name']),
            'cicon'     => trim($_GPC['cicon']),
            'navnumber' => intval($_GPC['navnumber']),
            'priority'  => intval($_GPC['priority']),
        );

        if (!empty($id)) {
            pdo_update($this->table_artcate, $data, array('id' => $id));
        } else {
            pdo_insert($this->table_artcate, $data);
        }
        message('信息更新成功！', $this->createWebUrl('artcate'), 'success');
    }
    $artcate = pdo_fetch("SELECT * FROM ".tablename($this->table_artcate)." WHERE id=:id AND uniacid=:uniacid LIMIT 1 ", array(':id'=>$id,':uniacid'=>$_W['uniacid']));
    if (empty($artcate)) {
        $artcate = array(
            'navnumber' => 0,
            'priority' => 0,
        );
    }

} elseif ($op == 'delete') {
    $id = intval($_GPC['id']);
    $artcate = pdo_fetch("SELECT * FROM ".tablename($this->table_artcate)." WHERE id=:id AND uniacid=:uniacid ",array(':id'=>$id,':uniacid'=>$_W['uniacid']));
    if (empty($artcate)) {
        message('要删除的文章分类不存在或是已经被删除！', referer(), 'error');
    }
    $article = pdo_getall($this->table_article, array('cateid'=>$id,'uniacid'=>$_W['uniacid']));
    if (!empty($article)) {
        message('要删除的文章分类下有文章，请先处理分类下文章再做删除操作！', referer(), 'error');
    }
    pdo_delete($this->table_artcate, array('id' => $id));
    message('文章分类信息删除成功！', referer(), 'success');


}
include $this->template('artcate');
?>