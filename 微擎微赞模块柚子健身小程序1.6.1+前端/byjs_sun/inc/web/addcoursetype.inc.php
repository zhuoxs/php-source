<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info = pdo_get('byjs_sun_course_type',array('type_id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){

    $data['course_type']=$_GPC['course_type'];
    $data['type_img'] = $_GPC['type_img'];

    $data['type_status']=$_GPC['type_status'];
    $data['top']=1;                    //置顶操作默认为1否  2为置顶操作
    $data['top_time']=Date('Y-m-d H:i:s');
    $data['type_course'] =$_GPC['type_course'];
    $data['uniacid'] = $_W['uniacid'];
    if($_GPC['id']==''){
        $res=pdo_insert('byjs_sun_course_type',$data);
        if($res){
            message('添加成功',$this->createWebUrl('coursetype',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('byjs_sun_course_type', $data, array('type_id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('编辑成功',$this->createWebUrl('coursetype',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/addcoursetype');