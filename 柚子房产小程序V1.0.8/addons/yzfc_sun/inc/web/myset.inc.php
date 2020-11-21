<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/2
 * Time: 15:18
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzfc_sun_logoset',array('uniacid' => $_W['uniacid']));

if(checksubmit('submit')){
    $data['my_name_one']=$_GPC['my_name_one']?$_GPC['my_name_one']:'我的课程';
    $data['my_img_one'] = $_GPC['my_img_one'];
    $data['my_name_two']=$_GPC['my_name_two']?$_GPC['my_name_two']:'约课记录';
    $data['my_img_two'] = $_GPC['my_img_two'];
    $data['my_name_three']=$_GPC['my_name_three']?$_GPC['my_name_three']:'授课老师';
    $data['my_img_three'] = $_GPC['my_img_three'];
    $data['my_name_four']=$_GPC['my_name_four']?$_GPC['my_name_four']:'我的收藏';
    $data['my_img_four'] = $_GPC['my_img_four'];
    $data['my_name_five']=$_GPC['my_name_five']?$_GPC['my_name_five']:'集卡奖品';
    $data['my_img_five'] = $_GPC['my_img_five'];
    $data['my_name_six']=$_GPC['my_name_six']?$_GPC['my_name_six']:'管理入口';
    $data['my_img_six'] = $_GPC['my_img_six'];
    $data['mykanjia_name']=$_GPC['mykanjia_name']?$_GPC['mykanjia_name']:'我的砍价';
    $data['mykanjia_icon'] = $_GPC['mykanjia_icon'];
    $data['mycoupon_name']=$_GPC['mycoupon_name']?$_GPC['mycoupon_name']:'我的优惠券';
    $data['mycoupon_icon'] = $_GPC['mycoupon_icon'];
    if($_GPC['id']==''){
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('yzfc_sun_logoset',$data);
        if($res){
            message('设置成功',$this->createWebUrl('myset',array()),'success');
        }else{
            message('设置失败','','error');
        }
    }else{

        $res = pdo_update('yzfc_sun_logoset', $data, array('uniacid' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('myset',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/myset');