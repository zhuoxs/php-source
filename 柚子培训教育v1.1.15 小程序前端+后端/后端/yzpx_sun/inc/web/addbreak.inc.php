<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/2
 * Time: 11:22
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

    $info=pdo_get('yzpx_sun_break',array('id'=>$_GPC['id']));
    if($info['cid']>0){
        $nowclassify=pdo_get('yzpx_sun_breakclassify',array('id'=>$info['cid']));
    }
    $class=pdo_getall('yzpx_sun_breakclassify',array('uniacid'=>$_W['uniacid']));
//    var_dump($class);exit;
    if (checksubmit('submit')){
//        var_dump($_FILES['ceshi']);exit();
        ini_set('upload_max_filesize ','1024M');
        if($_GPC['title']==null){
            message('请输入课间标题','','error');
        }
        if($_GPC['cid']==null){
            message('请选择课间分类','','error');
        }
        if($_GPC['toptype']==1&&$_GPC['img']==null){
            message('请上传一张图片','','error');
        }
        if($_GPC['toptype']==2&&$_GPC['video']==null){
            message('请上传视频','','error');
        }
        $data['cid']=$_GPC['cid'];
        $data['title']=$_GPC['title'];
        $data['toptype']=$_GPC['toptype']?$_GPC['toptype']:1;
        $data['img']=$_GPC['img'];
        $data['video']=$_GPC['video'];
        $data['video_img']=$_GPC['video_img'];
        $data['content']=$_GPC['content'];
        $data['uniacid']=$_W['uniacid'];
        $data['createtime']=time();
        if($_GPC['id']==''){
            $res=pdo_insert('yzpx_sun_break',$data);
            if($res){
                message('添加成功',$this->createWebUrl('breaklist',array()),'success');
            }else{
                message('添加失败','','error');
            }
        }else{
            $res=pdo_update('yzpx_sun_break',$data,array('id'=>$_GPC['id']));
            if($res){
                message('修改成功',$this->createWebUrl('breaklist',array()),'success');
            }else{
                message('修改失败','','error');
            }
        }
    }
include $this->template('web/addbreak');