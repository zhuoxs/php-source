<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
if($_GPC['yid']){
    $sql = ' SELECT * FROM ' . tablename('ymktv_sun_drinks') . ' d ' . 'JOIN ' . tablename('ymktv_sun_drinktype') . ' dt ' . ' ON ' . ' d.dt_id=dt.dtid' . ' WHERE ' . ' d.uniacid=' . $_W['uniacid'] . ' AND ' . ' d.id='.$_GPC['id'];
    $info = pdo_fetch($sql);
}else{
    $info = [];
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

    $data['uniacid'] = $_W['uniacid'];
    $data['y_name'] = $_GPC['y_name'];
    $data['y_cost'] = $_GPC['y_cost'];
    $data['y_price'] = $_GPC['y_price'];
    $data['y_details'] = htmlspecialchars_decode($_GPC['y_details']);  //包间详情
    $data['y_time'] = date("Y-m-d H:i:s");
//    p($data);die;
    if ($_GPC['yid'] == '' || $_GPC['yid'] == null) {

        $res = pdo_insert('ymktv_sun_youhui', $data);
    } else {

        $res = pdo_update('ymktv_sun_youhui', $data, array('yid' => $_GPC['yid']));
    }
    if ($res) {
        message('编辑成功', $this->createWebUrl('youhui', array()), 'success');
    } else {
        message('编辑失败', '', 'error');
    }
}
include $this->template('web/youhuiinfo');