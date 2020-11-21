<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();

$list = pdo_getall('fyly_sun_visa',array('uniacid' => $_W['uniacid']));

if($_GPC['op']=='delete'){
    $res=pdo_delete('fyly_sun_visa',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('visas'), 'success');
        }else{
              message('删除失败！','','error');
        }
}

include $this->template('web/visas');