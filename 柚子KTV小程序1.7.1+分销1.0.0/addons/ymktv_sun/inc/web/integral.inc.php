<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$type= isset($_GPC['type'])?$_GPC['type']:0;
$list = pdo_getall('ymktv_sun_integral',array('uniacid'=>$_W['uniacid']),'','','i_time DESC');
if($_GPC['op']=='delete'){
    $res=pdo_delete('ymktv_sun_integral',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('integral'), 'success');
        }else{
              message('删除失败！','','error');
        }
}


include $this->template('web/integral');