<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$list=pdo_getall('yzkm_sun_banner',array('uniacid'=>$_W['uniacid']));
// p($_GPC);die;

if($_GPC['op']=='delete'){

    $res=pdo_delete('yzkm_sun_banner',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('bannerdetail'), 'success');
        }else{
              message('删除失败！','','error');
        }
}

include $this->template('web/bannerdetail');