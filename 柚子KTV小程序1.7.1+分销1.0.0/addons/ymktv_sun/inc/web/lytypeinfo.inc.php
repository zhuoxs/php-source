<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
if($_GPC['lid']){
    $info = pdo_get('fyly_sun_lytype',array('uniacid'=>$_W['uniacid'],'lid'=>$_GPC['lid']));
}else{
    $info = [];
}

if (checksubmit('submit')) {
//    p($_GPC);die;
    $data['uniacid'] = $_W['uniacid'];
    $data['lname'] = $_GPC['lname'];
    $data['l_time'] = date("Y-m-d H:i:s");
//    p($data);die;
    if ($_GPC['lid'] == '' || $_GPC['lid'] == null) {
        $r = pdo_get('fyly_sun_lytype',array('uniacid'=>$_W['uniacid'],'lname'=>$_GPC['lname']));
        if($r){
            message('该分类已存在！');
        }else{
            $res = pdo_insert('fyly_sun_lytype', $data);
        }

    } else {
        $res = pdo_update('fyly_sun_lytype', $data, array('lid' => $_GPC['lid']));
    }
    if ($res) {
        message('编辑成功', $this->createWebUrl('lytype', array()), 'success');
    } else {
        message('编辑失败', '', 'error');
    }
}
include $this->template('web/lytypeinfo');