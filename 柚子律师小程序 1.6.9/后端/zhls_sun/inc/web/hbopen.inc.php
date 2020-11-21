<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){           
    $data['is_hbfl']=$_GPC['is_hbfl']; 
    $data['is_hbzf']=$_GPC['is_hbzf'];          
    $data['uniacid']=$_W['uniacid'];    
    if($_GPC['id']==''){                
        $res=pdo_insert('zhls_sun_system',$data);
        if($res){
            message('添加成功',$this->createWebUrl('hbopen',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('zhls_sun_system', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('hbopen',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/hbopen');