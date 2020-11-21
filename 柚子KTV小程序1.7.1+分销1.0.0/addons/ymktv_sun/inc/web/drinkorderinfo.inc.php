<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$order = pdo_get('ymktv_sun_order',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));

$order['good_name'] = explode(',',$order['good_name']);
$order['good_num'] = explode(',',$order['good_num']);

if(checksubmit('submit')){
    if($_W['ispost']){

        $res = pdo_update('ymktv_sun_order',array('status'=>$_GPC['status']),array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));

        if($res){
            message('编辑成功！', $this->createWebUrl('drinkorder'), 'success');
        }else{
            message('编辑失败！','','error');
        }
    }
}
include $this->template('web/drinkorderinfo');