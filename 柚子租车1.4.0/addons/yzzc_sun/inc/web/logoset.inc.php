<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzzc_sun_logoset',array('uniacid' => $_W['uniacid']));

if(checksubmit('submit')){
    $data['logo_name_one']=$_GPC['logo_name_one']?$_GPC['logo_name_one']:'超值套餐';
    $data['logo_img_one'] = $_GPC['logo_img_one'];
    $data['logo_name_two']=$_GPC['logo_name_two']?$_GPC['logo_name_two']:'领优惠券';
    $data['logo_img_two'] = $_GPC['logo_img_two'];
    $data['logo_name_three']=$_GPC['logo_name_three']?$_GPC['logo_name_three']:'签到积分';
    $data['logo_img_three'] = $_GPC['logo_img_three'];
    $data['logo_name_four']=$_GPC['logo_name_four']?$_GPC['logo_name_four']:'限时活动';
    $data['logo_img_four'] = $_GPC['logo_img_four'];
    $data['doorname'] = $_GPC['doorname']?$_GPC['doorname']:'上门接送';
    $data['doorlottery'] = $_GPC['doorlottery']?$_GPC['doorlottery']:'仅限上门取送范围内';
    $data['shopname'] = $_GPC['shopname']?$_GPC['shopname']:'到店取还';
    $data['shoplottery'] = $_GPC['shoplottery']?$_GPC['shoplottery']:'为您推荐最近的门店';
    if($_GPC['id']==''){
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('yzzc_sun_logoset',$data);
        if($res){
            message('设置成功',$this->createWebUrl('logoset',array()),'success');
        }else{
            message('设置失败','','error');
        }
    }else{

        $res = pdo_update('yzzc_sun_logoset', $data, array('uniacid' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('logoset',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/logoset');