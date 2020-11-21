<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$list = pdo_getall('wyzc_sun_type',array('uniacid' => $_W['uniacid']),array(),'','num ASC');
$list= pdo_getall('yzzc_sun_adpic',array('uniacid'=>$_W['uniacid']));
$info=pdo_get('yzzc_sun_system',array('uniacid'=>$_W['uniacid']),array('ad_pic'));
$info['open']=$info['ad_pic'];
//var_dump($info);exit;
if($_GPC['op']=='delete'){
    if($_W['ispost']){
        $res=pdo_update('yzzc_sun_system',array('ad_pic'=>$_GPC['open']),array('uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('adpic_list',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }
}
include $this->template('web/adpic_list');