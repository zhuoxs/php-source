<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzcyk_sun_story_album',array('id'=>$_GPC['id']));
$category=pdo_getall('yzcyk_sun_story_category',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['uniacid']=$_W['uniacid'];
    $data['category_id']=$_GPC['category_id'];
    $data['title']=$_GPC['title'];
    $data['pic']=$_GPC['pic'];
    $data['banner']=$_GPC['banner'];
    $data['source']=$_GPC['source'];
    $data['show_index']=$_GPC['show_index'];
    $data['show_st']=$_GPC['show_st'];
    $data['is_vip']=$_GPC['is_vip'];
    $data['add_time']= time();  
    if(empty($_GPC['id'])){
        $res = pdo_insert('yzcyk_sun_story_album', $data);
        if($res){
            message('添加成功',$this->createWebUrl('storyalbum',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        unset($data['add_time']);
        $res = pdo_update('yzcyk_sun_story_album', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('storyalbum',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }  
    
}
include $this->template('web/addstoryalbum');