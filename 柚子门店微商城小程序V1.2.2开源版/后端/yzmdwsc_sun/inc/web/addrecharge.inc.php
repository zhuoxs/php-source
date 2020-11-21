<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzmdwsc_sun_recharge',array('id'=>$_GPC['id']));
if(checksubmit('submit')){
    $data['uniacid']=$_W['uniacid'];
    $data['recharge_money']=$_GPC['recharge_money'];
    $data['recharge_money1']=$_GPC['recharge_money1']; 
    $data['gift_money']=$_GPC['gift_money'];
    $data['state']=$_GPC['state'];
    $data['add_time']= time();  
    if(empty($_GPC['id'])){
        $res = pdo_insert('yzmdwsc_sun_recharge', $data);
        if($res){
            message('添加成功',$this->createWebUrl('recharge',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('yzmdwsc_sun_recharge', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('recharge',array()),'success');
        }else{
            message('编辑失败','','error');
        }  
    }  
}
include $this->template('web/addrecharge'); 