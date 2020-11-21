<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzcyk_sun_tab',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){           
    $data['dynamic_banner']=$_GPC['dynamic_banner'];
    $data['dynamic_headimg']=$_GPC['dynamic_headimg'];
    $data['uniacid']=$_W['uniacid'];    
    if($_GPC['id']==''){                
        $res=pdo_insert('yzcyk_sun_tab',$data);
        if($res){
            message('添加成功',$this->createWebUrl('dynamicsettings',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('yzcyk_sun_tab', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('dynamicsettings',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/dynamicsettings');