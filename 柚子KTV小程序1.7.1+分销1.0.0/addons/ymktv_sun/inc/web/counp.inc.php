<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info = pdo_fetchall("SELECT * FROM ims_ymktv_sun_coupon WHERE weid = ".$_W['weid']);
global $_W, $_GPC;

if($_GPC['op']=='delete'){
    if($_W['ispost']){
        $res=pdo_delete('ymktv_sun_coupon',array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('counp',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }
}
if($_GPC['op']=='change'){
    $res=pdo_update('ymktv_sun_coupon',array('state'=>$_GPC['state']),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('counp',array()),'success');
    }else{
        message('操作失败','','error');
    }
}

include $this->template('web/counp');