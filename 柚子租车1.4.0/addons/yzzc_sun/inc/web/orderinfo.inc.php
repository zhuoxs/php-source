<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzzc_sun_order_set',array('uniacid'=>$_W['uniacid']));

if(checksubmit('submit')){

    if($_GPC['rule']==null){
        message('请您写完整订单说明及退改规则', '', 'error');
    }elseif($_GPC['know']==null){
        message('请您写完整取车须知','','error');
    }

    $data['uniacid']=$_W['uniacid'];
    $data['long_prepay']=$_GPC['long_prepay'];
    $data['tuimoney']=$_GPC['tuimoney'];
    $data['istui']=$_GPC['istui'];
    $data['short_prepay']=$_GPC['short_prepay'];
    $data['rule']=$_GPC['rule'];
    $data['know']=$_GPC['know'];
    $data['service_desc']=$_GPC['service_desc'];
    $data['zx_service_desc']=$_GPC['zx_service_desc'];
    $data['getcar_desc']=$_GPC['getcar_desc'];
    if(empty($_GPC['id'])){
        $res = pdo_insert('yzzc_sun_order_set', $data,array('uniacid'=>$_W['uniacid']));

        if($res){
            message('添加成功',$this->createWebUrl('orderinfo',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{

        $res = pdo_update('yzzc_sun_order_set', $data, array('uniacid'=>$_W['uniacid']));
    }
    if($res){
        message('修改成功',$this->createWebUrl('orderinfo',array()),'success');
    }else{
        message('修改失败','','error');
    }
}
include $this->template('web/orderinfo');