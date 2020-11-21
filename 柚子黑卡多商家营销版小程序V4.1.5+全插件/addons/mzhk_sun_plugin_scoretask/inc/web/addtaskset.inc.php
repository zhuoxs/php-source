<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('mzhk_sun_plugin_scoretask_taskset',array('id'=>$_GPC['id']));

if(checksubmit('submit')){
    $data['uniacid']=$_W['uniacid'];
    $data['title']=$_GPC['title'];
    $data['task_id']=$_GPC['task_id'];
    $data['task_type']=$_GPC['task_type'];
    $data['icon']=$_GPC['icon'];
    $data['score']=$_GPC['score'];
    $data['add_time']= time();
    if(empty($_GPC['id'])){
        $res = pdo_insert('mzhk_sun_plugin_scoretask_taskset', $data);
        if($res){
            message('添加成功',$this->createWebUrl('taskset',array('task_id'=>$_GPC['task_id'],'type'=>$_GPC['type'])),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        unset($data['add_time']);
        $res = pdo_update('mzhk_sun_plugin_scoretask_taskset', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('taskset',array('task_id'=>$_GPC['task_id'],'type'=>$_GPC['type'])),'success');
        }else{
            message('编辑失败','','error');
        }
    }  
    
}
include $this->template('web/addtaskset');