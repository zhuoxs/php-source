<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info = pdo_get('chbl_sun_coupon', array('id' => $_GPC['id']));
$val = json_decode($info['val'],true);
//查找出所有门店
$store = pdo_getall('chbl_sun_store_active',array('uniacid'=>$_W['uniacid']));
if (checksubmit('submit')) {
    if($_GPC['store_id']==0){
        message('请选择门店');
    }
    if($_GPC['showindex']=='on'){
        $show = 1;
    }else{
        $show = 0;
    }

    if($_GPC['val']['b']<=$_GPC['val']['c']){
        message('请设置正确的满减金额');
    }
    if($_GPC['total']< $_GPC['allowance']){
        message('请设置正确的数量');
    }
    $data['uniacid'] = $_W['uniacid'];
    $data['title'] = $_GPC['title'];
//    if (empty($_GPC['type'])) {
//        //暂时未启用优惠券类型功能,将优惠券类型设置为代金券(包含满减类型)
//        $data['type'] = $_GPC['type'] = 2;
//    }
    $data['store_id'] = $_GPC['store_id'];
    $data['astime'] = $_GPC['astime'];
    $data['antime'] = $_GPC['antime'];
//    $data['expiry_date'] = $_GPC['expiryDate'];
    $data['allowance'] = $_GPC['allowance'];
//    $data['num'] = $_GPC['num'];
    $data['val'] = json_encode($_GPC['val']);
    $data['total'] = $_GPC['total'];
    $data['scene'] = $_GPC['scene'];
    $data['status'] = 1;
    $data['selftime'] = time();
    $data['showindex'] = $show;
    if (empty($_GPC['id'])) {
        $res = pdo_insert('chbl_sun_coupon', $data);
    } else {
        $res = pdo_update('chbl_sun_coupon', $data,array('id'=>$_GPC['id']));
    }
    if($res){
        message('编辑成功！', $this->createWebUrl('coupon'), 'success');
    }else{
        message('编辑失败！');
    }
}

include $this->template('web/addcoupon');
