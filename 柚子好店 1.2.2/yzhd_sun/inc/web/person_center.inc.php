<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzhd_sun_system',array('uniacid'=>$_W['uniacid']));
if($info['platform_ad']){
    if(strpos($info['platform_ad'],',')){
        $lb_imgs= explode(',',$info['platform_ad']);

    }else{
        $lb_imgs=array(
            0=>$info['platform_ad']
        );
    }
}
if(checksubmit('submit')){

	$data['personal_img'] = $_GPC['personal_img'];
//	$data['create_time'] = time();

    if($_GPC['platform_ad']){

        $data['platform_ad']=implode(",",$_GPC['platform_ad']);
    }else{
        $data['platform_ad']='';
    }
//	$data['uniacid'] = $_W['uniacid'];

    if($_GPC['id']==''){
        $res=pdo_insert('yzhd_sun_system',$data,array('uniacid'=>$_W['uniacid']));
        if($res){
            message('添加成功',$this->createWebUrl('person_center',array()),'success');
        }else{
            message('添加失败','','error');
        }

    }else{

        $res = pdo_update('yzhd_sun_system', $data, array('id' => $_GPC['id']));

        if($res){
            message('编辑成功',$this->createWebUrl('person_center',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/person_center');
