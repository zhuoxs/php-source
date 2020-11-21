<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/2
 * Time: 11:22
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$info=pdo_get('yzpx_sun_lesson',array('id'=>$_GPC['id']));
if($info){
    $info['start_time']=date('Y-m-d H:i:s',$info['start_time']);
    $info['end_time']=date('Y-m-d H:i:s',$info['end_time']);
}
$type=$_GPC['type']?$_GPC['type']:1;
$couid=$_GPC['couid'];
if (checksubmit('submit')){
    if($_GPC['title']==null){
        message('请输入课间标题','','error');
    }
    if($_GPC['video_img']==null){
        message('请上传一张图片','','error');
    }
//    if($_GPC['video']==null){
//        message('请上传视频','','error');
//    }
    $data['couid']=$_GPC['couid'];
    $data['title']=$_GPC['title'];
    $data['video']=$_GPC['video'];
    $data['video_link']=$_GPC['video_link'];
    $data['video_type']=$_GPC['video_type'];
    $data['video_img']=$_GPC['video_img'];
    $data['start_time']=strtotime($_GPC['start_time']);
    $data['end_time']=strtotime($_GPC['end_time']);
    $data['content']=$_GPC['content'];
    $data['uniacid']=$_W['uniacid'];
    $data['createtime']=time();
    if($_GPC['id']==''){
        $res=pdo_insert('yzpx_sun_lesson',$data);
        if($res){
            message('添加成功',$this->createWebUrl('lessonlist',array('couid'=>$data['couid'],'type'=>$_GPC['type'])),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res=pdo_update('yzpx_sun_lesson',$data,array('id'=>$_GPC['id']));
        if($res){
            message('修改成功',$this->createWebUrl('lessonlist',array('couid'=>$data['couid'],'type'=>$_GPC['type'])),'success');
        }else{
            message('修改失败','','error');
        }
    }
}
include $this->template('web/addlesson');