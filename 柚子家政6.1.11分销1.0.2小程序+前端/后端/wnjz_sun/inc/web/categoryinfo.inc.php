<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
if($_GPC['cid']){
    $info = pdo_get('wnjz_sun_category',array('uniacid'=>$_W['uniacid'],'cid'=>$_GPC['cid']));
}else{
    $info = [];
}

if (checksubmit('submit')) {
//    p($_GPC);die;
    $data['uniacid'] = $_W['uniacid'];
    $data['cname'] = $_GPC['cname'];
    $data['c_time'] = date("Y-m-d H:i:s");
    $data['back_pic'] = $_GPC['back_pic'];
//    p($data);die;
    if ($_GPC['cid'] == '' || $_GPC['cid'] == null) {
        $r = pdo_get('wnjz_sun_category',array('uniacid'=>$_W['uniacid'],'cname'=>$_GPC['cname']));
        if($r){
            message('该分类已存在！');
        }else{
            $res = pdo_insert('wnjz_sun_category', $data);
        }

    } else {
        $res = pdo_update('wnjz_sun_category', $data, array('cid' => $_GPC['cid']));
    }
    if ($res) {
        message('编辑成功', $this->createWebUrl('category', array()), 'success');
    } else {
        message('编辑失败', '', 'error');
    }
}
include $this->template('web/categoryinfo');