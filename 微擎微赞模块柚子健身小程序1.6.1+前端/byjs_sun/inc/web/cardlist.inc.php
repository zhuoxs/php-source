<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_getall('ims_byjs_sun_card',array('uniacid'=>$_W['uniacid']));
if($_GPC['op']=='delete'){
    $res=pdo_delete('ims_byjs_sun_card',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
	   if($res){
        message('删除成功',$this->createWebUrl('cardlist','','success'));
    }else{
        message('删除失败','','error');
    }
}            
include $this->template('web/cardlist');