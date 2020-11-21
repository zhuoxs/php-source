<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

 global $_W, $_GPC;
//    $type=pdo_getall('zhls_sun_lawyer',array('uniacid'=>$_W['uniacid']),array(),'','id asc');
    $sql = ' SELECT * FROM ' . tablename('zhls_sun_lawtype') . ' lt ' . ' JOIN ' . tablename('zhls_sun_lawyer') .' l ' . ' ON ' . ' l.cate=lt.id' . ' WHERE ' . ' l.uniacid=' . $_W['uniacid'] . ' ORDER BY ' .  ' l.num DESC';
    $type = pdo_fetchall($sql);

if($_GPC['op']=='delete'){
    $res=pdo_delete('zhls_sun_lawyer',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('faxingshi',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($_GPC['op']=='change'){
	 $res=pdo_update('zhls_sun_lawyer',array('state'=>$_GPC['state']),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('faxingshi',array()),'success');
    }else{
        message('操作失败','','error');
    }
}

include $this->template('web/faxingshi');