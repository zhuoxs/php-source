<?php
/**
 * Created by PhpStorm.
 * User: lts
 * Date: 2018/4/27
 * Time: 17:51
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  uniacid=".$_W['uniacid'].' and hid ='.$_GPC['hid'];
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and name LIKE  '%$op%'";
}
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$start= $page * $size;

$total=pdo_fetchcolumn("select count(*) from " . tablename("yzfc_sun_housetype") .$where);
$pager = pagination($total, $page, $size);

$sql = 'SELECT * FROM '.tablename('yzfc_sun_housetype')."{$where} ORDER BY id asc LIMIT ".(($page-1) * $size).','.$size;
$info = pdo_fetchall($sql);
$hid=$_GPC['hid'];

if($_GPC['op']=='delete'){
    $res=pdo_delete('yzfc_sun_housetype',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('housetypelist',array('hid'=>$_GPC['hid'])),'success');
    }else{
        message('删除失败','','error');
    }
}

if($_GPC['op']=='tj'){
    $hinfo=pdo_get('yzfc_sun_housetype',array('id'=>$_GPC['id']),array('hid'));

    $totaltj=pdo_fetchcolumn("select count(*) from " . tablename("yzfc_sun_housetype") ." where uniacid =".$_W['uniacid']." and rec = 1 and hid =".$hinfo['hid']);
//    var_dump($totaltj);exit;
    if($totaltj<2){
        $res=pdo_update('yzfc_sun_housetype',array('rec'=>1),array('id'=>$_GPC['id']));
        if($res){
            message('推荐成功',$this->createWebUrl('housetypelist',array('hid'=>$hinfo['hid'])),'success');
        }else{
            message('推荐失败','','error');
        }
    }else{
        message('最多只能推荐2个','','error');
    }
}
if($_GPC['op']=='qxtj'){
    $hinfo=pdo_get('yzfc_sun_housetype',array('id'=>$_GPC['id']),array('hid'));
    $res=pdo_update('yzfc_sun_housetype',array('rec'=>0),array('id'=>$_GPC['id']));
    if($res){
        message('取消成功',$this->createWebUrl('housetypelist',array('hid'=>$hinfo['hid'])),'success');
    }else{
        message('取消失败','','error');
    }
}
include $this->template('web/housetypelist');