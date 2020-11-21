<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$list = pdo_getall('ymktv_sun_building',array('uniacid' => $_W['uniacid']),array(),'','addtime DESC');
if($_GPC['op']=='delete'){
    $res=pdo_delete('ymktv_sun_building',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('building',array()),'success');
    }else{
        message('删除失败','','error');
    }
}

include $this->template('web/building');