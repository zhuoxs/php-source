<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/11
 * Time: 17:25
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$school=pdo_getall('yzpx_sun_school',array('status'=>1,'uniacid'=>$_W['uniacid']));
$info=pdo_get('yzpx_sun_coupon',array('id'=>$_GPC['id']));
if($info){
    $info['start_time']=date('Y-m-d H:i:s',$info['start_time']);
    $info['end_time']=date('Y-m-d H:i:s',$info['end_time']);
}

if(strpos($info['sid'],',')){
    $info['sid']= explode(',',$info['sid']);
}else{
    $info['sid']=array(
        0=>$info['sid']
    );
}
//var_dump($info);exit;
if (checksubmit('submit')){
    if($_GPC['money']==null){
        message('请输入优惠券金额','','error');
    }elseif($_GPC['end_time']==null){
        message('请输入过期时间','','error');
    }
    if($_GPC['full']<$_GPC['money']){
        message('优惠券金额需大于满减金额','','error');
    }
    if($_GPC['full']==$_GPC['money']){
        message('优惠券金额需大于满减金额','','error');
    }
    if($_GPC['sid']){
        $data['sid']=implode(",",$_GPC['sid']);
    }
    $data['money']=$_GPC['money'];
    $data['full']=$_GPC['full'];
    $data['num']=$_GPC['num'];
    $data['use']=$_GPC['use'];
    $data['uniacid']=$_W['uniacid'];
    $data['end_time']=strtotime($_GPC['end_time']);
    $data['start_time']=strtotime($_GPC['start_time']);
    $data['createtime']=time();
    if($data['end_time']<$data['start_time']){
        message('开始时间需小于过期时间','','error');
    }
    if($_GPC['id']==''){
        $res=pdo_insert('yzpx_sun_coupon',$data);
        if($res){
            message('添加成功',$this->createWebUrl('couponlist',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{

        $res=pdo_update('yzpx_sun_coupon',$data,array('id'=>$_GPC['id']));
        if($res){
            message('修改成功',$this->createWebUrl('couponlist',array()),'success');
        }else{
            message('修改失败','','error');
        }
    }
}
include $this->template('web/addcoupon');