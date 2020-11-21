<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/2
 * Time: 10:06
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzpx_sun_indexad',array('uniacid'=>$_W['uniacid']));
if($info){
    $info['start_time']=date('Y-m-d H:i:s',$info['start_time']);
    $info['end_time']=date('Y-m-d H:i:s',$info['end_time']);
}

if($_GPC['op']=='status'){
    if($info){
        pdo_update('yzpx_sun_indexad',array('status'=>$_GPC['status']),array('uniacid'=>$_W['uniacid']));
    }else{
        pdo_insert('yzpx_sun_indexad',array('status'=>$_GPC['status'],'uniacid'=>$_W['uniacid']));
    }
}
if (checksubmit('submit')){
    if($_GPC['title']==null){
        message('请输入标题','','error');
    }elseif($_GPC['img']==null){
        message('请上传一张图片','','error');
    }elseif($_GPC['start_time']==null){
        message('请选择活动开始时间','','error');
    }elseif($_GPC['end_time']==null){
        message('请选择活动结束时间','','error');
    }
    $data['title']=$_GPC['title'];
    $data['img']=$_GPC['img'];
    $data['status']=$_GPC['status'];
    $data['money']=$_GPC['money'];
    $data['signnum_xn']=$_GPC['signnum_xn']?$_GPC['signnum_xn']:0;
    $data['icon']=$_GPC['icon'];
    $data['start_time']=strtotime($_GPC['start_time']);
    $data['end_time']=strtotime($_GPC['end_time']);
    $data['uniacid']=$_W['uniacid'];
    if($_GPC['id']==''){
        $res=pdo_insert('yzpx_sun_indexad',$data);
        if($res){
            message('添加成功',$this->createWebUrl('vacationad',array(),'success'));
        }else{
            message('添加失败','','error');
        }
    }else{
        $res=pdo_update('yzpx_sun_indexad',$data,array('uniacid'=>$_W['uniacid']));
        if($res){
            message('修改成功',$this->createWebUrl('vacationad',array(),'success'));
        }else{
            message('修改失败','','error');
        }
    }
}

include $this->template('web/vacationad');