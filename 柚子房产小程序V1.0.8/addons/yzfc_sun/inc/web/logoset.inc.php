<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzfc_sun_logoset',array('uniacid' => $_W['uniacid']));

if(checksubmit('submit')){
    $data['logo_name_one']=$_GPC['logo_name_one']?$_GPC['logo_name_one']:'热销楼盘';
    $data['logo_img_one'] = $_GPC['logo_img_one'];
    $data['logo_name_two']=$_GPC['logo_name_two']?$_GPC['logo_name_two']:'房产问答';
    $data['logo_img_two'] = $_GPC['logo_img_two'];
    $data['logo_name_three']=$_GPC['logo_name_three']?$_GPC['logo_name_three']:'公司简介';
    $data['logo_img_three'] = $_GPC['logo_img_three'];
    $data['logo_name_four']=$_GPC['logo_name_four']?$_GPC['logo_name_four']:'房贷计算';
    $data['logo_img_four'] = $_GPC['logo_img_four'];
    $data['card_img'] = $_GPC['card_img'];

    if($_GPC['id']==''){
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('yzfc_sun_logoset',$data);
        if($res){
            message('设置成功',$this->createWebUrl('logoset',array()),'success');
        }else{
            message('设置失败','','error');
        }
    }else{

        $res = pdo_update('yzfc_sun_logoset', $data, array('uniacid' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('logoset',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/logoset');