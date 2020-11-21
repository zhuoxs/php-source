<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$list = pdo_getall('yzcj_sun_in',array('uniacid' => $_W['uniacid']),array(),'','id asc');
if($_GPC['id']){
    $res=pdo_delete('yzcj_sun_in',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功',$this->createWebUrl('in',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
include $this->template('web/in');