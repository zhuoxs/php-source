<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('zhls_sun_appointment',array('id'=>$_GPC['id']));

if(checksubmit('submit')){
    if($_W['ispost']){
        $data['status'] = $_GPC['status'];
        $res = pdo_update('zhls_sun_appointment',$data,['uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']]);
        if($res){
            message('编辑成功！', $this->createWebUrl('appiontment'), 'success');
        }else{
            message('编辑失败！','','error');
        }
    }
}
include $this->template('web/appoininfo');