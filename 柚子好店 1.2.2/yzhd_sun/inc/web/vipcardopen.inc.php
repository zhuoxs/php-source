<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzhd_sun_vipcard',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['uniacid']=$_W['uniacid'];
    $data['vipopen']=$_GPC['vipopen'];
    $data['v_pay_num']=$_GPC['v_pay_num'];
    $data['vip_power']=$_GPC['vip_power'];
    $data['vip_rule']=$_GPC['vip_rule'];

    if($_GPC['id']==''){
        $ress=pdo_insert('yzhd_sun_vipcard',$data);
        if($res){
            message('添加成功',$this->createWebUrl('vipcardopen',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('yzhd_sun_vipcard', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('vipcardopen',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/vipcardopen');