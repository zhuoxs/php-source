<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzcyk_sun_system',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['is_haowuopen']=$_GPC['is_haowuopen'];
    $data['uniacid']=$_W['uniacid'];
    $data['haowu_title']=$_GPC['haowu_title'];
    if($_GPC['id']==''){                
        $res=pdo_insert('yzcyk_sun_system',$data);
        if($res){
            message('编辑成功',$this->createWebUrl('haowuopen',array()),'success');
        }else{
            message('编辑成功','','error');
        }
    }else{

        $res = pdo_update('yzcyk_sun_system', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('haowuopen',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}

include $this->template('web/haowuopen');