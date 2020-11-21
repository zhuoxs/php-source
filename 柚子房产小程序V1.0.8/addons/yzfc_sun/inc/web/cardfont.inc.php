<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_getall('yzfc_sun_card_font',array('uniacid'=>$_W['uniacid'],'cid'=>$_GPC['cid']));
$cid=$_GPC['cid'];
if($_GPC['op']=='delete'){

    $res=pdo_delete('yzfc_sun_card_font',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('cardfont',array('cid'=>$cid)),'success');
    }else{
        message('删除失败','','error');
    }
}
include $this->template('web/cardfont');