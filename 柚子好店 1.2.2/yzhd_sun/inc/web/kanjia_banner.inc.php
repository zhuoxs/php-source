<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzhd_sun_front_menu',array('uniacid'=>$_W['uniacid']));

if(checksubmit('submit')){
    $data['uniacid']=$_W['uniacid'];
    $data['menu1_name']=$_GPC['menu1_name'];
    $data['menu2_name']=$_GPC['menu2_name'];
    $data['menu3_name']=$_GPC['menu3_name'];
    $data['menu4_name']=$_GPC['menu4_name'];
    $data['menu4_logo']=$_GPC['menu4_logo'];
    $data['menu3_logo']=$_GPC['menu3_logo'];
    $data['menu2_logo']=$_GPC['menu2_logo'];
    $data['menu1_logo']=$_GPC['menu1_logo'];
    $data['menu1_ck_logo']=$_GPC['menu1_ck_logo'];
    $data['menu2_ck_logo']=$_GPC['menu2_ck_logo'];
    $data['menu3_ck_logo']=$_GPC['menu3_ck_logo'];
    $data['menu4_ck_logo']=$_GPC['menu4_ck_logo'];
    if($_GPC['id']==''){
        $res=pdo_insert('yzhd_sun_front_menu',$data);
        if($res){
            message('添加成功',$this->createWebUrl('kanjia_banner',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('yzhd_sun_front_menu', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('kanjia_banner',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/kanjia_banner');
