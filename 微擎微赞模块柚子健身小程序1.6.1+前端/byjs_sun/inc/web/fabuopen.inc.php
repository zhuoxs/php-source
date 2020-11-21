<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('byjs_sun_tab',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['is_fbopen']=$_GPC['is_fbopen'];
    $data['uniacid']=$_W['uniacid'];

    if($_GPC['id']==''){
        $res=pdo_insert('byjs_sun_tab',$data);
        if($res){
            message('编辑成功',$this->createWebUrl('fabuopen',array()),'success');
        }else{
            message('编辑成功','','error');
        }
    }else{
        $res = pdo_update('byjs_sun_tab', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('编辑成功',$this->createWebUrl('fabuopen',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/fabuopen');