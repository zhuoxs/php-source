<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$list = pdo_getall('zhls_sun_in',array('uniacid' => $_W['uniacid']),array(),'','num asc');
if($_GPC['id']){
    $res=pdo_delete('zhls_sun_in',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('in',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
include $this->template('web/in');