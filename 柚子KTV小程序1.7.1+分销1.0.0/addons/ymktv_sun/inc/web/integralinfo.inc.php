<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info = pdo_get('ymktv_sun_integral',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
$info['spec'] = explode(',',$info['spec']);
$info['specstock'] = explode(',',$info['specstock']);
//p($info);die;
if ($info['imgs']) {
    if (strpos($info['imgs'], ',')) {
        $imgs = explode(',', $info['imgs']);
    } else {
        $imgs = array(
            0 => $info['imgs']
        );
    }
}

if (checksubmit('submit')) {
    $stock = 0;
    foreach ($_GPC['stock'] as $k=>$v){
        $stock += $v;
    }
    if ($_GPC['imgs']) {
        $data['imgs'] = implode(",", $_GPC['imgs']);
    } else {
        $data['imgs'] = '';
    }
    $data['z_imgs'] = $_GPC['z_imgs'];
    $data['uniacid'] = $_W['uniacid'];
    $data['integral_name'] = $_GPC['integral_name'];
    $data['integral_price'] = $_GPC['integral_price'];
    $data['integral_details'] = htmlspecialchars_decode($_GPC['integral_details']);  //包间详情
    $data['i_time'] = date("Y-m-d H:i:s");
    $data['state'] = 0;
    $data['sort'] = $_GPC['sort'];
    $data['stock'] = $stock;
    $data['spec'] = implode(',',$_GPC['spec']);
    $data['specstock'] = implode(',',$_GPC['stock']);
//    p($data);die;
    if ($_GPC['id'] == '' || $_GPC['id'] == null) {

        $res = pdo_insert('ymktv_sun_integral', $data);
    } else {

        $res = pdo_update('ymktv_sun_integral', $data, array('id' => $_GPC['id']));
    }
    if ($res) {
        message('编辑成功', $this->createWebUrl('integral', array()), 'success');
    } else {
        message('编辑失败', '', 'error');
    }
}
include $this->template('web/integralinfo');