<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info = pdo_getall('wnjz_sun_coupon',array('uniacid'=>$_W['uniacid']));

foreach ($info as $k=>$v){
    $info[$k]['b_name'] = pdo_getcolumn('wnjz_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$v['build_id']),'name');
}

if($_GPC['op']=='delete'){
    if($_W['ispost']){
        $res=pdo_delete('wnjz_sun_coupon',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('counp',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }
}
if($_GPC['op']=='change'){
    $res=pdo_update('wnjz_sun_coupon',array('state'=>$_GPC['state']),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('操作成功',$this->createWebUrl('counp',array()),'success');
    }else{
        message('操作失败','','error');
    }
}

include $this->template('web/counp');