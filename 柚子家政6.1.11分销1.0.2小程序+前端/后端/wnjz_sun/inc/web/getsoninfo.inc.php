<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
if($_GPC['pid']){
    $info = pdo_get('wnjz_sun_category',array('uniacid'=>$_W['uniacid'],'cid'=>$_GPC['pid']));
}else{
    $info = [];
}
$pid = $_GPC['pid'];

if (checksubmit('submit')) {
//    p($_GPC);die;
    $data['uniacid'] = $_W['uniacid'];
    $data['cname'] = $_GPC['cname'];
    $data['c_time'] = date("Y-m-d H:i:s");
    $data['pid'] = $_GPC['pid'];
//    p($data);die;

    $r = pdo_get('wnjz_sun_category',array('uniacid'=>$_W['uniacid'],'cname'=>$_GPC['cname']));

    $res = pdo_insert('wnjz_sun_category', $data);
    if ($res) {
        message('编辑成功', $this->createWebUrl('category', array()), 'success');
    } else {
        message('编辑失败', '', 'error');
    }
}
include $this->template('web/getsoninfo');