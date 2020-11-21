<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$list = pdo_getall('wyzc_sun_type',array('uniacid' => $_W['uniacid']),array(),'','num ASC');
$info = pdo_getall('yzzc_sun_level',array('uniacid'=>$_W['uniacid']),array(),'','level_score ASC');
//p($info);die;
//global $_W, $_GPC;

if($_GPC['op']=='delete'){

    $res=pdo_delete('yzzc_sun_level',array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('memberslist',array()),'success');
    }else{
        message('操作失败','','error');
    }

}


include $this->template('web/memberslist');