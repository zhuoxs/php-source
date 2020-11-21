<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$list = pdo_getall('yzkm_sun_selectedtype',array('uniacid' => $_W['uniacid']),array(),'','tname');
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzkm_sun_selectedtype',array('tid'=>$_GPC['id']));
    // p($res);die;
    if($res){
        message('删除成功',$this->createWebUrl('industryList',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($_GPC['op']=='change'){
	 $res=pdo_update('yzkm_sun_selectedtype',array('type'=>$_GPC['type']),array('tid'=>$_GPC['tid']));
    if($res){
        message('操作成功',$this->createWebUrl('industryList',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
include $this->template('web/industryList');