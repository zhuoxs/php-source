<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$list = pdo_getall('yzhd_sun_user_coupon',array('uniacid'=>$_W['uniacid'],'cid'=>$_GPC['id']));
foreach ($list as $k=>$v){
    $list[$k]['cname'] = pdo_getcolumn('yzhd_sun_coupon',array('uniacid'=>$_W['uniacid'],'id'=>$v['cid']),'name');
    $list[$k]['username'] = pdo_getcolumn('yzhd_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$v['openid']),'name');
    $list[$k]['start_time'] = pdo_getcolumn('yzhd_sun_coupon',array('uniacid'=>$_W['uniacid'],'id'=>$v['cid']),'start_time');
    $list[$k]['expire_time'] = pdo_getcolumn('yzhd_sun_coupon',array('uniacid'=>$_W['uniacid'],'id'=>$v['cid']),'expire_time');
}

include $this->template('web/couponsdetails');
