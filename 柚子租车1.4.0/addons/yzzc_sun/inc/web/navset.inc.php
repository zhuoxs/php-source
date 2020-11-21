<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzzc_sun_logoset',array('uniacid' => $_W['uniacid']));

if(checksubmit('submit')){
    $data['nav_name_one']=$_GPC['nav_name_one']?$_GPC['nav_name_one']:'我的';
    if( ($_GPC['nav_img_one']&&empty($_GPC['nav_img_a'])) || ($_GPC['nav_img_a']&&empty($_GPC['nav_img_one'])) ){
        message('请同时设置图标一选中及未选中图标','','error');
    }
    if( ($_GPC['nav_img_two']&&empty($_GPC['nav_img_b'])) || ($_GPC['nav_img_b']&&empty($_GPC['nav_img_two'])) ){
        message('请同时设置图标二选中及未选中图标','','error');
    }
    if( ($_GPC['nav_img_three']&&empty($_GPC['nav_img_c'])) || ($_GPC['nav_img_c']&&empty($_GPC['nav_img_three'])) ){
        message('请同时设置图标三选中及未选中图标','','error');
    }
    if( ($_GPC['nav_img_four']&&empty($_GPC['nav_img_d'])) || ($_GPC['nav_img_d']&&empty($_GPC['nav_img_four'])) ){
        message('请同时设置图标四选中及未选中图标','','error');
    }
    $data['nav_img_one'] = $_GPC['nav_img_one'];
    $data['nav_img_two'] = $_GPC['nav_img_two'];
    $data['nav_img_three'] = $_GPC['nav_img_three'];
    $data['nav_img_four'] = $_GPC['nav_img_four'];
    $data['nav_img_a'] = $_GPC['nav_img_a'];
    $data['nav_name_two']=$_GPC['nav_name_two']?$_GPC['nav_name_two']:'附近';
    $data['nav_img_b'] = $_GPC['nav_img_b'];
    $data['nav_name_three']=$_GPC['nav_name_three']?$_GPC['nav_name_three']:'订单';
    $data['nav_img_c'] = $_GPC['nav_img_c'];
    $data['nav_name_four']=$_GPC['nav_name_four']?$_GPC['nav_name_four']:'我的';
    $data['nav_img_d'] = $_GPC['nav_img_d'];
    if($_GPC['id']==''){
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('yzzc_sun_logoset',$data);
        if($res){
            message('设置成功',$this->createWebUrl('navset',array()),'success');
        }else{
            message('设置失败','','error');
        }
    }else{

        $res = pdo_update('yzzc_sun_logoset', $data, array('uniacid' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('navset',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/navset');