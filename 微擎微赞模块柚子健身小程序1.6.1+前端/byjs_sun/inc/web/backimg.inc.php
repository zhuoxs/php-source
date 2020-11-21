<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();

$list = pdo_get('byjs_sun_backimg',array('uniacid' => $_W['uniacid']),array(),'','sort ASC');
if(checksubmit('submit')){
if($_GPC['id']){

    $res=pdo_update('byjs_sun_backimg',array('img'=>$_GPC['backimg']),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){

        message('编辑成功',$this->createWebUrl('backimg',array()),'success');

    }else{

        message('编辑失败','','error');

    }
    }else{
    $data['uniacid'] = $_W['uniacid'];
    $data['img'] = $_GPC['backimg'];
    $res = pdo_insert('byjs_sun_backimg',$data);
    if($res){

        message('编辑成功',$this->createWebUrl('backimg',array()),'success');

    }else{

        message('编辑失败','','error');

    }
}
}
include $this->template('web/backimg');