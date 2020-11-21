<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$punch_id=$_GPC['punch_id'];
$punch=pdo_get('mzhk_sun_punch',array('id'=>$punch_id));
$task_day=require_once 'wxapp_task_day_config.php';
$task_day_id=$_GPC['task_day_id'];
$result = array_filter($task_day,function($v){
    if($v['id']==$_GET['task_day_id']){
        return 1;
    }
});
$num=intval(array_keys($result)[0]);
$result=$result[$num];
$coupon=pdo_getall('mzhk_sun_coupon',array('uniacid'=>$_W['uniacid'],'is_punch'=>1));
$info=pdo_get('mzhk_sun_punch_prize',array('id'=>$_GPC['id']));
if(checksubmit('submit')){
    $data['uniacid']=$_W['uniacid'];
    $data['prize_day']=$_GPC['prize_day'];
    $data['punch_id']=$_GPC['punch_id'];
    $data['task_day_id']=$_GPC['task_day_id'];
    $data['add_time']= time();
    $data['coupon_id']=$_GPC['coupon_id'];
    $coupon=pdo_get('mzhk_sun_coupon',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['coupon_id']));
    if(empty($coupon)){
        message('优惠券不存在','','error');
        exit;
    }
    $data['store_id']=$coupon['store_id'];
    $data['state']=$_GPC['state'];
    if(empty($_GPC['id'])){
        $res = pdo_insert('mzhk_sun_punch_prize', $data);
        if($res){
            message('添加成功',$this->createWebUrl('punchprize',array('punch_id'=>$_GPC['punch_id'],'task_day_id'=>$_GPC['task_day_id'])),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        unset($data['add_time']);
        $res = pdo_update('mzhk_sun_punch_prize', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('punchprize',array('punch_id'=>$_GPC['punch_id'],'task_day_id'=>$_GPC['task_day_id'])),'success');
        }else{
            message('编辑失败','','error');
        }
    }  
    
}
include $this->template('web/addpunchprize');