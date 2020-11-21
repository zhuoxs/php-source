<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/10
 * Time: 15:56
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
if($_GPC['id']){
    $info=pdo_get('yzpx_sun_course_teach',array('id'=>$_GPC['id']));
}
$school=pdo_getall('yzpx_sun_school',array('uniacid'=>$_W['uniacid'],'status'=>1));
$teacher=pdo_getall('yzpx_sun_teacher',array('uniacid'=>$_W['uniacid'],'status'=>1,'sid'=>0));
$cid=$_GPC['cid'];
if (checksubmit('submit')){
    $tea['tid']=$_GPC['tid'];
    $tea['sid']=$_GPC['sid'];
    $tea['cid']=$_GPC['cid'];
    $tea['createtime']=time();
    $tea['uniacid']=$_W['uniacid'];
//    var_dump($tea);exit;
    $is=pdo_get('yzpx_sun_course_teach',array('cid'=>$_GPC['cid'],'sid'=>$_GPC['sid']),array('id'));
    if($is){
        message('该校区已添加','','error');
    }else{
        $res=pdo_insert('yzpx_sun_course_teach',$tea);
        if($res){
            $cinfo=pdo_get('yzpx_sun_course',array('id'=>$_GPC['cid']),array('title'));
            message('添加成功',$this->createWebUrl('joinlist',array('cid'=>$_GPC['cid'],'cname'=>$cinfo['title'])),'success');
        }else{
            message('添加失败','','error');
        }
    }

}
if($_GPC['op']=='select_school'){
    $teacher=pdo_getall('yzpx_sun_teacher',array('uniacid'=>$_W['uniacid'],'sid'=>$_GPC['sid'],'status'=>1));
    echo json_encode($teacher);exit;
}

include $this->template('web/addjoin');