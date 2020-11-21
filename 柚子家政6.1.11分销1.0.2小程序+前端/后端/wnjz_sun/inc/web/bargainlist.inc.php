<?php
global $_GPC, $_W;
load()->func('tpl');
$GLOBALS['frames'] = $this->getMainMenu();
$list = pdo_getall('wnjz_sun_new_bargain',array('uniacid' => $_W['uniacid']));
foreach ($list as $k=>$v){
    $list[$k]['b_name'] = pdo_getcolumn('wnjz_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$v['build_id']),'name');
}
if($_GPC['op']=='delete'){
    if($_W['ispost']){
        $res=pdo_delete('wnjz_sun_new_bargainlist',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('counp',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }
}
if($_GPC['op']=='change') {
    $res = pdo_update('wnjz_sun_new_bargain', array('status' => $_GPC['status']), array('id' => $_GPC['id']));
    if ($res) {
        message('操作成功', $this->createWebUrl('bargainlist', array()), 'success');
    } else {
        message('操作失败', '', 'error');
    }
}
if($_GPC['op']=='tg'){
    p($_GPC['id']);die;
    $res=pdo_update('wnjz_sun_new_bargain',array('status'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('通过成功！', $this->createWebUrl('bargainlist'), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('wnjz_sun_new_bargain',array('status'=>3),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('拒绝成功！', $this->createWebUrl('bargainlist'), 'success');
    }else{
        message('拒绝失败！','','error');
    }
}
include $this->template('web/bargainlist');