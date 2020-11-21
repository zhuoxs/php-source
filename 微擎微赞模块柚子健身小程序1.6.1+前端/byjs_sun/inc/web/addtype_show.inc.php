<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info  = pdo_getcolumn('byjs_sun_type_show',array(),'id');
if($_GPC['id']){
    $type_id = $_GPC['id'];
    if($_GPC['op'] == 'show'){
        if($info){
            message('添加失败已经有一件单品放置在首页了,如果要更改请先删除原来的',$this->createWebUrl('type',array()),'success');
        }
        $res = pdo_insert('byjs_sun_type_show',array('type_id'=>$type_id));
        if($res){
            message('添加成功',$this->createWebUrl('type',array('type_show':2)),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_delete('byjs_sun_type_show',array('type_id'=>$type_id));
        if($res){
            message('添加成功',$this->createWebUrl('type',array('type_show':1)),'success');
        }else{
            message('添加失败','','error');
        }
    }
}