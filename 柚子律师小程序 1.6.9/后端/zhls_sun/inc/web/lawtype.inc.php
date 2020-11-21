<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$type = pdo_getall('zhls_sun_lawtype',array('uniacid'=>$_W['uniacid']),'','','id ASC');

if($_GPC['op']=='delete'){
    $res=pdo_delete('zhls_sun_lawtype',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('lawtype',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($_GPC['op']=='change'){
	 $res=pdo_update('zhls_sun_lawtype',array('state'=>$_GPC['state']),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('lawtype',array()),'success');
    }else{
        message('操作失败','','error');
    }
}

include $this->template('web/lawtype');