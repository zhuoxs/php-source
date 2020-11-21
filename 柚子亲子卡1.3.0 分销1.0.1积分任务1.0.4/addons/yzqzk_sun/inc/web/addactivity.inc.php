<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzqzk_sun_activity',array('id'=>$_GPC['id']));
//判断积分任务表是否存在
$scoretaskplugin=0;
if(pdo_tableexists("yzqzk_sun_plugin_scoretask_system")){
    $scoretaskplugin=1;
}
if($info['lb_pics']){
    if(strpos($info['lb_pics'],',')){
        $lb_pics= explode(',',$info['lb_pics']);
    }else{
        $lb_pics=array(
            0=>$info['lb_pics']
        );
    }
}
$category=pdo_getall('yzqzk_sun_activity_category',array('uniacid'=>$_W['uniacid']));
$store=pdo_getall('yzqzk_sun_store',array('uniacid'=>$_W['uniacid'],'state'=>2));
if(checksubmit('submit')){
    $data['uniacid']=$_W['uniacid'];
    $data['title']=$_GPC['title'];
    $data['bm_begin_time']=strtotime($_GPC['bm_begin_time']);
    $data['bm_end_time']=strtotime($_GPC['bm_end_time']);
    $data['hdbegintime']=$_GPC['hdbegintime'];
    $data['hdendtime']=$_GPC['hdendtime'];
    $data['pic']=$_GPC['pic'];
    $data['tag']=$_GPC['tag'];
    $data['common_price']=$_GPC['common_price'];
    $data['qzk_price']=$_GPC['qzk_price'];
    $data['num']=$_GPC['num'];
    $data['qzk_status']=$_GPC['qzk_status'];
    $data['age_limit']=$_GPC['age_limit'];
    $data['remark']=$_GPC['remark'];
    $data['info']=htmlspecialchars_decode($_GPC['info']);
    $data['content']=htmlspecialchars_decode($_GPC['content']);
    $data['store_id']=$_GPC['store_id'];
    $data['category_id']=$_GPC['category_id'];
    $data['add_time']= time();
    $data['show_index']=$_GPC['show_index'];
    $data['gkfl_status']=$_GPC['gkfl_status'];
    if($scoretaskplugin==1){
        $data['money_rate']=$_GPC['money_rate'];
        $data['score_rate']=$_GPC['score_rate'];
    }

    if($_GPC['lb_pics']){
        $data['lb_pics']=implode(",",$_GPC['lb_pics']);
    }else{
        $data['lb_pics']='';
    }

    if(empty($_GPC['id'])){
        $res = pdo_insert('yzqzk_sun_activity', $data);
        if($res){
            message('添加成功',$this->createWebUrl('activity',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        unset($data['add_time']);
        $res = pdo_update('yzqzk_sun_activity', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('activity',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }  
    
}
include $this->template('web/addactivity');