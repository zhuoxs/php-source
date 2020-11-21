<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
if($_GPC['sid']){
    $info = pdo_get('ymktv_sun_servies',array('uniacid'=>$_W['uniacid'],'sid'=>$_GPC['sid']));
}else{
    $info = [];
}

if ($info['z_imgs']) {
    if (strpos($info['z_imgs'], ',')) {
        $imgs = explode(',', $info['z_imgs']);
    } else {
        $imgs = array(
            0 => $info['z_imgs']
        );
    }
}
$build = pdo_getall('ymktv_sun_building',array('uniacid'=>$_W['uniacid']));
if (checksubmit('submit')) {
//    p($_GPC);die;
    $data['z_imgs'] = $_GPC['z_imgs'];
    $data['uniacid'] = $_W['uniacid'];
    $data['servies_name'] = $_GPC['servies_name'];
    $data['login'] = $_GPC['login'];
    $data['mobile'] = $_GPC['mobile'];
    $data['password'] = $_GPC['password'];
    $data['b_id'] = $_GPC['b_id'];
    $data['servies_details'] = htmlspecialchars_decode($_GPC['servies_details']);
    $data['s_time'] = date("Y-m-d H:i:s");
//    p($data);die;
    $admin = pdo_get('ymktv_sun_business_account',array('uniacid'=>$_W['uniacid'],'account'=>$_GPC['login']));
    $servies = pdo_get('ymktv_sun_servies',array('uniacid'=>$_W['uniacid'],'login'=>$_GPC['login']));
    $branchhead = pdo_get('ymktv_sun_branchhead',array('uniacid'=>$_W['uniacid'],'account'=>$_GPC['login']));

    if ($_GPC['sid'] == '' || $_GPC['sid'] == null) {
        if($admin || $servies || $branchhead){
            message('该账号已存在！');
        }else{
            $res = pdo_insert('ymktv_sun_servies', $data);
        }

    }else{
        $ser = pdo_getall('ymktv_sun_servies',array('uniacid'=>$_W['uniacid'],'login'=>$_GPC['login'],'sid !='=>$_GPC['sid']));
        if($ser){
            message('该账号已存在！');
        }else{
            if($admin || $branchhead){
                message('该账号已存在！');
            }else{
                $res = pdo_update('ymktv_sun_servies', $data, array('sid' => $_GPC['sid']));
            }
        }

    }
    if ($res) {
        message('编辑成功', $this->createWebUrl('servies', array()), 'success');
    } else {
        message('编辑失败', '', 'error');
    }
}
include $this->template('web/serviesinfo');