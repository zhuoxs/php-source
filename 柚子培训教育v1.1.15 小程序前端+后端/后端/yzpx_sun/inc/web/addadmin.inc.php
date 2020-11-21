<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/2
 * Time: 11:22
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$school=pdo_getall('yzpx_sun_school',array('uniacid'=>$_W['uniacid'],'admin_uid'=>0,'status'=>1));
$teacher=pdo_getall('yzpx_sun_teacher',array('uniacid'=>$_W['uniacid'],'admin_uid'=>0,'status'=>1));
if (checksubmit('submit')){
    if($_GPC['uid']==null){
        message('请输入管理员id','','error');
    }
    if($_GPC['isadmin']==null){
        message('请选择管理员类型','','error');
    }
    $user=pdo_get('yzpx_sun_user',array('id'=>$_GPC['uid']),array('isadmin'));
    if($user){
        if($user['isadmin']>0){
            message('该用户已是其他管理员了','','error');
        }
    }else{
        message('当前用户不存在，请核对后再添加哦','','error');
    }

    if($_GPC['isadmin']==2){
        $res=pdo_update('yzpx_sun_school',array('admin_uid'=>$_GPC['uid']),array('id'=>$_GPC['sid']));
    }elseif($_GPC['isadmin']==3){
        $res=pdo_update('yzpx_sun_teacher',array('admin_uid'=>$_GPC['uid']),array('id'=>$_GPC['tid']));
    }
    if($res){
        pdo_update('yzpx_sun_user',array('isadmin'=>$_GPC['isadmin']),array('id'=>$_GPC['uid']));
        message('添加成功',$this->createWebUrl('user'),'success');
    }else{
        message('添加失败','','error');
    }
}
if($_GPC['op']=='findname'){
    $user=pdo_get('yzpx_sun_user',array('id'=>$_GPC['uid']),array('user_name'));
    echo json_encode($user);
    exit();
}
include $this->template('web/addadmin');