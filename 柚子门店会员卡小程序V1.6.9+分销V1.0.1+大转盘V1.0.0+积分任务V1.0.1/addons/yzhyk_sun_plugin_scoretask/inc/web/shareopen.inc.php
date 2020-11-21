<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['is_shareopen']=$_GPC['is_shareopen'];
    $data['uniacid']=$_W['uniacid'];
    $data['share_title']=$_GPC['share_title'];
    $data['share_rule']=$_GPC['share_rule'];
    if($_GPC['id']==''){                
        $res=pdo_insert('yzhyk_sun_system',$data);
        if($res){
            message('编辑成功',$this->createWebUrl('shareopen',array()),'success');
        }else{
            message('编辑成功','','error');
        }
    }else{
        $res = pdo_update('yzhyk_sun_system', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('shareopen',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}

include $this->template('web/shareopen');