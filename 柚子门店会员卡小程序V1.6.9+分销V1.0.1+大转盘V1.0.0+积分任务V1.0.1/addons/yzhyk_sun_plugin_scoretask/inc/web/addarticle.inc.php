<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzhyk_sun_plugin_scoretask_article',array('id'=>$_GPC['id']));
if(checksubmit('submit')){
    $data['uniacid']=$_W['uniacid'];
    $data['show_type']=$_GPC['show_type'];
    $data['title']=$_GPC['title'];
    $data['icon']=$_GPC['icon'];
    $data['icon_vertical']=$_GPC['icon_vertical'];
    $data['show_index']=$_GPC['show_index'];
    $data['show_task']=$_GPC['show_task'];
    $data['url']=$_GPC['url'];
    $data['file_path']=$_GPC['file_path'];
    $data['publish_time']=strtotime($_GPC['publish_time']);
    $data['add_time']= time();
    $article=pdo_get('yzhyk_sun_plugin_scoretask_article',array('uniacid'=>$_W['uniacid'],'type'=>$_GPC['type']));
    if(empty($_GPC['id'])){
        $res = pdo_insert('yzhyk_sun_plugin_scoretask_article', $data);
        if($res){
            message('添加成功',$this->createWebUrl('article',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        unset($data['add_time']);
        $res = pdo_update('yzhyk_sun_plugin_scoretask_article', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('article',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }  
    
}
include $this->template('web/addarticle');