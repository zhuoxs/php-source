<!--课程类型操作-->
<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$list = pdo_getall('byjs_sun_course_type',array(),'','',array('top DESC','top_time DESC','type_id DESC',''));
//print_r($list);
if($_GPC['op']=='delete'){
    $res=pdo_delete('byjs_sun_course_type',array('type_id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功',$this->createWebUrl('coursetype',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($_GPC['op']=='change'){
    $res=pdo_update('byjs_sun_course_type',array('type_status'=>$_GPC['type_status']),array('type_id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('操作成功',$this->createWebUrl('coursetype',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
include $this->template('web/coursetype');