<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzhd_sun_ac_banner',array('uniacid'=>$_W['uniacid']));
if($info['lb_imgs']){
    $img = $info['lb_imgs'];
}
if($info['lb_imgs1']){
    $lb_imgs1= $info['lb_imgs1'];
}
if($info['lb_imgs2']){
    $lb_imgs2 = $info['lb_imgs2'];
}
if($info['lb_imgs3']){
    $lb_imgs3 = $info['lb_imgs3'];
}
if(checksubmit('submit')){

    $data['uniacid']=$_W['uniacid'];
    $data['lb_imgs']=$_GPC['lb_imgs'];
    $data['lb_imgs1']=$_GPC['lb_imgs1'];
    $data['lb_imgs2']=$_GPC['lb_imgs2'];
    $data['lb_imgs3']=$_GPC['lb_imgs3'];

    if($_GPC['id']==''){
        $res=pdo_insert('yzhd_sun_ac_banner',$data);


        if($res){
            message('添加成功',$this->createWebUrl('ac_banner',array()),'success');
        }else{
            message('添加失败','','error');
        }

    }else{

        $res = pdo_update('yzhd_sun_ac_banner', $data, array('id' => $_GPC['id']));

        if($res){
            message('编辑成功',$this->createWebUrl('ac_banner',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/acssssb');