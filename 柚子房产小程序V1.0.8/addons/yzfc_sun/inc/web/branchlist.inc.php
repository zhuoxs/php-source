<?php
/**
 * Created by PhpStorm.
 * User: lts
 * Date: 2018/4/27
 * Time: 17:51
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  uniacid=".$_W['uniacid']." and status = 1";
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and name LIKE  '%$op%'";
}
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$start= $page * $size;

$total=pdo_fetchcolumn("select count(*) from " . tablename("yzfc_sun_branch") .$where);
$pager = pagination($total, $page, $size);

$sql = 'SELECT * FROM '.tablename('yzfc_sun_branch')."{$where} ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
$info = pdo_fetchall($sql);

//var_dump($info);exit;
if($_GPC['op']=='delete'){
    $res=pdo_update('yzfc_sun_branch',array('status'=>0),array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('branchlist',array()),'success');
    }else{
        message('删除失败','','error');
    }
}

include $this->template('web/branchlist');