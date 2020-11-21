<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$list = pdo_getall('ymktv_sun_drinktype',array('uniacid' => $_W['uniacid']),array(),'','sort DESC');
if($_GPC['op']=='delete'){
    $res=pdo_delete('ymktv_sun_drinktype',array('dtid'=>$_GPC['dtid']));
    if($res){
        message('删除成功',$this->createWebUrl('drinktype',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($_GPC['op']=='change'){
	 $res=pdo_update('ymktv_sun_type',array('state'=>$_GPC['state']),array('dtid'=>$_GPC['dtid']));
    if($res){
        message('操作成功',$this->createWebUrl('drinktype',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
include $this->template('web/drinktype');