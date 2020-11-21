<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzhyk_sun_plugin_scoretask_task',array('id'=>$_GPC['id']));
$category=array(
    array('id'=>1,'title'=>'签到'),
    array('id'=>2,'title'=>'阅读文章'),
    array('id'=>3,'title'=>'邀请好友看文章'),
    array('id'=>4,'title'=>'邀请好友砍积分'),
    array('id'=>5,'title'=>'积分抽奖'),
    array('id'=>6,'title'=>'收藏'),
    array('id'=>7,'title'=>'邀请好友'),
);
if(checksubmit('submit')){
    $data['uniacid']=$_W['uniacid'];
    $data['type']=$_GPC['type'];
    $data['title']=$_GPC['title'];
    $data['icon']=$_GPC['icon'];
    $data['task_num']=$_GPC['task_num'];
    $data['score']=$_GPC['score'];
    $data['task_score']=$_GPC['task_score'];
    $data['add_time']= time();
    $task=pdo_get('yzhyk_sun_plugin_scoretask_task',array('uniacid'=>$_W['uniacid'],'type'=>$_GPC['type']));
    if(empty($_GPC['id'])){
        if($task){
            message('添加失败,每种任务类型只能添加一种','','error');
        }
        $res = pdo_insert('yzhyk_sun_plugin_scoretask_task', $data);
        if($res){
            message('添加成功',$this->createWebUrl('task',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $task_first=pdo_get(yzhyk_sun_plugin_scoretask_task,array('id'=>$_GPC['id']));
        if($task&&$task_first['type']!=$_GPC['type']){
            message('添加失败,每种任务类型只能添加一种','','error');
        }
        unset($data['add_time']);
        $res = pdo_update('yzhyk_sun_plugin_scoretask_task', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('task',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }  
    
}
include $this->template('web/addtask');