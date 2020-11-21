<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info = pdo_get('zhls_sun_coupon', array('id' => $_GPC['id']));
$val = json_decode($info['val'],true);

if (checksubmit('submit')) {
    if($_GPC['showIndex']=='on'){
        $show = 1;
    }else{
        $show = 0;
    }
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
    $data['val'] = json_encode($_GPC['val']);
//    $data['exchange'] = $_GPC['exchange'];
    $data['scene'] = $_GPC['scene'];
    $data['state'] = 1;
    $data['status'] = 1;
    $data['selftime'] = time();
    $data['showIndex'] = $show;
    if (empty($_GPC['id'])) {
        $res = pdo_insert('zhls_sun_coupon', $data);
    } else {
        $res = pdo_update('zhls_sun_coupon', $data,array('id'=>$_GPC['id']));
    }
    if($res){
        message('编辑成功！', $this->createWebUrl('counp'), 'success');
    }else{
        message('编辑失败！');
    }
}

include $this->template('web/caropen');
