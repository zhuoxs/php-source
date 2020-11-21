<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/2
 * Time: 11:22
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$info=pdo_get('yzzc_sun_branch_admin',array('id'=>$_GPC['id']));
$bid=$_GPC['bid'];
if (checksubmit('submit')){
    if($_GPC['uid']==null){
        message('请输入管理员id','','error');
    }
    $data['bid']=$_GPC['bid'];
    $data['uid']=$_GPC['uid'];
    $data['auth']=$_GPC['auth'];
    $data['uniacid']=$_W['uniacid'];
    $data['createtime']=time();
//    if($_GPC['auth']==1){
//        $isadmin=pdo_get('yzzc_sun_branch_admin',array('bid'=>$bid,'auth'=>1));
//        if($isadmin){
//            message('只能有一个超级管理员哦','','error');
//        }
//    }

    if($_GPC['id']==''){
        $isuser=pdo_get('yzzc_sun_branch_admin',array('uid'=>$_GPC['uid']));
        if($isuser){
            message('该用户已是管理员了','','error');
        }
        $user=pdo_get('yzzc_sun_user',array('id'=>$_GPC['uid']),array('id'));
        if($user){
            $res=pdo_insert('yzzc_sun_branch_admin',$data);
            if($res){
                message('添加成功',$this->createWebUrl('branchadminlist',array('bid'=>$data['bid'])),'success');
            }else{
                message('添加失败','','error');
            }
        }else{
            message('当前用户不存在，请核对后再添加哦','','error');
        }

    }else{
        $res=pdo_update('yzzc_sun_branch_admin',$data,array('id'=>$_GPC['id']));
        if($res){
            message('修改成功',$this->createWebUrl('branchadminlist',array('bid'=>$data['bid'])),'success');
        }else{
            message('修改失败','','error');
        }
    }
}
if($_GPC['op']=='findname'){
    $user=pdo_get('yzzc_sun_user',array('id'=>$_GPC['uid']),array('user_name'));
    echo json_encode($user);
    exit();
}
include $this->template('web/addbranchadmin');