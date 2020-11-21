<?php

global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$cateid = $_GPC['cateid'];
$chid = $_GPC['chid'];


$id = intval($_GPC['id']);
$row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_cate')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
if (empty($row)) {
    message('栏目不存在或是已经被删除！');
}
$row2 = pdo_fetch("SELECT id FROM ".tablename('sudu8_page_cate')." WHERE cid = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
if($row2 != ""){
    message('请先删除二级栏目!', $this->createWebUrl('cate', array('op'=>'display')), 'error');
}
$row3 = pdo_fetch("SELECT id FROM ".tablename('sudu8_page_products')." WHERE cid = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
if($row3 != ""){
    message('该栏目存在内容，无法删除!', $this->createWebUrl('cate', array('op'=>'display')), 'error');
}
pdo_delete('sudu8_page_cate', array('id' => $id ,'uniacid' => $uniacid));
message('栏目删除成功!', $this->createWebUrl('cate', array('op'=>'display','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');