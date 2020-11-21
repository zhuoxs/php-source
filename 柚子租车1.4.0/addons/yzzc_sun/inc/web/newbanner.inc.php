<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzzc_sun_banner',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['new_banner'] = $_GPC['new_banner'];
    if($_GPC['id']==''){
        $res=pdo_insert('yzzc_sun_banner',$data,array('uniacid'=>$_W['uniacid']));
        if($res){
            message('添加成功',$this->createWebUrl('newbanner',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{

        $res = pdo_update('yzzc_sun_banner', $data, array('uniacid' => $_GPC['id']));

        if($res){
            message('编辑成功',$this->createWebUrl('newbanner',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/newbanner');