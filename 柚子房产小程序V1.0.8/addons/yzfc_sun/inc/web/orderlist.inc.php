<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  uniacid=".$_W['uniacid'];
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and username LIKE  '%$op%'";
}
if($_GPC['hid']){
    $where .=" and hid =".$_GPC['hid'];
}
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$start= $page * $size;

$total=pdo_fetchcolumn("select count(*) from " . tablename("yzfc_sun_house_order") .$where);
$pager = pagination($total, $page, $size);

$sql = 'SELECT * FROM '.tablename('yzfc_sun_house_order')."{$where} ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
$info = pdo_fetchall($sql);
//var_dump($sql);exit;
if($info){
    foreach ($info as $key =>$value){
        $info[$key]['ordertime']=date('Y-m-d H:i:s',$value['ordertime']);
        $info[$key]['createtime']=date('Y-m-d H:i:s',$value['createtime']);

    }
}

include $this->template('web/orderlist');