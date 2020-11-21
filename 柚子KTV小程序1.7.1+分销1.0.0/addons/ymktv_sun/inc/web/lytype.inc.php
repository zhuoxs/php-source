<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$type= isset($_GPC['type'])?$_GPC['type']:0;
$list = pdo_getall('fyly_sun_lytype',array('uniacid'=>$_W['uniacid']),'','','lid ASC');


if($_GPC['op']=='delete'){
    $res=pdo_delete('fyly_sun_lytype',array('lid'=>$_GPC['lid']));
    if($res){
        message('删除成功！', $this->createWebUrl('lytype'), 'success');
    }else{
        message('删除失败！','','error');
    }


}

include $this->template('web/lytype');