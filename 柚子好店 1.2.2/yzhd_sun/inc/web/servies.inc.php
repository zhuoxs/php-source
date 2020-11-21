<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$type= isset($_GPC['type'])?$_GPC['type']:0;
$list = pdo_getall('yzhd_sun_servies',array('uniacid'=>$_W['uniacid']),'','','s_time DESC');
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzhd_sun_servies',array('sid'=>$_GPC['sid']));
    if($res){
         message('删除成功！', $this->createWebUrl('servies'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
include $this->template('web/servies');