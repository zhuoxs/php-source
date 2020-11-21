<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$list = pdo_getall('zhls_sun_type',array('uniacid' => $_W['uniacid']),array(),'','num ASC');
$info = pdo_getall('zhls_sun_coupon',['weid'=>$_W['uniacid']]);
//p($info);die;
global $_W, $_GPC;

if($_GPC['op']=='delete'){
    if($_W['ispost']){
        $res=pdo_delete('zhls_sun_coupon',array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('counp',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }
}
if($_GPC['op']=='change'){
    $res=pdo_update('zhls_sun_coupon',array('state'=>$_GPC['state']),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('counp',array()),'success');
    }else{
        message('操作失败','','error');
    }
}

include $this->template('web/counp');