<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('mzhk_sun_announcement',array('id'=>$_GPC['id']));
if(checksubmit('submit')){
    $data['uniacid']=$_W['uniacid'];
    $data['title']=$_GPC['title'];
    $data['show_index']=$_GPC['show_index'];
    $data['type']=1;
    $data['add_time']= time();  
    if(empty($_GPC['id'])){
        $res = pdo_insert('mzhk_sun_announcement', $data);
        if($res){
            message('添加成功',$this->createWebUrl('announcement',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('mzhk_sun_announcement', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('announcement',array()),'success');
        }else{
            message('编辑失败','','error');
        }  
    }  
    
}
include $this->template('web/addannouncement');