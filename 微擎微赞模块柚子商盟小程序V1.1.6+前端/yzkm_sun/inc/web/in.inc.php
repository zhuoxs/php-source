<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
// $list = pdo_getall('yzkm_sun_duration',array('uniacid' => $_W['uniacid']),array(),"status!="=>3),'','');
$list=pdo_getall('yzkm_sun_duration',array('uniacid'=>$_W['uniacid']));
// p($list);die;
if($_GPC['id']){
    $res=pdo_delete('yzkm_sun_duration',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('in',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
include $this->template('web/in');