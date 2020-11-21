<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzmdwsc_sun_tab',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){           
    $data['dynamic_banner']=$_GPC['dynamic_banner'];
//    $data['dynamic_status']=$_GPC['dynamic_status'];
    $data['uniacid']=$_W['uniacid'];    
    $data['is_review']=$_GPC['is_review'];
    if($_GPC['id']==''){                
        $res=pdo_insert('yzmdwsc_sun_tab',$data);
        if($res){
            message('添加成功',$this->createWebUrl('dynamicsettings',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('yzmdwsc_sun_tab', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('dynamicsettings',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/dynamicsettings');