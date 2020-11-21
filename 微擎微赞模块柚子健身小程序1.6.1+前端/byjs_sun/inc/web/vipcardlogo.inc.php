<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();

$list = pdo_get('byjs_sun_vipcardlogo',array('uniacid' => $_W['uniacid']));

if(checksubmit('submit')){
 
if($_GPC['id']){
	
    $res=pdo_update('byjs_sun_vipcardlogo',array('logo'=>$_GPC['logo'],'text'=>htmlspecialchars_decode($_GPC['text'])),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){

        message('编辑成功',$this->createWebUrl('vipcardlogo',array()),'success');

    }else{

        message('编辑失败','','error');

    }
    }else{
  	
    $data['uniacid'] = $_W['uniacid'];
    $data['logo'] = $_GPC['logo'];
    $data['text']=htmlspecialchars_decode($_GPC['text']);
    $res = pdo_insert('byjs_sun_vipcardlogo',$data);
    if($res){

        message('编辑成功',$this->createWebUrl('vipcardlogo',array()),'success');

    }else{

        message('编辑失败','','error');

    }
}
}
include $this->template('web/vipcardlogo');