<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzqzk_sun_story',array('id'=>$_GPC['id']));
$category=pdo_getall('yzqzk_sun_story_category',array('uniacid'=>$_W['uniacid']));
$album=pdo_getall('yzqzk_sun_story_album',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['uniacid']=$_W['uniacid'];
    $data['album_id']=$_GPC['album_id'];
    if($_GPC['album_id']>0){
        $album=pdo_get('yzqzk_sun_story_album',array('id'=>$_GPC['album_id']));
        $data['category_id']=$album['category_id'];
    }else{
        $data['category_id']=$_GPC['category_id'];
    }
    $data['title']=$_GPC['title'];
    $data['pic']=$_GPC['pic'];
    $data['pic_bg']=$_GPC['pic_bg'];
    $data['pic_open']=$_GPC['pic_open'];
    $data['file_path']=$_GPC['file_path'];
    $data['show_index']=$_GPC['show_index'];
    $data['show_st']=$_GPC['show_st'];
    $data['is_vip']=$_GPC['is_vip'];
    $data['add_time']= time();
    $data['is_album']=$data['album_id']?1:0;
    $data['duration']=$_GPC['duration'];
    $data['file_link']=$_GPC['file_link'];
    $data['sort']=$_GPC['sort'];
    if(empty($_GPC['id'])){
        $res = pdo_insert('yzqzk_sun_story', $data);
        if($res){
            message('添加成功',$this->createWebUrl('story',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        unset($data['add_time']);
        $res = pdo_update('yzqzk_sun_story', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('story',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }  
    
}
include $this->template('web/addstory');