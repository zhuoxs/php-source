<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$where="  uniacid=".$_W['uniacid'];

if($_GPC['keywords']) {
    $op = $_GPC['keywords'];
    $where .= " and account LIKE  '%$op%'";

}
$type='all';
if($_GPC['type']=='adminlist'){
    $type=$_GPC['type'];
    $where .=' and isadmin > 0';
}
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$sql = "SELECT * FROM ims_yzfc_sun_admin where ".$where." ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
$list = pdo_fetchall($sql);
foreach ($list as $key =>$value){
    $list[$key]['createtime']=date('Y-m-d H:i:s',$value['createtime']);
    $list[$key]['bname']='所有分店';
    if($value['bid']){
        $branch=pdo_get('yzfc_sun_branch',array('id'=>$value['bid']),array('name'));
        $list[$key]['bname']=$branch['name'];
    }
}
$total=pdo_fetchcolumn("select count(*) from ims_yzfc_sun_admin where ".$where);
$pager = pagination($total, $page, $size);

if($_GPC['op']=='admin'){
    $isadmin=pdo_get('yzfc_sun_user_admin',array('isadmin'=>1,'uniacid'=>$_W['uniacid']),array('id'));
    if($isadmin){
        message('设置失败,只能有一个超级管理员哦','','error');
    }else{
        $res=pdo_update('yzfc_sun_user_admin',array('isadmin'=>1),array('id'=>$_GPC['id']));
        if($res){
            message('设置成功',$this->createWebUrl('user_admin',array()),'success');
        }else{
            message('设置失败','','error');
        }
    }
}
if($_GPC['op']=='qxadmin'){
    $res=pdo_update('yzfc_sun_user_admin',array('isadmin'=>0),array('id'=>$_GPC['id']));
    if($res){
        message('取消成功',$this->createWebUrl('user_admin',array()),'success');
    }else{
        message('取消失败','','error');
    }
}
if($_GPC['op']=='qxadmin2'){
    $res=pdo_update('yzfc_sun_user_admin',array('isadmin'=>0),array('id'=>$_GPC['id']));
    pdo_update('yzfc_sun_school',array('admin_uid'=>0),array('admin_uid'=>$_GPC['id']));
    if($res){
        message('取消成功',$this->createWebUrl('user_admin',array()),'success');
    }else{
        message('取消失败','','error');
    }
}
if($_GPC['op']=='qxadmin3'){
    $res=pdo_update('yzfc_sun_user_admin',array('isadmin'=>0),array('id'=>$_GPC['id']));
    pdo_update('yzfc_sun_teacher',array('admin_uid'=>0),array('admin_uid'=>$_GPC['id']));
    if($res){
        message('取消成功',$this->createWebUrl('user_admin',array()),'success');
    }else{
        message('取消失败','','error');
    }
}
include $this->template('web/useradmin');