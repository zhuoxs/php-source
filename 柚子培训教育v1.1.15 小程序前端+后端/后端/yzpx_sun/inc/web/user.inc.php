<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  uniacid=".$_W['uniacid'];
$where="uniacid =".$_W['uniacid'];
if($_GPC['keywords']) {
    $op = $_GPC['keywords'];
    $where = "uniacid =" . $_W['uniacid'] . " and user_name LIKE  '%$op%'";

}
$type='all';
if($_GPC['type']=='adminlist'){
    $type=$_GPC['type'];
    $where .=' and isadmin > 0';
}
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$sql = "SELECT * FROM ims_yzpx_sun_user where ".$where." ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
$list = pdo_fetchall($sql);
foreach ($list as $key =>$value){
    $list[$key]['time']=date('Y-m-d H:i:s',$value['time']);

}
$total=pdo_fetchcolumn("select count(*) from ims_yzpx_sun_user where ".$where);
$pager = pagination($total, $page, $size);

if($_GPC['op']=='admin'){
    $isadmin=pdo_get('yzpx_sun_user',array('isadmin'=>1,'uniacid'=>$_W['uniacid']),array('id'));
    if($isadmin){
        message('设置失败,只能有一个超级管理员哦','','error');
    }else{
        $res=pdo_update('yzpx_sun_user',array('isadmin'=>1),array('id'=>$_GPC['id']));
        if($res){
            message('设置成功',$this->createWebUrl('user',array()),'success');
        }else{
            message('设置失败','','error');
        }
    }
}
if($_GPC['op']=='qxadmin'){
    $res=pdo_update('yzpx_sun_user',array('isadmin'=>0),array('id'=>$_GPC['id']));
    if($res){
        message('取消成功',$this->createWebUrl('user',array()),'success');
    }else{
        message('取消失败','','error');
    }
}
if($_GPC['op']=='qxadmin2'){
    $res=pdo_update('yzpx_sun_user',array('isadmin'=>0),array('id'=>$_GPC['id']));
    pdo_update('yzpx_sun_school',array('admin_uid'=>0),array('admin_uid'=>$_GPC['id']));
    if($res){
        message('取消成功',$this->createWebUrl('user',array()),'success');
    }else{
        message('取消失败','','error');
    }
}
if($_GPC['op']=='qxadmin3'){
    $res=pdo_update('yzpx_sun_user',array('isadmin'=>0),array('id'=>$_GPC['id']));
    pdo_update('yzpx_sun_teacher',array('admin_uid'=>0),array('admin_uid'=>$_GPC['id']));
    if($res){
        message('取消成功',$this->createWebUrl('user',array()),'success');
    }else{
        message('取消失败','','error');
    }
}
include $this->template('web/user');