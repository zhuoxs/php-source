<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$type = isset($_GPC['type'])?$_GPC['type']:0;

$list = pdo_getall('ymktv_sun_vipka',array('uniacid'=>$_W['uniacid']),'','','vip_term ASC');
if($_GPC['op']=='delete'){
    $res=pdo_delete('ymktv_sun_vipka',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('操作成功',$this->createWebUrl('adminvip',array()),'success');
    }else{
        message('操作失败','','error');
    }

}

include $this->template('web/vip/adminvip');