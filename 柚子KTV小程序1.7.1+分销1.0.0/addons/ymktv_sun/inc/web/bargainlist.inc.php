<?php
global $_GPC, $_W;
load()->func('tpl');
$GLOBALS['frames'] = $this->getMainMenu();
$list = pdo_getall('ymktv_sun_new_bargain',array('uniacid' => $_W['uniacid']),'','','sort DESC');
foreach ($list as $k=>$v){
    $list[$k]['servies_name'] = pdo_getcolumn('ymktv_sun_servies',array('uniacid'=>$_W['uniacid'],'sid'=>$v['sid']),'servies_name');
}
if($_GPC['op']=='delete'){
    if($_W['ispost']){
        $res=pdo_delete('ymktv_sun_new_bargain',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('bargainlist',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }
}
if($_GPC['op']=='change') {
    $res = pdo_update('ymktv_sun_new_bargain', array('status' => $_GPC['status']), array('id' => $_GPC['id']));
    if ($res) {
        message('操作成功', $this->createWebUrl('bargainlist', array()), 'success');
    } else {
        message('操作失败', '', 'error');
    }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('ymktv_sun_new_bargain',array('status'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('通过成功！', $this->createWebUrl('bargainlist'), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('ymktv_sun_new_bargain',array('status'=>3),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('拒绝成功！', $this->createWebUrl('bargainlist'), 'success');
    }else{
        message('拒绝失败！','','error');
    }
}
include $this->template('web/bargainlist');