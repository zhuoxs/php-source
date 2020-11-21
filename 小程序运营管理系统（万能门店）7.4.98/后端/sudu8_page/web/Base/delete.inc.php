<?php


global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$cateid = $_GPC['cateid'];
$chid = $_GPC['chid'];
$id = intval($_GPC['id']);

$row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_banner')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));

if (empty($row)) {

    message('项目不存在或是已经被删除！');

}

pdo_delete('sudu8_page_banner', array('id' => $id ,'uniacid' => $uniacid));

message('删除成功!', $this->createWebUrl('base', array('op'=>$_GPC['type'],"cateid"=>$cateid,"chid"=>$chid)), 'success');