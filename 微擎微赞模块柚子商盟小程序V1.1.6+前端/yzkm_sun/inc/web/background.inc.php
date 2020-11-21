<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info = pdo_get('yzkm_sun_background', array('uniacid' => $_W['uniacid']));
if(checksubmit('submit')){
$raa=pdo_get('yzkm_sun_background',array('uniacid'=>$_W['uniacid']));
    $data['background']=$_GPC['background'];
    $data['uniacid']=$_W['uniacid'];
if ($raa=='') {
                    $res=pdo_insert('yzkm_sun_background',$data);
                    if($res){
                        message('添加成功',$this->createWebUrl('background',array()),'success');
                    }else{
                        message('添加失败','','error');
                    }   
}else{
        $res = pdo_update('yzkm_sun_background', $data, array('uniacid'=>$_W['uniacid']));
        if($res){
            message('编辑成功',$this->createWebUrl('background',array()),'success');
        }else{
            message('编辑失败','','error');
        }
}


}
include $this->template('web/background');