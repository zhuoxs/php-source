<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['is_yuyueopen']=$_GPC['is_yuyueopen'];
    $data['uniacid']=$_W['uniacid'];
    $data['yuyue_title']=$_GPC['yuyue_title'];
    if($_GPC['id']==''){
        $res=pdo_insert('yzhyk_sun_system',$data);
        if($res){
            message('编辑成功',$this->createWebUrl('yuyueopen',array()),'success');
        }else{
            message('编辑成功','','error');
        }
    }else{

        $res = pdo_update('yzhyk_sun_system', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('yuyueopen',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}

include $this->template('web/yuyueopen');