<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
if($_GPC['sid']){
    $info = pdo_get('yzhd_sun_servies',array('uniacid'=>$_W['uniacid'],'sid'=>$_GPC['sid']));
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

if (checksubmit('submit')) {
//    p($_GPC);die;
    $data['z_imgs'] = $_GPC['z_imgs'];
    $data['uniacid'] = $_W['uniacid'];
    $data['servies_name'] = $_GPC['servies_name'];
    $data['login'] = $_GPC['login'];
    $data['password'] = $_GPC['password'];
    $data['servies_details'] = htmlspecialchars_decode($_GPC['servies_details']);  //包间详情
    $data['s_time'] = date("Y-m-d H:i:s");
//    p($data);die;
    if ($_GPC['sid'] == '' || $_GPC['sid'] == null) {
        $r = pdo_get('yzhd_sun_servies',array('uniacid'=>$_W['uniacid'],'login'=>$_GPC['login']));
        if($r){
            message('该账号已存在！');
        }else{
            $res = pdo_insert('yzhd_sun_servies', $data);
        }

    } else {
        $b = pdo_getall('yzhd_sun_servies',array('uniacid'=>$_W['uniacid']));
        $c = [];
        foreach ($b as $k=>$v){
            if($v['sid']!=$_GPC['sid']){
                if($_GPC['login']==$v['login']){
                    $c[] = $v;
                }
            }
        }
        if(empty($c)){
            $res = pdo_update('yzhd_sun_servies', $data, array('sid' => $_GPC['sid']));
        }else{
            message('该账号已存在！');
        }

    }
    if ($res) {
        message('编辑成功', $this->createWebUrl('servies', array()), 'success');
    } else {
        message('编辑失败', '', 'error');
    }
}
include $this->template('web/serviesinfo');