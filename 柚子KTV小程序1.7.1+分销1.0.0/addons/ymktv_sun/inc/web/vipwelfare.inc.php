<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$type = isset($_GPC['type'])?$_GPC['type']:0;

$list = pdo_getall('ymktv_sun_vipwelfare',array('uniacid'=>$_W['uniacid']),'','','addtime DESC');

if($_GPC['op']=='delete'){
    $res=pdo_delete('ymktv_sun_vipwelfare',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('vipwelfare'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('ymktv_sun_vipwelfare',array('state'=>2),array('id'=>$_GPC['id']));
    if($res){
         message('通过成功！', $this->createWebUrl('vipwelfare'), 'success');
        }else{
              message('通过失败！','','error');
        }
}

include $this->template('web/vipwelfare');