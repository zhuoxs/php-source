<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$sql = "SELECT FROM_UNIXTIME(time,'%Y-%m-%d %H:%I:%S') AS time,FROM_UNIXTIME(pay_time,'%Y-%m-%d %H:%I:%S') AS pay_time,order_num,user_name,tel,money,good_name,note,state FROM ims_ymktv_sun_order WHERE uniacid = ".$_W['uniacid']." AND id = ".$_GPC['id'];
//$item=pdo_fetch($sql);

$item = pdo_get('ymktv_sun_order',array('uniacid' => $_W['uniacid'],'id' => $_GPC['id']));
if ($_W['ispost']){
    $res = pdo_update('ymktv_sun_order',array('state' => $_GPC['state']),array('uniacid' => $_W['uniacid'],'id' => $_GPC['id']));
    if($res){
        message('修改成功',$this->createWebUrl('ddgl',array()),'success');
    }else{
        message('修改失败','','error');
    }
}
include $this->template('web/orderinfo');