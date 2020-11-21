<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$list = pdo_getall('chbl_sun_top',array('uniacid' => $_W['uniacid']),array(),'','num asc');
if($_GPC['id']){
    $res=pdo_delete('chbl_sun_top',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('top',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
$count=pdo_get('chbl_sun_top', array('uniacid'=>$_W['uniacid']), array('COUNT(*) as total'));
include $this->template('web/top');