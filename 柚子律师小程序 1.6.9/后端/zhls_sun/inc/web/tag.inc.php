<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$list = pdo_getall('zhls_sun_car_tag',array('uniacid' => $_W['uniacid']),array(),'','typename asc');
if($_GPC['id']){
    $res=pdo_delete('zhls_sun_car_tag',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('tag',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
include $this->template('web/tag');