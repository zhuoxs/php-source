<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$sql = "SELECT FROM_UNIXTIME(time,'%Y-%m-%d %H:%I:%S') AS time,FROM_UNIXTIME(pay_time,'%Y-%m-%d %H:%I:%S') AS pay_time,order_num,user_name,tel,money,good_name,note,state FROM ims_byjs_sun_order WHERE uniacid = ".$_W['uniacid']." AND id = ".$_GPC['id'];
//$item=pdo_fetch($sql);
$sql = ' SELECT * FROM ' . tablename('byjs_sun_user') . ' u ' . ' JOIN ' . tablename('byjs_sun_expert') . ' e ' . ' ON ' . ' e.user_id=u.openid' . ' WHERE ' . ' e.uniacid=' . $_W['uniacid'] . ' AND ' . ' u.uniacid=' . $_W['uniacid'] . ' AND ' . ' e.id='.$_GPC['id'];
$item = pdo_fetch($sql);
$item['imgs'] = explode(',',$item['imgs']);
$is_shopen = pdo_getcolumn('byjs_sun_tab',array('uniacid'=>$_W['uniacid']),'is_shopen');
//p($item);die;
if ($_W['ispost']){
//    p($_GPC);die;
    $res = pdo_update('byjs_sun_expert',array('isexamine' => $_GPC['isexamine']),array('uniacid' => $_W['uniacid'],'id' => $_GPC['id']));
    if($res){
        message('修改成功',$this->createWebUrl('release',array()),'success');
    }else{
        message('修改失败','','error');
    }
}
include $this->template('web/releaseinfo');