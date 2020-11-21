<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzpx_sun_logoset',array('uniacid' => $_W['uniacid']));

if(checksubmit('submit')){
    $data['logo_name_one']=$_GPC['logo_name_one']?$_GPC['logo_name_one']:'关于我们';
    $data['logo_img_one'] = $_GPC['logo_img_one'];
    $data['logo_name_two']=$_GPC['logo_name_two']?$_GPC['logo_name_two']:'新闻动态';
    $data['logo_img_two'] = $_GPC['logo_img_two'];
    $data['logo_name_three']=$_GPC['logo_name_three']?$_GPC['logo_name_three']:'精品课程';
    $data['logo_img_three'] = $_GPC['logo_img_three'];
    $data['logo_name_four']=$_GPC['logo_name_four']?$_GPC['logo_name_four']:'授课老师';
    $data['logo_img_four'] = $_GPC['logo_img_four'];
    $data['logo_name_five']=$_GPC['logo_name_five']?$_GPC['logo_name_five']:'预约报名';
    $data['logo_icon_five']=$_GPC['logo_icon_five']?$_GPC['logo_icon_five']:'1';
    $data['logo_img_five'] = $_GPC['logo_img_five'];
    $data['logo_name_six']=$_GPC['logo_name_six']?$_GPC['logo_name_six']:'集卡活动';
    $data['logo_img_six'] = $_GPC['logo_img_six'];
    $data['fx_name']=$_GPC['fx_name']?$_GPC['fx_name']:'分校列表';
    $data['fx_icon'] = $_GPC['fx_icon'];
    $data['kanjia_name']=$_GPC['kanjia_name']?$_GPC['kanjia_name']:'砍价列表';
    $data['kanjia_icon'] = $_GPC['kanjia_icon'];
    $data['coupon_img'] = $_GPC['coupon_img'];
    if($_GPC['id']==''){
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('yzpx_sun_logoset',$data);
        if($res){
            message('设置成功',$this->createWebUrl('logoset',array()),'success');
        }else{
            message('设置失败','','error');
        }
    }else{

        $res = pdo_update('yzpx_sun_logoset', $data, array('uniacid' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('logoset',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/logoset');