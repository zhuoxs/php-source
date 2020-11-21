<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();

$list = pdo_getall('zhls_sun_goods_spec',array('uniacid' => $_W['uniacid']),array(),'','sort ASC');

if($_GPC['id']){

    $res=pdo_delete('zhls_sun_goods_spec',array('id'=>$_GPC['id']));

    if($res){

        message('删除成功',$this->createWebUrl('attribute',array()),'success');

    }else{

        message('删除失败','','error');

    }

}

include $this->template('web/attribute');