<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('byjs_sun_mb',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['is_open']=$_GPC['is_open'];
    $data['mb1']=$_GPC['mb1'];
    $data['mb2']=$_GPC['mb2'];
    $data['mb3']=$_GPC['mb3'];
    $data['uniacid']=$_W['uniacid'];
	
    if($_GPC['id']==''){
        $res=pdo_insert('byjs_sun_mb',$data);
        if($res){
            message('编辑成功',$this->createWebUrl('mbmessage',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }else{
        $res = pdo_update('byjs_sun_mb', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('编辑成功',$this->createWebUrl('mbmessage',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/mbmessage');