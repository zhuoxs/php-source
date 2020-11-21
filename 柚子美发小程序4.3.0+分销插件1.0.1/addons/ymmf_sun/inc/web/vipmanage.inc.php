<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$info = pdo_getall('ymmf_sun_vip_ka',array('uniacid'=>$_W['uniacid']));

if($_GPC['op'] == 'delete'){
    $res = pdo_delete('ymmf_sun_vip_ka',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('vipmanage',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
include $this->template('web/vipmanage');