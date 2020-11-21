<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/2
 * Time: 16:33
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
if($_GPC['id']){
    $info=pdo_get('yzpx_sun_teacher',array('id'=>$_GPC['id']));
    if($info['cid']>0){
        $nowtype=pdo_get('yzpx_sun_courseclassify',array('id'=>$info['cid']));
    }
}
$class=pdo_getall('yzpx_sun_courseclassify',array('uniacid'=>$_W['uniacid']));
$school=pdo_getall('yzpx_sun_school',array('uniacid'=>$_W['uniacid'],'status'=>1));
if (checksubmit('submit')){
    if($_GPC['name']==null){
        message('请输入名称','','error');
    }elseif($_GPC['headurl']==null){
        message('请上传头像','','error');
    }elseif($_GPC['school']==null){
        message('请输入毕业院校','','error');
    }  elseif ($_GPC['cid']==null){
        message('请选择老师分类','','error');
    }
    $data['cid']=$_GPC['cid'];
    $data['sid']=$_GPC['sid'];
    $data['name']=$_GPC['name'];
    $data['headurl']=$_GPC['headurl'];
    $data['school']=$_GPC['school'];
    $data['age']=$_GPC['age'];
    $data['tel']=$_GPC['tel'];
    $data['content']=$_GPC['content'];
    $data['uniacid']=$_W['uniacid'];
    if($_GPC['id']==''){
        $res=pdo_insert('yzpx_sun_teacher',$data);
        if($res){
            message('添加成功',$this->createWebUrl('teacherlist',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res=pdo_update('yzpx_sun_teacher',$data,array('id'=>$_GPC['id']));
        if($res){
            message('修改成功',$this->createWebUrl('teacherlist',array()),'success');
        }else{
            message('修改失败','','error');
        }
    }
}

include $this->template('web/addteacher');