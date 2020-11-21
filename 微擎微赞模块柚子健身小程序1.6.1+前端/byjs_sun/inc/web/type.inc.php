<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$list = pdo_getall('byjs_sun_type',array('uniacid' => $_W['uniacid']),array(),'','num ASC');
$info  = pdo_get('byjs_sun_type_show',array(),array('id','type_id'));
if($_GPC['op']=='delete'){
    $res=pdo_delete('byjs_sun_type',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功',$this->createWebUrl('type',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($_GPC['op']=='change'){
	 $res=pdo_update('byjs_sun_type',array('state'=>$_GPC['state']),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('操作成功',$this->createWebUrl('type',array()),'success');
    }else{
        message('操作失败','','error');
    }
}

if($_GPC['id']){
    $type_id = $_GPC['id'];
    if($_GPC['op'] == 'show'){
        if($info){
            message('添加失败已经有一件单品放置在首页了,如果要更改请先删除原来的',$this->createWebUrl('type',array()),'success');
        }
        $res = pdo_insert('byjs_sun_type_show',array('type_id'=>$type_id));
        if($res){
            message('添加成功',$this->createWebUrl('type',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_delete('byjs_sun_type_show',array('type_id'=>$type_id,'uniacid'=>$_W['uniacid']));
        if($res){
            message('添加成功',$this->createWebUrl('type',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }
}
include $this->template('web/type');