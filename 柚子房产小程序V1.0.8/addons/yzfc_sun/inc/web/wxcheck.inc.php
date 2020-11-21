<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$info=pdo_get('yzfc_sun_system',array('uniacid' => $_W['uniacid']));
if(checksubmit('submit')){

    $set['uniacid'] = $_W['uniacid'];
    $set['wechat_check'] = $_GPC['wechat_check'];

    if($_GPC['id']==''){
        $res1=pdo_insert('yzfc_sun_system', $set);
    }else{
        $res2=pdo_update('yzfc_sun_system', $set, array('id' => $_GPC['id']));
    }
    if($res1 || $res2){
        message('设置成功',$this->createWebUrl('wxcheck',array()),'success');
    }else{
        message('设置失败','','error');
    }
}
include $this->template('web/wxcheck');