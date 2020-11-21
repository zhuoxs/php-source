<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzhyk_sun_privilege_identifier',array('id'=>$_GPC['id']));
if(checksubmit('submit')){
    $data['uniacid']=$_W['uniacid'];
    $data['title']=$_GPC['title'];
    $data['pic']=$_GPC['pic'];
    $data['add_time']= time();  
    if(empty($_GPC['id'])){
        $res = pdo_insert('yzhyk_sun_privilege_identifier', $data);
        if($res){
            message('添加成功',$this->createWebUrl('privilegeidentifier',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('yzhyk_sun_privilege_identifier', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('privilegeidentifier',array()),'success');
        }else{
            message('编辑失败','','error');
        }  
    }  
    
}
include $this->template('web/addprivilegeidentifier');