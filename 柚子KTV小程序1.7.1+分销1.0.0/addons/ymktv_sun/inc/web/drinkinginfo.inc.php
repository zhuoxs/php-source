<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
if($_GPC['id']){
    $sql = ' SELECT d.*,dt.dtid,dt.dt_name FROM ' . tablename('ymktv_sun_drinks') . ' d ' . 'JOIN ' . tablename('ymktv_sun_drinktype') . ' dt ' . ' ON ' . ' d.dt_id=dt.dtid' . ' WHERE ' . ' d.uniacid=' . $_W['uniacid'] . ' AND ' . ' d.id='.$_GPC['id'];
    $info = pdo_fetch($sql);
}else{
    $info = [];
}
$type = pdo_getall('ymktv_sun_drinktype',array('uniacid'=>$_W['uniacid']));
// 分店数据
$build = pdo_getall('ymktv_sun_building',array('uniacid'=>$_W['uniacid']));

if($info['build_id']){
    $build_id = explode(',',$info['build_id']);
}

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
//    p($_GPC);die;
    if ($_GPC['imgs']) {
        $data['imgs'] = implode(",", $_GPC['imgs']);
    } else {
        $data['imgs'] = '';
    }
    $data['build_id'] = implode(',',$_GPC['build_id']);

    $data['z_imgs'] = $_GPC['z_imgs'];
    $data['uniacid'] = $_W['uniacid'];
    $data['drink_name'] = $_GPC['drink_name'];
    $data['drink_cost'] = $_GPC['drink_cost'];
    $data['drink_price'] = $_GPC['drink_price'];
    $data['sort'] = $_GPC['sort'];
    $data['dt_id'] = $_GPC['dt_id'];          //包间大小
    $data['drink_details'] = htmlspecialchars_decode($_GPC['drink_details']);  //包间详情
    $data['d_time'] = date("Y-m-d H:i:s");
//    p($data);die;
    if ($_GPC['id'] == '' || $_GPC['id'] == null) {

        $res = pdo_insert('ymktv_sun_drinks', $data);
    } else {

        $res = pdo_update('ymktv_sun_drinks', $data, array('id' => $_GPC['id']));
    }
    if ($res) {
        message('编辑成功', $this->createWebUrl('drinking', array()), 'success');
    } else {
        message('编辑失败', '', 'error');
    }
}
include $this->template('web/drinkinginfo');