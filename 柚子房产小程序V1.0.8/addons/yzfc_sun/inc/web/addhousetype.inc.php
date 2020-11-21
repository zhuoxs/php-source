<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/2
 * Time: 11:22
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$info=pdo_get('yzfc_sun_housetype',array('id'=>$_GPC['id']));
if(strpos($info['banner'],',')){
    $banner= explode(',',$info['banner']);
}else{
    $banner=array(
        0=>$info['banner']
    );
}
if($info){
    $info['start_time']=date('Y-m-d H:i:s',$info['start_time']);
    $info['end_time']=date('Y-m-d H:i:s',$info['end_time']);
}
$hid=$_GPC['hid'];
if (checksubmit('submit')){
    if($_GPC['name']==null){
        message('请输入名称','','error');
    }
    if($_GPC['banner']){
//        if(count($_GPC['img'])<5){
        $data['banner']=implode(",",$_GPC['banner']);
//        }else{
//            message('图片最多只能上传三张','','error');
//        }
    }else{
        $data['banner']='';
    }
    $data['hid']=$_GPC['hid'];
    $data['name']=$_GPC['name'];
    $data['img']=$_GPC['img'];
    $data['area']=$_GPC['area'];
    $data['totalmoney']=$_GPC['totalmoney'];
    $data['room']=$_GPC['room'];
    $data['icon']=$_GPC['icon'];
    $data['info']=$_GPC['info'];
    $data['sale_status']=$_GPC['sale_status'];
    $data['uniacid']=$_W['uniacid'];
    $data['detail']=$_GPC['detail'];
//    var_dump($data);exit;
    if($_GPC['id']==''){
        $res=pdo_insert('yzfc_sun_housetype',$data);
        if($res){
            message('添加成功',$this->createWebUrl('housetypelist',array('hid'=>$data['hid'])),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res=pdo_update('yzfc_sun_housetype',$data,array('id'=>$_GPC['id']));
        if($res){
            message('修改成功',$this->createWebUrl('housetypelist',array('hid'=>$data['hid'])),'success');
        }else{
            message('修改失败','','error');
        }
    }
}
include $this->template('web/addhousetype');