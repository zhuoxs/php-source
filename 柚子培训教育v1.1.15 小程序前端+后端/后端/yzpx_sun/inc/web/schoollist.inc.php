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

$total=pdo_fetchcolumn("select count(*) from " . tablename("yzpx_sun_school") .$where);
$pager = pagination($total, $page, $size);

$sql = 'SELECT * FROM '.tablename('yzpx_sun_school')."{$where} ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
$info = pdo_fetchall($sql);
foreach ( $info as $key =>$value){
    $user=pdo_get('yzpx_sun_user',array('id'=>$value['admin_uid']),array('user_name'));
    $info[$key]['username']=$user['user_name'];
}
//var_dump($info);exit;
if($_GPC['op']=='delete'){
    $res=pdo_update('yzpx_sun_school',array('status'=>0),array('id'=>$_GPC['id']));
    if($res){
        //删除课程
        pdo_update('yzpx_sun_course_teach',array('status'=>0),array('sid'=>$_GPC['id']));
        //删除老师
        pdo_update('yzpx_sun_teacher',array('status'=>0),array('sid'=>$_GPC['id']));

        message('删除成功',$this->createWebUrl('schoollist',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
/**设为默认推荐*/
if($_GPC['op']=='default'){
    $is=pdo_get('yzpx_sun_school',array('uniacid'=>$_W['uniacid'],'default'=>1));
    if($is){
        message('只能设置一个默认分校','','error');
    }else{
        $resd=pdo_update('yzpx_sun_school',array('default'=>1),array('id'=>$_GPC['id']));
        if($resd){
            message('设置成功',$this->createWebUrl('schoollist',array()),'success');
        }else{
            message('设置失败','','error');
        }
    }
}
/**取消默认推荐*/
if($_GPC['op']=='nodefault'){
    $resd=pdo_update('yzpx_sun_school',array('default'=>0),array('id'=>$_GPC['id']));
    if($resd){
        message('取消成功',$this->createWebUrl('schoollist',array()),'success');
    }else{
        message('取消失败','','error');
    }
}
include $this->template('web/schoollist');