<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzcyk_sun_system',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['is_gywmopen']=$_GPC['is_gywmopen'];
    $data['uniacid']=$_W['uniacid'];
    $data['gywm_title']=$_GPC['gywm_title'];
    $data['address']=$_GPC['address'];
    $data['gywm_banner']=$_GPC['gywm_banner'];
    $data['customer_time']=$_GPC['customer_time'];
    $data['provide']=$_GPC['provide'];
    $data['shopdes']=htmlspecialchars_decode($_GPC['shopdes']);
    $coordinates = trim($_GPC['coordinates']);
    $coordinatesarr = explode(",",$coordinates);
    $data['coordinates'] = trim($coordinates);
    $data['latitude'] = $coordinatesarr[0];//纬度
    $data['longitude'] = $coordinatesarr[1];//精度 
    if($_GPC['id']==''){                
        $res=pdo_insert('yzcyk_sun_system',$data);
        if($res){
            message('编辑成功',$this->createWebUrl('gywmopen',array()),'success');
        }else{
            message('编辑成功','','error');
        }
    }else{
        $res = pdo_update('yzcyk_sun_system', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('gywmopen',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}

include $this->template('web/gywmopen');