<?php
global $_GPC, $_W;
load()->func('tpl');
$GLOBALS['frames'] = $this->getMainMenu();
$list = pdo_getall('yzhd_sun_new_bargain',array('uniacid' => $_W['uniacid']));

if($_GPC['op']=='delete'){
    if($_W['ispost']){
        $res=pdo_delete('yzhd_sun_new_bargainlist',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('counp',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }
}
if($_GPC['op']=='change') {
    $res = pdo_update('yzhd_sun_new_bargain', array('status' => $_GPC['status']), array('id' => $_GPC['id']));
    if ($res) {
        message('操作成功', $this->createWebUrl('bargainlist', array()), 'success');
    } else {
        message('操作失败', '', 'error');
    }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('yzhd_sun_new_bargain',array('status'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('通过成功！', $this->createWebUrl('bargainlist'), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzhd_sun_new_bargain',array('status'=>3),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('拒绝成功！', $this->createWebUrl('bargainlist'), 'success');
    }else{
        message('拒绝失败！','','error');
    }
}
include $this->template('web/bargainlist');