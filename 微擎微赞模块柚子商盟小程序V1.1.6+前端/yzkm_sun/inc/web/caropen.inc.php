<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info = pdo_get('yzkm_sun_coupon', array('id' => $_GPC['id']));
$val = json_decode($info['val'],true);

if (checksubmit('submit')) {

    $data['weid'] = $_W['weid'];
    $data['title'] = $_GPC['title'];
    if (empty($_GPC['type'])) {
        //暂时未启用优惠券类型功能,将优惠券类型设置为代金券(包含满减类型)
        $data['type'] = $_GPC['type'] = 2;
    }
    $data['astime'] = $_GPC['astime'];
    $data['antime'] = $_GPC['antime'];
    $data['expiryDate'] = $_GPC['expiryDate'];
    $data['allowance'] = $_GPC['allowance'];
    $data['total'] = $_GPC['total'];
    $data['val'] = $_GPC['val'];
    $data['vab'] = $_GPC['vab'];
   $data['uniacid'] = $_W['uniacid'];
    $data['scene'] = $_GPC['scene'];
    $data['showIndex'] =$_GPC['showIndex'];

    if (empty($_GPC['id'])) {
        $res = pdo_insert('yzkm_sun_coupon', $data,array('uniacid'=>$_W['uniacid']));
        if($res){
            message('添加成功！', $this->createWebUrl('counp'), 'success');
        }else{
            message('添加失败！');
        }
    } else {
        $res = pdo_update('yzkm_sun_coupon', $data,array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    }
    if($res){
        message('编辑成功！', $this->createWebUrl('counp'), 'success');
    }else{
        message('编辑失败！');
    }
}

include $this->template('web/caropen');
