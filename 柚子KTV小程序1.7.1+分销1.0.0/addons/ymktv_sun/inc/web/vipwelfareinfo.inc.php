<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info = pdo_get('ymktv_sun_vipwelfare',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));

if (checksubmit('submit')) {
    $data['welfare'] = $_GPC['welfare'];
    $data['wel_img'] = $_GPC['wel_img'];
    $data['uniacid'] = $_W['uniacid'];
    $data['addtime'] = time();
    if ($_GPC['id'] == '' || $_GPC['id'] == null) {

        $res = pdo_insert('ymktv_sun_vipwelfare', $data);
    } else {

        $res = pdo_update('ymktv_sun_vipwelfare', $data, array('id' => $_GPC['id']));
    }
    if ($res) {
        message('编辑成功', $this->createWebUrl('vipwelfare', array()), 'success');
    } else {
        message('编辑失败', '', 'error');
    }
}
include $this->template('web/vipwelfareinfo');