<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/14
 * Time: 10:30
 */

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info = pdo_getall('yzzc_sun_taocan',array('uniacid' => $_W['uniacid']),array(),'','id DESC');
// $info = pdo_getall('yzzc_sun_taocan',['uniacid'=>$_W['uniacid']]);

global $_W, $_GPC;

if($_GPC['op']=='delete'){
    if($_W['ispost']){
        $res=pdo_delete('yzzc_sun_taocan',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('taocan',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }
}
if($_GPC['op']=='change'){
    $res=pdo_update('yzzc_sun_taocan',array('status'=>$_GPC['status']),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('操作成功',$this->createWebUrl('taocan',array()),'success');
    }else{
        message('操作失败','','error');
    }
}

include $this->template('web/taocan');